<?php

class ModelReportSaleOrderReport extends HModel{
    protected function getTable() {
        return 'ins_sale_order';
    }

    protected function getView() {
        return 'vw_ins_sale_order';
    }
	
	public function getProductJson($search, $page, $limit=25, $filter=array()) {
        if($page=='') {
            $page = 0;
        }
        $offset = $page*$limit;

        $arrWhere = array();
        $arrWhere[] = "`company_id` = '". $this->session->data['company_id'] ."'";
        $arrWhere[] = "(`product_code` LIKE '".$search."%' OR `name` LIKE '".$search."%')";
        $sql = "SELECT count(*) as total_records";
        $sql .= " FROM `vw_in0_product`";
        $sql .= " WHERE " . implode(' AND ', $arrWhere);
        $query = $this->conn->query($sql);
        $row = $query->row;
        $total_records = $row['total_records'];

        $sql = "SELECT *, product_id as id";
        $sql .= " FROM `vw_in0_product`";
        $sql .= " WHERE " . implode(' AND ', $arrWhere);
        $sql .= " LIMIT " . $offset . "," . $limit;
        $query = $this->conn->query($sql);
        $rows = $query->rows;

        return array(
            'total_count' => $total_records,
            'sql' => $sql,
            'items' => $rows
        );
    }

    public function getSaleOrderReport($filter = array(), $sort_order = array()){

        $sql = "";
        $sql .= "SELECT";
        $sql .= " `sod`.`company_id` AS `company_id`,"; 
        $sql .= " `sod`.`company_branch_id` AS `company_branch_id`,"; 
        $sql .= " `sod`.`fiscal_year_id` AS `fiscal_year_id`, ";
        $sql .= " `sod`.`sale_order_id` AS `sale_order_id`, ";
        $sql .= " `sod`.`sale_order_detail_id` AS `sale_order_detail_id`,"; 
        $sql .= " `so`.`document_date` AS `document_date`, ";
        $sql .= " `so`.`document_identity` AS `document_identity`,"; 
        $sql .= " `so`.`partner_type_id` AS `partner_type_id`, ";
        $sql .= " `so`.`partner_id` AS `partner_id`, ";
        $sql .= " `cp`.`name` AS `partner_name`, ";
        $sql .= " `sod`.`product_id` AS `product_id`, ";
        $sql .= " `p`.`product_code` AS `product_code`, ";
        $sql .= " `p`.`name` AS `product_name`, ";
        $sql .= " `sod`.`qty` AS `so_qty`, ";
        $sql .= " (";
        $sql .= " SELECT"; 
        $sql .= " SUM(`dcd`.`qty`) AS `qty`"; 
        $sql .= " FROM ";
        $sql .= " `ins_delivery_challan_detail` `dcd`"; 
        $sql .= " WHERE ";
        $sql .= " `dcd`.`company_id` = `sod`.`company_id`"; 
        $sql .= " AND `dcd`.`company_branch_id` = `sod`.`company_branch_id` ";
        $sql .= " AND `dcd`.`fiscal_year_id` = `sod`.`fiscal_year_id` ";
        $sql .= " AND `dcd`.`ref_document_identity` = `so`.`document_identity`"; 
        $sql .= " AND `dcd`.`product_id` = `sod`.`product_id`";
        $sql .= " ) AS `dc_qty`, ";
        $sql .= " (";
        $sql .= " SELECT"; 
        $sql .= " SUM(`sid`.`qty`) AS `qty`"; 
        $sql .= " FROM ";
        $sql .= " `ins_sale_tax_invoice_detail` `sid`"; 
        $sql .= " LEFT JOIN ins_delivery_challan dc ON dc.document_type_id = sid.ref_document_type_id ";
        $sql .= " AND dc.document_identity = sid.ref_document_identity ";
        $sql .= " WHERE ";
        $sql .= " `sid`.`company_id` = `sod`.`company_id`"; 
        $sql .= " AND `sid`.`company_branch_id` = `sod`.`company_branch_id` ";
        $sql .= " AND `sid`.`fiscal_year_id` = `sod`.`fiscal_year_id` ";
        $sql .= " AND `sid`.`ref_document_identity` = `dc`.`document_identity`"; 
        $sql .= " AND `sid`.`product_id` = `sod`.`product_id`";
        $sql .= " ) AS `si_qty`, ";
        $sql .= " `sod`.`rate` AS `rate`,"; 
        $sql .= " `sod`.`amount` AS `amount`,"; 
        $sql .= " `p`.`unit_id` AS `unit_id`, ";
        $sql .= " `u`.`name` AS unit, ";
        $sql .= " `u`.`code` AS unit_code"; 
        $sql .= " FROM ";
        $sql .= " `ins_sale_order_detail` `sod` ";
        $sql .= " INNER JOIN `ins_sale_order` `so` ON so.`sale_order_id` = sod.`sale_order_id`"; 
        $sql .= " INNER JOIN `in0_product_master` p ON p.`product_master_id` = sod.`product_master_id` ";
        $sql .= " INNER JOIN `in0_unit` u ON u.`unit_id` = sod.`unit_id` ";
        $sql .= " INNER JOIN `core_partner` AS cp ON cp.`partner_type_id` = so.`partner_type_id` ";
        $sql .= " AND `cp`.`partner_id` = `so`.`partner_id`";

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

        $query = $this->conn->query($sql);
        return $query->rows;

    }
}