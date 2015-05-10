<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Album_class extends CI_Model
{
	protected $tAlbum = 'album';
	
	/**
	 *	Add an album to the db
	 */
	public function add_album($name)
	{
		$id_album = $this->album_exist($name);
		if($id_album != FALSE){
		}
		else
		{
			//	Ces données seront automatiquement échappées
			$this->db->set('album_name', $name);
			
			//	Ces données ne seront pas échappées
			// $this->db->set('date', 'NOW()', false);
			
			//	Une fois que tous les champs ont bien été définis, on "insert" le tout
			$this->db->insert($this->tAlbum);
			
			$id_album = $this->db->insert_id();
		}
		
		return $id_album;
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
	public function album_exist($name)
	{
		$query = $this->db->query("
						SELECT *
						FROM ".$this->tAlbum." 
						WHERE album_name = '".$name."'
						");
		
		if ($query->num_rows() > 0) {
			foreach($query->result() as $row)
			{
				$id_album = $row->id_album;
			}
			
			return $id_album;
		}
		else
			return FALSE;
	}
	
}