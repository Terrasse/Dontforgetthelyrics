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
		$this -> load -> model('artist_class');
		$this -> load -> model('album_class');
		$this -> load -> model('music_class');
	}

	public function index() {
		// $output=$this -> misiXmatchAPI_class -> extractLyrics("https://www.musixmatch.com/lyrics/The-Beatles/Hey-Jude");
		// var_dump($output);
		// $result = $this -> spotifyAPI_class ->getToken();
		// var_dump($result);
		// var_dump($result['0']->expires_at);
		
		
		// test bd artists
		// var_dump($this->artist_class->getArtists('3'));
		
		// test bd album
		// var_dump($this->album_class->getAlbumName('1'));
		$ex=explode('<br>','salutsalut salutsalut<br>laalakaklalala<br>');
		var_dump(5000==null);
	}

}
