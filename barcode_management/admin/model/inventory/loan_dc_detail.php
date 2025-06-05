<?php

class ModelInventoryLoanDcDetail extends HModel {

    protected function getTable() {
        return 'ina_loan_dc_detail';
    }

    protected function getView() {
        return $this->getViewForm();
    }

    public function getViewForm(){
        $sql = "";
        $sql .= " ( ";
        $sql .= " SELECT";
        $sql .= " `ldd`.*,";
        $sql .= " `p`.`name` AS `product_name`,";
        $sql .= " `u`.`name` AS `unit`,";
        $sql .= " `wd`.`name` AS `warehouse_name`";
        $sql .= " FROM `ina_loan_dc_detail` `ldd`";
        $sql .= " LEFT JOIN `ina_loan_dc` `ld`";
        $sql .= " ON `ld`.`company_id` = `ldd`.`company_id`";
        $sql .= " AND `ld`.`loan_dc_id` = `ldd`.`loan_dc_id`";
        $sql .= " LEFT JOIN `in0_product` `p`";
        $sql .= " ON `p`.`company_id` = `ldd`.`company_id`";
        $sql .= " AND `p`.`product_id` = `ldd`.`product_id`";
        $sql .= " LEFT JOIN `in0_unit` `u`";
        $sql .= " ON `u`.`company_id` = `ldd`.`company_id`";
        $sql .= " AND `u`.`unit_id` = `ldd`.`unit_id`";
        $sql .= " LEFT JOIN `in0_warehouse` `wd`";
        $sql .= " ON `wd`.`company_id` = `ldd`.`company_id`";
        $sql .= " AND `wd`.`warehouse_id` = `ldd`.`warehouse_id`";
        $sql .= " ) `ldd` ";
        return $sql;
    }

    public function getProductVendorSerials($loan_dc_id, $product_master_id){
        $sql .= " SELECT GROUP_CONCAT(p.`vendor_serial_no`) AS vendor_serial_no, SUM(qty) AS qty";
        $sql .= " FROM ina_loan_dc_detail ldd";
        $sql .= " INNER JOIN in0_product p";
        $sql .= " ON p.product_id = ldd.product_id";
        $sql .= " WHERE ldd.loan_dc_id = '{$loan_dc_id}'";
        $sql .= " AND p.product_master_id = '{$product_master_id}'";
        $query = $this->db->query($sql);
        return $query->row;
    }

}

?>