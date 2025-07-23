<?php
include('config.php');

$message = '['.date('Y-m-d H:i:s').'] - '.$_SERVER['REMOTE_ADDR'].' - Customer with Invoice'.PHP_EOL;
$message .= 'Request: '.json_encode(array('get'=>$_GET, 'post'=>$_POST)).PHP_EOL;
file_put_contents('api.log', $message , FILE_APPEND | LOCK_EX);
if (validateToken($_GET['token'])) {
    $con = mysqli_connect(DB_SERVER,DB_USER,DB_PASSWORD,DB_MASTER);

    $company_id = $_SESSION['company_id'];
    $company_branch_id = $_SESSION['company_branch_id'];
    try {
        $customer_name = $_POST['customer_name'];
        $customer_code = $_POST['customer_code'];
        $customer_phone = $_POST['customer_phone'];
        $customer_mobile = $_POST['customer_mobile'];
        $customer_address = $_POST['customer_address'];
        $customer_email = $_POST['customer_email'];
        $customer_gst_no = $_POST['customer_gst_no'];
        $customer_ntn_no = $_POST['customer_ntn_no'];

        $document_date = $_POST['invoice_date'];
        $manual_ref_no = $_POST['invoice_no'];
        $remarks = $_POST['invoice_description'];
        $total_amount = $_POST['invoice_amount'];

        $arrError = array();

        if($customer_name=='') {
            $arrError[] = '`customer_name` is required';
        }

        if($customer_code=='') {
            $arrError[] = '`customer_code` is required';
        }

        if($document_date=='') {
            $arrError[] = '`document_date` is required';
        } else {
            $d = DateTime::createFromFormat('Y-m-d', $document_date);
            if(!($d && $d->format('Y-m-d') === $document_date)) {
                $arrError[] = '`invoice_date` is required in valid format ['.date('Y-m-d').']';
            }
        }

        if($manual_ref_no=='') {
            $arrError[] = '`invoice_no` is required';
        }

        if($remarks=='') {
            $arrError[] = '`invoice_description` is required.';
        }

        if(!is_numeric($total_amount)) {
            $arrError[] = '`invoice_amount` is required and must be numeric.';
        } elseif ($total_amount=='0') {
            $arrError[] = '`invoice_amount` is required.';
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
                    $customer_id = $customer['customer_id'];
                } else {
                    $customer_id = getGUID();
                    $sql = "INSERT INTO `core_customer` SET `company_id`='$company_id', `company_branch_id`='$company_branch_id', `customer_id` = '$customer_id', `customer_code`='$customer_code', `name`='$customer_name', `address`='$customer_address', `phone`='$customer_phone', `mobile`='$customer_mobile', `email`='$customer_email', `gst_no`='$customer_gst_no', `ntn_no`='$customer_ntn_no', `document_currency_id`=9, `outstanding_account_id`='".CUSTOMER_OUTSTANDING_ID."', `advance_account_id`='".CUSTOMER_ADVANCE_ID."'";
                    $query = $con->query($sql);
                    $sql = "INSERT INTO `core_partner` SET `partner_type_id`='2', `partner_type`='Customer', `company_id`='$company_id', `company_branch_id`='$company_branch_id', `partner_id` = '$customer_id', `ref_id`='$customer_code', `name`='$customer_name', `address`='$customer_address', `phone`='$customer_phone', `mobile`='$customer_mobile', `email`='$customer_email', `gst_no`='$customer_gst_no', `ntn_no`='$customer_ntn_no', `document_currency_id`=9, `outstanding_account_id`='".CUSTOMER_OUTSTANDING_ID."', `advance_account_id`='".CUSTOMER_ADVANCE_ID."'";
                    $query = $con->query($sql);
                }

                $document = getNextDocument($con, DT_DEBIT_INVOICE_ID);
                $document_type_id = DT_DEBIT_INVOICE_ID;
                $document_prefix = $document['document_prefix'];
                $document_no = $document['document_no'];
                $document_identity = $document['document_identity'];

                //$con->begin_transaction();
                $arrSQL = [];
                $con->autocommit(false);
                $con->begin_transaction(MYSQLI_TRANS_START_READ_WRITE);
                $debit_invoice_id = getGUID();
                $company_id = $_SESSION['company_id'];
                $company_branch_id = $_SESSION['company_branch_id'];
                $fiscal_year_id = $_SESSION['fiscal_year_id'];

                $sql = "INSERT INTO `gli_debit_invoice` SET `debit_invoice_id`='$debit_invoice_id', `company_id`='$company_id', `company_branch_id`='$company_branch_id', `fiscal_year_id`='$fiscal_year_id'";
                $sql .= ", `document_type_id`='$document_type_id', `document_prefix`='$document_prefix', `document_no`='$document_no', `document_identity`='$document_identity', `document_date`='$document_date'";
                $sql .= ", `manual_ref_no`='$manual_ref_no', `partner_type_id`='2', `partner_id`='$customer_id', `remarks`='$remarks', `document_currency_id`='9', `total_amount`='$total_amount', `net_amount`='$total_amount'";
                $sql .= ", `base_currency_id`='9', `conversion_rate`='1', `base_amount`='$total_amount', `created_at`='".date('Y-m-d H:i:s')."', `created_by_id`='".$_SESSION['user_id']."'";
                if (!$con->query($sql)) {
                    throw new Exception($con->error);
                }
                $arrSQL[] = $sql;

                $debit_invoice_detail_id = getGUID();
                $sql = "INSERT INTO `gli_debit_invoice_detail` SET `company_id`='$company_id', `company_branch_id`='$company_branch_id', `fiscal_year_id`='$fiscal_year_id', `debit_invoice_id`='$debit_invoice_id', `debit_invoice_detail_id`='$debit_invoice_detail_id'";
                $sql .= ", `partner_type_id`='2', `partner_id`='$customer_id', `sort_order`='0', `coa_id`='".REVENUE_ACCOUNT_ID."', `remarks`='$remarks', `quantity`='1', `rate`='$total_amount', `amount`='$total_amount', `base_currency_id`='9', `conversion_rate`='1', `base_amount`='$total_amount'";
                $sql .= ", `created_at`='".date('Y-m-d H:i:s')."', `created_by_id`='".$_SESSION['user_id']."'";
                $arrSQL[] = $sql;
                if (!$con->query($sql)) {
                    throw new Exception($con->error);
                }

                $ledger_debit_id = getGUID();
                $sql = "INSERT INTO `core_ledger` SET `ledger_id`='$ledger_debit_id', `company_id`='$company_id', `company_branch_id`='$company_branch_id', `fiscal_year_id`='$fiscal_year_id'";
                $sql .= ", `document_type_id`='".DT_DEBIT_INVOICE_ID."', `document_date`='$document_date', `document_identity`='$document_identity'";
                $sql .= ", `document_id`='$debit_invoice_id', `document_detail_id`='$debit_invoice_detail_id', `sort_order`=0";
                $sql .= ", `partner_type_id`='2', `partner_id`='$customer_id', `ref_document_type_id`='".DT_DEBIT_INVOICE_ID."', `ref_document_identity`='$document_identity'";
                $sql .= ", `coa_id`='".CUSTOMER_OUTSTANDING_ID."', `remarks`='$remarks', `document_currency_id`='9', `document_debit`='$total_amount', `document_credit`='0'";
                $sql .= ", `base_currency_id`='9', `conversion_rate`='1', `debit`='$total_amount', `credit`='0', `created_at`='".date('Y-m-d H:i:s')."', `created_by_id`='".$_SESSION['user_id']."'";
                $arrSQL[] = $sql;
                if (!$con->query($sql)) {
                    throw new Exception($con->error);
                }

                $ledger_credit_id = getGUID();
                $sql = "INSERT INTO `core_ledger` SET `ledger_id`='$ledger_credit_id', `company_id`='$company_id', `company_branch_id`='$company_branch_id', `fiscal_year_id`='$fiscal_year_id'";
                $sql .= ", `document_type_id`='".DT_DEBIT_INVOICE_ID."', `document_date`='$document_date', `document_identity`='$document_identity'";
                $sql .= ", `document_id`='$debit_invoice_id', `document_detail_id`='$debit_invoice_detail_id', `sort_order`=0";
                $sql .= ", `partner_type_id`='2', `partner_id`='$customer_id', `ref_document_type_id`='".DT_DEBIT_INVOICE_ID."', `ref_document_identity`='$document_identity'";
                $sql .= ", `coa_id`='".REVENUE_ACCOUNT_ID."', `remarks`='$remarks', `document_currency_id`='9', `document_credit`='$total_amount', `document_debit`='0'";
                $sql .= ", `base_currency_id`='9', `conversion_rate`='1', `credit`='$total_amount', `debit`='0', `created_at`='".date('Y-m-d H:i:s')."', `created_by_id`='".$_SESSION['user_id']."'";
                $arrSQL[] = $sql;
                if (!$con->query($sql)) {
                    throw new Exception($con->error);
                }

                $sql = "INSERT INTO `core_document` SET `company_id`='$company_id', `company_branch_id`='$company_branch_id', `fiscal_year_id`='$fiscal_year_id'";
                $sql .= ", `partner_type_id`='2', `partner_id`='$customer_id', `document_type_id`='".DT_DEBIT_INVOICE_ID."', `document_id`='$debit_invoice_id', `document_identity`='$document_identity', `document_date`='$document_date'";
                $sql .= ", `route`='".$document['route']."', `primary_key_field`='".$document['primary_key']."', `primary_key_value`='$debit_invoice_id'";
                $sql .= ", `document_currency_id`='9', `document_amount`='$total_amount', `conversion_rate`='1', `base_currency_id`='9', `base_amount`='$total_amount'";
                $sql .= ", `created_at`='".date('Y-m-d H:i:s')."', `created_by_id`='".$_SESSION['user_id']."'";
                $arrSQL[] = $sql;
                if (!$con->query($sql)) {
                    throw new Exception($con->error);
                }

                $con->commit();
                //$con->autocommit(true);
                $json = array(
                    'success' => true,
                    //'sql' => $arrSQL,
                    'invoice_no' => $document_identity
                );
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

    $message = '['.date('Y-m-d H:i:s').'] - '.$_SERVER['REMOTE_ADDR'].' - Customer Invoice'.PHP_EOL;
    $message .= 'Request: '.json_encode(array('get'=>$_GET, 'post'=>$_POST)).PHP_EOL;
    $message .= 'Response: '.json_encode($json).PHP_EOL;
    file_put_contents('api.log', $message , FILE_APPEND | LOCK_EX);
    echo json_encode($json);
    exit;
}

echo json_encode("here2");
exit;
?>