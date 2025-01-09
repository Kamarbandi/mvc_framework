<?php

defined('ROOTPATH') OR exit('Access Denied!');

spl_autoload_register(function ($classname) {
    $classname = explode("\\", $classname);
    $classname = end($classname);
    $filename = "../app/models/" . ucfirst($classname) . ".php";

    if (file_exists($filename)) {
        require $filename;
    } else {
        error_log("Class file for {$classname} not found: {$filename}",
            3,
            'C:\wamp64\www\mvc\public\logs\my_errors.log');
        throw new Exception("Class {$classname} could not be loaded from {$filename}");
    }
});

require 'config.php';
require 'functions.php';
require 'Database.php';
require 'Model.php';
require 'Controller.php';
require 'App.php';