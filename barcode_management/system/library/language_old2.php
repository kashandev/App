<?php

final class Language {

    private $data = array();
    private $session = array();

    public function __construct($registry) {
        $this->db = $registry->get('db');
        $session = $registry->get('session');

        $this->session = array(
            'module' => $session->data['module'],
            'language' => $session->data['language_code']
        );
    }

    public function get($key) {
        return (isset($this->data[$key]) ? $this->data[$key] : $key);
    }

    public function load($route) {
        //$session = $this->sessioin->data;
        //d(array($this->session, $route), true);
        $sql = "SELECT lvl.`code`, v.`module`, v.`document`, v.`route`, v.`label`, lvl.`value`";
        $sql .= " FROM `core_variable` v";
        $sql .= " LEFT JOIN (";
        $sql .= " SELECT lv.*, l.code, l.`name` AS language_name";
        $sql .= " FROM `core_language_variable` lv";
        $sql .= " INNER JOIN `core_language` l ON l.`language_id` = lv.`language_id` AND l.`code` = '".$this->session['language']."'";
        $sql .= " ) AS lvl ON lvl.variable_id = v.`variable_id`";
        $sql .= " WHERE v.`module`='".$this->session['module']."' AND v.`route` = ''";
        if($route != '') {
            $sql .= " UNION ALL";
            $sql .= " SELECT lvl.`code`, v.`module`, v.`document`, v.`route`, v.`label`, lvl.`value`";
            $sql .= " FROM `core_variable` v";
            $sql .= " LEFT JOIN (";
            $sql .= " SELECT lv.*, l.code, l.`name` AS language_name";
            $sql .= " FROM `core_language_variable` lv";
            $sql .= " INNER JOIN `core_language` l ON l.`language_id` = lv.`language_id` AND l.`code` = '".$this->session['language']."'";
            $sql .= " ) AS lvl ON lvl.variable_id = v.`variable_id`";
            $sql .= " WHERE v.`module`='".$this->session['module']."' AND v.`route` = '".$route."'";
        }
        //d($sql, true);
        $query = $this->db->query($sql);
        $rows = $query->rows;
        foreach($rows as $row) {
            if($row['value']==null) {
                $this->data[$row['label']] = $row['label'];
            } else {
                $this->data[$row['label']] = $row['value'];
            }
        }

        return $this->data;
    }

}

?>