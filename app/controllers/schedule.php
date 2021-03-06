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

    $pageModel = $this->model('PageModel');
    $pageData = $pageModel->getPageData('schedule');

    $schoolModel = $this->model('SchoolModel');
    $school = $schoolModel->getSchoolData();
    $socialModel = $this->model('SocialModel');
    $social_links = $socialModel->getSocialLinks();

    $gamesModel = $this->model('GamesModel');
    $curSeason = $gamesModel->getCurrentSeason();

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
    $baseData = array(
      'header_data' => $header_data,
      'footer_data' => $footer_data,
      'page_data' => $pageData[0],
      'season' => $curSeason
    );

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
      'page_data' => $baseData['page_data'],
      'season' => $baseData['season'],
      'games' => $curSchedule,
      'past_games' => $pastGames
    ));
  }

  public function getSingle($model, $slug, $baseData)
  {
    $gameData = $model->getGame($slug);
    $postData = $model->getPost($slug);
    $data = array(
      'header_data' => $baseData['header_data'],
      'footer_data' => $baseData['footer_data'],
      'gameData' => $gameData,
      'postData' => $postData
    );

    $this->view('schedule/single', $data);
  }
}
