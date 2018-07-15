<?php

class SocialModel
{
  public function __construct()
  {
    $data = new Data;
    $filepath = Config::get('data/webdata') . "school_info.csv";
    $this->_school = $data->getWebData($filepath);
  }
  public function setupSocialLinks()
  {
    return array(
      'twitter' => array(
        'id' => 1,
        'name' => 'Twitter',
        'slug' => 'twitter',
        'user' => 'goonville',
        'link' => $this->_school[0]['twitter']
      ),
      'facebook' => array(
        'id' => 2,
        'name' => 'Facebook',
        'slug' => 'facebook',
        'user' => 'goonville',
        'link' => $this->_school[0]['facebook']
      )
    );
  }

  public function getSocialLinks()
  {
    return $this->setupSocialLinks();
  }
}
