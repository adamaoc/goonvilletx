<?php

class SchoolModel
{
  private $_data = null;
  private $_filepath = null;
	public $name = null;
  public $schoolAddressStreet = null;
  public $schoolAddressCity = null;
  public $schoolAddressState = null;
  public $schoolAddressZip = null;
  public $schoolPhone = null;
  public $schoolEmail = null;

  public function __construct()
  {
    $this->_data = new Data;
    $this->_filepath = Config::get('data/webdata') . "school_info.csv";
  }

  public function getSchoolAddress($school_info)
  {
    return array(
      'street' => $school_info[0]['street'],
      'city' => $school_info[0]['city'],
      'state' => $school_info[0]['state'],
      'zip' => $school_info[0]['zip']
    );
  }

  public function getSchoolData()
  {
    $school_info = $this->_data->getWebData($this->_filepath);
    $address = $this->getSchoolAddress($school_info);
    // $school_info[0]['address'] = $address;
    return $school_info[0];
  }

  public function updateSchoolInfo($data)
  {
    $updatedInfo = array(
      'id' => 'schoolinfo',
      'school_name' => $data['school_name'],
      'mascot' => $data['mascot'],
      'school_aka' => $data['school_aka'],
      'email' => $data['email'],
      'phone' => $data['phone'],
      'street' => $data['street'],
      'city' => $data['city'],
      'state' => $data['state'],
      'zip' => $data['zip'],
      'twitter' => $data['twitter'],
      'facebook' => $data['facebook'],
      'footer_logo' => $data['footer_logo'],
      'header_logo' => $data['header_logo']
    );

    $this->_data->updateWebData($this->_filepath, $updatedInfo);
    return $updatedInfo;
  }

  public function updateLogo($data, $location)
  {
    $schoolData = $this->getSchoolData();
    foreach ($schoolData as $key => $value) {
      if ($key === $location) {
        $schoolData[$key] = $data['file_path'];
      }
    }
    $this->_data->updateWebData($this->_filepath, $schoolData);
    return $schoolData;
  }
}
