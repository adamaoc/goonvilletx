<?php

switch ($data['type']) {
  case 'flyer':
    getComponent('AnnouncementFlyer', $data);
    break;
  case 'large_text':
    getComponent('AnnouncementLargeText', $data);
    break;
  default:
    // code...
    break;
}
