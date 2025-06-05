<?php

class ModelInventoryLoanDc extends HModel {

    protected function getTable() {
        return 'ina_loan_dc';
    }

    protected function getView() {
        return $this->getViewForm();
    }

    public function getViewForm(){
        $sql = "";
        $sql .= " ( ";
        $sql .= " SELECT";
        $sql .= " `ld`.*,";
        $sql .= " `w`.`name` AS `warehouse`,";
        $sql .= " `p`.`name` AS `partner_name`";
        $sql .= " FROM `ina_loan_dc` `ld`";
        $sql .= " LEFT JOIN `in0_warehouse` `w`";
        $sql .= " ON `w`.`company_id` = `ld`.`company_id`";
        $sql .= " AND `w`.`warehouse_id` = `ld`.`warehouse_id`";
        $sql .= " LEFT JOIN `core_partner` `p`";
        $sql .= " ON `p`.`company_id` = `ld`.`company_id`";
        $sql .= " AND `p`.`partner_id` = `ld`.`partner_id`";
        $sql .= " ) `ld` ";
        return $sql;
    }

}

?>