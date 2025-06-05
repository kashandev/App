<?php

class ModelReportPurchaseOrderReport extends HModel {

    protected function getTable() {
        return 'vw_inp_purchase_order_detail';
    }


    public function getWarehouseSales($filter=array(), $sort_order=array()) {
        $sql = "SELECT warehouse_id, warehouse, product_category_id, product_category, product_id, product_code, product, unit_id, unit, sum(qty) as qty, sum(amount) as amount, round(sum(amount)/sum(qty),2) as rate";
        $sql .= " FROM `" . DB_PREFIX . $this->getTable() . "`";
        if($filter) {
            if(is_array($filter)) {
                $table_columns = $this->getTableColumns($this->getTable());
                $implode = array();
                foreach($filter as $column => $value) {
                    if(in_array($column,$table_columns)) {
                        $implode[] = "`$column`='$value'";
                    }
                }
                if($implode)
                    $sql .= " WHERE " . implode(" AND ", $implode);
            } else {
                $sql .= " WHERE " . $filter;
            }
        }
        $sql .= "GROUP BY warehouse_id, warehouse, product_category_id, product_category, product_id, product_code, product, unit_id, unit";

        if($sort_order) {
            $sql .= " ORDER BY " . implode(',',$sort_order);
        }

        $query = $this->conn->query($sql);

        return $query->rows;
    }


    public function getPurchaseOrderReport($filter = array(), $sort_order = array()){

        $sql = "";
        $sql .= " SELECT";
        $sql .= " `pod`.`company_id`                 AS `company_id`,";
        $sql .= " `pod`.`company_branch_id`          AS `company_branch_id`,";
        $sql .= " `pod`.`fiscal_year_id`             AS `fiscal_year_id`, ";
        $sql .= " `pod`.`purchase_order_id`          AS `purchase_order_id`,";
        $sql .= " `pod`.`purchase_order_detail_id`   AS `purchase_order_detail_id`,";
        $sql .= " `po`.`document_date`               AS `document_date`, ";
        $sql .= " `po`.`document_identity`           AS `document_identity`,";
        $sql .= " `po`.`partner_type_id`             AS `partner_type_id`, ";
        $sql .= " `po`.`partner_id`                  AS `partner_id`, ";
        $sql .= " `cp`.`name`                        AS `partner_name`,";
        $sql .= " `pod`.`product_id`                 AS `product_id`, ";
        $sql .= " `p`.`product_code`                 AS `product_code`, ";
        $sql .= " `p`.`name`                         AS `product_name`, ";
        $sql .= " `pod`.`qty`                        AS `po_qty`, ";

        $sql .= " CASE WHEN `po`.`invoice_type` = 'Import' THEN";

        $sql .= " (";

        $sql .= " SELECT SUM(`pid`.`qty`)           AS `qty`";
        $sql .= " FROM `inp_purchase_invoice_detail` `pid` ";
        $sql .= " WHERE `pid`.`company_id`          = `pod`.`company_id` ";
        $sql .= " AND `pid`.`company_branch_id`     = `pod`.`company_branch_id` ";
        $sql .= " AND `pid`.`fiscal_year_id`        = `pod`.`fiscal_year_id` ";
        $sql .= " AND `pid`.`ref_document_identity` = `po`.`document_identity`";
        $sql .= " AND `pid`.`product_id`            = `pod`.`product_id`";

        $sql .= " ) ELSE (";

        $sql .= " SELECT SUM(`grd`.`qty`)           AS `qty`";
        $sql .= " FROM `inp_goods_received_detail` `grd` ";
        $sql .= " WHERE `grd`.`company_id`          = `pod`.`company_id` ";
        $sql .= " AND `grd`.`company_branch_id`     = `pod`.`company_branch_id` ";
        $sql .= " AND `grd`.`fiscal_year_id`        = `pod`.`fiscal_year_id` ";
        $sql .= " AND `grd`.`ref_document_identity` = `po`.`document_identity`";
        $sql .= " AND `grd`.`product_id`            = `pod`.`product_id`";

        $sql .= " ) END                            AS `mrn_qty`,";

        $sql .= " `pod`.`rate`                     AS `rate`, ";
        $sql .= " `pod`.`amount`                   AS `amount`, ";
        $sql .= " `p`.`unit_id`                    AS `unit_id`,";
        $sql .= " `u`.`name`                       AS unit, ";
        $sql .= " `u`.`code`                       AS unit_code ";

        $sql .= " FROM `inp_purchase_order_detail` `pod`";
        $sql .= " INNER JOIN `inp_purchase_order` po ON po.`purchase_order_id` = pod.`purchase_order_id`";
        $sql .= " left JOIN `in0_product_master` p ON p.`product_master_id` = pod.`product_id` ";
        $sql .= " left JOIN `in0_unit` u ON u.`unit_id` = pod.`unit_id` ";
        $sql .= " left JOIN `core_partner` AS cp ON cp.`partner_type_id` = po.`partner_type_id` ";
        $sql .= " AND `cp`.`partner_id` = `po`.`partner_id` ";

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

        if($sort_order){
            $sql .= " ORDER BY " . implode(',',$sort_order);
        }

        //d($sql, true);

        $query = $this->conn->query($sql);
        return $query->rows;

    }

}

?>