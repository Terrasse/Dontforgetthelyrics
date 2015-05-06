<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Game extends MY_Controller {
	
	public function __construct()
	{
		parent::__construct();
		
		// Bibliothèque de chargment des vues de template
		$this->load->library('layout');
		$this->output->enable_profiler(TRUE);
		
		// Modeles
		$this->load->model('music_class');
	}
	
	public function index()
	{
		$this->layout->view('game/launch_game');
	}
	
	public function launch_game()
	{
		if ($this->session->userdata('connected'))
		{
			redirect('game/game_step/1');
		}
		else
		{
			redirect('connection');
		}
	}
	
	public function game_step($id_music)
	{
		$query_music = $this->music_class->getMusic($id_music);
		if ($query_music->num_rows() > 0)
		{
			foreach($query_music->result() as $row)
			{
				$datas_music['id_music'] = $row->id_music;
				$datas_music['title'] = $row->title;
				$datas_music['lyrics'] = $row->lyrics;
			}
		}
			
		$this->layout->view('game/game_step', $datas_music);
	}
}