<?php

class MY_Controller extends CI_Controller{
	public function __construct(){
		
		parent::__construct();
		require_once APPPATH.'funcaig/slug.php';
		require_once APPPATH.'funcaig/mail.php';
		require_once APPPATH.'funcaig/preview.php';
		require_once APPPATH.'funcaig/datetodatetime.php';
		require_once APPPATH.'funcaig/datetimetodate.php';
		require_once APPPATH.'funcaig/datetimetodateshort.php';
		require_once APPPATH.'funcaig/datetimetodateclassic.php';
	}
}

?>