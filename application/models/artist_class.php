<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Artist_class extends CI_Model
{
	protected $tArtist = 'artist';
	protected $tMusic = 'music';
	protected $tMusic_Artist = 'music_artist';

	/**
	*	Add an artist to the db
	*/
	public function add_artist($name)
	{
		//	Ces données seront automatiquement échappées
		$this->db->set('name', $name);

		//	Ces données ne seront pas échappées
		// $this->db->set('date', 'NOW()', false);

		//	Une fois que tous les champs ont bien été définis, on "insert" le tout
		$this->db->insert($this->tArtist);

		return $this->db->insert_id();
	}

	/**
	 *	Add an artist to the db
	 */
	public function add_artist_by_spotify($id_music, $name)
	{
		//	Ces données seront automatiquement échappées
		$this->db->set('name', $name);
		
		//	Ces données ne seront pas échappées
		// $this->db->set('date', 'NOW()', false);
		
		//	Une fois que tous les champs ont bien été définis, on "insert" le tout
		$this->db->insert($this->tArtist);
		
		$id_artist = $this->db->insert_id();
		
		$this->db->set('id_music', $id_music);
		$this->db->set('id_artist', $id_artist);
		
		$this->db->insert($this->tMusic_Artist);
	}
	
	/**
	 *	Remove an artist from the db
	 */
	public function remove_artist($id_artist)
	{
		return $this->db->where('id_artist', $id_artist)
						->delete($this->tArtist);
	}
	
	/**
	 *	Return datas from an artist
	 */
	public function getArtist($id_artist)
	{
		return $this->db->query("
								SELECT *
								FROM ".$this->tArtist." 
								WHERE id_artist = ".$id_artist."
								");
	}
	
	/**
	 *	Return datas from an artist
	 */
	public function getArtists($id_music)
	{
		return $this->db->query("
								SELECT *
								FROM ".$this->tArtist ." 
								INNER JOIN ". $this->tMusic_Artist ." ON ". $this->tArtist.".id_artist = ".$this->tMusic_Artist .".id_artist
								INNER JOIN ". $this->tMusic ." ON ". $this->tMusic .".id_music = ".$this->tMusic_Artist .".id_music
								WHERE ". $this->tMusic .".id_music = ". $id_music ."
								");
	}
	
	/**
	 *	Search an artist in the db
	 */
	public function artist_exist($name, $firstname)
	{
		$query = $this->db->query("
						SELECT *
						FROM ".$this->tArtist." 
						WHERE name = ".$name."
						AND firstname = ".$firstname."
						");
		
		if ($query->num_rows() > 0)
			return TRUE;
		else
			return FALSE;
	}
	
}