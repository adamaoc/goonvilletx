<?php

class SocialModel
{

  public function setupSocialLinks()
  {
    return array(
      'twitter' => array(
        'id' => 1,
        'name' => 'Twitter',
        'slug' => 'twitter',
        'user' => 'goonville',
        'link' => 'https://twitter.com/NForneyFalcons'
      ),
      'facebook' => array(
        'id' => 2,
        'name' => 'Facebook',
        'slug' => 'facebook',
        'user' => 'goonville',
        'link' => 'https://www.facebook.com/groups/1471729716254806/'
      )
    );
  }

  public function getSocialLinks()
  {
    return $this->setupSocialLinks();
  }
}
