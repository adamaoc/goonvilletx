<?php

class API extends Controller {
  public function index($path = '', $sec = '')
  {
    if ($path === 'schedule') {
      $this->getScheduleData();
    }
    if ($path === 'page') {
      $this->getPageData($sec);
    }
    if ($path === 'sponsors') {
      if ($sec === 'delete') {
        $id = $_GET['id'];
        $deletedSponsor = $this->deleteSponsor($id);
        exit;
      }
      if ($sec === 'upload') {
        $uploadedImage = $this->uploadSponsorImage($_FILES['file']);
        if (isset($uploadedImage['errors'])) {
          $this->api($uploadedImage[0], 'errors');
        } else {
          $this->api($uploadedImage, 'image');
        }
      } elseif($sec === 'sponsor') {
        $this->getSponsor();
      } else {
        $this->getSponsorsData();
      }
    }
  }

  private function getScheduleData()
  {
    $json = @file_get_contents('php://input');
    $schedule = $this->model('GamesModel');
    if (!empty($json)) {
      $headers = getallheaders();
      if (!Token::apiCheck($headers['Token'])) {
        $this->api(array(
          "error" => "You're not aloud to access this",
          "token" => $_SESSION['api_token']
        ), 'error', 500);
      } else {
        // update schedule data
      }
    } else {
      $games = $schedule->getAllGames();
      $this->api($games, 'games');
    }
  }

  private function getPageData($page)
  {
    $json = @file_get_contents('php://input');
    $pageModel = $this->model('PageModel');
    if (!empty($json)) {
      // update request //
      $headers = getallheaders();
      if (!Token::apiCheck($headers['Token'])) {
        $this->api(array(
          "error" => "You're not aloud to access this",
          "token" => $_SESSION['api_token']
        ), 'error', 500);
      } else {
        $array = json_decode($json, true);
        $pageData = $pageModel->updatePageData($page, $array);
        $this->api($pageData, 'page');
      }

    } else {
      $pageData = $pageModel->getPageData($page);
      $this->api($pageData, 'page');
    }
  }

  private function getSponsorsData()
  {
    $json = @file_get_contents('php://input');
    $sponsorsModel = $this->model('SponsorsModel');

    if (!empty($json)) {
      // update request //
      $headers = getallheaders();
      if (!Token::apiCheck($headers['Token'])) {
        $this->api(array(
          "error" => "You're not aloud to access this",
          "token" => $_SESSION['api_token']
        ), 'error', 500);
      } else {
        $array = json_decode($json, true);
        $sponsors = $sponsorsModel->addNewSponsor($array);
        $this->api($sponsors, 'sponsors');
      }

    } else {
      $sponsors = $sponsorsModel->getSponsors();
      $this->api($sponsors, 'sponsors');
    }
  }

  private function getSponsor()
  {
    $json = @file_get_contents('php://input');
    $sponsorsModel = $this->model('SponsorsModel');
    if (!empty($json)) {
      $headers = getallheaders();
      if (!Token::apiCheck($headers['Token'])) {
        $this->api(array(
          "error" => "You're not aloud to access this",
          "token" => $_SESSION['api_token']
        ), 'error', 500);
      } else {
        $array = json_decode($json, true);
        $sponsor = $sponsorsModel->updateSponsor($array[0]);
        $this->api($sponsor, 'sponsor');
      }
    } else {
      $sponsor = $sponsorsModel->getSponsor();
      $this->api($sponsor, 'sponsor');
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

    $allowed = array('jpg', 'png');

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

  public function deleteSponsor($id) {
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
          $this->api(array(
            "success" => true
          ), 'success');
      } else {
        $this->api(array(
          "error" => true,
          "error_message" => "Delete unsuccessful"
        ), 'error', 500);
      }
    }
  }
}
