<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Artist_class extends CI_Model
{
	protected $tArtist = 'artist';
	
	/**
	 *	Add an artist to the db
	 */
	public function add_artist($name, $firstname)
	{
		//	Ces donn�es seront automatiquement �chapp�es
		$this->db->set('name', $name);
		$this->db->set('firstname', $firstname);
		
		//	Ces donn�es ne seront pas �chapp�es
		// $this->db->set('date', 'NOW()', false);
		
		//	Une fois que tous les champs ont bien �t� d�finis, on "insert" le tout
		$this->db->insert($this->tArtist);
		
		return $this->db->insert_id();
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
	
}