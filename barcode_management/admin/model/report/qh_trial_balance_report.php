<?php

class ModelReportQhTrialBalanceReport extends HModel {

    protected function getTable() {
        return 'vw_qh_qarze_hassana_repayment_detail';
    }

    public function getData($where){
        $sql = "";
        $sql .= "  SELECT p.partner_id,p.its_no,p.name AS partner_name,max(rq.amaanat_no) as amaanat_no,";
        $sql .= "  (";
        $sql .= "  SELECT SUM(debit - credit)";
        $sql .= "  FROM vw_core_ledger o";
        $sql .= "  WHERE ( o.`coa_id` = '{8099ECF7-BB38-C0B7-F74C-C6801909793F}' OR o.`coa_id` = '{4C4EEEDF-30EE-8504-6BB3-00319DF298AB}' OR o.coa_id = '{FB632835-E147-D5C9-7699-801BBE6FAD7E}')";
        $sql .= "  AND o.document_date < '2018-07-01'";
        $sql .= "  AND o.partner_type_id = l.partner_type_id AND o.partner_id = l.partner_id";
        $sql .= "  ) AS opening";
        $sql .= "  , SUM(debit) AS debit, SUM(credit) AS credit";
        $sql .= "  FROM `vw_core_ledger` l";
        $sql .= "  INNER JOIN `core_partner` p ON p.`company_id` = l.`company_id`  AND p.`partner_type_id` = l.`partner_type_id` AND p.partner_id = l.partner_id";
        $sql .= "  LEFT JOIN `qh_qarze_hassana_request` rq ON rq.`its_no` = p.`its_no` and rq.project_id = l.project_id AND rq.sub_project_id = l.sub_project_id";
        $sql .= "  WHERE (l.`coa_id` = '{8099ECF7-BB38-C0B7-F74C-C6801909793F}' OR l.`coa_id` = '{4C4EEEDF-30EE-8504-6BB3-00319DF298AB}' OR l.coa_id = '{FB632835-E147-D5C9-7699-801BBE6FAD7E}')";
        $sql .= "  AND l.`document_date` >= '2018-07-01'";



//        $sql .= "  SELECT p.partner_id,p.its_no,p.name AS partner_name,";
//        $sql .= " ( SELECT SUM(debit - credit) FROM vw_core_ledger l";
//        $sql .= " WHERE(l.`coa_id` = '{8099ECF7-BB38-C0B7-F74C-C6801909793F}' ";
//        $sql .= " OR l.`coa_id` = '{4C4EEEDF-30EE-8504-6BB3-00319DF298AB}' ";
//        $sql .= "  OR l.coa_id = '{FB632835-E147-D5C9-7699-801BBE6FAD7E}') ";
//        $sql .= "  AND p.`partner_id` = l.`partner_id` AND l.document_date < '2018-07-01'";
//        $sql .= " GROUP BY  l.partner_id,coa_id) AS opening,";
//        $sql .= " SUM(credit) as credit, SUM(debit) as debit,rq.amaanat_no FROM vw_core_ledger l";
//        $sql .= " INNER JOIN `core_partner` p ON p.`company_id` = l.`company_id`  AND p.`partner_type_id` = l.`partner_type_id` ";
//        $sql .= " AND p.`partner_id` = l.`partner_id` AND l.`coa_id` = p.`outstanding_account_id`";
//        $sql .= "  LEFT JOIN `qh_qarze_hassana_request` rq ON rq.`its_no` = p.`its_no` and rq.project_id = l.project_id AND rq.sub_project_id = l.sub_project_id";
//        $sql .= " where l.`document_date` > '2018-07-01'";
        if($where) {
            if(is_array($where)) {
                $table_columns = $this->getTableColumns($this->getTable());
                $implode = array();
                foreach($where as $column => $value) {
                    if(in_array($column,$table_columns)) {
                        $implode[] = "`$column`='$value'";
                    }
                }
                if($implode)
                    $sql .= " AND  " . implode(" AND ", $implode);
            } else {
                $sql .= " AND  " . $where;
            }
        }

        $sql .= " GROUP BY  l.partner_id ";
        $sql .= " ORDER BY rq.`amaanat_no` ASC";
        $query = $this->conn->query($sql);
         $row = $query->rows;
       // d($query,true);
        return $row;
    }

//    public function getLedgerData($filter){
//        $sql = "";
//        $sql .= "  SELECT qh.*,level3.`name` AS coa_name, sp.project_name,sp.name AS sub_project_name";
//        $sql .= " FROM `qh_qarze_hassana_request` qh";
//        $sql .= " LEFT JOIN `vw_gl0_coa_level3` level3 ON level3.coa_level3_id = qh.receivable_account_id";
//        $sql .= " LEFT JOIN `vw_core_sub_project` sp ON sp.project_id = qh.project_id AND sp.sub_project_id = qh.sub_project_id";
//
//        if($filter) {
//            if(is_array($filter)) {
//                $table_columns = $this->getTableColumns($this->getTable());
//                $implode = array();
//                foreach($filter as $column => $value) {
//                    if(in_array($column,$table_columns)) {
//                        $implode[] = "`$column`='$value'";
//                    }
//                }
//                if($implode)
//                    $sql .= " where  " . implode(" AND ", $implode);
//            } else {
//                $sql .= " where  " . $filter;
//            }
//        }
//        /*$sql .= " UNION";
//        $sql .= " SELECT SUM(debit - credit) balance FROM core_ledger";
//        $sql .= " WHERE `document_type_id` IN (38,39) AND cheque_date < '2018-08-11'";
//        $sql .= " GROUP BY coa_id";
//        */
//        $query = $this->conn->query($sql);
//        //d($query,true);
//        $rows = $query->rows;
//        return $rows;
//    }
}

?>