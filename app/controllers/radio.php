<?php

class Radio extends Controller
{
	public function index($sec = null)
	{
    $user = new User;
    $user_data = array(
      "user" => $user->data(),
      "loggedin" => $user->isLoggedIn()
    );

    $pageModel = $this->model('PageModel');

    $schoolModel = $this->model('SchoolModel');
    $school = $schoolModel->getSchoolData();
    $socialModel = $this->model('SocialModel');
    $social_links = $socialModel->getSocialLinks();

    $footer_data = array(
      'school' => $school,
      'social_links' => $social_links,
      'user_data' => $user_data
    );
    $radioModel = $this->model('RadioModel');

    if(!empty($sec)) {
      $postData = $radioModel->getPostData($sec);
      $post = $radioModel->getPost($sec);

      $header_data = array(
        'seo_title' => 'THIS NEEDS TO BE THE POST TITLE',
        'seo_desc' => 'THIS NEEDS TO BE THE POST DESC',
        'logo' => $school['header_logo']
      );
      
      $this->view('radio/post', array(
        'header_data' => $header_data,
        'footer_data' => $footer_data,
        'post_data' => $postData,
        'post' => $post
      ));
    } else {
      $pageData = $pageModel->getPageData('radio');
      $header_data = array(
        'seo_title' => $pageData[0]['seo_title'],
        'seo_desc' => $pageData[0]['seo_desc'],
        'logo' => $school['header_logo']
      );
      $postList = $radioModel->recentListSet(0, 3);
      $this->view('radio/index', array(
        'header_data' => $header_data,
        'footer_data' => $footer_data,
        'page_data' => $pageData[0],
        'post_list' => $postList
      ));
    }
	}
}
