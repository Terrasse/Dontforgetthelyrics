<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Music_class extends CI_Model
{
	protected $tMusic = 'music';
	protected $tArtist = 'artist';
	protected $tAlbum = 'album';
	
	/**
	 *	Add a music to the db
	 */
	public function add_music($path, $title, $lyrics, $id_artist, $id_album)
	{
		//	Ces données seront automatiquement échappées
		$this->db->set('title', $title);
		$this->db->set('path', $path);
		$this->db->set('lyrics', $lyrics);
		$this->db->set('id_artist', $id_artist);
		$this->db->set('id_album', $id_album);
		
		//	Ces données ne seront pas échappées
		// $this->db->set('date', 'NOW()', false);
		
		//	Une fois que tous les champs ont bien été définis, on "insert" le tout
		$this->db->insert($this->tMusic);
		
		return $this->db->insert_id();
	}
	
	/**
	 *	Remove a music from the db
	 */
	public function remove_music($id_music)
	{
		return $this->db->where('id_music', $id_music)
						->delete($this->tMusic);
	}
	
	/**
	 *	Return datas from a music
	 */
	public function getMusic($id_music)
	{
		return $this->db->query("
								SELECT *
								FROM ".$this->tMusic." 
								INNER JOIN ".$this->tArtist." ON ".$this->tArtist.".id_artist = ".$this->tMusic.".id_artist
								INNER JOIN ".$this->tAlbum." ON ".$this->tAlbum.".id_album = ".$this->tMusic.".id_album
								WHERE id_music = ".$id_music."
								");
	}
	
}