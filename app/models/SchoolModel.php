<?php

class SchoolModel
{
	public $name = null;
  public $schoolAddressStreet = null;
  public $schoolAddressCity = null;
  public $schoolAddressState = null;
  public $schoolAddressZip = null;
  public $schoolPhone = null;
  public $schoolEmail = null;

  public function __construct()
  {
    $data = new Data;
    $filepath = Config::get('data/webdata') . "school_info.csv";
    $school_info = $data->getWebData($filepath);
    $this->name = $school_info[0]['school_name'];
    $this->schoolAddressStreet = $school_info[0]['street'];
    $this->schoolAddressCity = $school_info[0]['city'];
    $this->schoolAddressState = $school_info[0]['state'];
    $this->schoolAddressZip = $school_info[0]['zip'];
    $this->schoolPhone = $school_info[0]['phone'];
    $this->schoolEmail = $school_info[0]['email'];
  }

  public function getSchoolAddress()
  {
    return array(
      'street' => $this->schoolAddressStreet,
      'city' => $this->schoolAddressCity,
      'state' => $this->schoolAddressState,
      'zip' => $this->schoolAddressZip
    );
  }

  public function getSchoolData()
  {
    $address = $this->getSchoolAddress();
    return array(
      'name' => $this->name,
      'phone' => $this->schoolPhone,
      'email' => $this->schoolEmail,
      'address' => $address
    );
  }
}
