<?php

class ModelInventoryProduct extends HModel {

    protected function getTable() {
        return 'in0_product';
    }

    protected function getView() {
        return 'vw_in0_product';
    }

    protected function getJoin() {
        $sql  = " FROM `in0_product` `p`";
        $sql .= " LEFT JOIN `in0_product_category` `pc` ON `pc`.`company_id` = `p`.`company_id` AND `pc`.`product_category_id` = `p`.`product_category_id`";
        $sql .= " LEFT JOIN `in0_unit` `u` ON `u`.`company_id` = `p`.`company_id` AND `u`.`unit_id` = `p`.`unit_id`";
        $sql .= " LEFT JOIN `in0_brand` `b` ON `b`.`company_id` = `p`.`company_id` AND `b`.`brand_id` = `p`.`brand_id`";
        $sql .= " LEFT JOIN `in0_model` `md` ON `md`.`company_id` = `p`.`company_id` AND `md`.`model_id` = `p`.`model_id`";
        return $sql;
    }

    public function getMaxProductCode() {
        $sql = "SELECT MAX(CONVERT(product_code,UNSIGNED INTEGER)) as max_no";
        $sql .= " FROM `".DB_PREFIX."in0_product`";
        $query = $this->conn->query($sql);
        $row = $query->row;
        //d($sql,true);
        return (is_null($row['max_no'])?'1':$row['max_no']+1);
    }

    public function getProductSerialNo($product_code,$type) {
        $sql = "SELECT MAX(TRIM(serial_no)) AS max_serial_no,COUNT(serial_no) AS count_serial_no";
        $sql.= " FROM `".DB_PREFIX."core_stock_ledger_history`";
        $sql.=" WHERE serial_no LIKE '%".$product_code."-%' ";
        $sql.="AND document_type_id = ".$type." ";
        $query = $this->conn->query($sql);
        $row = $query->row;
        return $row;
    }

    public function getOptionList($search='', $filter=NULL, $sort_order=NULL, $page=0, $limit=25) {
        if($page=='') {
            $page = 0;
        }
        $offset = $page*$limit;

        $sql = "SELECT count(*) as total_records";
        $sql .= $this->getJoin();
        if($filter) {
            if(is_array($filter)) {
                $implode = array();
                foreach($filter as $column => $value) {
                    $implode[] = "$column='$value'";
                }
                if($implode)
                    $sql .= " WHERE " . implode(" AND ", $implode);
            } else {
                $sql .= " WHERE " . $filter;
            }
        }
        $query = $this->conn->query($sql);
        $row = $query->row;
        $total_records = $row['total_records'];


        $sql = "SELECT p.*, pc.name as product_category, u.name as unit, b.name as brand, md.name as model";
        $sql .= $this->getJoin();
        if($filter) {
            if(is_array($filter)) {
                $implode = array();
                foreach($filter as $column => $value) {
                    $implode[] = "$column='$value'";
                }
                if($implode)
                    $sql .= " WHERE " . implode(" AND ", $implode);
            } else {
                $sql .= " WHERE " . $filter;
            }
        } else {
            $sql .= " WHERE 1";
        }
        $sql .= " AND (LOWER(p.name) LIKE '%".strtolower($search)."%' OR LOWER(p.product_code) LIKE '%".strtolower($search)."%')";
        if($sort_order) {
            $sql .= " ORDER BY " . implode(" AND ", $sort_order);
        }
        $sql .= " LIMIT " . $offset . "," . $limit;
        $query = $this->conn->query($sql);
        $rows = $query->rows;


        return array(
            'total_count' => $total_records,
            'sql' => $sql,
            'items' => $rows
        );
    }

    public function getProductJson($search, $page, $limit=25, $filter=array()) {
        if($page=='') {
            $page = 0;
        }
        $offset = $page*$limit;

        $arrWhere = array();
        $arrWhere[] = "`company_id` = '". $this->session->data['company_id'] ."'";
        $arrWhere[] = "(`product_code` LIKE '%".$search."%' OR `name` LIKE '%".$search."%')";
        $arrWhere[] = "LOWER(`status`) = 'active'";
        if(isset($filter['product_category_id']) && $filter['product_category_id']) {
            $arrWhere[] = "`product_category_id` = '".$filter['product_category_id']."'";
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
        $sql .= " WHERE `company_id` = '". $this->session->data['company_id'] ."'";

        $query = $this->conn->query($sql);
        return $query->row;
    }
}
?>