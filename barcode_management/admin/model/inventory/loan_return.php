<?php

class ModelInventoryLoanReturn extends HModel {

    protected function getTable() {
        return 'ina_loan_return';
    }

    protected function getView() {
        return $this->getViewForm();
    }

    public function getViewForm(){
        $sql = "";
        $sql .= " ( ";
        $sql .= " SELECT";
        $sql .= " `lr`.*,";
        $sql .= " `w`.`name` AS `warehouse`";
        $sql .= " FROM `ina_loan_return` `lr`";
        $sql .= " LEFT JOIN `in0_warehouse` `w`";
        $sql .= " ON `w`.`company_id` = `lr`.`company_id`";
        $sql .= " AND `w`.`warehouse_id` = `lr`.`warehouse_id`";
        $sql .= " ) `lr` ";
        return $sql;
    }

}

?>