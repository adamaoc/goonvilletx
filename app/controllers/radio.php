<?php

class Radio extends Controller
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
    $header_data = array(
      'title' => 'Schedule 2018-2019 Season | Goonville, TX'
    );
    $footer_data = array(
      'school' => $school,
      'social_links' => $social_links,
      'user_data' => $user_data
    );

		$this->view('radio/index', array(
      'header_data' => $header_data,
      'footer_data' => $footer_data
    ));
	}
}
