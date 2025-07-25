<?php

class ModelReportIncomeStatement extends HModel {

    protected function getTable() {
        return 'temp_income_statement';
    }

    public function getIncomeStatement($filter){
        $sql = 'SELECT SUM(debit-credit) AS amount,coa.`level2_display_name`,coa.`level1_name`,coa.gl_type_id,gt.`name` FROM core_ledger l';
        $sql .= " LEFT JOIN `vw_gl0_coa_all` coa ON coa.`coa_level3_id` = l.`coa_id`";
        $sql .= " LEFT JOIN `const_gl_type` gt ON gt.`gl_type_id` = coa.`gl_type_id`";
        $sql .= " WHERE (coa.`gl_type_id` = 4 OR coa.`gl_type_id`= 5) AND l.`document_date` >= '".$filter['date_from']."'  AND l.`document_date` <= '".$filter['date_to']."'";
        $sql .= " GROUP BY coa.`coa_level2_id`";
        $sql .= " ORDER BY `gl_type_id` ASC;";

        $query = $this->conn->query($sql);

        return $query->rows;
    }

//    public function getIncomeStatement($filter=array(), $sort_order=array()) {
//        $sql = "SELECT l.company_id, l.company_branch_id, l.fiscal_year_id";
//        $sql .= ",gl.name,c.coa_level1_id, c.level1_code, c.level1_display_name";
//        $sql .= ", c.coa_level2_id, c.level2_code, c.level2_display_name";
//        $sql .= ", c.coa_level3_id, c.level3_code, c.level3_display_name";
//        $sql .= ", SUM(l.debit) AS debit, SUM(l.credit) AS credit, SUM(l.debit-l.credit) AS balance ";
//        $sql .= " FROM `vw_ledger` l";
//        $sql .= " INNER JOIN `vw_coa_all` c ON c.company_id = l.company_id AND c.coa_level3_id = l.coa_id";
//        $sql .= " INNER JOIN gl_type gl ON gl.gl_type_id = c.gl_type_id";
//        if($filter) {
//            if(is_array($filter)) {
////                $table_columns = $this->getTableColumns($this->getTable());
//                $implode = array();
//                foreach($filter as $column => $value) {
////                    if(in_array($column,$table_columns)) {
//                    $implode[] = "`$column`='$value'";
////                    }
//                }
//                if($implode)
//                    $sql .= " WHERE " . implode(" AND ", $implode);
//            } else {
//                $sql .= " WHERE " . $filter;
//            }
//        }
//        $sql .= " AND c.gl_type_id IN (4,5,6,7) ";
//        $sql .= " GROUP BY c.coa_level3_id, c.level3_code, c.level3_display_name";
//        $sql .= " HAVING SUM(l.debit-l.credit) != 0";
//
//        if($sort_order) {
//            $sql .= " ORDER BY " . implode(',',$sort_order);
//        }
//
//        $query = $this->conn->query($sql);
////d(array($query,$sql,true));
//        return $query->rows;
//    }

}

?>