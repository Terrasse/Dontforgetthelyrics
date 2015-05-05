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
}

?>