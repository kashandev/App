<?php
include('config.php');

$message = '['.date('Y-m-d H:i:s').'] - '.$_SERVER['REMOTE_ADDR'].' - TenantReceipt'.PHP_EOL;
$message .= 'Request: '.json_encode(array('get'=>$_GET, 'post'=>$_POST)).PHP_EOL;
file_put_contents('api.log', $message , FILE_APPEND | LOCK_EX);
if (validateToken($_GET['token'])) {
    $con = mysqli_connect(DB_SERVER,DB_USER,DB_PASSWORD,DB_MASTER);

    try {
        $building_code = $_POST['building_code'];
        $document_date = $_POST['document_date'];
        //$challan_no = $_POST['challan_no'];
        $challan_no = '';
        $remarks = $_POST['remarks'];
        $total_amount = $_POST['total_amount'];
        $cash_amount = $_POST['cash_amount'];
        $cheque_amount = $_POST['cheque_amount'];
        $cheque_date = $_POST['cheque_date'];
        $cheque_no = $_POST['cheque_no'];

        if($total_amount=='') {
            $total_amount = 0;
        }
        if($cash_amount=='') {
            $cash_amount = 0;
        }
        if($cheque_amount=='') {
            $cheque_amount = 0;
        }

        $arrError = array();

        if($building_code=='') {
            $arrError[] = '`building_code` is required';
        }

        if($document_date=='') {
            $arrError[] = '`document_date` is required';
        } else {
            $d = DateTime::createFromFormat('Y-m-d', $document_date);
            if(!($d && $d->format('Y-m-d') === $document_date)) {
                $arrError[] = '`document_date` is required in valid format ['.date('Y-m-d').']';
            }
        }

        if($cheque_date=='') {
            $cheque_date = NULL;
        } else {
            $d = DateTime::createFromFormat('Y-m-d', $cheque_date);
            if(!($d && $d->format('Y-m-d') === $cheque_date)) {
                $arrError[] = '`cheque_date` is required in valid format ['.date('Y-m-d').']';
            }
        }

        if(!is_numeric($cash_amount)) {
            $arrError[] = '`cash_amount` must be numeric.';
        }
        if(!is_numeric($cheque_amount)) {
            $arrError[] = '`cheque_amount` must be numeric.';
        }
        if(($cash_amount + $cheque_amount) != $total_amount) {
            $arrError[] = '`total_amount` must be equal to `cash_amount` + `cheque_amount`';
        }
        if($total_amount=='0') {
            $arrError[] = '`total_amount` is required';
        } else {
            if(!is_numeric($total_amount)) {
                $arrError[] = '`total_amount` must be numeric.';
            }
        }

        if($arrError) {
            $json = array(
                'success' => false,
                'error' => implode(',',$arrError)
            );
        } else {
            $sql = "SELECT *";
            $sql .= " FROM `fiscal_year`";
            $sql .= " WHERE `company_id` = '".COMPANY_ID."' AND '".$document_date."' > `date_from` AND '".$document_date."' <= `date_to`";
            $query = $con->query($sql);
            if($query->num_rows) {
                $year = $query->fetch_assoc();
                ///echo json_encode($year);
                //exit;
                $_SESSION['fiscal_year_id'] = $year['fiscal_year_id'];
                $_SESSION['fy_code'] = $year['fy_code'];
                $con->select_db($year['db_name']);

                $sql = "select *";
                $sql .= " from `core_building` b";
                $sql .= " INNER JOIN `gl0_coa_level3` l3 on l3.coa_level3_id = b.coa_id";
                $sql .= " where b.building_code = '".$building_code."'";
                $query = $con->query($sql);
                if($query->num_rows > 0) {
                    $building_data = $query->fetch_assoc();
                    $arrSQL = array();
                    $arrDocument = array();

                    if($cheque_amount > 0) {
                        $document = getNextDocument($con, BANK_RECEIPT_ID);
                        $document_identity = $document['document_identity'];

                        //$con->begin_transaction();
                        $con->autocommit(false);
                        $bank_receipt_id = getGUID();
                        $sql = "Insert into glt_bank_receipt (company_id,company_branch_id,fiscal_year_id,document_type_id,bank_receipt_id,document_prefix,document_no,document_identity,document_date,transaction_account_id,";
                        $sql .= " remarks,total_amount,total_net_amount,created_at,created_by_id) VALUES ";
                        $sql .= " ('".COMPANY_ID."','".BRANCH_ID."','".$year['fiscal_year_id']."','".BANK_RECEIPT_ID."','".$bank_receipt_id."',";
                        $sql .= "'".$document['document_prefix']."','".$document['document_no']."','".$document['document_identity']."','".$document_date."','".BANK_ACCOUNT_ID."',";
                        $sql .= "'".$remarks."','".$cheque_amount."','".$cheque_amount."','".date('Y-m-d H:i:s')."','".$created_by_id."')";
                        $con->query($sql);
                        //$arrSQL[] = $sql;

                        $bank_receipt_detail_id = getGUID();
                        $sql = "Insert into glt_bank_receipt_detail (bank_receipt_detail_id,company_id,company_branch_id,";
                        $sql .= "fiscal_year_id,bank_receipt_id,coa_id,cheque_date, cheque_no, amount,net_amount,base_amount,base_net_amount,created_at,created_by_id) VALUES ";
                        $sql .= "('".$bank_receipt_detail_id."','".COMPANY_ID."','".BRANCH_ID."','".$year['fiscal_year_id']."','".$bank_receipt_id."','".$building_data['coa_id']."','".$cheque_date."','".$cheque_no."','".$cheque_amount."','".$cheque_amount."','".$cheque_amount."','".$cheque_amount."','".date('Y-m-d H:i:s')."','".$created_by_id."')";
                        $con->query($sql);
                        //$arrSQL[] = $sql;

                        $ledger_debit_id = getGUID();
                        $sql = "Insert into core_ledger (ledger_id,company_id,company_branch_id,fiscal_year_id,document_type_id,document_id,document_detail_id,";
                        $sql .= "document_identity,document_date,challan_no,coa_id,remarks,document_debit,debit,created_at,created_by_id) VALUES ";
                        $sql .= "('".$ledger_debit_id."','".COMPANY_ID."','".BRANCH_ID."','".$year['fiscal_year_id']."','".BANK_RECEIPT_ID."','".$bank_receipt_id."','".$bank_receipt_detail_id."','".$document['document_identity']."',";
                        $sql .= "'".$document_date."','".$challan_no."','".BANK_ACCOUNT_ID."','".$remarks."','".$cheque_amount."','".$cheque_amount."','".date('Y-m-d H:i:s')."',11)";
                        $con->query($sql);
                        //$arrSQL[] = $sql;

                        $ledger_credit_id = getGUID();
                        $sql = "Insert into core_ledger (ledger_id,company_id,company_branch_id,fiscal_year_id,document_type_id,document_id,document_detail_id,";
                        $sql .= "document_identity,document_date,challan_no,coa_id,remarks,document_credit,credit,created_at,created_by_id) VALUES ";
                        $sql .= "('".$ledger_credit_id."','".COMPANY_ID."','".BRANCH_ID."','".$year['fiscal_year_id']."','".BANK_RECEIPT_ID."','".$bank_receipt_id."','".$bank_receipt_detail_id."','".$document['document_identity']."',";
                        $sql .= "'".$document_date."','".$challan_no."','".$building_data['coa_id']."','".$remarks."','".$cheque_amount."','".$cheque_amount."','".date('Y-m-d H:i:s')."',11)";
                        $con->query($sql);
                        //$arrSQL[] = $sql;

                        $sql = "insert into core_document (company_id,company_branch_id,fiscal_year_id,document_type_id,document_id,";
                        $sql .= "document_identity,document_date,document_amount,base_amount,created_at,created_by_id) VALUES ";
                        $sql .= "('".COMPANY_ID."','".BRANCH_ID."','".$year['fiscal_year_id']."','".BANK_RECEIPT_ID."','".$bank_receipt_id."','".$document['document_identity']."','".$document_date."','".$cheque_amount."','".$cheque_amount."','".date('Y-m-d H:i:s')."',11)";
                        $con->query($sql);
                        //$arrSQL[] = $sql;

                        //$con->commit();
                        $con->autocommit(true);
                        $arrDocument[] = $document_identity;
                    }
                    if($cash_amount > 0) {
                        $document = getNextDocument($con, CASH_RECEIPT_ID);
                        $document_identity = $document['document_identity'];

                        //$con->begin_transaction();
                        $con->autocommit(false);
                        $cash_receipt_id = getGUID();
                        $sql = "Insert into glt_cash_receipt (company_id,company_branch_id,fiscal_year_id,document_type_id,cash_receipt_id,document_prefix,document_no,document_identity,document_date,transaction_account_id,";
                        $sql .= " remarks,total_amount,total_net_amount,created_at,created_by_id) VALUES ";
                        $sql .= " ('".COMPANY_ID."','".BRANCH_ID."','".$year['fiscal_year_id']."','".CASH_RECEIPT_ID."','".$cash_receipt_id."',";
                        $sql .= "'".$document['document_prefix']."','".$document['document_no']."','".$document['document_identity']."','".$document_date."','".CASH_ACCOUNT_ID."',";
                        $sql .= "'".$remarks."','".$cash_amount."','".$cash_amount."','".date('Y-m-d H:i:s')."','".$created_by_id."')";
                        $con->query($sql);
                        $arrSQL[] = $sql;

                        $cash_receipt_detail_id = getGUID();
                        $sql = "Insert into glt_cash_receipt_detail (cash_receipt_detail_id,company_id,company_branch_id,";
                        $sql .= "fiscal_year_id,cash_receipt_id,coa_id,amount,net_amount,base_amount,base_net_amount,created_at,created_by_id) VALUES ";
                        $sql .= "('".$cash_receipt_detail_id."','".COMPANY_ID."','".BRANCH_ID."','".$year['fiscal_year_id']."','".$cash_receipt_id."','".$building_data['coa_id']."','".$cash_amount."','".$cash_amount."','".$cash_amount."','".$cash_amount."','".date('Y-m-d H:i:s')."','".$created_by_id."')";
                        $con->query($sql);
                        $arrSQL[] = $sql;

                        $ledger_debit_id = getGUID();
                        $sql = "Insert into core_ledger (ledger_id,company_id,company_branch_id,fiscal_year_id,document_type_id,document_id,document_detail_id,";
                        $sql .= "document_identity,document_date,challan_no,coa_id,remarks,document_debit,debit,created_at,created_by_id) VALUES ";
                        $sql .= "('".$ledger_debit_id."','".COMPANY_ID."','".BRANCH_ID."','".$year['fiscal_year_id']."','".CASH_RECEIPT_ID."','".$cash_receipt_id."','".$cash_receipt_detail_id."','".$document['document_identity']."',";
                        $sql .= "'".$document_date."','".$challan_no."','".CASH_ACCOUNT_ID."','".$remarks."','".$cash_amount."','".$cash_amount."','".date('Y-m-d H:i:s')."',11)";
                        $con->query($sql);
                        $arrSQL[] = $sql;

                        $ledger_credit_id = getGUID();
                        $sql = "Insert into core_ledger (ledger_id,company_id,company_branch_id,fiscal_year_id,document_type_id,document_id,document_detail_id,";
                        $sql .= "document_identity,document_date,challan_no,coa_id,remarks,document_credit,credit,created_at,created_by_id) VALUES ";
                        $sql .= "('".$ledger_credit_id."','".COMPANY_ID."','".BRANCH_ID."','".$year['fiscal_year_id']."','".CASH_RECEIPT_ID."','".$cash_receipt_id."','".$cash_receipt_detail_id."','".$document['document_identity']."',";
                        $sql .= "'".$document_date."','".$challan_no."','".$building_data['coa_id']."','".$remarks."','".$cash_amount."','".$cash_amount."','".date('Y-m-d H:i:s')."',11)";
                        $con->query($sql);
                        $arrSQL[] = $sql;

                        $sql = "insert into core_document (company_id,company_branch_id,fiscal_year_id,document_type_id,document_id,";
                        $sql .= "document_identity,document_date,document_amount,base_amount,created_at,created_by_id) VALUES ";
                        $sql .= "('".COMPANY_ID."','".BRANCH_ID."','".$year['fiscal_year_id']."','".CASH_RECEIPT_ID."','".$cash_receipt_id."','".$document['document_identity']."','".$document_date."','".$cash_amount."','".$cash_amount."','".date('Y-m-d H:i:s')."',11)";
                        $con->query($sql);
                        $arrSQL[] = $sql;

                        //$con->commit();
                        $con->autocommit(true);
                        $arrDocument[] = $document_identity;
                    }

                    $json = array(
                        'success' => true,
                        'document_no' => implode(',', $arrDocument)
                    );

                } else {
                    $json = array(
                        'success' => false,
                        'error' => 'Invalid Building Code.'
                    );
                }
            } else {
                $json = array(
                    'success' => false,
                    'error' => 'Invalid Document Date'
                );
            }
        }

    } catch(Exception $e) {
        $con->rollback();
        $json = array(
            'success' => false,
            'error' => $e->getMessage()
        );
    }

    $con->close();

    $message = '['.date('Y-m-d H:i:s').'] - '.$_SERVER['REMOTE_ADDR'].' - TenantReceipt'.PHP_EOL;
    $message .= 'Request: '.json_encode(array('get'=>$_GET, 'post'=>$_POST)).PHP_EOL;
    $message .= 'Response: '.json_encode($json).PHP_EOL;
    file_put_contents('api.log', $message , FILE_APPEND | LOCK_EX);
    echo json_encode($json);
    exit;
}

echo json_encode("here2");
exit;
?>