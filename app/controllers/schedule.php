<?php

class Schedule extends Controller
{
	public function index($slug = '')
	{
    $user = new User;
    $user_data = array(
      "user" => $user->data(),
      "loggedin" => $user->isLoggedIn()
    );

    $schoolModel = $this->model('SchoolModel');
    $school = $schoolModel->getSchoolData();
    $socialModel = $this->model('SocialModel');
    $social_links = $socialModel->getSocialLinks();
    $header_data = array(
      'title' => 'Schedule 2018-2019 Season | Goonville, TX'
    );
    $footer_data = array(
      'school' => $school,
      'social_links' => $social_links,
      'user_data' => $user_data
    );
    $baseData = array(
      'header_data' => $header_data,
      'footer_data' => $footer_data
    );
    $gamesModel = $this->model('GamesModel');

    if(empty($slug)) {
      $this->getIndex($gamesModel, $baseData);
		}else{
      $this->getSingle($gamesModel, $slug, $baseData);
		}
	}

  public function getIndex($model, $baseData)
  {
    $curSchedule = $model->getCurrentScheduleAll();
    $pastGames = $model->getAllPastGames();

    $this->view('schedule/index', array(
      'header_data' => $baseData['header_data'],
      'footer_data' => $baseData['footer_data'],
      'games' => $curSchedule,
      'past_games' => $pastGames
    ));
  }

  public function getSingle($model, $slug, $baseData)
  {
    $gameData = $model->getGame($slug);
    $data = array(
      'header_data' => $baseData['header_data'],
      'footer_data' => $baseData['footer_data'],
      'gameData' => $gameData
    );

    $this->view('schedule/single', $data);
  }
}
