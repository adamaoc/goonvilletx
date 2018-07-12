<?php

function getComponent($file, $data = array()) {

	$docroot = $_SERVER['DOCUMENT_ROOT'];
	$dirpath = $docroot."/app/views/components/";

	$filepath = $dirpath.$file.".php";

	return require $filepath;

}

function getShared($file, $data = array()) {

	$docroot = $_SERVER['DOCUMENT_ROOT'];
	$dirpath = $docroot."/app/views/shared/";

	$filepath = $dirpath.$file.".php";

	return require_once $filepath;
}

function getHeader($data = array()) {

	return getShared("header", $data);
}

function getFooter($data = array()) {

	return getShared("footer", $data);
}

function escape($string) {
  return htmlentities($string, ENT_QUOTES, 'UTF-8');
}

function rawData($data, $dump = false) {
  echo "<br><pre>";
  if ($dump) {
    var_dump($data);
  } else {
    print_r($data);
  }
  echo "</pre><br>";
}
