<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends MY_Controller {
	
	public function __construct()
	{
		parent::__construct();
		
		// Bibliothèque de chargment des vues de template
		$this->load->library('layout');
	}
	
	public function index()
	{
		$this->layout->view('home');
	}
}