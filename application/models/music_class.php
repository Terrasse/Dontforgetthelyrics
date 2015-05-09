<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Music_class extends CI_Model {
	protected $tMusic = 'music';
	protected $tArtist = 'artist';
	protected $tMusic_Artist = 'music_artist';
	protected $tAlbum = 'album';

	/**
	 *	Add a music to the db
	 */
	public function add_music($id_spotify, $path, $title, $lyrics, $id_album) {
		//	Ces donn�es seront automatiquement �chapp�es
		$this -> db -> set('id_spotify', $id_spotify);
		$this -> db -> set('title', $title);
		$this -> db -> set('path', $path);
		$this -> db -> set('lyrics', $lyrics);
		$this -> db -> set('id_album', $id_album);

		//	Ces donn�es ne seront pas �chapp�es
		// $this->db->set('date', 'NOW()', false);

		//	Une fois que tous les champs ont bien �t� d�finis, on "insert" le tout
		$this -> db -> insert($this -> tMusic);

		return $this -> db -> insert_id();
	}

	/**
	 *	Remove a music from the db
	 */
	public function remove_music($id_music) {
		return $this -> db -> where('id_music', $id_music) -> delete($this -> tMusic);
	}

	/**
	 *	Return datas from a music
	 */
	public function getMusic($id_music) {
		return $this -> db -> query("
								SELECT *
								FROM " . $this -> tMusic . " 
								INNER JOIN " . $this -> tMusic_Artist . " ON " . $this -> tMusic . ".id_music = " . $this -> tMusic_Artist . ".id_music
								INNER JOIN " . $this -> tArtist . " ON " . $this -> tArtist . ".id_artist = " . $this -> tMusic_Artist . ".id_artist
								INNER JOIN " . $this -> tAlbum . " ON " . $this -> tAlbum . ".id_album = " . $this -> tMusic . ".id_album
								WHERE " . $this -> tMusic . ".id_music = " . $id_music . "
								");
	}
	
	/**
	 *	Return datas from a music
	 */
	public function searchMusics($title) {
		return $this -> db -> query("
								SELECT *
								FROM " . $this -> tMusic . " 
								INNER JOIN " . $this -> tMusic_Artist . " ON " . $this -> tMusic . ".id_music = " . $this -> tMusic_Artist . ".id_music
								INNER JOIN " . $this -> tArtist . " ON " . $this -> tArtist . ".id_artist = " . $this -> tMusic_Artist . ".id_artist
								INNER JOIN " . $this -> tAlbum . " ON " . $this -> tAlbum . ".id_album = " . $this -> tMusic . ".id_album
								WHERE " . $this -> tMusic . ".title = '" . $title . "'
								");
	}

	/**
	 *	Return datas from all musics
	 */
	public function getMusics() {
		return $this -> db -> query("
								SELECT *
								FROM " . $this -> tMusic . " 
								INNER JOIN " . $this -> tMusic_Artist . " ON " . $this -> tMusic . ".id_music = " . $this -> tMusic_Artist . ".id_music
								INNER JOIN " . $this -> tArtist . " ON " . $this -> tArtist . ".id_artist = " . $this -> tMusic_Artist . ".id_artist
								INNER JOIN " . $this -> tAlbum . " ON " . $this -> tAlbum . ".id_album = " . $this -> tMusic . ".id_album
								");
	}

	public function donwloadMusic() {
		// récuperer la musique
		// puis ajouter bdd
		// puis sauvegarder le .mp3 dans le bon dossier
		// $output[0]
		$output = array();
		$status;
		$vartest = exec("", $output, $status);
		foreach ($output as $row) {
			echo $row;
		}
	}

}
