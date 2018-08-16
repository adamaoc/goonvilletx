<?php

class Roster extends Controller
{
	public function index($sec)
	{
    $user = new User;
    $user_data = array(
      "user" => $user->data(),
      "loggedin" => $user->isLoggedIn()
    );

    $rostersModel = $this->model('RostersModel');

    $showRoster = null;
    $rosterPage = 'roster/index';

    switch ($sec) {
      case 'players':
        $showRoster = $rostersModel->getPlayers();
        $rosterPage = 'roster/players';
        break;
      case 'coaches':
        $showRoster = $rostersModel->getCoaches();
        $rosterPage = 'roster/coaches';
        break;
    }

    $schoolModel = $this->model('SchoolModel');
    $school = $schoolModel->getSchoolData();
    $socialModel = $this->model('SocialModel');
    $social_links = $socialModel->getSocialLinks();

    $header_data = array(
      'seo_title' => 'Goonville Player Roster for the 2018-2019 Season',
      'seo_desc' => 'Goonville Player Roster for the 2018-2019 Season',
      'logo' => $school['header_logo']
    );

    $footer_data = array(
      'school' => $school,
      'social_links' => $social_links,
      'user_data' => $user_data
    );

		$this->view($rosterPage, array(
      'header_data' => $header_data,
      'footer_data' => $footer_data,
      'roster' => $showRoster
    ));
	}
}
