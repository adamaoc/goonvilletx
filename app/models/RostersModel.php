<?php

class RostersModel
{
  private $_data = null;
  private $_coachFilepath = null;
  private $_playerFilepath = null;

  public function __construct()
  {
    $this->_data = new Data;
    $this->_playerFilepath = Config::get('data/webdata') . "rosters/player-roster.csv";
    $this->_coachFilepath = Config::get('data/webdata') . "rosters/coach-roster.csv";
  }

  public function getALlRosters()
  {
    $playerRoster = $this->_data->getWebData($this->_playerFilepath);
    $coachRoster = $this->_data->getWebData($this->_coachFilepath);
    return array('players' => $playerRoster, 'coaches' => $coachRoster);
  }

  private function _incrementId($type = '')
  {
    $rosters = $this->getALlRosters();
    $cur = $rosters['players'];
    if ($type === 'coaches') {
      $cur = $rosters['coaches'];
    }
    if (count($cur) === 0) {
      return 1001;
    }
    $lastItem = count($cur) - 1;
    $lastRow = $cur[$lastItem];
    return $lastRow['id'] + 1;
  }

  public function addPlayer($data)
  {
    // id,photo,number,name,grade,positions,awards //
    $postData = array(
      "id" => $this->_incrementId(),
      "photo" => $data['image'],
      "number" => $data['number'],
      "name" => $data['name'],
      "grade" => $data['grade'],
      "positions" => $data['positions'],
      "awards" => $data['awards']
    );
    $this->_data->addData($this->_playerFilepath, $postData);
    $rostersData = $this->getALlRosters();
    return $rostersData['players'];
  }

  public function updatePlayer($data)
  {
    $updateData = array(
      "id" => $data['id'],
      "photo" => $data['photo'],
      "number" => $data['number'],
      "name" => $data['name'],
      "grade" => $data['grade'],
      "positions" => $data['positions'],
      "awards" => $data['awards']
    );
    $this->_data->updateWebData($this->_playerFilepath, $updateData);
    return $updateData;
  }

  public function deletePlayer($id)
  {
    return $this->_data->deleteData($this->_playerFilepath, $id);
  }

  public function addCoach($data)
  {
    // id,photo,name,positions,title
    $postData = array(
      "id" => $this->_incrementId('coaches'),
      "photo" => $data['image'],
      "name" => $data['name'],
      "positions" => $data['positions'],
      "title" => $data['title']
    );
    $this->_data->addData($this->_coachFilepath, $postData);
    $rostersData = $this->getALlRosters();
    return $rostersData['coaches'];
  }

  public function updateCoach($data)
  {
    $updateData = array(
      "id" => $data['id'],
      "photo" => $data['photo'],
      "name" => $data['name'],
      "positions" => $data['positions'],
      "title" => $data['title']
    );
    $this->_data->updateWebData($this->_coachFilepath, $updateData);
    return $updateData;
  }

  public function deleteCoach($id)
  {
    return $this->_data->deleteData($this->_coachFilepath, $id);
  }

  public function getPlayers()
  {
    return $this->_data->getWebData($this->_playerFilepath);
  }
  public function getCoaches()
  {
    return $this->_data->getWebData($this->_coachFilepath);
  }
}
