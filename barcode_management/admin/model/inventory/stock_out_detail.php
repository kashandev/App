<?php

class ModelInventoryStockOutDetail extends HModel {

    protected function getTable() {
        return 'ina_stock_out_detail';
    }

    protected function getView() {
        return 'vw_ina_stock_out_detail';
    }

    public function getDetails($filter=array(), $sort_order=array(),$group_by = array()) {
        $sql = "Select * ";
        $sql .= " FROM " . DB_PREFIX . $this->getView();
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
       if($group_by) {
        $sql .= " GROUP BY " . implode(',',$group_by); 
       }
        if($sort_order) {
            $sql .= " ORDER BY " . implode(',',$sort_order);
        }

        $query = $this->conn->query($sql);
        return $query->rows;
    }

     public function getProductSum($filter=array(), $sort_order=array(),$group_by = array()) {
        $sql = "Select `product_code`, CONCAT(`product_code`,' - ',`product_name`) AS `product_name`, SUM(`qty`) AS `total_qty`, `unit_price`, SUM(`total_price`) AS `total_price` ";
        $sql .= " FROM " . DB_PREFIX . $this->getView();
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
       if($group_by) {
        $sql .= " GROUP BY " . implode(',',$group_by); 
       }
        if($sort_order) {
            $sql .= " ORDER BY " . implode(',',$sort_order);
        }

        $query = $this->conn->query($sql);
        return $query->rows;
    }
}
?>