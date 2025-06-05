<?php
include('config.php');

if(validateToken($_GET['token'])){
    $con = mysqli_connect(DB_SERVER,DB_USER,DB_PASSWORD,DB_MASTER);
    try {

        $its_no = $_POST['its_no'];
        $challan_no = $_POST['challan_no'];
        $event_id = $_POST['event_id'];
        $remarks = $_POST['remarks'];
        $document_date = $_POST['document_date'];
        $amount = $_POST['amount'];
        $arrError = array();


        if($event_id=='') {
            $arrError[] = '`event_id` is required';
        }

        if($document_date=='') {
            $arrError[] = '`document_date` is required';
        } else {
            $d = DateTime::createFromFormat('Y-m-d', $document_date);
            if(!($d && $d->format('Y-m-d') === $document_date)) {
                $arrError[] = '`document_date` is required in valid format ['.date('Y-m-d').']';
            }
        }

        if($amount=='') {
            $arrError[] = '`amount` is required';
        } else {
            if(!is_numeric($amount)) {
                $arrError[] = '`amount` must be numeric.';
            }
        }

        if($arrError) {
            $json = array(
                'success' => false,
                'error' => implode(PHP_EOL, $arrError)
            );
        } else {
            $sql = "SELECT *";
            $sql .= " FROM `fiscal_year`";
            $sql .= " WHERE `company_id` = '".COMPANY_ID."' AND '".$document_date."' > `date_from` AND '".$document_date."' <= `date_to`";
            $query = $con->query($sql);

            if($query->num_rows > 0) {
                $year = $query->fetch_assoc();
                $_SESSION['fiscal_year_id'] = $year['fiscal_year_id'];
                $_SESSION['fy_code'] = $year['fy_code'];
                $con->select_db($year['db_name']);

                $sql = "select * from core_sub_project";
                $sql .= " where event_id = '".$event_id."'";
                $query = $con->query($sql);
                $project_data = $query->fetch_assoc();

                if($query->num_rows > 0) {
                    $document = getNextDocument($con,BANK_RECEIPT_ID);
                    $document_identity = $document['document_identity'];
                    //$con->begin_transaction();
                    $arrSQL = array();
                    $con->autocommit(false);

                    $bank_receipt_id = getGUID();
                    $sql = " insert into glt_bank_receipt (company_id,company_branch_id,fiscal_year_id,document_type_id,bank_receipt_id,document_prefix,document_no,document_identity,document_date,transaction_account_id,project_id,";
                    $sql .= " sub_project_id,challan_no,its_no,remarks,total_amount,total_net_amount,created_at,created_by_id) VALUES ";
                    $sql .= " ('".COMPANY_ID."','".BRANCH_ID."','".$year['fiscal_year_id']."','".BANK_RECEIPT_ID."','".$bank_receipt_id."','".$document['document_prefix']."','".$document['document_no']."','".$document['document_identity']."','".$document_date."',";
                    $sql .= "'".BANK_ACCOUNT_ID."','".$project_data['project_id']."','".$project_data['sub_project_id']."',";
                    $sql .= "'".$challan_no."','".$its_no."','".$remarks."','".$amount."','".$amount."','".date('Y-m-d H:i:s')."',11)";
                    $arrSQL[] = $sql;
                    $con->query($sql);

                    $bank_receipt_detail_id = getGUID();
                    $sql = "insert into glt_bank_receipt_detail (bank_receipt_detail_id,company_id,company_branch_id,";
                    $sql .= "fiscal_year_id,bank_receipt_id,coa_id,amount,net_amount,base_amount,base_net_amount,created_at,created_by_id) VALUES ";
                    $sql .= "('".$bank_receipt_detail_id."','".COMPANY_ID."','".BRANCH_ID."','".$year['fiscal_year_id']."','".$bank_receipt_id."','".$project_data['revenue_account_id']."','".$amount."','".$amount."','".$amount."','".$amount."','".date('Y-m-d H:i:s')."',11)";
                    $arrSQL[] = $sql;
                    $con->query($sql);

                    $ledger_debit_id = getGUID();
                    $sql = "insert into core_ledger (ledger_id,company_id,company_branch_id,fiscal_year_id,document_type_id,document_id,document_detail_id,";
                    $sql .= "document_identity,document_date,its_no,challan_no,project_id,sub_project_id,coa_id,remarks,document_debit,debit,created_at,created_by_id) VALUES ";
                    $sql .= "('".$ledger_debit_id."','".COMPANY_ID."','".BRANCH_ID."','".$year['fiscal_year_id']."','".BANK_RECEIPT_ID."','".$bank_receipt_id."','".$bank_receipt_detail_id."','".$document['document_identity']."',";
                    $sql .= "'".$document_date."','".$its_no."','".$challan_no."','".$project_data['project_id']."','".$project_data['sub_project_id']."','".$project_data['bank_account_id']."','".$remarks."','".$amount."','".$amount."','".date('Y-m-d H:i:s')."',11)";
                    $arrSQL[] = $sql;
                    $con->query($sql);

                    $ledger_credit_id = getGUID();
                    $sql = "insert into core_ledger (ledger_id,company_id,company_branch_id,fiscal_year_id,document_type_id,document_id,document_detail_id,";
                    $sql .= "document_identity,document_date,its_no,challan_no,project_id,sub_project_id,coa_id,remarks,document_credit,credit,created_at,created_by_id) VALUES ";
                    $sql .= "('".$ledger_credit_id."','".COMPANY_ID."','".BRANCH_ID."','".$year['fiscal_year_id']."','".BANK_RECEIPT_ID."','".$bank_receipt_id."','".$bank_receipt_detail_id."','".$document['document_identity']."',";
                    $sql .= "'".$document_date."','".$its_no."','".$challan_no."','".$project_data['project_id']."','".$project_data['sub_project_id']."','".$project_data['revenue_account_id']."','".$remarks."','".$amount."','".$amount."','".date('Y-m-d H:i:s')."',11)";
                    $arrSQL[] = $sql;
                    $con->query($sql);

                    $sql = "insert into core_document (company_id,company_branch_id,fiscal_year_id,document_type_id,document_id,";
                    $sql .= "document_identity,document_date,document_amount,base_amount,created_at,created_by_id) VALUES ";
                    $sql .= "('".COMPANY_ID."','".COMPANY_ID."','".$year['fiscal_year_id']."','".BANK_RECEIPT_ID."','".$bank_receipt_id."','".$document['document_identity']."','".$document_date."','".$amount."','".$amount."','".date('Y-m-d H:i:s')."',11)";
                    $arrSQL[] = $sql;
                    $query = $con->query($sql);

                    //$con->commit();
                    $con->autocommit(true);


                    $json = array(
                        'success' => true,
                        'document_no' => $document_identity
                    );
                }
                else{
                    $json = array(
                        'success'=>false,
                        'error'=>'Invalid Event ID',
                    );
                }
            }
            else {
                $json = array(
                    'success' => false,
                    'error' => 'Invalid Document Date'
                );
            }

        }
    }
    catch(Exception $e){
        $con->rollback();
        $json = array(
            'success'=>false,
            'error'=>$e->getMessage()
        );
    }
    $con->close();
    $message = '['.date('Y-m-d H:i:s').'] - '.$_SERVER['REMOTE_ADDR'].' - ZiaratReceipt'.PHP_EOL;
    $message .= 'Request: '.json_encode(array('get'=>$_GET, 'post'=>$_POST)).PHP_EOL;
    $message .= 'Response: '.json_encode($json).PHP_EOL;
    file_put_contents('api.log', $message , FILE_APPEND | LOCK_EX);
    echo json_encode($json);
    exit;
}
