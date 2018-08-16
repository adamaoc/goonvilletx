<?php

class About extends Controller
{
	public function index()
	{
    $user = new User;
    $user_data = array(
      "user" => $user->data(),
      "loggedin" => $user->isLoggedIn()
    );
    $pageModel = $this->model('PageModel');
    $pageData = $pageModel->getPageData('about');

    $schoolModel = $this->model('SchoolModel');
    $school = $schoolModel->getSchoolData();
    $socialModel = $this->model('SocialModel');
    $social_links = $socialModel->getSocialLinks();
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

		$this->view('about/index', array(
      'header_data' => $header_data,
      'footer_data' => $footer_data,
      'page_data' => $pageData[0]
    ));
	}
}
