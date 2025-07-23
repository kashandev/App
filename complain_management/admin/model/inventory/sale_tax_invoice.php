<?php

class ModelInventorySaleTaxInvoice extends HModel {

    protected function getTable() {
        return 'ins_sale_tax_invoice';
    }

    protected function getView() {
        return 'vw_ins_sale_tax_invoice';
    }

    protected function getListRecord() {

        return 'vw_ins_sale_tax_invoice_pending_status';
    }

    public function getLists($data) {
        if(!isset($data['filter'])) {
            $data['filter'] = array();
        }
        if(!isset($data['criteria'])) {
            $data['criteria'] = array();
        }
        $filterSQL = $this->getFilterString($data['filter']);
        $criteriaSQL = $this->getCriteriaString($data['criteria']);

        $sql = "SELECT count(*) as total";
        $sql .= " FROM " . DB_PREFIX . $this->getListRecord();
        if($filterSQL) {
            $sql .= " WHERE " . $filterSQL;
        }
        $query = $this->conn->query($sql);
        $table_total = $query->row['total'];

        $sql = "SELECT count(*) as total";
        $sql .= " FROM " . DB_PREFIX . $this->getListRecord();
        if($filterSQL) {
            $sql .= " WHERE " . $filterSQL;
        }
        $query = $this->conn->query($sql);
        $total = $query->row['total'];

        $sql = "SELECT *";
        $sql .= " FROM " . DB_PREFIX . $this->getListRecord();
        if($filterSQL) {
            $sql .= " WHERE " . $filterSQL;
        }
        if($criteriaSQL) {
            $sql .= $criteriaSQL;
        }

//        d($sql,true);
        $query = $this->conn->query($sql);
        $lists = $query->rows;

        return array('table_total' => $table_total, 'total' => $total, 'lists' => $lists);
    }

    public function getNextDocument($document_type_id) {
        $sql = "SELECT * FROM `core_company_branch_document_prefix`";
        $sql .= " where `company_id`='".$this->session->data['company_id']."'";
        //$sql .= " AND `company_branch_id`='".$this->session->data['company_branch_id']."'";
        $sql .= " AND `document_type_id` = '".$document_type_id."'";
        $query = $this->conn->query($sql);
        $row = $query->row;
        if(empty($row)) {
            $sql = "SELECT * FROM `const_document_type` where `document_type_id` = '".$document_type_id."'";
            $query = $this->conn->query($sql);
            $row = $query->row;
        }

        $table_name = $row['table_name'];
        $aSearch = array('{FY}','{BC}');
        $aReplace = array($this->session->data['fy_code'], $this->session->data['branch_code']);
        $prefix = str_replace($aSearch, $aReplace, $row['document_prefix']);

        $sql = "SELECT MAX(document_no) as max_no FROM `".$table_name."`";
        $sql .= " WHERE `company_id` = '".$this->session->data['company_id']."'";
        // $sql .= " AND `document_prefix` = '".$prefix."'";
        $query = $this->conn->query($sql);
        $record = $query->row;

        if(empty($record['max_no'])) {
            $max_no =  1;
        } else {
            $max_no =  $record['max_no']+1;
        }
        $document_identity = $prefix . str_pad($max_no,$row['zero_padding'],"0",STR_PAD_LEFT);

        return array(
            'sql' => $sql,
            'document_type' => $row['document_name'],
            'document_no' => $max_no,
            'document_prefix' => $prefix,
            'document_identity' => $document_identity,
            'route' => $row['route'],
            'table_name' => $row['table_name'],
            'primary_key' => $row['primary_key']
        );
    }

    public function getSaleInvNextDocument($document_type_id)
    {
        $sql = "SELECT * FROM `core_company_branch_document_prefix`";
        $sql .= " where `company_id`='".$this->session->data['company_id']."'";
        //$sql .= " AND `company_branch_id`='".$this->session->data['company_branch_id']."'";
        $sql .= " AND `document_type_id` = '".$document_type_id."'";
        $query = $this->conn->query($sql);
        $row = $query->row;
        if(empty($row)) {
            $sql = "SELECT * FROM `const_document_type` where `document_type_id` = '".$document_type_id."'";
            $query = $this->conn->query($sql);
            $row = $query->row;
        }

        $table_name = 'ins_sale_tax_invoice';
        $aSearch = array('{FY}','{BC}');
        $aReplace = array($this->session->data['fy_code'], $this->session->data['branch_code']);
        $prefix = str_replace($aSearch, $aReplace, $row['document_prefix']);

        $sql = "SELECT MAX(document_no) as max_no FROM `".$table_name."`";
        $sql .= " WHERE `company_id` = '".$this->session->data['company_id']."'";
        $sql .= " AND `sale_type` = 'sale_invoice'";
        $query = $this->conn->query($sql);
        $record = $query->row;

        if(empty($record['max_no'])) {
            $max_no =  1;
        } else {
            $max_no =  $record['max_no']+1;
        }
        $document_identity = $prefix . str_pad($max_no,$row['zero_padding'],"0",STR_PAD_LEFT);

        return array(
            'sql' => $sql,
            'document_type' => 'Sales Tax Invoice',
            'document_no' => $max_no,
            'document_prefix' => $prefix,
            'document_identity' => $document_identity,
            'route' => 'inventory/sale_tax_invoice',
            'table_name' => 'ins_sale_tax_invoice',
            'primary_key' => 'sale_tax_invoice_id'
        );
    }

    public function getSaleTaxNo()
    {
        $sql = "SELECT MAX(sale_tax_no) as sale_tax_no FROM `ins_sale_tax_invoice`";
        $sql .= " WHERE `company_id` = '".$this->session->data['company_id']."'";
        $sql .= " AND `sale_type` = 'sale_tax_invoice'";
        $query = $this->conn->query($sql);
        return $record = $query->row;
    }

    public function getPreviousBalance($filter) {
        
        $sql =  "SELECT";
        $sql .= " SUM(`l`.`debit`) - SUM(`l`.`credit`) AS `previous_balance`";
        $sql .= " FROM `core_ledger` `l`";
        $sql .= " INNER JOIN `core_partner` `p` ON `l`.`partner_id` = `p`.`partner_id`";
        $sql .= " AND `l`.`coa_id` = `p`.`outstanding_account_id`";
        $sql .= " {$filter}";
        $query = $this->conn->query($sql);
        if( $query->row ){
            return $query->row['previous_balance'];
        }
        return 0;
    }

     public function get_sale_tax_invoice($filter=array(), $sort_order=array()){
        $sql = "SELECT *";
        $sql .= " FROM " . DB_PREFIX . $this->getTable();
        if($filter) {
            if(is_array($filter)) {
                $implode = array();
                foreach($filter as $column => $value) {
                    $implode[] = "`$column`='$value'";
                }
                if($implode)
                    $sql .= " WHERE " . implode(" AND ", $implode);
            } else {
                $sql .= " WHERE " . $filter;
            }
        }
        if($sort_order) {
            $sql .= " ORDER BY " . implode(',',$sort_order);
        }
        $query = $this->conn->query($sql);
        return $query->row;
    }



  public function getJobOrder($filter=array(), $sort_order=array()) {
       
         $sql = "SELECT `jo`.`company_id` AS `company_id`,`jo`.`job_order_id` AS `job_order_id`,
        `jo`.`company_branch_id` AS `company_branch_id`,`jo`.`fiscal_year_id` AS `fiscal_year_id`,
        `jo`.`document_prefix` AS `document_prefix`,`jo`.`document_no` AS `document_no`,
        `jo`.`document_type_id` AS `document_type_id`, `sti`.`document_identity` AS `invoice_no`,
        `jo`.`job_order_id` AS `job_order_id`,`jo`.`document_date`     AS `document_date`,

        `sti`.`customer_name` AS `customer_name`,
        `jo`.`customer_contact` AS `customer_contact`,
        `jo`.`customer_address` AS `customer_address`,
        `jo`.`customer_email` AS `customer_email`,
        `jo`.`document_identity` AS `job_order_no`,
        `jo`.`purchase_date` AS `purchased_date`,
        `jo`.`repair_receive_date` AS `received_date`,
        `jo`.`repair_complete_date` AS `complete_date`,
        `jo`.`delivery_date` AS `delivery_date`,
        `jo`.`product_id` AS `product_id`,
        `jo`.`product_model` AS `model`,
        `jo`.`warranty_status` AS `warranty`,
        `jo`.`warranty_type` AS `warranty_type`,
        `jo`.`warranty_card_no` AS `warranty_card_no`,
        `jo`.`product_serial_no` AS `product_serial_no`,
        `jo`.`fault_description` AS `fault_description`,
        `jo`.`document_identity` AS `job_order_no`,
        `jo`.`repair_remarks` AS `repair_remarks`,
        `jo`.`created_at` AS `created_at`,
        `jo`.`created_by_id` AS `created_by_id`
        FROM (`ins_job_order` `jo`
        LEFT JOIN `ins_sale_tax_invoice` `sti`
        ON (`sti`.`job_order_id` = `jo`.`job_order_id`)) ";
       
        if($filter) {
            if(is_array($filter)) {
                //$table_columns = $this->getTableColumns($this->getTable());
               $implode = array();
                foreach($filter as $column => $value) {
                    //if(in_array($column,$table_columns)) {
                    $implode[] = "`$column`='$value'";
                    //}
                }
                if($implode)
                    $sql .= " WHERE " . implode(" AND ", $implode);
            } else {
                $sql .= " WHERE " . $filter;
            }
        }

        if($sort_order) {
            $sql .= " ORDER BY " . implode(',',$sort_order);
        }
     // d($sql,true);

        $query = $this->conn->query($sql);
        return $query->row;
       
    }

   public function getSaleInvoice($filter=array(), $sort_order=array()) {
       
         $sql = "SELECT `sti`.`document_identity` AS `invoice_no`,
        `sti`.`sale_tax_invoice_id` AS `sale_tax_invoice_id`,`sti`.`document_date` AS `document_date`,
        `sti`.`print_date` AS `print_date`,`sti`.`customer_name` AS `customer_name`,
        `sti`.`mobile` AS `customer_contact`
         FROM `ins_sale_tax_invoice` `sti`";
        if($filter) {
            if(is_array($filter)) {
                //$table_columns = $this->getTableColumns($this->getTable());
                $implode = array();
                foreach($filter as $column => $value) {
                    //if(in_array($column,$table_columns)) {
                    $implode[] = "`$column`='$value'";
                    //}
                }
                if($implode)
                    $sql .= " WHERE " . implode(" AND ", $implode);
            } else {
                $sql .= " WHERE " . $filter;
            }
        }

        if($sort_order) {
            $sql .= " ORDER BY " . implode(',',$sort_order);
        }
     // d($sql,true);

        $query = $this->conn->query($sql);
        return $query->row;
       
    }


    public function getSaleInvoiceDetail($filter=array(), $sort_order=array()) {
    
       $sql = "SELECT `stid`.`company_id` AS `company_id`, `stid`.`sale_tax_invoice_detail_id` AS `sale_tax_invoice_detail_id`, `stid`.`company_branch_id`  AS `company_branch_id`,
       `stid`.`part_name` AS `part_name`,`p`.`name` AS `service_name`,  `stid`.`product_code` AS `product_code`, `stid`.`product_id` AS `product_id`,
       `stid`.`product_type` AS `product_type`, `stid`.`qty` AS `qty`,`stid`.`rate` AS `rate`, 
       `stid`.`amount` AS `amount`, `stid`.`created_at` AS `created_at`,`stid`.`created_by_id` AS `created_by_id` 
       FROM `ins_sale_tax_invoice_detail` `stid`  LEFT JOIN `in0_product` `p` on `p`.`product_id` = `stid`.`product_id` ";
        
        if($filter) {
            if(is_array($filter)) {
                //$table_columns = $this->getTableColumns($this->getTable());
                $implode = array();
                foreach($filter as $column => $value) {
                    //if(in_array($column,$table_columns)) {
                    $implode[] = "`$column`='$value'";
                    //}
                }
                if($implode)
                    $sql .= " WHERE " . implode(" AND ", $implode);
            } else {
                $sql .= " WHERE " . $filter;
            }
        }

        if($sort_order) {
            $sql .= " ORDER BY " . implode(',',$sort_order);
        }

        $query = $this->conn->query($sql);
        return $query->rows;
    }

}

?>