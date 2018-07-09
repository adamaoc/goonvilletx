<?php

session_start();

$GLOBALS['config'] = array(
  'http' => array(
    'root' =>  'http://' . $_SERVER['HTTP_HOST'] . '/'
  ),
  'data' => array(
    'path' => $_SERVER['DOCUMENT_ROOT'] . '/app/data/'
  ),
  'remember' => array(
    'cookie_name' => 'hash',
    'cookie_expiry' => 604800
  ),
  'session' => array(
    'session_name' => 'user',
    'token_name' => 'token'
  )
);

spl_autoload_register(function($class) {
	require_once $_SERVER['DOCUMENT_ROOT'] . '/app/core/' . $class . '.php';
});

require_once $_SERVER['DOCUMENT_ROOT'] . '/app/core/Functions.php';
