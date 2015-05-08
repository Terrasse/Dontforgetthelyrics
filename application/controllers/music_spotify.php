<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Music_spotify extends MY_Controller {
	
	public function __construct()
	{
		parent::__construct();
		
		// Bibliothèque de chargment des vues de template
		$this->load->library('layout');
		$this->output->enable_profiler(TRUE);
		
		// Modeles
		$this->load->model('music_class');
		$this->music_class->test();
		$this->music_class->autorization();
		$this->music_class->searchMusic("Muse",10,0);
	}
	
	public function index()
	{
		
	}
}