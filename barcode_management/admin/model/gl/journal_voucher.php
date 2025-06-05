<?php

class ModelGLJournalVoucher extends HModel {

    protected function getTable() {
        return 'glt_journal_voucher';
    }

    public function getDataFromLedger($document_type_id, $document_id){
        $sql = "";
        $sql .= "SELECT level3.name AS account,`debit` ,`credit`, sp.project_name as project,sp.name AS sub_project ";
        $sql .= " FROM core_ledger l";
        $sql .= " LEFT JOIN `vw_core_sub_project` sp ON sp.project_id = l.project_id AND sp.sub_project_id = l.sub_project_id";
        $sql .= " LEFT JOIN `vw_gl0_coa_level3` level3 ON level3.coa_level3_id = l.coa_id";
        $sql .= " WHERE document_id = '".$document_id."' AND document_type_id = '" . $document_type_id . "'";
      //  $sql .= ' GROUP BY `account`;';

        $query = $this->conn->query($sql);
        $rows = $query->rows;
     //   d($query,true);
        //d(array($sql, $rows),true);
        return $rows;
    }


}

?>