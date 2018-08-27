<?php

class Page extends Controller
{
	public function index($sec)
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

        $footer_data = array(
            'school' => $school,
            'social_links' => $social_links,
            'user_data' => $user_data
        );

        switch ($sec) {
            case 'polish-and-pray':
                $header_data = array(
                    'seo_title' => "Polish and Pray",
                    'seo_desc' => "Polish and Pray - Join other moms to clean, make notes, and pray for our players before their games.",
                    'logo' => $school['header_logo']
                );

                $this->view('page/pnp', array(
                    'header_data' => $header_data,
                    'footer_data' => $footer_data,
                ));
                break;
            
            default:
                $this->view('page/index', array(
                    'header_data' => $header_data,
                    'footer_data' => $footer_data
                ));
                break;
        }
	}
}
