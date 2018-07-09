<?php

class GamesModel
{
	public $name;
  public $games = array();

  function __construct()
  {
    $this->getGamesData();
  }

  public function getGamesData()
  {
    $gamesArr = array(
      'fields' => array(),
      'games' => array()
    );
    $row = 1;
    if (($handle = fopen("./data/games.csv", "r")) !== FALSE) {
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
