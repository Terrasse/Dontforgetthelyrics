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
		$id_artist = $this->artist_exist($name);
		if($id_artist != FALSE){
		}
		else
		{
			//	Ces donn�es seront automatiquement �chapp�es
			$this->db->set('name', $name);
			
			//	Ces donn�es ne seront pas �chapp�es
			// $this->db->set('date', 'NOW()', false);

			//	Une fois que tous les champs ont bien �t� d�finis, on "insert" le tout
			$this->db->insert($this->tArtist);

			$id_artist = $this->db->insert_id();
		}
		
		return $id_artist;
	}

	/**
	 *	Add an artist to the db
	 */
	public function add_artist_by_spotify($id_music, $name)
	{
		$id_artist = $this->add_artist($name);
		
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
		return $query = $this->db->query("
								SELECT id_artist, name
								FROM ".$this->tMusic ." NATURAL JOIN ".$this->tMusic_Artist." NATURAL JOIN ".$this->tArtist."
								WHERE id_music = ". $id_music ."
								");
	}
	
	public function getArtistsName($id_music){
		$query = $this->getArtists($id_music);
		$artists=array();
		if ($query -> num_rows() > 0) {
			$artists=array();
			foreach ( $query->result() as $value){
				$artists[]=$value->name; 
			}
		} else {
			$artists[]='Unknown';
		}
		return $artists;
	}
	
	
	/**
	 *	Search an artist in the db
	 */
	public function artist_exist($name)
	{
		$query = $this->db->query("
						SELECT *
						FROM ".$this->tArtist." 
						WHERE name = '".addslashes($name)."'
						");
		
		if ($query->num_rows() > 0){
			foreach($query->result() as $row)
			{
				$id_artist = $row->id_artist;
			}
			
			return $id_artist;
		}
		else
			return FALSE;
	}
	
}