<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Player extends MY_Controller {
	
	//Constructor
	public function __construct()
	{
		parent::__construct();
		
		// Bibliothèque de chargment des vues de template
		$this->load->library('layout');
	}
	
	public function index()
	{
		$this->layout->view('Profile/player_profile');
	}
}