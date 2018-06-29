<?php

class Home extends Controller
{
	public function index()
	{
    $schoolModel = $this->model('SchoolModel');
    $school = $schoolModel->getSchoolData();

    $socialModel = $this->model('SocialModel');
    $social_links = $socialModel->getSocialLinks();

    $gamesModel = $this->model('GamesModel');
    $curSchedule = $gamesModel->getCurrentSchedule(0, 5);

    $pagesModel = $this->model('PagesModel');
    $pageData = $pagesModel->getPageData('home')[0];
    
    $game_data = $curSchedule[0];

    $header_data = array(
      'page' => 'home',
      'seo_title' => $pageData['seo_title'],
      'seo_desc' => $pageData['seo_desc']
    );

    $footer_data = array(
      'school' => $school,
      'social_links' => $social_links
    );

		$this->view('home/index', array(
      'header_data' => $header_data,
      'footer_data' => $footer_data,
      'games' => $curSchedule,
      'game_data' => $game_data
    ));
	}
}
