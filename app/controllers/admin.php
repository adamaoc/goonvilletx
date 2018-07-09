<?php

class Admin extends Controller
{
  private $_errors = array();

  public function index($path = null)
  {
    $schoolModel = $this->model('SchoolModel');
    $school = $schoolModel->getSchoolData();
    $socialModel = $this->model('SocialModel');
    $social_links = $socialModel->getSocialLinks();
    $header_data = array(
      'title' => 'Goonville, TX'
    );
    $footer_data = array(
      'school' => $school,
      'social_links' => $social_links
    );
    $user = new User;
    $user_data = array(
      "user" => $user->data(),
      "loggedin" => $user->isLoggedIn()
    );

    if ($path === 'login') {
      $this->loginPage();
      $this->view('admin/login', array(
        'header_data' => $header_data,
        'footer_data' => $footer_data,
        "errors" => $this->_errors));

    } else if ($path === 'register') {
      $this->registerPage();
      $this->view('admin/register', array(
        'header_data' => $header_data,
        'footer_data' => $footer_data,
        'user_data' => $user_data,
        "errors" => $this->_errors));

    } else if ($path === 'logout') {
      $this->logoutPage();
      $this->view('admin/logout');

    } else {
  		$this->view('admin/index', array(
        'header_data' => $header_data,
        'footer_data' => $footer_data,
        'user_data' => $user_data));
    }
  }

  public function loginPage()
  {
    if (Input::exists()) {
      if ($this->checkToken()) {
        $this->loginValidate();
      }
    }
  }

  private function loginValidate()
  {
    $validate = new Validate;
    $validation = $validate->check($_POST, array(
      'username' => array( 'required' => true ),
      'password' => array( 'required' => true )
    ));

    if ($validation->passed()) {
      // login user
      $user = new User();
      $login = $user->login(Input::get('username'), Input::get('password'));
      if ($login) {
        // echo "Success";
        Redirect::to('http://localhost:8888/');
      } else {
        echo "Sorry, username or password was incorrect.";
      }
    } else {
      $this->_errors = $validation->errors();
    }
  }

  public function registerPage()
  {
    if (Input::exists()) {
      if ($this->checkToken()) {
        $this->registerValidate();
      }
    }
  }

  private function registerValidate()
  {
    $validate = new Validate;
    $validation = $validate->check($_POST, array(
      'username' => array(
        'required' => true,
        'min' => 4,
        'max' => 20,
        'unique' => 'users'
      ),
      'password' => array(
        'required' => true,
        'min' => 6
      ),
      'name' => array(
        'required' => true,
        'min' => 4,
        'max' => 50
      )
    ));

    if ($validation->passed()) {
      // echo "Passed";
      $newUser = array(
        'username' => Input::get('username'),
        'password' => Input::get('password'),
        'name' => Input::get('name')
      );
      $user = new User();
      $user->create($newUser);
      Session::flash('success', 'You successfully registered.');
      Redirect::to('http://localhost:8888');
      // Redirect::to(404);
    } else {
      $this->_errors = $validation->errors();
    }
  }

  public function logoutPage()
  {
    $user = new User;
    $user->logout();
    Redirect::to('http://localhost:8888/');
  }

  private function checkToken()
  {
    return Token::check(Input::get('token'));
  }
}
