<?php

class ModelInventoryLoanReturnDetail extends HModel {

    protected function getTable() {
        return 'ina_loan_return_detail';
    }

    protected function getView() {
        return $this->getViewForm();
    }

    public function getViewForm(){
        $sql = "";
        $sql .= " ( ";
        $sql .= " SELECT";
        $sql .= " `lrd`.*,";
        $sql .= " `pm`.`name` AS `product_name`,";
        $sql .= " `u`.`name` AS `unit`,";
        $sql .= " `wd`.`name` AS `warehouse_name`";
        $sql .= " FROM `ina_loan_return_detail` `lrd`";
        $sql .= " LEFT JOIN `ina_loan_return` `lr`";
        $sql .= " ON `lr`.`company_id` = `lrd`.`company_id`";
        $sql .= " AND `lr`.`loan_return_id` = `lrd`.`loan_return_id`";
        $sql .= " LEFT JOIN `in0_product_master` `pm`";
        $sql .= " ON `pm`.`company_id` = `lrd`.`company_id`";
        $sql .= " AND `pm`.`product_master_id` = `lrd`.`product_id`";
        $sql .= " LEFT JOIN `in0_unit` `u`";
        $sql .= " ON `u`.`company_id` = `lrd`.`company_id`";
        $sql .= " AND `u`.`unit_id` = `lrd`.`unit_id`";
        $sql .= " LEFT JOIN `in0_warehouse` `wd`";
        $sql .= " ON `wd`.`company_id` = `lrd`.`company_id`";
        $sql .= " AND `wd`.`warehouse_id` = `lrd`.`warehouse_id`";
        $sql .= " ) `lrd` ";
        return $sql;
    }

}

?>