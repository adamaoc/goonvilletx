<?php

class User {
  private $_data,
          $_user,
          $_sessionName,
          $_isLoggedIn;

  public function __construct($user = null)
  {
    $this->_data = new Data;
    $this->_sessionName = Config::get('session/session_name');

    if (!$user) {
      if (Session::exists($this->_sessionName)) {
        $user = Session::get($this->_sessionName);
        if ($this->findById($user)) {
          $this->_isLoggedIn = true;
        } else {
          // prossess logout
          $this->logout();
        }
      }
    } else {
      $this->findById($user);
    }
  }

  public function create($newUser)
  {
    $filePath = Config::get('data/path') . "Users.csv";
    $count = count(file($filePath));
    if ($count > 1) {
      $count = ($count - 1) + 1;
    }
    $salt = Hash::salt(32);
    $groupId = 0;
    if ($newUser['username'] === Config::get('data/superuser')) {
      $groupId = 1;
    }
    //id,username,password,salt,name,date,group
    $data = array(
      "id" => $count,
      "username" => $newUser['username'],
      "password" => Hash::make($newUser['password'], $salt),
      "salt" => $salt,
      "name" => $newUser['name'],
      "data" => date('Y-m-d H:i:s'),
      "group" => $groupId
    );
    $this->_data->addData($filePath, $data);
  }

  public function find($username = null)
  {
    if ($username) {
      $this->_user = $this->_data->getUser($username);
      return true;
    }
    return false;
  }

  public function findById($userId = null)
  {
    if ($userId) {
      $this->_user = $this->_data->getUserById($userId);
      return true;
    }
    return false;
  }

  public function login($username = null, $password = null)
  {
    $user = $this->find($username);
    if ($user) {
      if ($this->_user['password'] === Hash::make($password, $this->_user['salt'])) {
        // echo "OK";
        Session::put($this->_sessionName, $this->_user['id']);
        return true;
      }
    }
    return false;
  }

  public function logout()
  {
    Session::delete($this->_sessionName);
  }

  public function data()
  {
    return $this->_user;
  }

  public function isLoggedIn()
  {
    return $this->_isLoggedIn;
  }

  public function isSuperSet()
  {
    $user = $this->find(Config::get('data/superuser'));
    if ($this->_user) {
      return true;
    }
    return false;
  }

  public function setupData()
  {
    $filePath = Config::get('data/path') . 'Users.csv';
    if (!file_exists($filePath)) {
      mkdir(Config::get('data/path'), 0755, true);
      $baseData = array('id','username','password','salt','name','date','group');
      $this->_data->addData($filePath, $baseData);
    }
    return true;
  }
}
