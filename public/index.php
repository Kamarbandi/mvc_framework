<?php

use Core\App;

session_start();

$minPHPVersion = '8.0';
if (phpversion() < $minPHPVersion)
{
    die("PHP version must be {$minPHPVersion} or higher. Current version is " . phpversion());
}

define('ROOTPATH', __DIR__ . DIRECTORY_SEPARATOR);

require "../app/core/init.php";

DEBUG ? ini_set('display_errors', 1) : ini_set('display_errors', 0);

$app = new App;
$app->loadController();
