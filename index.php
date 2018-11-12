<?php

if ($_SERVER['HTTP_HOST'] === 'localhost:8888') {
    //to Show All Errors:
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', TRUE);
} else {
    //to Hide All Errors:
    error_reporting(0);
    ini_set('display_errors', 0);
}

require_once 'app/init.php';

$app = new App;
