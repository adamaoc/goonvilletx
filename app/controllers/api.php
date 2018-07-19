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
        $pageData = $pageModel->getPageData($secPath);
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
        $uploadedImage = $this->uploadSponsorImage($_FILES['file']);
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
      default:
        $games = $gamesModel->getAllGames();
        return array('data' => $games, 'name' => 'games');
        break;
    }
  }

  private function uploadSponsorImage($file)
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
          $file_destination = 'public/images/sponsors/' . $file_name_new;

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
}
