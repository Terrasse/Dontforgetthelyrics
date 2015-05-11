<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Player extends MY_Controller {
	
	//Constructor
	public function __construct()
	{
		parent::__construct();
	
		// Bibliothèque de chargment des vues de template
		$this->load->library('layout');
		$this -> load -> library('form_validation');
		
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
	
	public function profile()
	{	
		
		$id_player = $this->session->userdata('id_player');
		
		// Modeles
		$level_name = array ("Low", "Mid", "High");
		
		$query_player = $this->player_class->getPlayer($id_player);
		if ($query_player->num_rows() > 0)
		{
			foreach($query_player->result() as $row)
			{
				$datas_player['username'] = $row->username;
				if($row->level == 1){
					$opt1 = 2;
					$opt2 = 3;
				}
				else if($row->level == 2){
					$opt1 = 3;
					$opt2 = 1;
				}
				else
				{
					$opt1 = 2;
					$opt2 = 1;
				}
				
				$datas_player['level'] = '
					<option value="'.$row->level .'">'.$level_name[$row->level - 1] .'</option>
					<option value="'.$opt1.'">'.$level_name[$opt1 - 1].'</option>
					<option value="'.$opt2.'">'.$level_name[$opt2 - 1].'</option>
					';
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
	
	public function set_level()
	{
		$this->form_validation->set_rules('level', '"Level "', 'required|min_length[1]|max_length[1]');
		
		$level = $this->input->post('level');
		$id_player = $this->session->userdata('id_player');
		
		if($this->form_validation->run())
		{
			//	Le formulaire est valide
			if($this->player_class->updatePlayer($id_player, null, null, null, $level)){}
			else
			{
				redirect('profile/'.$id_player);
			}
		}
		redirect('profile/'.$id_player);
	}
}