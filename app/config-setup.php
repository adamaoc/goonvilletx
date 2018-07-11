<?php

$GLOBALS['config'] = array(
  'http' => array(
    'root' =>  'http://' . $_SERVER['HTTP_HOST'] . '/',
    'admin' =>  "http://" . $_SERVER['HTTP_HOST'] . "/admin/"
  ),
  'data' => array(
    'path' => 'path to data',
    'superuser' => 'super user name',
    'api_token' => 'token here'
  ),
  'remember' => array(
    'cookie_name' => 'cookie name',
    'cookie_expiry' => 2880
  ),
  'session' => array(
    'session_name' => 'session name',
    'token_name' => 'token name'
  )
);
