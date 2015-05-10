<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Subtitles_misixmatchapi extends MY_Controller {

	public function __construct() {
		parent::__construct();

		// Bibliothèque de chargment des vues de template
		$this -> load -> library('layout');
		$this -> output -> enable_profiler(TRUE);

		// models
		$this -> load -> model('misiXmatchAPI_class');
		$this -> load -> model('spotifyAPI_class');
	}

	public function index() {
		// $output=$this -> misiXmatchAPI_class -> extractLyrics("https://www.musixmatch.com/lyrics/The-Beatles/Hey-Jude");
		// var_dump($output);
		$result = $this -> spotifyAPI_class ->getToken();
		var_dump($result);
		var_dump($result['0']->expires_at);
	}

}
