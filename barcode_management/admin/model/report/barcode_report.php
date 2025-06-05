<?php

class ModelReportBarcodeReport extends HModel {

    protected function getTable() {
       return 'stock_ledger_history';
   }

   public function getReport($filter){


        $sql = "";
        $sql .= " SELECT ";
        $sql .= " l.serial_no,";
        $sql .= " l.batch_no,";
        $sql .= " p.product_code,";
        $sql .= " p.name AS product_name,";
        $sql .= " pc.name AS product_category,";
        $sql .= " CONCAT(IFNULL(p.product_code, ''), '-',IFNULL(b.name, ''),'-',IFNULL(m.name, ''),'-',IFNULL(p.name, '')) AS description,";
        $sql .= " w.name AS warehouse,";
        $sql .= " m.name AS model,";
        $sql .= " b.name AS brand,";
        $sql .= " SUM(base_qty) AS qty";
        $sql .= " FROM";
        $sql .= " core_stock_ledger_history l  ";
        $sql .= " LEFT JOIN in0_product p ";
        $sql .= " ON p.`company_id` = l.`company_id`"; 
        $sql .= " AND p.`product_id` = l.`product_id` ";
        $sql .= " LEFT JOIN in0_product_category pc ";
        $sql .= " ON pc.`company_id` = p.`company_id` ";
        $sql .= " AND pc.`product_category_id` = p.`product_category_id`";
        $sql .= " LEFT JOIN in0_warehouse w";
        $sql .= " ON w.`company_id` = l.`company_id`"; 
        $sql .= " AND w.`warehouse_id` = l.`warehouse_id`";
        $sql .= " LEFT JOIN in0_brand b";
        $sql .= " ON b.`company_id` = p.`company_id`"; 
        $sql .= " AND b.`brand_id` = p.`brand_id`";
        $sql .= " LEFT JOIN in0_model m";
        $sql .= " ON m.`company_id` = p.`company_id`"; 
        $sql .= " AND m.`model_id` = p.`model_id`";

        $sql .= " WHERE l.`company_id` = '".$filter['company_id']."'";
        $sql .= " AND l.`company_branch_id` = '".$filter['company_branch_id']."'";
        $sql .= " AND l.`fiscal_year_id` = '".$filter['fiscal_year_id']."'";
        $sql .= " AND l.`document_date` <= '".$filter['to_date']."'";
        
        if(isset($filter['product_id']) && $filter['product_id'] != ''){
            $sql .= " AND p.`product_id` = '".$filter['product_id']."'";
        }

        if(isset($filter['product_category_id']) && $filter['product_category_id'] != ''){
            $sql .= " AND p.`product_category_id` = '".$filter['product_category_id']."'";
        }

        if(isset($filter['warehouse_id']) && $filter['warehouse_id'] != ''){
            $sql .= " AND l.`warehouse_id` = '".$filter['warehouse_id']."'";
        }
        

        $sql .= " GROUP BY l.serial_no ";
        $sql .= " HAVING qty > 0 ";
        $sql .= " ORDER BY p.name";

        $query = $this->db->query($sql);
        return $query->rows;

   }

}
