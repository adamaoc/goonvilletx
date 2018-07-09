<?php

session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . '/app/config.php';

spl_autoload_register(function($class) {
	require_once $_SERVER['DOCUMENT_ROOT'] . '/app/core/' . $class . '.php';
});

require_once $_SERVER['DOCUMENT_ROOT'] . '/app/core/Functions.php';
