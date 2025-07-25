<?php

final class Language {

    private $directory;
    private $data = array();

    public function __construct($directory) {
        $this->directory = $directory;
    }

    public function get($key) {
        return (isset($this->data[$key]) ? $this->data[$key] : $key);
    }

    public function load($filename) {

        $file = DIR_LANGUAGE . $this->directory . '/' . $this->directory . '.php';
        if (file_exists($file)) {
            $_ = array();

            require($file);

            $this->data = array_merge($this->data, $_);
        }

        $file = DIR_LANGUAGE . $this->directory . '/' . $filename . '.php';
        if (file_exists($file)) {
            $_ = array();

            require($file);

            $this->data = array_merge($this->data, $_);

            return $this->data;
        } else {
            d('Error: Could not load language ' . $file . '!',true);
        }
    }

}

?>