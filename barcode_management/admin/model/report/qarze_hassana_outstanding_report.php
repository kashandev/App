<?php

class ModelReportQarzeHassanaOutstandingReport extends HModel {

    protected function getTable() {
        return 'vw_qh_qarze_hassana_repayment_detail';
    }

    public function getOutstanding($where){
        $sql = "";

        $sql .= " SELECT l.`partner_id`,p.name,p.its_no,request.amaanat_no,sp.project_name,sp . `name` AS sub_project_name, l.coa_id,l.`project_id`, ";
        $sql .= " SUM(debit - credit)  AS Balance ";
        $sql .= " FROM vw_core_ledger l";
        $sql .= " LEFT JOIN `vw_core_sub_project` sp ON sp . project_id = l . project_id AND sp . sub_project_id = l . sub_project_id ";
        $sql .= " INNER JOIN `core_partner` p ON p.`partner_id` =  l.partner_id ";
        $sql .= " INNER JOIN qh_qarze_hassana_request request ON request.its_no =  p.its_no ";

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
                    $sql .= " where  " . implode(" AND ", $implode);
            } else {
                $sql .= " where  " . $where;
            }
        }


        $sql .= " GROUP BY l.partner_id";
        $sql .= " ORDER BY request.amaanat_no";


        $query = $this->conn->query($sql);
         $row = $query->rows;
       // d($query,true);
        return $row;
    }

    public function getTopOutstandings(){
        $sql = "SELECT `name`,MAX(balance) as outstanding_amount FROM  (SELECT p.name AS `name`,p.its_no, SUM(debit - credit)  AS balance ";
        $sql .= " FROM vw_core_ledger l";
        $sql .= " INNER JOIN `core_partner` p ON p.`partner_id` =  l.partner_id ";
        $sql .= " WHERE (l.`coa_id` = '{8099ECF7-BB38-C0B7-F74C-C6801909793F}'";
        $sql .= " OR l.`coa_id` = '{4C4EEEDF-30EE-8504-6BB3-00319DF298AB}'";
        $sql .= " OR l.coa_id = '{FB632835-E147-D5C9-7699-801BBE6FAD7E}')";
        $sql .= " GROUP BY l.`partner_id`) a GROUP BY `name` ORDER BY outstanding_amount DESC LIMIT 5 ;";

        $query = $this->conn->query($sql);
        $row = $query->rows;
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