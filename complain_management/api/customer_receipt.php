<?php
include('config.php');

$message = '['.date('Y-m-d H:i:s').'] - '.$_SERVER['REMOTE_ADDR'].' - TenantReceipt'.PHP_EOL;
$message .= 'Request: '.json_encode(array('get'=>$_GET, 'post'=>$_POST)).PHP_EOL;
file_put_contents('api.log', $message , FILE_APPEND | LOCK_EX);
if (validateToken($_GET['token'])) {
    $con = mysqli_connect(DB_SERVER,DB_USER,DB_PASSWORD,DB_MASTER);

    $company_id = $_SESSION['company_id'];
    $company_branch_id = $_SESSION['company_branch_id'];
    $currency_id = 9;
    $conversion_rate = 1;
    try {
        $customer_code = $_POST['customer_code'];
        $document_date = $_POST['receipt_date'];
        $manual_ref_no = $_POST['receipt_no'];
        $remarks = $_POST['remarks'];
        $total_amount = $_POST['receipt_amount'];

        if($total_amount=='') {
            $total_amount = 0;
        }

        $arrError = array();

        if($document_date=='') {
            $arrError[] = '`invoice_date` is required';
        } else {
            $d = DateTime::createFromFormat('Y-m-d', $document_date);
            if(!($d && $d->format('Y-m-d') === $document_date)) {
                $arrError[] = '`invoice_date` is required in valid format ['.date('Y-m-d').']';
            }
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
            $sql .= " WHERE `company_id` = '".$company_id."' AND '".$document_date."' > `date_from` AND '".$document_date."' <= `date_to`";
            $query = $con->query($sql);
            if($query->num_rows) {
                $year = $query->fetch_assoc();
                ///echo json_encode($year);
                //exit;
                $_SESSION['fiscal_year_id'] = $year['fiscal_year_id'];
                $_SESSION['fy_code'] = $year['fy_code'];
                $con->select_db($year['db_name']);

                $sql = "select *";
                $sql .= " from `core_customer`";
                $sql .= " where customer_code = '".$customer_code."'";
                $query = $con->query($sql);
                if($query->num_rows > 0) {
                    $customer = $query->fetch_assoc();
                    $partner_type_id = 2;
                    $partner_id = $customer['customer_id'];

                    $document = getNextDocument($con, DT_CASH_RECEIPT_ID);
                    $document_type_id = DT_CASH_RECEIPT_ID;
                    $document_prefix = $document['document_prefix'];
                    $document_no = $document['document_no'];
                    $document_identity = $document['document_identity'];

                    //$con->begin_transaction();
                    $arrSQL = [];
                    $con->autocommit(false);
                    $con->begin_transaction(MYSQLI_TRANS_START_READ_WRITE);
                    $cash_receipt_id = getGUID();
                    $company_id = $_SESSION['company_id'];
                    $company_branch_id = $_SESSION['company_branch_id'];
                    $fiscal_year_id = $_SESSION['fiscal_year_id'];
                    $document_id = $cash_receipt_id;

                    $data = array(
                        'cash_receipt_id' => $cash_receipt_id,
                        'company_id' => $company_id,
                        'company_branch_id' => $company_branch_id,
                        'fiscal_year_id' => $fiscal_year_id,
                        'document_type_id' => $document_type_id,
                        'document_prefix' => $document_prefix,
                        'document_no' => $document_no,
                        'document_date' => $document_date,
                        'document_identity' => $document_identity,
                        'manual_ref_no' => $manual_ref_no,
                        'transaction_account_id' => CASH_ACCOUNT_ID,
                        'partner_type_id' => $partner_type_id,
                        'partner_id' => $partner_id,
                        'remarks' => $remarks,
                        'document_currency_id' => '9',
                        'total_amount' => $total_amount,
                        'total_net_amount' => $total_amount,
                        'conversion_rate' => 1,
                        'base_total_amount' => $total_amount,
                        'base_total_net_amount' => $total_amount,
                        'created_at' => date('Y-m-d H:i:s'),
                        'created_by_id' => $_SESSION['user_id'],
                    );

                    $sql = getInsertSQL('glt_cash_receipt', $data);
                    $arrSQL[] = $sql;
                    if (!$con->query($sql)) {
                        throw new Exception($con->error);
                    }


                    $document_data = array(
                        'company_id' => $company_id,
                        'company_branch_id' => $company_branch_id,
                        'fiscal_year_id' => $fiscal_year_id,
                        'document_type_id' => $document_type_id,
                        'document_id' => $document_id,
                        'document_identity' => $document_identity,
                        'document_date' => $document_date,
                        'partner_type_id' => $partner_type_id,
                        'partner_id' => $partner_id,
                        'document_currency_id' => $currency_id,
                        'document_amount' => $total_amount,
                        'conversion_rate' => $conversion_rate,
                        'base_currency_id' => $currency_id,
                        'base_amount' => $total_amount,
                        'created_at' => date('Y-m-d H:i:s'),
                        'created_by_id' => $_SESSION['user_id'],
                    );
                    $sql = getInsertSQL('core_document', $document_data);
                    $arrSQL[] = $sql;
                    if (!$con->query($sql)) {
                        throw new Exception($con->error);
                    }

                    $cash_receipt_detail_id = getGUID();
                    $receipt_detail_data = array(
                        'company_id' => $company_id,
                        'company_branch_id' => $company_branch_id,
                        'fiscal_year_id' => $fiscal_year_id,
                        'cash_receipt_id' => $cash_receipt_id,
                        'cash_receipt_detail_id' => $cash_receipt_detail_id,
                        'coa_id' => CUSTOMER_OUTSTANDING_ID,
                        'remarks' => $remarks,
                        'document_currency_id' => $currency_id,
                        'amount' => $total_amount,
                        'net_amount' => $total_amount,
                        'base_currency_id' => $currency_id,
                        'conversion_rate' => $conversion_rate,
                        'base_amount' => $total_amount,
                        'base_net_amount' => $total_amount,
                        'created_at' => date('Y-m-d H:i:s'),
                        'created_by_id' => $_SESSION['user_id'],
                    );
                    $sql = getInsertSQL('glt_cash_receipt_detail', $receipt_detail_data);
                    $arrSQL[] = $sql;
                    if (!$con->query($sql)) {
                        throw new Exception($con->error);
                    }

                    $ledger_id = getGUID();
                    $ledger_data = array(
                        'ledger_id' => $ledger_id,
                        'company_id' => $company_id,
                        'company_branch_id' => $company_branch_id,
                        'fiscal_year_id' => $fiscal_year_id,
                        'document_type_id' => $document_type_id,
                        'document_id' => $document_id,
                        'document_identity' => $document_identity,
                        'document_detail_id' => $cash_receipt_detail_id,
                        'document_date' => $document_date,
                        'partner_type_id' => $partner_type_id,
                        'partner_id' => $partner_id,
                        'remarks' => $remarks,
                        'document_currency_id' => $currency_id,
                        'base_currency_id' => $currency_id,
                        'conversion_rate' => $conversion_rate,
                        'coa_id' => CASH_ACCOUNT_ID,
                        'document_credit' => 0,
                        'document_debit' => $total_amount,
                        'credit' => 0,
                        'debit' => $total_amount,
                        'created_at' => date('Y-m-d H:i:s'),
                        'created_by_id' => $_SESSION['user_id'],
                    );
                    $sql = getInsertSQL('core_ledger', $ledger_data);
                    $arrSQL[] = $sql;
                    if (!$con->query($sql)) {
                        throw new Exception($con->error);
                    }

                    $ledger_id = getGUID();
                    $ledger_data = array(
                        'ledger_id' => $ledger_id,
                        'company_id' => $company_id,
                        'company_branch_id' => $company_branch_id,
                        'fiscal_year_id' => $fiscal_year_id,
                        'document_type_id' => $document_type_id,
                        'document_id' => $document_id,
                        'document_identity' => $document_identity,
                        'document_detail_id' => $cash_receipt_detail_id,
                        'document_date' => $document_date,
                        'partner_type_id' => $partner_type_id,
                        'partner_id' => $partner_id,
                        'remarks' => $remarks,
                        'document_currency_id' => $currency_id,
                        'base_currency_id' => $currency_id,
                        'conversion_rate' => $conversion_rate,
                        'coa_id' => CUSTOMER_OUTSTANDING_ID,
                        'document_debit' => 0,
                        'document_credit' => $total_amount,
                        'debit' => 0,
                        'credit' => $total_amount,
                        'created_at' => date('Y-m-d H:i:s'),
                        'created_by_id' => $_SESSION['user_id'],
                    );
                    $sql = getInsertSQL('core_ledger', $ledger_data);
                    $arrSQL[] = $sql;
                    if (!$con->query($sql)) {
                        throw new Exception($con->error);
                    }

                    $con->commit();
                    //$con->autocommit(true);
                    $json = array(
                        'success' => true,
                        'sql' => $arrSQL,
                        'receipt_no' => $document_identity
                    );
                } else {
                    $json = array(
                        'success' => false,
                        'error' => 'Invalid Document Date'
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
            'error' => $e->getMessage(),
            'sql' => $arrSQL
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