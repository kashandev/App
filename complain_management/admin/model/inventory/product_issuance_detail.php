<?php

class ModelInventoryProductIssuanceDetail extends HModel {

    protected function getTable() {
        return 'ins_product_issuance_detail';
    }

    protected function getView() {
        return 'ins_product_issuance_detail';
    }

    public function getJobOrderEstimateDetail($filter=array(), $sort_order=array()) {
    
       $sql = "SELECT `pid`.`company_id` AS `company_id`, `pid`.`product_issuance_detail_id` AS `product_issuance_detail_id`,
       `pid`.`product_issuance_id` 	AS `product_issuance_id`, `pid`.`company_branch_id`		AS `company_branch_id`,
       `pid`.`part_name` AS `part_name`, `pid`.`product_code` AS `product_code`, `pid`.`product_id` AS `product_id`,
       `pid`.`product_type` AS `product_type`, `pid`.`quantity` AS `quantity`,`pid`.`rate` AS `rate`, 
       `pid`.`amount` AS `amount`, `pid`.`created_at` AS `created_at`,`pid`.`created_by_id` AS `created_by_id` 
       FROM `ins_product_issuance_detail` `pid`";
        
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
        return $query->rows;
    }
}

?>