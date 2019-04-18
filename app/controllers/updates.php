<?php

class Updates extends Controller
{
	public function index($v = '')
	{
    print_r("Updating App...");
    if ($v !== '') 
    {
      if(file_exists('app/updates/update-'.$v.'.php'))		
      {
        require_once 'app/updates/update-'.$v.'.php';
        unset($v);
      }
    } else {
      echo "Updated...";
    }
	}
}
