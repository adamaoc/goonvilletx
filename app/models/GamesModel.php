<?php

class GamesModel
{
	public $name,
         $games = array();
  private $_db,
          $_file;

  function __construct()
  {
    $this->_file = Config::get('data/webdata') . 'games.csv';
    $this->_db = new Data;
    $this->getGamesData();
  }

  public function getGamesData()
  {
    $gamesArr = array(
      'fields' => array(),
      'games' => array()
    );
    $row = 1;
    if (($handle = fopen($this->_file, "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            if ($row === 1) {
                foreach ($data as $value) {
                  array_push($gamesArr['fields'], $value);
                }
            } else {
              foreach ($data as $key => $value) {
                $field = $gamesArr['fields'][$key];
                $id = $row - 2;
                $gamesArr['games'][$id][$field] = $value;
              }
            }
            $row++;
        }
        fclose($handle);
    }
    $this->games = $gamesArr;
  }

  public function updateGame($data)
  {
    // id,date,home_team,visiting_team,location,home_score,visiting_score
    $updateData = array(
      "id"              => $data['id'],
      "date"            => $data['date'],
      "home_team"       => $data['home_team'],
      "visiting_team"   => $data['visiting_team'],
      "location"        => $data['location'],
      "home_score"      => $data['home_score'],
      "visiting_score"  => $data['visiting_score']
    );
    $this->_db->updateWebData($this->_file, $updateData);
    return $updateData;
  }

  public function getAllGames()
  {
    return $this->games['games'];
  }

  public function getGame($id)
  {
    foreach ($this->games['games'] as $value) {
      if ($value['id'] === $id) {
        return $value;
      }
    }
    return false;
  }

  public function getCurrentSchedule($startnum, $endnum)
	{
		$list = $this->games['games'];
    $date_now = date("Y-m-d");
		array_multisort($list, SORT_ASC);
		for($i = $startnum; $i < $endnum; ++$i) {
      $listDate = $list[$i]['date'];
      if ($listDate > $date_now) {
        $buildarr[] = $list[$i];
      }
		}
		return $buildarr;
	}

  public function getCurrentScheduleAll()
  {
    $list = $this->games['games'];
    $date_now = date("Y-m-d");
    array_multisort($list, SORT_ASC);
    foreach ($list as $game) {
      $listDate = $game['date'];
      if($listDate > $date_now) {
        $buildarr[] = $game;
      }
    }

    return $buildarr;
  }

  public function getPastGames($startnum, $endnum)
	{
    die;
		$list = $this->games['games'];
    $date_now = date("Y-m-d");
		array_multisort($list, SORT_ASC);
		for($i = $startnum; $i < $endnum; ++$i) {
      $listDate = $list[$i]['date'];
      if ($date_now > $listDate) {
        $buildarr[] = $list[$i];
      }
		}
		return $buildarr;
	}

  public function getAllPastGames()
  {
    $list = $this->games['games'];
    $date_now = date("Y-m-d");
    $buildarr = array();

    foreach ($list as $game) {
      if ($date_now > $game['date']) {
        $buildarr[] = $game;
      }
      return $buildarr;
    }
  }
}
