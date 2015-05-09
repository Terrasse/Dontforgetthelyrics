<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Album_class extends CI_Model
{
	protected $tAlbum = 'album';
	
	/**
	 *	Add an album to the db
	 */
	public function add_album($album_name)
	{
		//	Ces données seront automatiquement échappées
		$this->db->set('album_name', $album_name);
		
		//	Ces données ne seront pas échappées
		// $this->db->set('date', 'NOW()', false);
		
		//	Une fois que tous les champs ont bien été définis, on "insert" le tout
		$this->db->insert($this->tAlbum);
		
		return $this->db->insert_id();
	}
	
	/**
	 *	Remove an album from the db
	 */
	public function remove_album($id_album)
	{
		return $this->db->where('id_album', $id_album)
						->delete($this->tAlbum);
	}
	
	/**
	 *	Return datas from an album
	 */
	public function getAlbum($id_album)
	{
		return $this->db->query("
								SELECT *
								FROM ".$this->tAlbum." 
								WHERE id_album = ".$id_album."
								");
	}
	
	/**
	 *	Search an album in the db
	 */
	public function album_exist($album_name, $release_date)
	{
		$query = $this->db->query("
						SELECT *
						FROM ".$this->tAlbum." 
						WHERE album_name = '".$album_name."'
						");
		
		if ($query->num_rows() > 0)
			return TRUE;
		else
			return FALSE;
	}
	
}