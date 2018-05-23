<?php

class Home extends Controller
{
	public function index()
	{
    $header_data = array(
      'title' => 'Goonville, TX'
    );

		$this->view('home/index', ['header_data' => $header_data]);
	}
}
