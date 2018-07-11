<?php

class PageModel {
  private $_db = null;
  public function __construct()
  {
    $this->_db = new Data;
  }
  public function getPageData($page)
  {
    $file = Config::get('data/webdata') . 'pages/' . $page . '.csv';
    $data = $this->_db->getWebData($file);
    return $data;
  }
  public function updatePageData($page, $data)
  {
    $file = Config::get('data/webdata') . 'pages/' . $page . '.csv';
    $data = $this->_db->updateWebData($file, $data);
    return $data;
  }
}
