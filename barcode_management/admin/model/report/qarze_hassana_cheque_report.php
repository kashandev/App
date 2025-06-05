<?php

class ModelReportQarzeHassanaChequeReport extends HModel {

    protected function getTable() {
        return 'vw_qh_qarze_hassana_repayment_detail';
    }

    public function getData($filter){

        $sql = "";
        $sql .=  "SELECT qhdsd.`cheque_amount`,qhdsd.`cheque_no`,qhr.`amaanat_no`,level3.name AS coa_name ";
        $sql .= " FROM `qh_qarze_hassana_deposit_slip_detail` qhdsd";
        $sql .= " INNER JOIN `qh_qarze_hassana_deposit_slip` qhds ON qhds.`qarze_hassana_deposit_slip_id` = qhdsd.`qarze_hassana_deposit_slip_id`";
        $sql .= " LEFT JOIN `qh_qarze_hassana_request` qhr ON qhr.`its_no` = qhdsd.`its_no`";
        $sql .= " LEFT JOIN `vw_gl0_coa_level3` level3 ON level3.coa_level3_id = qhds.`bank_account_id`";

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
                    $sql .= " where  " . implode(" AND ", $implode);
            } else {
                $sql .= " where  " . $filter;
            }
        }

        $query = $this->conn->query($sql);
      //  d($query,true);
        $rows = $query->rows;
        return $rows;
    }
}

?>