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

    $pageModel = $this->model('PageModel');
    $pageData = $pageModel->getPageData('home');

    $schoolModel = $this->model('SchoolModel');
    $school = $schoolModel->getSchoolData();
    $socialModel = $this->model('SocialModel');
    $social_links = $socialModel->getSocialLinks();
    $gamesModel = $this->model('GamesModel');
    $curSchedule = $gamesModel->getCurrentSchedule(0, 5);
    $curSeason = $gamesModel->getCurrentSeason();

    $sponsorsModel = $this->model('SponsorsModel');
    $sponsors = $sponsorsModel->getSponsors();

    $game_data = null;
    
    if (!empty($curSchedule)) {
      $game_data = $curSchedule[0];
    }
    
    $header_data = array(
      'seo_title' => $pageData[0]['seo_title'],
      'seo_desc' => $pageData[0]['seo_desc'],
      'logo' => $school['header_logo']
    );

    $footer_data = array(
      'school' => $school,
      'social_links' => $social_links,
      'user_data' => $user_data
    );

		$this->view('home/index', array(
      'header_data' => $header_data,
      'footer_data' => $footer_data,
      'games' => $curSchedule,
      'game_data' => $game_data,
      'season' => $curSeason,
      'page_data' => $pageData[0],
      'sponsors' => $sponsors,
      'announcement' => null
    ));
	}
}
