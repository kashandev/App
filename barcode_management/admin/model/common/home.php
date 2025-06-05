<?php

class ModelCommonHome extends HModel {

    public function getSales($data) {
        $sql = "SELECT date, sum(amount) as amount";
        $sql .= " FROM vw_receipt_service r";
        $sql .= " WHERE TRUE";
        if(isset($data['date_from']) && $data['date_from']) {
            $sql .= " AND r.date >= '" . $data['date_from'] . "'";
        }
        
        if(isset($data['date_to']) && $data['date_to']) {
            $sql .= " AND r.date <= '" . $data['date_to'] . "'";
        }
        $sql .= " GROUP BY date";
        
        $query = $this->db->query($sql);
        return $query->rows;
    }


}

?>