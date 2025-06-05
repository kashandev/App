<?php

class ModelSetupSubProject extends HModel {

    public function getTable()
    {
        return 'sub_project';
    }

    public function getView()
    {
        return 'vw_sub_project';
    }

    protected function getJoin() {
        $sql  = " FROM `sub_project` sp";
        $sql .= " INNER JOIN `project` p ON p.`project_id` = sp.`project_id`";

        return $sql;
    }

    public function getOptionList($search='', $filter=NULL, $sort_order=NULL, $page=0, $limit=25) {
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


        $sql = "SELECT p.project_id, p.name as project_name, sp.sub_project_id, sp.name as sub_project";
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
        $sql .= " AND (LOWER(p.name) LIKE '%".strtolower($search)."%' OR LOWER(sp.name) LIKE '%".strtolower($search)."%')";
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


}


?>