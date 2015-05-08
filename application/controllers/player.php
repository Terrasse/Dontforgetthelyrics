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
		$this->load->model('result_class');
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
		
		$query_player = $this->player_class->getPlayer($id_player);
		if ($query_player->num_rows() > 0)
		{
			foreach($query_player->result() as $row)
			{
				$datas_player['username'] = $row->username;
			}
		}
		
		$i = 1;
		
		$query_result = $this->result_class->getBestResult($id_player);
		if ($query_result->num_rows() > 0)
		{
			$datas_player['empty_result'] = false;
			foreach($query_result->result() as $row)
			{
				$datas_player['result'][$i]['music'] = $row->title;
				$datas_player['result'][$i]['result'] = $row->result;
				$datas_player['result'][$i]['name'] = $row->name;
				$i++;
				
				if ($i > 5)
					break;
			}
			
			for ($j = $i ; $j <= 5 ; $j++)
			{
				$datas_player['result'][$j]['music'] = "/";
				$datas_player['result'][$j]['result'] = "/";
				$datas_player['result'][$j]['name'] = "/";
			}
		}
		else
		{
			$datas_player['empty_result'] = true;
		}
			
		$this->layout->view('profile/player_profile', $datas_player);
	}
}