<?php

class SponsorsModel {
  private $_db,
          $_file;

  public function __construct()
  {
    $this->_db = new Data;
    $this->_file = Config::get('data/webdata') . 'sponsors.csv';
  }

  public function getSponsors()
  {
    return $this->_db->getWebData($this->_file);
  }

  public function addNewSponsor($data)
  {
    $rowCount = count($this->getSponsors());
    $newId = $rowCount  + 1001;
    // id,name,link,image,image_alt,placement,color //
    $postData = array(
      "id" => $newId,
      "name" => $data['name'],
      "link" => $data['link'],
      "image" => $data['image'],
      "image_alt" => $data['image_alt'],
      "placement" => $data['placement'],
      "color" => $data['color']
    );
    $this->_db->addData($this->_file, $postData);
  }
}
