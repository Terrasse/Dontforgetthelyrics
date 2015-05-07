<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Connection_class extends CI_Model
{
	protected $tPlayer = 'player';
	
	public function connection($username, $pw)
	{
		$password = hash ('sha256', $pw, false);

		return $this->db->select('*')
						->from($this->tPlayer)
						->where(array('username' => $username, 'password' => $password))
						->get()
						->result();
	}	
	public function register($username, $password)
	{
		$password = hash ('sha256', $password, false);
		
		//	Ces données seront automatiquement échappées
		$this->db->set('username',   $username);
		$this->db->set('password', $password);
		
		//	Ces données ne seront pas échappées
		// $this->db->set('date', 'NOW()', false);
		
		//	Une fois que tous les champs ont bien été définis, on "insert" le tout
		$this->db->insert($this->tPlayer);
		
		return $this->db->insert_id();
	}
}

?>