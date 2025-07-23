<?php

class ModelInventoryJobOrder extends HModel {

    protected function getTable() {
        return 'ins_job_order';
    }

    protected function getView() {
        return 'ins_job_order';
    }

    public function getFilteredRows(){
        $sql = "SELECT jo.`document_identity`, jo.`job_order_id` FROM `ins_job_order` `jo` LEFT JOIN `ins_job_order_estimate` joe 
        ON `jo`.job_order_id = `joe`.job_order_id WHERE joe.`job_order_id` IS NULL";

        $query = $this->conn->query($sql);
        $job_orders = $query->rows;

        return $job_orders;
    }

    public function getFilteredRowsForPI(){
        $sql = "SELECT jo.`document_identity`, jo.`job_order_id` FROM `ins_job_order` `jo` LEFT JOIN `ins_product_issuance` pi 
        ON `jo`.job_order_id = `pi`.job_order_id WHERE pi.`job_order_id` IS NULL";

        $query = $this->conn->query($sql);
        $job_orders = $query->rows;

        return $job_orders;
    }

     public function getFilteredRowsForPID($job_order_id = ''){
        if($job_order_id == '')
        {

        $sql = "SELECT jo.`document_identity`, jo.`job_order_id` FROM `ins_job_order` `jo` JOIN `ins_product_issuance` pi 
        ON `jo`.job_order_id = `pi`.job_order_id
        LEFT JOIN `ins_sale_tax_invoice` sti ON `sti`.job_order_id = `pi`.job_order_id WHERE sti.`job_order_id` IS NULL
        ";
        }
        else
        {
          $sql = "SELECT jo.`document_identity`, jo.`job_order_id` FROM `ins_job_order` `jo` JOIN `ins_product_issuance` pi 
          ON `jo`.job_order_id = `pi`.job_order_id
          JOIN `ins_sale_tax_invoice` sti ON `sti`.job_order_id = `pi`.job_order_id WHERE sti.`job_order_id` = '".$job_order_id."'
        ";
        }
        $query = $this->conn->query($sql);
        $job_orders = $query->rows;
        return $job_orders;
    }


      public function getFilteredRowsForJOE($job_order_id = ''){
        if($job_order_id == '')
        {

        $sql = "SELECT jo.`document_identity`, jo.`job_order_id` FROM `ins_job_order` `jo` JOIN `ins_job_order_estimate` joe
        ON `joe`.job_order_id = `jo`.job_order_id
        LEFT JOIN `ins_sale_tax_invoice` sti ON `sti`.job_order_id = `joe`.job_order_id WHERE sti.`job_order_id` IS NULL AND `joe`.is_post = 1
 
        ";
        }
        else
        {
          $sql = "SELECT jo.`document_identity`, jo.`job_order_id` FROM `ins_job_order` `jo` JOIN `ins_job_order_estimate` joe 
          ON `jo`.job_order_id = `jo`.job_order_id
          JOIN `ins_sale_tax_invoice` sti ON `sti`.job_order_id = `joe`.job_order_id WHERE sti.`job_order_id` = '".$job_order_id."'
          AND `joe`.is_post = 1
        ";
        }
        // ";
        $query = $this->conn->query($sql);
        $job_orders = $query->rows;
        return $job_orders;
    }



    public function getJobOrderDetails($filter=array(), $sort_order=array()) {
       
         $sql = "SELECT `jo`.`company_id` AS `company_id`,`jo`.`job_order_id` AS `job_order_id`,
        `jo`.`company_branch_id` AS `company_branch_id`,`jo`.`fiscal_year_id` AS `fiscal_year_id`,
        `jo`.`document_prefix` AS `document_prefix`,`jo`.`document_no` AS `document_no`,
        `jo`.`document_type_id` AS `document_type_id`, `jo`.`document_identity` AS `document_identity`,
        `jo`.`job_order_id` AS `job_order_id`,`jo`.`document_date`     AS `document_date`,
        `jo`.`customer_name` AS `customer_name`,
        `jo`.`customer_contact` AS `customer_contact`,
        `jo`.`customer_address` AS `customer_address`,
        `jo`.`customer_email` AS `customer_email`,
        `jo`.`document_identity` AS `job_order_no`,
        `jo`.`purchase_date` AS `purchased_date`,
        `jo`.`repair_receive_date` AS `received_date`,
        `jo`.`repair_complete_date` AS `complete_date`,
        `jo`.`delivery_date` AS `delivery_date`,
        `jo`.`document_identity` AS `job_order_no`,
        `jo`.`product_id` AS `product_id`,
        `jo`.`product_model` AS `model`,
        `jo`.`warranty_status` AS `warranty`,
        `jo`.`warranty_type` AS `warranty_type`,
        `jo`.`warranty_card_no` AS `warranty_card_no`,
        `jo`.`product_serial_no` AS `product_serial_no`,
        `jo`.`fault_description` AS `fault_description`,
        `jo`.`repair_remarks` AS `repair_remarks`,
        `jo`.`job_order_type` AS `job_order_type`,
        `jo`.`created_at` AS `created_at`,
        `jo`.`created_by_id` AS `created_by_id`,
        `p`.`name` AS `product_name`,
        `p`.`wholesale_price` AS `service_charges` FROM (`ins_job_order` `jo`
        JOIN `in0_product` `p`
        ON (`p`.`product_id` = `jo`.`product_id`)) ";
       
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


}

?>