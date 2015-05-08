<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Music_spotify extends MY_Controller {
	
	public function __construct()
	{
		parent::__construct();
		
		// Bibliothèque de chargment des vues de template
		$this->load->library('layout');
		$this->output->enable_profiler(TRUE);
		
		// Modeles
		$this->load->model('spotifyAPI_class');
		$musiques= $this->spotifyAPI_class->searchMusics("in da club",0);
		var_dump($musiques);
	}
	
	public function index()
	{
		
	}
}