<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Music_model extends CI_Model
{
	protected $tPlayer = 'player';
	
	/**
	 *	Add a player to the db
	 */
	public function addPlayer($username, $password)
	{
		//	Ces données seront automatiquement échappées
		$this->db->set('username', $username);
		$this->db->set('password', $password);
		
		//	Ces données ne seront pas échappées
		// $this->db->set('date', 'NOW()', false);
		
		//	Une fois que tous les champs ont bien été définis, on "insert" le tout
		$this->db->insert($this->tPlayer);
		
		return $this->db->insert_id();
	}
	
	/**
	 *	Édite une produit déjà existante
	 */
	 
	public function updatePlayer($id_player, $password = null, $username = null, $bestResult = null)
	{
		//	Il n'y a rien à éditer
		if($password == null AND $username == null AND $bestResult == null)
		{
			return false;
		}
		
		//	Ces données seront échappées
		if($password != null)
			$this->db->set('password', $password);
		if($username != null)	
			$this->db->set('username', $username);
		if($bestResult != null)
			$this->db->set('bestResult', $bestResult);
		
		//	La condition
		$this->db->where('id_player', (int) $id_player);
		
		return $this->db->update($this->tPlayer);
	}
	
	/**
	 *	Remove a player from the db
	 */
	public function removePlayer($id_music)
	{
		return $this->db->where('id_player', $id_player)
						->delete($this->tPlayer);
	}
	
	/**
	 *	Return datas from a player
	 */
	public function getPlayer($id_player)
	{
		return $this->db->query("
								SELECT *
								FROM ".$this->tPlayer." 
								WHERE id_player = ".$id_player."
								");
	}
}