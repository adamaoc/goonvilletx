<?php

class SponsorsModel {
  private $_db,
          $_file;

  public function __construct()
  {
    $this->_db = new Data;
    $this->_file = Config::get('data/webdata') . 'sponsors.csv';
  }

  private function _incrementId()
  {
    $curSponsors = $this->getSponsors();
    $lastItem = count($curSponsors) - 1;
    $lastRow = $curSponsors[$lastItem];
    return $lastRow['id'] + 1;
  }

  public function getSponsors()
  {
    return $this->_db->getWebData($this->_file);
  }
  public function getSponsor()
  {
    // need to implement...
    // no real use case for it at the moment though
  }
  public function deleteSponsor($id)
  {
    return $this->_db->deleteData($this->_file, $id);
  }
  public function addNewSponsor($data)
  {
    // id,name,link,image,image_alt,placement,color //
    $postData = array(
      "id" => $this->_incrementId(),
      "name" => $data['name'],
      "link" => $data['link'],
      "image" => $data['image'],
      "image_alt" => $data['image_alt'],
      "placement" => $data['placement'],
      "color" => $data['color']
    );
    $this->_db->addData($this->_file, $postData);
    return $this->getSponsors();
  }
  public function updateSponsor($data)
  {
    $updateData = array(
      "id" => $data['id'],
      "name" => $data['name'],
      "link" => $data['link'],
      "image" => $data['image'],
      "image_alt" => $data['image_alt'],
      "placement" => $data['placement'],
      "color" => $data['color']
    );
    $this->_db->updateWebData($this->_file, $updateData);
    return $updateData;
  }
}
