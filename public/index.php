<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

$minPHPVersion = '8.0';
if (phpversion() < $minPHPVersion)
{
    die("Your PHP version must be {$minPHPVersion} or higher to run this app. Your current version is " . phpversion());
}

session_start();

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../routes/api.php';