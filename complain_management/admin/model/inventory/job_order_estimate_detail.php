<?php

class ModelInventoryJobOrderEstimateDetail extends HModel {

    protected function getTable() {
        return 'ins_job_order_estimate_detail';
    }

    protected function getView() {
        return 'ins_job_order_estimate_detail';
    }

    public function getJobOrderEstimateDetail($filter=array(), $sort_order=array()) {
    
       $sql = "SELECT `joed`.`company_id` AS `company_id`, `joed`.`job_order_estimate_detail_id` AS `job_order_estimate_detail_id`,
       `joed`.`job_order_estimate_id` 	AS `job_order_estimate_id`, `joed`.`company_branch_id`		AS `company_branch_id`,
       `joed`.`part_name` AS `part_name`, `joed`.`product_code` AS `product_code`, `joed`.`product_id` AS `product_id`,
       `joed`.`product_type` AS `product_type`, `joed`.`quantity` AS `quantity`,`joed`.`rate` AS `rate`, 
       `joed`.`amount` AS `amount`, `joed`.`created_at` AS `created_at`,`joed`.`created_by_id` AS `created_by_id` 
       FROM `ins_job_order_estimate_detail` `joed`";
        
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