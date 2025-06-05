<?php
// HTTP
define('HTTP_SERVER', 'http://' . $_SERVER['HTTP_HOST'] . '/admin/');
define('HTTP_BASE', 'http://' . $_SERVER['HTTP_HOST'] . '/admin/');
define('HTTP_IMAGE', 'http://' . $_SERVER['HTTP_HOST'] . '/images/');
define('HTTP_UPLOAD', 'http://' . $_SERVER['HTTP_HOST'] . '/upload/');

define('HTTPS_SERVER', 'http://' . $_SERVER['HTTP_HOST'] . '/admin/');
define('HTTPS_BASE', 'http://' . $_SERVER['HTTP_HOST'] . '/admin/');
define('HTTPS_IMAGE', 'http://' . $_SERVER['HTTP_HOST'] . '/images/');
define('HTTPS_UPLOAD', 'http://' . $_SERVER['HTTP_HOST'] . '/upload/');

// DIR
define('DIR_ROOT', dirname(dirname(__FILE__)) . "/");
define('DIR_APPLICATION', DIR_ROOT . 'admin/');
define('DIR_SYSTEM', DIR_ROOT . 'system/');
define('DIR_DATABASE', DIR_SYSTEM .  'database/');
define('DIR_LANGUAGE', DIR_APPLICATION . 'language/');
define('DIR_TEMPLATE', DIR_APPLICATION . 'view/template/');
define('DIR_CONFIG', DIR_SYSTEM . 'config/');
define('DIR_IMAGE', DIR_ROOT . 'images/');
define('DIR_CACHE', DIR_SYSTEM . 'cache/');
define('DIR_DOWNLOAD', DIR_ROOT . 'download/');
define('DIR_UPLOAD', DIR_ROOT . 'upload/');
define('DIR_LOGS', DIR_SYSTEM . 'logs/');
define('DIR_CATALOG', DIR_ROOT . 'catalog/');

// DB
define('DB_DRIVER', 'dbmysqli');
define('DB_HOSTNAME', 'localhost');
define('DB_USERNAME', 'hussain_dbuser');
define('DB_PASSWORD', 'Bharmal786#');
define('DB_DATABASE', 'hussain_invendipos');
define('DB_PREFIX', '');

// Config
define('CONFIG_DISPLAY_ERROR', 0);
define('CONFIG_LOG_ERROR', 1);
define('CONFIG_ERROR_FILE_NAME', 'error_'.date('Ymd').'.log');

// Config
define('CONFIG_APPLICATION_CODE', 'iPOS');
define('CONFIG_APPLICATION_NAME', 'INVENDiPOS');

// Date
define('PICKER_DATE', 'DD-MM-YYYY');
define('PICKER_DATE_TIME', 'DD-MM-YYYY HH:mm:ss');
define('PICKER_TIME', 'HH:mm');
define('STD_DATE', 'd-m-Y');
define('MYSQL_DATE', 'Y-m-d');
define('STD_DATETIME', 'd-m-Y H:i:s');
define('MYSQL_DATETIME', 'Y-m-d H:i:s');

?>