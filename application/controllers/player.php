<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Player extends MY_Controller {
	
	//Constructor
	public function __construct()
	{
		parent::__construct();
	
		// Bibliothèque de chargment des vues de template
		$this->load->library('layout');
		
		// Modeles
		$this->load->model('player_class');
	}
	
	public function index()
	{	
		
		// Modeles
		// $this->load->model('nouvelles/modnouvelles');

		// $this->layout->view('profile/player_profile');
	}
	
	public function profile($id_player)
	{	
		
		// Modeles
		// $this->load->model('nouvelles/modnouvelles');
		
		$query_player = $this->player_class->getPlayer($id_player);
		if ($query_player->num_rows() > 0)
		{
			foreach($query_player->result() as $row)
			{
				$datas_player['username'] = $row->username;
				$datas_player['password'] = $row->password;
				$datas_player['best_result'] = $row->best_result;
			}
		}
			
		$this->layout->view('profile/player_profile', $datas_player);
	}
}