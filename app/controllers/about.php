<?php

class About extends Controller
{
	public function index()
	{
    $schoolModel = $this->model('SchoolModel');
    $school = $schoolModel->getSchoolData();
    $socialModel = $this->model('SocialModel');
    $social_links = $socialModel->getSocialLinks();
    $header_data = array(
      'title' => 'About Goonville, TX | The North Forney Falcons'
    );

    $footer_data = array(
      'school' => $school,
      'social_links' => $social_links
    );

		$this->view('about/index', array(
      'header_data' => $header_data,
      'footer_data' => $footer_data
    ));
	}
}
