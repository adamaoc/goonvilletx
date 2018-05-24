<?php

class SchoolModel
{
	public $name = "North Forney High School";
  public $schoolAddressStreet = "6170 Falcon Way,";
  public $schoolAddressCity = "Forney";
  public $schoolAddressState = "TX";
  public $schoolAddressZip = "75126";
  public $schoolPhone = "(469) 762-4159";
  public $schoolEmail = "testing@goonvilletx.com";

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
