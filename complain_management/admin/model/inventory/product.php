<?php

class ModelInventoryProduct extends HModel {

    protected function getTable() {
        return 'in0_product';
    }

    protected function getView() {
        return 'vw_in0_product';
    }

    public function getMaxProductCode() {
        $sql = "SELECT MAX(CONVERT(product_code,UNSIGNED INTEGER)) as max_no";
        $sql .= " FROM `".DB_PREFIX."in0_product`";
        $query = $this->conn->query($sql);
        $row = $query->row;
        //d($sql,true);
        return (is_null($row['max_no'])?'1':$row['max_no']+1);
    }


    public function getServiceCharges($filter=array()) {
        $arrWhere = array();
        if(isset($filter['product_id']) && $filter['product_id']) {
            $arrWhere[] = "`product_id` = '".$filter['product_id']."'";
        }
        $sql = "SELECT `wholesale_price` as service_charges";
        $sql .= " FROM `in0_product`";
        $sql .= " WHERE " . implode(' AND ', $arrWhere);
        $query = $this->conn->query($sql);
        $row = $query->row;
        return array(
            'service_charges' => $row['service_charges']
        );
    }


    public function getProductJson($search, $page, $product_type = '', $limit=25, $filter=array()) {
        if($page=='') {
            $page = 0;
        }
        $offset = $page*$limit;

        $arrWhere = array();
        $arrWhere[] = "(`product_code` LIKE '".$search."%' OR `name` LIKE '".$search."%')";
        if(isset($filter['product_category_id']) && $filter['product_category_id']) {
            $arrWhere[] = "`product_category_id` = '".$filter['product_category_id']."'";
        }

        if($product_type!='') {
            $arrWhere[] = "`product_type` = '".$product_type."'";
        }

        $sql = "SELECT count(*) as total_records";
        $sql .= " FROM `vw_in0_product`";
        $sql .= " WHERE " . implode(' AND ', $arrWhere);
        $query = $this->conn->query($sql);
        $row = $query->row;
        $total_records = $row['total_records'];

        $sql = "SELECT *, product_id as id";
        $sql .= " FROM `vw_in0_product`";
        $sql .= " WHERE " . implode(' AND ', $arrWhere);
        $sql .= " LIMIT " . $offset . "," . $limit;
        $query = $this->conn->query($sql);
        $rows = $query->rows;

        return array(
            'total_count' => $total_records,
            'sql' => $sql,
            'items' => $rows
        );
    }

    public function getTotalProduct() {
        $sql = "SELECT COUNT(product_id) total_product  FROM `in0_product` ";

        $query = $this->conn->query($sql);
        return $query->row;
    }
}
?>