<?php

final class DB {

    private $driver;

    public function __construct($driver, $hostname, $username, $password, $database) {
        try {
            if (file_exists(DIR_DATABASE . $driver . '.php')) {
                require_once(DIR_DATABASE . $driver . '.php');
            } else {
                exit('Error: Could not load database file ' . $driver . '!');
            }

            $this->driver = new $driver($hostname, $username, $password, $database);
        } catch(Exception $e) {
            d($e);
        }
    }

    public function select_db($db_name) {
        return $this->driver->select_db($db_name);
    }

    public function multi_query($sql) {
        return $this->driver->multi_query($sql);
    }

    public function query($sql) {
        return $this->driver->query($sql);
    }

    public function escape($value) {
        return $this->driver->escape($value);
    }

    public function countAffected() {
        return $this->driver->countAffected();
    }

    public function getLastId() {
        return $this->driver->getLastId();
    }

    public function beginTransaction() {
        return $this->driver->beginTransaction();
    }

    public function commit() {
        return $this->driver->commit();
    }

    public function rollback() {
        return $this->driver->rollback();
    }

}

?>