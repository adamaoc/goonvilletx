<?php

class API extends Controller {
  private $_authError = array('data' => "You're not aloud to access this", 'name' => 'error');

  public function index($path = '', $sec = '')
  {
    switch ($path) {
      case 'page':
        $returnData = $this->handlePageRoute($sec);
        $this->api($returnData['data'], $returnData['name']);
        break;
      case 'schedule':
        $returnData = $this->handleScheduleRoute($sec);
        $this->api($returnData['data'], $returnData['name']);
        break;
      case 'sponsors':
        $returnData = $this->handleSponsorsRoute($sec);
        $this->api($returnData['data'], $returnData['name']);
        break;
      case 'school':
        $returnData = $this->handleSchoolRoute($sec);
        $this->api($returnData['data'], $returnData['name']);
        break;
      case 'rosters':
        $returnData = $this->handleRostersRoute($sec);
        $this->api($returnData['data'], $returnData['name']);
        break;
      case 'radio-posts':
        $returnData = $this->handleRadioPostsRoute($sec);
        $this->api($returnData['data'], $returnData['name']);
        break;
      default:
        $this->api(array('error' => 'You must hit a valid endpoint.'), 'errors');
        break;
    }
  }

  private function _authCheck($json)
  {
    $headers = getallheaders();
    if (!empty($headers['Token']) && !empty($json)) {
      if (Token::apiCheck($headers['Token'])) {
        return true;
      }
    }
    return false;
  }

  private function handlePageRoute($secPath)
  {
    $json = @file_get_contents('php://input');
    $pageModel = $this->model('PageModel');
    $schoolModel = $this->model('SchoolModel');
    switch ($secPath) {
      case 'update':
        $page = $_GET['page'];
        if ($this->_authCheck($json)) {
          $array = json_decode($json, true);
          $pageData = $pageModel->updatePageData($page, $array);
          return array('data' => $pageData, 'name' => 'page');
        } else {
          return $this->_authError;
        }
        break;
      default:
        $pageData = array('school' => '');
        $pageData = $pageModel->getPageData($secPath);
        $pageData['school'] = $schoolModel->getSchoolData();
        return array('data' => $pageData, 'name' => 'page');
        break;
    }
  }

  private function handleSponsorsRoute($secPath)
  {
    $json = @file_get_contents('php://input');
    $sponsorsModel = $this->model('SponsorsModel');
    switch ($secPath) {
      case 'update':
        if ($this->_authCheck($json)) {
          $array = json_decode($json, true);
          $sponsor = $sponsorsModel->updateSponsor($array[0]);
          return array('data' => $sponsor, 'name' => 'sponsor');
        } else {
          return $this->_authError;
        }
        break;
      case 'delete':
        $id = $_GET['id'];
        return $this->deleteSponsor($id);
        break;
      case 'add':
        if ($this->_authCheck($json)) {
          $array = json_decode($json, true);
          $sponsors = $sponsorsModel->addNewSponsor($array);
          return array('data' => $sponsors, 'name' => 'sponsors');
        } else {
          return $this->_authError;
        }
        break;
      case 'upload':
        $uploadedImage = $this->uploadImage($_FILES['file'], 'public/images/sponsors/');
        if (isset($uploadedImage['errors'])) {
          return array('data' => $uploadedImage[0], 'name' => 'error');
        } else {
          return array('data' => $uploadedImage, 'name' => 'image');
        }
        break;
      case 'sponsor':
        // code...
        break;
      default:
        $sponsors = $sponsorsModel->getSponsors();
        return array('data' => $sponsors, 'name' => 'sponsors');
        break;
    }
  }

  private function handleScheduleRoute($secPath)
  {
    $json = @file_get_contents('php://input');
    $gamesModel = $this->model('GamesModel');
    switch ($secPath) {
      case 'update':
        if ($this->_authCheck($json)) {
          $array = json_decode($json, true);
          $game = $gamesModel->updateGame($array);
          return array('data' => $game, 'name' => 'game');
        } else {
          return $this->_authError;
        }
        break;
      case 'addnew':
        if ($this->_authCheck($json)) {
          $array = json_decode($json, true);
          $game = $gamesModel->addNewGame($array);
          return array('data' => $game, 'name' => 'game');
        }
        break;
      case 'game_post':
        $id = $_GET['id'];
        if ($this->_authCheck($json)) {
          $array = json_decode($json, true);
          $gamePost = $gamesModel->updateGamePost($array, $id);
          return array('data' => $gamePost, 'name' => 'game_post');
        } else {
          $gameData = $gamesModel->getPost($id);
          return array('data' => $gameData, 'name' => 'game');
        }
        break;
      default:
        $games = $gamesModel->getAllGames();
        $season = $gamesModel->getCurrentSeason();
        $scheduleArr = array('games' => $games, 'season' => $season);
        return array('data' => $scheduleArr, 'name' => 'schedule');
        break;
    }
  }

  private function uploadImage($file, $dest)
  {
    $file_name = $file['name'];
    $file_tmp = $file['tmp_name'];
    $file_size = $file['size'];
    $file_error = $file['error'];
    // work out file extension
    $file_ext = explode('.', $file_name);
    $file_ext = strtolower(end($file_ext));

    $allowed = array('jpg', 'jpeg', 'png');

    if (in_array($file_ext, $allowed)) {
      if ($file_error === 0) {
        if ($file_size <= 2097152) {
          $file_name_new = uniqid('', true) . '.' . $file_ext;
          $file_destination = $dest . $file_name_new;

          if (move_uploaded_file($file_tmp, $file_destination)) {
            return array(
              'file_path' => $file_destination,
              'file_name' => $file_name_new
            );
          }
        } else {
          $file_error = 'file too large';
        }
      } else {
        $file_error = 'file had an error';
      }
    } else {
      $file_error = 'unsupported file extention';
    }
    return array( 'errors' => $file_error );
  }

  public function deleteSponsor($id)
  {
    $headers = getallheaders();
    if (!Token::apiCheck($headers['Token'])) {
      $this->api(array(
        "error" => "You're not aloud to access this",
        "token" => $_SESSION['api_token']
      ), 'error', 500);
    } else {
      $sponsorsModel = $this->model('SponsorsModel');
      $deleteSuccess = $sponsorsModel->deleteSponsor($id);
      if ($deleteSuccess) {
        return array('data' => array('success' => true), 'name' => 'success');
      } else {
        return array('data' => array("error_message" => "Delete unsuccessful"), 'name' => 'error');
      }
    }
  }

  private function handleSchoolRoute($sec)
  {
    $json = @file_get_contents('php://input');
    $schoolModel = $this->model('SchoolModel');
    switch ($sec) {
      case 'update':
        if ($this->_authCheck($json)) {
          $array = json_decode($json, true);
          $schoolInfo = $schoolModel->updateSchoolInfo($array);
          return array('data' => $schoolInfo, 'name' => 'school');
        } else {
          return $this->_authError;
        }
        break;
      case 'logo-upload':
        if ($this->_authCheck($_FILES['file'])) {
          $location = $_GET['location'];
          $array = json_decode($json, true);

          $imgLoc = 'public/images/logos/';
          if (!file_exists($imgLoc)) {
            exit();
          }
          $uploadedImage = $this->uploadImage($_FILES['file'], $imgLoc);
          if (isset($uploadedImage['errors'])) {
            return array('data' => $uploadedImage[0], 'name' => 'error');
          } else {
            $schoolInfo = $schoolModel->updateLogo($uploadedImage, $location);
            return array('data' => $schoolInfo, 'name' => 'school');
          }
        } else {
          return $this->_authError;
        }
        break;
      default:
        // code...
        break;
    }
  }

  private function handleRostersRoute($sec)
  {
    $json = @file_get_contents('php://input');
    $rosterModel = $this->model('RostersModel');
    switch ($sec) {
      case 'all':
        $rosters = $rosterModel->getALlRosters();
        return array('data' => $rosters, 'name' => 'rosters');

      case 'get-team':
        $teamPlayers = $rosterModel->getTeam($_GET['team']);
        return array('data' => $teamPlayers);

      case 'add-player':
        $array = json_decode($json, true);
        $players = $rosterModel->addPlayer($array);
        return array('data' => $players, 'name' => 'players');
      case 'player-update':
        if ($this->_authCheck($json)) {
          $array = json_decode($json, true);
          $player = $rosterModel->updatePlayer($array);
          return array('data' => $player, 'name' => 'player');
        } else {
          return $this->_authError;
        }
        break;
      case 'delete-player':
        $id = $_GET['id'];
        $deleteSuccess = $rosterModel->deletePlayer($id);
        if ($deleteSuccess) {
          return array('data' => array('success' => true), 'name' => 'success');
        } else {
          return array('data' => array("error_message" => "Delete unsuccessful"), 'name' => 'error');
        }
        break;
      case 'add-coach':
        $array = json_decode($json, true);
        $coaches = $rosterModel->addCoach($array);
        return array('data' => $coaches, 'name' => 'coaches');
      case 'coach-update':
        if ($this->_authCheck($json)) {
          $array = json_decode($json, true);
          $coach = $rosterModel->updateCoach($array);
          return array('data' => $coach, 'name' => 'coach');
        } else {
          return $this->_authError;
        }
        break;
      case 'delete-coach':
        $id = $_GET['id'];
        $deleteSuccess = $rosterModel->deleteCoach($id);
        if ($deleteSuccess) {
          return array('data' => array('success' => true), 'name' => 'success');
        } else {
          return array('data' => array("error_message" => "Delete unsuccessful"), 'name' => 'error');
        }
        break;
      case 'upload':
        $imgLoc = 'data/rosters/imgs/';
        if (!file_exists($imgLoc)) {
          mkdir($imgLoc);
        }
        $uploadedImage = $this->uploadImage($_FILES['file'], $imgLoc);
        if (isset($uploadedImage['errors'])) {
          return array('data' => $uploadedImage[0], 'name' => 'error');
        } else {
          return array('data' => $uploadedImage, 'name' => 'image');
        }
        break;
      default:
        // code...
        break;
    }
  }

  private function handleRadioPostsRoute($sec)
  {
    $json = @file_get_contents('php://input');
    $radioModel = $this->model('RadioModel');
    switch ($sec) {
      case 'all':
        # code...
        break;
      case 'post':
        $id = $_GET['id'];
        if ($this->_authCheck($json)) {
          // $array = json_decode($json, true);
          // $post = $radioModel->getPostById($id);
          // return array('data' => $post, 'name' => 'post');
        } else {
          $data = $radioModel->getPostById($id);
          return array('data' => $data, 'name' => 'post');
        }
        break;
      default:
        $postList = $radioModel->getPostListAll();
        return array('data' => $postList, 'name' => 'posts');
        break;
    }
  }
}
