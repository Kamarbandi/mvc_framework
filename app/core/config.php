<?php

if ($_SERVER['SERVER_NAME'] == 'mvc.de') {
    define('DATABASE_NAME', 'mvc_db');
    define('DB_HOST', 'localhost');
    define('USER_NAME', 'root');
    define('PASSWORD', '');
    define('DBDRIVER', '');

    define('ROOT', 'http://mvc.de/public');
} else {
    define('DATABASE_NAME', 'your_db');
    define('DB_HOST', 'localhost');
    define('USER_NAME', 'root');
    define('PASSWORD', '');
    define('DBDRIVER', '');
    define('ROOT', 'https://domain_name.com');
}

define('APP_NAME', "MVC");
define('APP_DESC', "Mini Framework");

define('DEBUG', true);
