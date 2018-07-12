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
      $this->getSponsorsData();
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
}
