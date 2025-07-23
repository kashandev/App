<?php

class ModelInventoryJobOrderEstimate extends HModel {

    protected function getTable() {
        return 'ins_job_order_estimate';
    }

    protected function getView() {
        return 'ins_job_order_estimate';
    }

    public function getJobOrderEstimate($filter=array(), $sort_order=array()) {
       
         $sql = "SELECT `joe`.`company_id` AS `company_id`,`joe`.`job_order_estimate_id` AS `job_order_estimate_id`,
        `joe`.`company_branch_id` AS `company_branch_id`,`joe`.`fiscal_year_id` AS `fiscal_year_id`,
        `joe`.`document_prefix` AS `document_prefix`,`joe`.`document_no` AS `document_no`,
        `joe`.`document_type_id` AS `document_type_id`, `joe`.`document_identity` AS `document_identity`,
        `joe`.`job_order_id` AS `job_order_id`,`joe`.`document_date`     AS `document_date`,
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
        `jo`.`symptom` AS `symptom`,
        `joe`.`created_at` AS `created_at`,
        `joe`.`created_by_id` AS `created_by_id`,
        `joe`.`is_post` AS `is_post`,
        `p`.`name` AS `product_name`  FROM ((`ins_job_order_estimate` `joe`
        JOIN `ins_job_order` `jo`
        ON (`joe`.`job_order_id` = `jo`.`job_order_id`))
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


    public function getJobOrderEstimateDetail($filter=array(), $sort_order=array()) {
    
       $sql = "SELECT `joed`.`company_id` AS `company_id`, `joed`.`job_order_estimate_detail_id` AS `job_order_estimate_detail_id`,
       `joed`.`job_order_estimate_id`   AS `job_order_estimate_id`, `joed`.`company_branch_id`      AS `company_branch_id`,
       `joed`.`part_name` AS `part_name`,`p`.`name` AS `service_name`,  `joed`.`product_code` AS `product_code`, `joed`.`product_id` AS `product_id`,
       `joed`.`product_type` AS `product_type`, `joed`.`quantity` AS `quantity`,`joed`.`rate` AS `rate`, 
       `joed`.`amount` AS `amount`, `joed`.`created_at` AS `created_at`,`joed`.`created_by_id` AS `created_by_id` 
       FROM `ins_job_order_estimate_detail` `joed`  LEFT JOIN `in0_product` `p` on `p`.`product_id` = `joed`.`product_id` ";
        
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



   public function getProductsByEstimate($id){
    
    $sql = "SELECT 
    `joe`.`job_order_estimate_id` AS `job_order_estimate_id`,
    `jo`.`customer_name`,
    `jo`.`customer_contact`,
    `joed`.`product_id`,
    `joed`.`product_code`,
    `joed`.`product_type`,
    `joed`.`part_name`, 
    `joed`.`quantity`,
    `joed`.`rate`,
    `joed`.`amount`, 
    `p`.`name` AS `product_name`,
    `pu`.`unit_id` AS `unit_id`,
    `pu`.`name` AS `product_unit`
    FROM ((((`ins_job_order_estimate` `joe`
    JOIN `ins_job_order_estimate_detail` `joed` ON (`joed`.`job_order_estimate_id` = `joe`.`job_order_estimate_id` ))
    JOIN `ins_job_order` `jo` ON (`jo`.`job_order_id` = `joe`.`job_order_id`))
    LEFT JOIN `in0_product` `p` ON (`joed`.`product_id` = `p`.`product_id` ))
    LEFT JOIN `in0_unit` `pu` ON (`pu`.`unit_id` = `p`.`unit_id` ))
    WHERE `joe`.job_order_id ='".$id."' AND `joe`.`is_post` = 1";
    $query = $this->conn->query($sql);
    return $query->rows;
   }


//    public function getListView($data) {
//        if(!isset($data['filter'])) {
//            $data['filter'] = array();
//        }
//        if(!isset($data['criteria'])) {
//            $data['criteria'] = array();
//        }
//        $filterSQL = $this->getFilterString($data['filter']);
//        $criteriaSQL = $this->getCriteriaString($data['criteria']);
//
//
//        $sql = "SELECT count(*) as total";
//        $sql .= " FROM " . DB_PREFIX . $this->getView();
//        if($filterSQL) {
//            $sql .= " WHERE " . $filterSQL;
//        }
//
//        $query = $this->conn->query($sql);
//        $total = $query->row['total'];
//
//        $sql = "SELECT `joe`.`company_id` AS `company_id`,`joe`.`job_order_estimate_id` AS `job_order_estimate_id`,
//        `joe`.`company_branch_id` AS `company_branch_id`,`joe`.`fiscal_year_id` AS `fiscal_year_id`,
//        `joe`.`document_prefix` AS `document_prefix`,`joe`.`document_no` AS `document_no`,
//        `joe`.`document_type_id` AS `document_type_id`, `joe`.`document_identity` AS `document_identity`,
//        `joe`.`job_order_id` AS `job_order_id`,`joe`.`document_date`     AS `document_date`,
//        `jo`.`customer_name` AS `customer_name`,
//        `jo`.`document_identity` AS `job_order_no`,
//        `jo`.`product_id` AS `product_id`,
//        `jo`.`product_model` AS `model`,
//        `jo`.`product_serial_no` AS `product_serial_no`,
//        `jo`.`fault_description` AS `fault_description`,
//        `jo`.`symptom` AS `symptom`,
//        `joe`.`created_at` AS `created_at`,
//        `joe`.`created_by_id` AS `created_by_id`,
//        `p`.`name` AS `product_name`  FROM ((`ins_job_order_estimate` `joe`
//        JOIN `ins_job_order` `jo`
//        ON (`joe`.`job_order_id` = `jo`.`job_order_id`))
//        JOIN `in0_product` `p`
//        ON (`p`.`product_id` = `jo`.`product_id`))";
//
//        $counter = 0;
//        $filterIs="";
//        $newFilter=explode(" AND ",$filterSQL);
//        foreach($newFilter as $new){
//            $filterIs.=" `joe`.".$new;
//            if( $counter != count( $newFilter ) - 1) {
//
//                // Print the array content
//                $filterIs.=" AND ";
//            }
//            $counter++;
//        }
//        if($filterSQL) {
//            $sql .= " WHERE  " . $filterIs;
//        }
//        if($criteriaSQL) {
//            $sql .= $criteriaSQL;
//        }
//        // d($sql ,true);
//
//        $query = $this->conn->query($sql);
//        $lists = $query->rows;
//
//        return array('table_total' => $table_total, 'total' => $total, 'lists' => $lists);
//
//    }

    protected function defaultColumns() {
        $sql = "SELECT `joe`.`company_id` AS `company_id`,`joe`.`job_order_estimate_id` AS `job_order_estimate_id`,
        `joe`.`company_branch_id` AS `company_branch_id`,`joe`.`fiscal_year_id` AS `fiscal_year_id`,
        `joe`.`document_prefix` AS `document_prefix`,`joe`.`document_no` AS `document_no`,
        `joe`.`document_type_id` AS `document_type_id`, `joe`.`document_identity` AS `document_identity`,
        `joe`.`job_order_id` AS `job_order_id`,`joe`.`document_date`     AS `document_date`,
        `jo`.`customer_name` AS `customer_name`,
        `jo`.`document_identity` AS `job_order_no`,
        `jo`.`product_id` AS `product_id`,
        `jo`.`product_model` AS `model`,
        `jo`.`product_serial_no` AS `product_serial_no`,
        `jo`.`fault_description` AS `fault_description`,
        `jo`.`symptom` AS `symptom`,
        `joe`.`created_at` AS `created_at`,
        `joe`.`created_by_id` AS `created_by_id`,
        `p`.`name` AS `product_name`";

        return $sql;
    }

    private function getListColumns() {
        $sql = "joe.*,jo.`document_identity` AS job_order_identity, jo.`customer_name`, p.`name` AS product_name, jo.`fault_description` AS fault_description";

        return $sql;
    }

    private function getListView() {
        $sql = "`ins_job_order_estimate` `joe`".PHP_EOL;
        $sql .= " INNER JOIN `ins_job_order` `jo` ON `joe`.`job_order_id` = `jo`.`job_order_id`".PHP_EOL;
        $sql .= " INNER JOIN `in0_product` `p` ON `p`.`product_id` = `jo`.`product_id`".PHP_EOL;

        return $sql;
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
        $sql .= " FROM " . DB_PREFIX . $this->getListView();
        if($filterSQL) {
            $sql .= " WHERE " . $filterSQL;
        }
        $query = $this->conn->query($sql);
        $table_total = $query->row['total'];

        $sql = "SELECT count(*) as total";
        $sql .= " FROM " . DB_PREFIX . $this->getListView();
        if($filterSQL) {
            $sql .= " WHERE " . $filterSQL;
        }
        $query = $this->conn->query($sql);
        $total = $query->row['total'];

        $sql = "SELECT ". $this->getListColumns();
        $sql .= " FROM " . DB_PREFIX . $this->getListView();
        if($filterSQL) {
            $sql .= " WHERE " . $filterSQL;
        }
        if($criteriaSQL) {
            $sql .= $criteriaSQL;
        }

        $query = $this->conn->query($sql);
        $lists = $query->rows;

        return array('table_total' => $table_total, 'total' => $total, 'lists' => $lists);
    }

}

?>