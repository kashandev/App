<?php

class ModelInventoryProductIssuance extends HModel {

    protected function getTable() {
        return 'ins_product_issuance';
    }

    protected function getView() {
        return 'ins_product_issuance';
    }

    public function getProductIssuance($filter=array(), $sort_order=array()) {
       
        $sql = "SELECT `pi`.`company_id` AS `company_id`,`pi`.`product_issuance_id` AS `product_issuance_id`,
       `pi`.`company_branch_id` AS `company_branch_id`,`pi`.`fiscal_year_id` AS `fiscal_year_id`,
       `pi`.`document_prefix` AS `document_prefix`,`pi`.`document_no` AS `document_no`,
       `pi`.`document_type_id` AS `document_type_id`, `pi`.`document_identity` AS `document_identity`,
       `pi`.`job_order_id` AS `job_order_id`,`pi`.`document_date`     AS `document_date`,
       `jo`.`customer_name` AS `customer_name`,
       `jo`.`document_identity` AS `job_order_no`,
       `jo`.`product_id` AS `product_id`,
       `jo`.`product_model` AS `model`,
       `jo`.`product_serial_no` AS `product_serial_no`,
       `jo`.`fault_description` AS `fault_description`,
       `jo`.`symptom` AS `symptom`,
       `pi`.`created_at` AS `created_at`,
       `pi`.`created_by_id` AS `created_by_id`,
       `p`.`name` AS `product_name`  FROM ((`ins_product_issuance` `pi`
       JOIN `ins_job_order` `jo`
       ON (`pi`.`job_order_id` = `jo`.`job_order_id`))
       JOIN `in0_product` `p`
       ON (`p`.`product_id` = `jo`.`product_id`))";
      

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
    //    d($sql,true);

       $query = $this->conn->query($sql);
       return $query->row;
      
   }

   public function getProductsByJobOrder($id){
    
    $sql = "SELECT 
    `jo`.`customer_name` AS `customer_name`,
    `jo`.`product_name` AS `job_order_product_name`,
    `joe`.`job_order_estimate_id` AS `job_order_estimate_id`,
    `joed`.`product_code`,
    `joed`.`part_name`,
    `joed`.`product_id`,
    `joed`.`product_code`,
    `joed`.`product_type` , 
    `joed`.`quantity`,
    `joed`.`rate`,
    `joed`.`amount`, 
    `p`.`name` AS `product_name`
    FROM (((`ins_job_order` `jo`
    JOIN `ins_job_order_estimate` `joe` ON (`jo`.`job_order_id` = `joe`.`job_order_id`))
    JOIN `ins_job_order_estimate_detail` `joed` ON (`joe`.`job_order_estimate_id` = `joed`.`job_order_estimate_id` ))
    LEFT JOIN `in0_product` `p` ON (`joed`.`product_id` = `p`.`product_id` ))
    WHERE `jo`.job_order_id ='".$id."'";

    // d($sql,true);
    $query = $this->conn->query($sql);
    return $query->rows;
   }


   public function getProductsByIssuance($id){
    
    $sql = "SELECT 
    `pi`.`product_issuance_id` AS `product_issuance_id`,
    `pid`.`product_id`,
    `pid`.`product_code`,
    `pid`.`product_type`,
    `pid`.`part_name`, 
    `pid`.`quantity`,
    `pid`.`rate`,
    `pid`.`amount`, 
    `p`.`name` AS `product_name`,
    `pu`.`name` AS `product_unit`
    FROM ((((`ins_product_issuance` `pi`
    JOIN `ins_job_order` `jo` ON (`jo`.`job_order_id` = `pi`.`job_order_id`))
    JOIN `ins_product_issuance_detail` `pid` ON (`pi`.`product_issuance_id` = `pid`.`product_issuance_id` ))
    LEFT JOIN `in0_product` `p` ON (`pid`.`product_id` = `p`.`product_id` ))
    LEFT JOIN `in0_unit` `pu` ON (`pu`.`unit_id` = `p`.`unit_id` ))
    WHERE `pi`.job_order_id ='".$id."'";
    $query = $this->conn->query($sql);
    return $query->rows;
   }


   protected function defaultColumns() {
    $sql = "SELECT `pi`.`company_id` AS `company_id`,`pi`.`product_issuance_id` AS `product_issuance_id`,
    `pi`.`company_branch_id` AS `company_branch_id`,`pi`.`fiscal_year_id` AS `fiscal_year_id`,
    `pi`.`document_prefix` AS `document_prefix`,`pi`.`document_no` AS `document_no`,
    `pi`.`document_type_id` AS `document_type_id`, `pi`.`document_identity` AS `document_identity`,
    `pi`.`job_order_id` AS `job_order_id`,`pi`.`document_date` AS `document_date`,
    `jo`.`customer_name` AS `customer_name`,
    `jo`.`document_identity` AS `job_order_no`,
    `jo`.`product_id` AS `product_id`,
    `jo`.`product_model` AS `model`,
    `jo`.`product_serial_no` AS `product_serial_no`,
    `jo`.`fault_description` AS `fault_description`,
    `jo`.`symptom` AS `symptom`,
    `pi`.`created_at` AS `created_at`,
    `pi`.`created_by_id` AS `created_by_id`,
    `p`.`name` AS `product_name`";

    return $sql;
}

private function getListColumns() {
    $sql = "pi.*, jo.`document_identity` AS job_order_identity, jo.`customer_name`, p.`name` AS product_name, jo.`fault_description` AS fault_description";

    return $sql;
}

   private function getListView() {
    $sql = "`ins_product_issuance` `pi`".PHP_EOL;
    $sql .= " INNER JOIN `ins_job_order` `jo` ON `pi`.`job_order_id` = `jo`.`job_order_id`".PHP_EOL;
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