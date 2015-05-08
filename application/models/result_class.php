<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Result_class extends CI_Model
{
	protected $tResult = 'result';
	
	/**
	 *	Add a result to the db
	 */
	public function addResult($id_player, $id_music, $result)
	{
		//	Ces données seront automatiquement échappées
		$this->db->set('id_player', $id_player);
		$this->db->set('id_music', $id_music);
		$this->db->set('result', $result);
		
		//	Ces données ne seront pas échappées
		// $this->db->set('date', 'NOW()', false);
		
		//	Une fois que tous les champs ont bien été définis, on "insert" le tout
		$this->db->insert($this->tResult);
		
		return $this->db->insert_id();
	}
	
	/**
	 *	Update a result for a player and a music
	 */
	 
	public function updateResult($id_player, $id_music, $result)
	{
		$this->db->set('result', $result);
		
		//	La condition
		$this->db->where('id_player', (int) $id_player);
		$this->db->where('id_music', (int) $id_music);
		
		return $this->db->update($this->tResult);
	}
	
	/**
	 *	Remove a result from the db
	 */
	public function removePlayer($id_player, $id_music)
	{
		return $this->db->where('id_player', $id_player)
						->where('id_music', (int) $id_music)
						->delete($this->tResult);
	}
	
	/**
	 *	Return datas from a result
	 */
	public function getResult($id_player, $id_music)
	{
		return $this->db->query("
								SELECT *
								FROM ".$this->tResult." 
								WHERE id_player = ".$id_player."
								AND id_music = ".$id_music."
								");
	}
	
	/**
	 *	Return datas of the best result
	 */
	public function getBestResult($id_player)
	{
		return $this->db->query("
								SELECT *
								FROM ".$this->tResult." r, music m
								WHERE id_player = ".$id_player."
								AND r.id_music = m.id_music
								ORDER BY result DESC
								LIMIT 5
								");
	}
}