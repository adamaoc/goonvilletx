<?php

class Login extends Controller
{
	public function index()
	{
    $schoolModel = $this->model('SchoolModel');
    $school = $schoolModel->getSchoolData();
    $socialModel = $this->model('SocialModel');
    $social_links = $socialModel->getSocialLinks();
    $header_data = array(
      'title' => 'Goonville, TX - Login Page'
    );
    $footer_data = array(
      'school' => $school,
      'social_links' => $social_links
    );
		$this->view('login/index', array(
      'header_data' => $header_data,
      'footer_data' => $footer_data
    ));
	}
}
