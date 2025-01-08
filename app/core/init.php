<?php

spl_autoload_register(function ($classname) {
    $filename = "../app/models/" . ucfirst($classname) . ".php";

    if (file_exists($filename)) {
        require $filename;
    } else {
        error_log("Class file for {$classname} not found: {$filename}");
        throw new Exception("Class {$classname} could not be loaded from {$filename}");
    }
});

require 'config.php';
require 'functions.php';
require 'Database.php';
require 'Model.php';
require 'Controller.php';
require 'App.php';