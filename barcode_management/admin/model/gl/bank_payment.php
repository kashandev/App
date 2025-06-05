<?php

class ModelGLBankPayment extends HModel {

    protected function getTable() {
        return 'glt_bank_payment';
    }

    protected function getView() {
        return 'vw_glt_bank_payment';
    }

    public function getDataFromLedger($document_type_id, $document_id){
        $sql = "";
        $sql .= "SELECT `account`,SUM(`debit`) debit,SUM(`credit`) credit ";
        $sql .= " FROM vw_core_ledger  WHERE document_id = '".$document_id."' AND document_type_id = '" . $document_type_id . "'";
        $sql .= ' GROUP BY `account`;';

        $query = $this->conn->query($sql);
        $rows = $query->rows;

        //d(array($sql, $rows),true);
        return $rows;
    }
}

?>