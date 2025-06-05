<?php

class ModelReportQarzeHassanaRepaymentReport extends HModel {

    protected function getTable() {
        return 'vw_core_ledger';
    }
    public function getPartyOpening($filter = array(),$sort_order = array()) {
        $sql = "SELECT l.company_id, l.company_branch_id, l.fiscal_year_id, l.partner_type_id, p.partner_type, l.partner_id,p.its_no,l.project_id,sp . `project_name` AS project_name,sp . `name` AS sub_project_name,bpd.amaanat_no, p.name as partner_name";
        $sql .= ", '' as document_date, '' as document_identity, '' as ref_document_identity, l.coa_id, account, 'Opening Balance' as remarks";
        $sql .= ", CASE WHEN SUM(debit - credit) > 0 THEN SUM(debit - credit) ELSE 0 END as debit";
        $sql .= ", CASE WHEN SUM(debit - credit) < 0 THEN SUM(credit - debit) ELSE 0 END as credit";
        $sql .= " FROM vw_core_ledger l";
        $sql .= " INNER JOIN `core_partner` p ON p.`company_id` = l.`company_id` AND p.`partner_type_id` = l.`partner_type_id` AND p.`partner_id` = l.`partner_id` ";
        $sql .= " LEFT JOIN `vw_core_sub_project` sp ON sp . project_id = l . project_id AND sp . sub_project_id = l . sub_project_id";
        $sql .= " LEFT JOIN `glt_bank_payment` bp ON bp.bank_payment_id = l.document_id";
        $sql .= " LEFT JOIN `glt_bank_payment_detail` bpd ON bpd.bank_payment_id = bp.bank_payment_id";
        if($filter) {
            if(is_array($filter)) {
                //$table_columns = $this->getTableColumns($this->getTable());
                $implode = array();
                foreach($filter as $column => $value) {
                    //if(in_array($column,$table_columns)) {
                    $implode[] = "`$column`='$value'";
                    //}
                }
                if($implode)
                    $sql .= " WHERE " . implode(" AND ", $implode);
            } else {
                $sql .= " WHERE " . $filter;
            }
        }
        $sql .= " GROUP BY l.company_id, l.company_branch_id, l.fiscal_year_id, l.partner_type_id, p.partner_type, l.partner_id, p.name, coa_id";
        if($sort_order) {
           // $sql .= " ORDER BY " . implode(',',$sort_order);
        }

        $query = $this->conn->query($sql);
       // d($query,true);
        $rows = $query->rows;
        return $rows;
    }

    public function getPartyLedger($filter = array(),$sort_order = array()) {
        $sql  = "SELECT l.company_id, l.company_branch_id, l.fiscal_year_id,l.cheque_no,p.its_no, l.partner_type_id,sp . `project_name` AS project_name,sp . `name` AS sub_project_name,brd.amaanat_no, p.partner_type, l.partner_id, p.name as partner_name";
        $sql .= ", l.document_date, l.document_identity, l.ref_document_identity, l.coa_id, account, debit, credit, l.remarks";
        $sql .= " FROM vw_core_ledger l";
        $sql .= " LEFT JOIN `vw_core_sub_project` sp ON sp . project_id = l . project_id AND sp . sub_project_id = l . sub_project_id";
        $sql .= " INNER JOIN `core_partner` p ON p.`company_id` = l.`company_id` AND p.`partner_type_id` = l.`partner_type_id` AND p.`partner_id` = l.`partner_id`";
        $sql .= " LEFT JOIN `glt_bank_receipt` br ON br.bank_receipt_id = l.document_id";
        $sql .= " LEFT JOIN `glt_bank_receipt_detail` brd ON brd.bank_receipt_id = br.bank_receipt_id";

        if($filter) {
            if(is_array($filter)) {
                //$table_columns = $this->getTableColumns($this->getTable());
                $implode = array();
                foreach($filter as $column => $value) {
                    //if(in_array($column,$table_columns)) {
                    $implode[] = "`$column`='$value'";
                    //}
                }
                if($implode)
                    $sql .= " WHERE " . implode(" AND ", $implode);
            } else {
                $sql .= " WHERE " . $filter;
            }
        }
        if($sort_order) {
            $sql .= " ORDER BY l.document_date";
        }
        $query = $this->conn->query($sql);
        $rows = $query->rows;
       // d($query,true);
        return $rows;
    }

//
//    public function getLedgerData($filter){
//        $sql = "";
////        $sql .= "SELECT qh.*,level3.`name` AS coa_name,ledger.`coa_id`";
////        $sql .= " FROM `qh_qarze_hassana_request` qh";
////        $sql .= " LEFT JOIN `vw_gl0_coa_level3` level3 ON level3.coa_level3_id = qh.receivable_account_id";
////        $sql .= " LEFT JOIN qh_qarze_hassana_repayment_detail qrd ON qrd.`its_no` = qh.its_no";
////        $sql .= " LEFT JOIN qh_qarze_hassana_repayment qr ON qr.qarze_hassana_repayment_id = qrd.`qarze_hassana_repayment_id`";
////        $sql .= " LEFT JOIN vw_core_ledger ledger ON qrd.qarze_hassana_repayment_id = ledger.`document_id`";
//
//       $sql .= " SELECT p . its_no,p . name,l.document_identity,l . cheque_no,l . cheque_date,l.coa_id,l . debit,l . credit,qhr.amaanat_no,sp . `project_name` AS project_name,sp . `name` AS sub_project_name";
//        $sql .= " FROM core_ledger l";
//        $sql .= " INNER JOIN core_partner p ON p . `partner_id` = l . `partner_id`";
//        $sql .= " LEFT JOIN `vw_core_sub_project` sp ON sp . project_id = l . project_id AND sp . sub_project_id = l . sub_project_id";
//        $sql .= " LEFT JOIN `qh_qarze_hassana_request` qhr ON qhr.`its_no` = p.`its_no` ";
//       // $sql .= " where p.`partner_id` = l.`partner_id` AND l.`coa_id` IN (p.`outstanding_account_id`)";
//       // $sql .= " and l.cheque_date < '.$filter.'";
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