<?php

class AnnouncementModel {

  private $_data,
          $_file;

  public function __construct()
  {
    $this->_data = new Data;
    $this->_file = Config::get('data/webdata') . '/announcements/schedule.csv';
  }

  private function _incrementId()
  {
    $list = $this->getAnnouncements();
    if (empty($list)) {
      return "1001";
    }
    $lastItem = count($list) - 1;
    $lastRow = $list[$lastItem];
    return $lastRow['id'] + 1;
  }

  public function getAnnouncements()
  {
    return $this->_db->getWebData($this->_file);
  }

  public function getAnnouncementById($id)
  {
    $list = $this->getAnnouncements();
    $current = null;
    foreach ($list as $item) {
      if ($item['id'] === $id) {
        $current = $item;
      }
    }
    return $current;
  }

  public function getAnnouncementByDate($startRange, $endRange)
  {
    $list = $this->getAnnouncements();
    $readyToDisplay = array();

    foreach ($list as $item) {
      if($item['start_date'] >= $startRange && $item['end_date'] <= $endRange) {
        $readyToDisplay += $item;
      }
    }
    // I have no idea if this is going to work...
    return $readyToDisplay;
  }

  public function addAnnouncement($data)
  {
    // id,type,start_date,end_date,flyer_link,content_link
    $toAdd = array(
      "id" => $this->_incrementId(),
      "type" => $data['type'],
      "start_date" => $data['start_date'],
      "end_date" => $data['end_date'],
      "flyer_link" => $data['flyer_link'],
      "content_link" => $data['content_link']
    );

    $content = $data['content'];

    $this->_data->addData($this->_file, $content);
  }
}
