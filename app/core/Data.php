<?php

class Data {
  private $_query,
          $_error = false,
          $_results,
          $_count = 0;

  private function _getData($file)
  {
    $filepath = Config::get('data/path') . $file . ".csv";
    $dataArr = array(
      'fields' => array(),
      'data' => array()
    );
    $row = 1;
    if (($handle = fopen($filepath, "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 2000, ",")) !== FALSE) {
            if ($row === 1) {
                foreach ($data as $value) {
                  array_push($dataArr['fields'], $value);
                }
            } else {
              foreach ($data as $key => $value) {
                $field = $dataArr['fields'][$key];
                $id = $row - 2;
                $dataArr['data'][$id][$field] = $value;
              }
            }
            $row++;
        }
        fclose($handle);
    }
    $this->_count = count($dataArr['data']);
    $this->_results = $dataArr['data'];
    return $dataArr['data'];
  }

  private function _updateData($filePath, $id, $updatedRow)
  {
    $dataArr = array();
    $row = 0;
    if (($handle = fopen($filePath, "r")) !== FALSE) {
      while (($data = fgetcsv($handle, 2000, ",")) !== FALSE) {
        if ($data[0] === $id) {
          $dataArr[$row] = $updatedRow;
        } else {
          $dataArr[$row] = $data;
        }
        $row++;
      }
    }
    fclose($handle);
    // save back to file //
    $fp = fopen($filePath, 'w');
    foreach ($dataArr as $fields) {
        fputcsv($fp, $fields);
    }
    fclose($fp);
  }

  public function deleteData($filePath, $id)
  {
    if ($id) {
      $dataArr = array();
      $row = 0;
      if (($handle = fopen($filePath, "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 2000, ",")) !== FALSE) {
          if ($data[0] !== $id) {
            $dataArr[$row] = $data;
          }
          $row++;
        }
      }
      fclose($handle);
      // save back to file //
      $fp = fopen($filePath, 'w');
      foreach ($dataArr as $fields) {
          fputcsv($fp, $fields);
      }
      fclose($fp);
      return true;
    }
    return false;
  }

  public function addData($filePath, $data)
  {
    $fileOpen = fopen($filePath, 'a');

    fputcsv($fileOpen, $data);
    fclose($fileOpen);
  }

  public function getUser($username)
  {
    $users = $this->_getData('Users');
    foreach ($users as $user) {
      if ($user['username'] === $username) {
        return $user;
      }
    }
    return null;
  }

  public function getUserById($id)
  {
    $users = $this->_getData('Users');
    foreach ($users as $user) {
      if ($user['id'] === $id) {
        return $user;
      }
    }
    return null;
  }

  public function getAll($filename)
  {
    return $this->_getData($filename);
  }

  public function count()
  {
    return $this->_count;
  }

  public function updateUser($user)
  {
    $filePath = Config::get('data/path') . "Users.csv";
    $id = $user['id'];
    $updatedRow = $user;
    $this->_updateData($filePath, $id, $updatedRow);
  }

  public function getWebData($file)
  {
    $filepath = $file;
    $dataArr = array(
      'fields' => array(),
      'data' => array()
    );
    $row = 1;
    if (($handle = fopen($filepath, "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 2000, ",")) !== FALSE) {
            if ($row === 1) {
                foreach ($data as $value) {
                  array_push($dataArr['fields'], $value);
                }
            } else {
              foreach ($data as $key => $value) {
                $field = $dataArr['fields'][$key];
                $id = $row - 2;
                $dataArr['data'][$id][$field] = $value;
              }
            }
            $row++;
        }
        fclose($handle);
    }
    $this->_count = count($dataArr['data']);
    $this->_results = $dataArr['data'];
    return $dataArr['data'];
  }

  public function updateWebData($file, $data)
  {
    $id = $data['id'];
    $updatedRow = $data;
    $this->_updateData($file, $id, $updatedRow);
    return $this->getWebData($file);
  }
}
