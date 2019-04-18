<?php

function dateSort($a, $b) {
  return strtotime($a['date']) - strtotime($b['date']);
}

class GamesModel
{
	public $name,
         $games = array(),
         $seasonYears = '2018-2019',
         $gamesFile = '',
         $seasons = array();
  private $_db,
          $_file;

  function __construct()
  {
    $this->_seasons = Config::get('data/webdata') . 'seasons/seasons.csv';
    $this->_file = Config::get('data/webdata') . 'games.csv';
    $this->_db = new Data;
    $this->getSeason();
    $this->getGamesData();
  }

  public function getSeason()
  {
    $dir = "data/seasons";
    if (!is_dir($dir)) {
      return;
    }
    $seasonsArr = array(
      'fields' => array(),
      'seasons' => array()
    );
    $row = 1;
    if (($handle = fopen($this->_seasons, "r")) !== FALSE) {
      while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        if ($row === 1) {
          foreach ($data as $value) {
            array_push($seasonsArr['fields'], $value);
          }
        } else {
          foreach ($data as $key => $value) {
            $field = $seasonsArr['fields'][$key];
            $id = $row - 2;
            $seasonsArr['seasons'][$id][$field] = $value;
          }
        }
        $row++;
      }
      fclose($handle);
    }
    $seasons = $seasonsArr['seasons'];
    foreach ($seasons as $season) {
      if ($season['current'] === '1') {
        $this->seasonYears = $season['years'];
        $this->gamesFile = $season['gamesPath'];
      }
    }
    $this->_file = Config::get('data/webdata') . $this->gamesFile;
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
    // rawData($gamesArr);
    // die;
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

  public function addNewGame($data) 
  {
    // id,date,home_team,visiting_team,location,home_score,visiting_score
    $gameData = array(
      "id"              => $data['id'],
      "date"            => $data['date'],
      "home_team"       => $data['home_team'],
      "visiting_team"   => $data['visiting_team'],
      "location"        => $data['location'],
      "home_score"      => $data['home_score'],
      "visiting_score"  => $data['visiting_score']
    );
    $this->_db->addWebData($this->_file, $gameData);
    return $gameData;
  }

  public function getAllGames()
  {
    return $this->games['games'];
  }

  public function getCurrentSeason()
  {
    return $this->seasonYears;
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
    $curArr = array();
    $buildarr = array();

    usort($list, 'dateSort');

    foreach ($list as $game) {
      if ($game['date'] >= $date_now) {
        $curArr[] = $game;
      }
    } 

    if ($endnum > count($curArr)) {
      $endnum = count($curArr);
    }

		for($i = $startnum; $i < $endnum; ++$i) {
      $buildarr[] = $curArr[$i];
    }

    return $buildarr;
	}

  public function getCurrentScheduleAll()
  {
    $buildarr = array();
    $list = $this->games['games'];
    $date_now = date("Y-m-d");

    usort($list, 'dateSort');

    foreach ($list as $game) {
      $listDate = $game['date'];
      if($listDate >= $date_now) {
        $buildarr[] = $game;
      }
    }

    return $buildarr;
  }

  public function getPastGames($startnum, $endnum)
	{
    // is this working???
		$list = $this->games['games'];
    $date_now = date("Y-m-d");

    usort($list, 'dateSort');

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

    usort($list, 'dateSort');

    foreach ($list as $game) {
      if ($date_now > $game['date']) {
        $buildarr[] = $game;
      }
    }
    return $buildarr;
  }

  public function getPost($id)
	{
    $fname = Config::get('data/webdata') . '/games/game_' . $id . '.md';
    if (file_exists($fname)) {
      $post = file($fname);
      $postarr = $this->buildPostData($post);
      return $postarr;
    } else {
      return null;
    }
	}

  private function buildPostData($post)
  {
    $blog_title = trim(str_replace(array("\n", '*'), '', $post[0]));
    $blog_author = trim(str_replace(array("\n", '*'), '', $post[1]));
    $blog_status = trim(str_replace(array("\n", '*'), '', $post[2]));

    $excerpt = $post[4];
    $max_words = 50;
    $phrase_array = explode(' ',$excerpt);
    if(count($phrase_array) > $max_words && $max_words > 0) {
        $excerpt = implode(' ',array_slice($phrase_array, 0, $max_words)).'...';
    }
    $blog_intro = $excerpt;

    $blog_content = join('', array_slice($post, 4));

    $buildarr = array(
      "title" 	=> $blog_title,
      "author" => $blog_author,
      "status"	=> $blog_status,
      "excerpt" 	=> $blog_intro,
      "content" 	=> $blog_content
    );

    return $buildarr;
  }

  public function updateGamePost($data, $id)
  {
    $fname = Config::get('data/webdata') . '/games/game_' . $id . '.md';
    if (file_exists($fname)) {
      $post = file($fname);
      $mdFile = $this->buildFile($post, $data);
    } else {
      $mdFile = $this->buildFile(array(), $data);
    }
    $file = fopen($fname, "wa+");
    $i = 0;
    foreach ($mdFile as $line) {
      if ($i < 5) {
        fwrite($file, $line);
      }
      $i++;
    }
    fclose($file);
    return $data;
  }

  private function buildFile($post, $data)
  {
    $post[0] = "* " . $data["title"] . "\n";
    $post[1] = "* " . $data["author"] . "\n";
    $post[2] = "* " . $data["status"] . "\n";
    $post[3] = "\n";
    $post[4] = $data["content"];
    return $post;
  }
}
