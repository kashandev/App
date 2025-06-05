<?php

class ModelCommonStockLedgerHistory extends HModel {

    protected function getTable() {
        return 'core_stock_ledger_history';
    }

//    protected function getView() {
//        return 'vw_core_stock_ledger_history';
//    }

    public function getStocks($filter = array()) {
        $sql = "";
        $sql .= "SELECT product_id, SUM(base_qty) AS stock_qty, SUM(base_amount) AS stock_amount, ROUND(SUM(base_amount)/SUM(base_qty),2) AS avg_cogs_rate";
        $sql .= " FROM `core_stock_ledger_history`";
        if($filter) {
            if(is_array($filter)) {
                $implode = array();
                foreach($filter as $column => $value) {
                    $implode[] = "`$column`='$value'";
                }
                if($implode)
                    $sql .= " WHERE " . implode(" AND ", $implode);
            } else {
                $sql .= " WHERE " . $filter;
            }
        }
        $sql .= " GROUP BY company_id, company_branch_id, fiscal_year_id, product_id";

        $query = $this->conn->query($sql);
        return $query->rows;
    }

    public function getStock($filter = array()) {
        $sql = "";
        $sql .= "SELECT SUM(base_qty) AS stock_qty, SUM(base_amount) AS stock_amount, ROUND(SUM(base_amount)/SUM(base_qty),2) AS avg_stock_rate";
        $sql .= " FROM `core_stock_ledger_history`";
        if($filter) {
            if(is_array($filter)) {
                $implode = array();
                foreach($filter as $column => $value) {
                    $implode[] = "`$column`='$value'";
                }
                if($implode)
                    $sql .= " WHERE " . implode(" AND ", $implode);
            } else {
                $sql .= " WHERE " . $filter;
            }
        }

        $query = $this->conn->query($sql);
        //d($query);
        return $query->row;
    }


    public function getStockSerialNo($filter = array()) {
        $sql = "";
        $sql .= "SELECT serial_no AS stock_serial_no";
        $sql .= " FROM `core_stock_ledger_history`";
        if($filter) {
            if(is_array($filter)) {
                $implode = array();
                foreach($filter as $column => $value) {
                    $implode[] = "`$column`='$value'";
                }
                if($implode)
                    $sql .= " WHERE " . implode(" AND ", $implode);
            } else {
                $sql .= " WHERE " . $filter;
            }
        }
        $sql .= " HAVING SUM(`base_amount`) < 0";
        $sql .= " ORDER BY `serial_no` DESC";

        $query = $this->conn->query($sql);
        //d($query);
        return $query->row;
    }


    public function getWarehouseStock($product_id, $warehouse_id='') {
        $sql = "";
        $sql .= " SELECT SUM(IF(warehouse_id='".$warehouse_id."',base_qty,0)) AS stock_qty, ROUND(SUM(base_amount)/SUM(base_qty),2) AS avg_stock_rate";
        $sql .= " FROM `core_stock_ledger`";
        $sql .= " WHERE company_id = '".$this->session->data['company_id']."'";
        $sql .= " AND company_branch_id = '".$this->session->data['company_branch_id']."'";
        $sql .= " AND fiscal_year_id = '".$this->session->data['fiscal_year_id']."'";
        $sql .= " AND product_id = '".$product_id."'";

        $query = $this->conn->query($sql);
        return $query->row;
    }

    public function getBalanceContainers($filter=array()) {
        $sql = "";
        $sql .= "SELECT `container_no`, COUNT(*) as records, SUM(`base_qty`) AS base_qty";
        $sql .= " FROM `core_stock_ledger`";
        if($filter) {
            if(is_array($filter)) {
                $implode = array();
                foreach($filter as $column => $value) {
                    $implode[] = "`$column`='$value'";
                }
                if($implode)
                    $sql .= " WHERE " . implode(" AND ", $implode);
            } else {
                $sql .= " WHERE " . $filter;
            }
        }
        $sql .= " GROUP BY `container_no`";
        $sql .= " HAVING `base_qty` > 0";

        $query = $this->conn->query($sql);
        return $query->rows;
    }

    public function getBalanceContainerStocks($container_no, $warehouse_id='') {
        $sql = "";
        $sql .= "SELECT sl.warehouse_id, w.name as `warehouse_name`, sl.container_no, sl.batch_no, sl.product_id, p.product_code, p.name as product_name, sl.base_unit_id";
        $sql .= ", p.cubic_meter, p.cubic_feet, p.cost_price, p.sale_price";
        $sql .= ", (sl.base_qty * p.cubic_meter) AS total_cubic_meter, (sl.base_qty * p.cubic_feet) AS total_cubic_feet";
        $sql .= ", SUM(sl.base_qty) AS balance_qty, SUM(sl.base_amount) AS balance_amount, Round(SUM(sl.base_amount)/SUM(sl.base_qty * p.cubic_feet),2) AS avg_cog_rate";
        $sql .= " FROM `core_stock_ledger` sl";
        $sql .= " INNER JOIN `in0_product` p ON p.product_id = sl.product_id";
        $sql .= " LEFT JOIN `in0_warehouse` w ON w.warehouse_id = sl.warehouse_id";
        $sql .= " WHERE `container_no` = '".$container_no."'";
        if($warehouse_id != '') {
            $sql .= " AND `warehouse_id` = '".$warehouse_id."'";
        }
        $sql .= " GROUP BY warehouse_id, container_no, batch_no, product_id, base_unit_id";

        $query = $this->conn->query($sql);
        return $query->rows;
    }

}

?>