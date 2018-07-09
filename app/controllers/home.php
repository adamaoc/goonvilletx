<?php

class Home extends Controller
{
	public function index()
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
    $gamesModel = $this->model('GamesModel');
    $curSchedule = $gamesModel->getCurrentSchedule(0, 5);

    $game_data = $curSchedule[0];

    $header_data = array(
      'title' => 'Goonville, TX'
    );

    $footer_data = array(
      'school' => $school,
      'social_links' => $social_links
    );

		$this->view('home/index', array(
      'header_data' => $header_data,
      'footer_data' => $footer_data,
      'games' => $curSchedule,
      'game_data' => $game_data,
      'user_data' => $user_data
    ));
	}
}
