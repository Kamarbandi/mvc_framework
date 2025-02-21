<?php

//defined('ROOT_PATH') or exit('Access Denied!');

if ((empty($_SERVER['SERVER_NAME']) && php_sapi_name() == 'cli') || (!empty($_SERVER['SERVER_NAME']) && $_SERVER['SERVER_NAME'] == 'localhost')) {
    /** database config **/
    define('DB_NAME', 'db_name');
    define('DB_HOST', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASS', '');
    define('DB_DRIVER', '');

    define('ROOT', 'http://your_domain.de');

} else {
    define('DB_NAME', 'db_name');
    define('DB_HOST', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASS', '');
    define('DB_DRIVER', '');

    define('ROOT', 'http://your_domain.de');
}

define('APP_NAME', "Give here name of application");
define('APP_DESC', "Give here description of application");

/** true means show errors **/
define('DEBUG', true);
