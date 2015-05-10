<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Player_class extends CI_Model {
	protected $tPlayer = 'player';

	/**
	 *	Add a player to the db
	 */
	public function addPlayer($username, $password) {
		//	Ces donn�es seront automatiquement �chapp�es
		$this -> db -> set('username', $username);
		$this -> db -> set('password', $password);

		//	Ces donn�es ne seront pas �chapp�es
		// $this->db->set('date', 'NOW()', false);

		//	Une fois que tous les champs ont bien �t� d�finis, on "insert" le tout
		$this -> db -> insert($this -> tPlayer);

		return $this -> db -> insert_id();
	}

	/**
	 *	�dite une produit d�j� existante
	 */

	public function updatePlayer($id_player, $password = null, $username = null, $bestResult = null) {
		//	Il n'y a rien � �diter
		if ($password == null AND $username == null AND $bestResult == null) {
			return false;
		}

		//	Ces donn�es seront �chapp�es
		if ($password != null)
			$this -> db -> set('password', $password);
		if ($username != null)
			$this -> db -> set('username', $username);
		if ($bestResult != null)
			$this -> db -> set('bestResult', $bestResult);

		//	La condition
		$this -> db -> where('id_player', (int)$id_player);

		return $this -> db -> update($this -> tPlayer);
	}

	/**
	 *	Remove a player from the db
	 */
	public function removePlayer($id_music) {
		return $this -> db -> where('id_player', $id_player) -> delete($this -> tPlayer);
	}

	public function getLevelPlayer($id_player) {
		$query = $this -> getPlayer($id_player);
		$player_level = array();
		if ($query -> num_rows() > 0) {
			foreach ($query->result() as $value) {
				return $value -> level;
			}
		} 
		return 0;
	}

	/**
	 *	Return datas from a player
	 */
	public function getPlayer($id_player) {
		return $this -> db -> query("
								SELECT *
								FROM " . $this -> tPlayer . " 
								WHERE id_player = " . $id_player . "
								");
	}

}
