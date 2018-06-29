<?php

class Editable
{
  private static $_instance = null;

  public static function getInstance()
  {
    if (!isset(self::$_instance)) {
      require_once $_SERVER['DOCUMENT_ROOT'] . '/app/models/PagesModel.php';
      self::$_instance = new PagesModel();
    }
    return self::$_instance;
  }

  public function getPageData($page) {
    self::$_instance->getPageData($page);
  }
}
