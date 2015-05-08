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
			redirect('game/randomMusic');
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
				
				$lyrics = explode(' ', $row->lyrics);
				foreach($lyrics as $word){
					$datas_music['lyrics'][] = $word;
				}
				
				$datas_music['album_name'] = $row->album_name;
				$datas_music['name'] = $row->name;
				$datas_music['firstname'] = $row->firstname;
			}
		}
			
		$this->layout->view('game/game_step', $datas_music);
	}
	
	public function randomMusic()
	{
		$query_music = $this->music_class->getMusics();
		if ($query_music->num_rows() > 0)
		{
			foreach($query_music->result() as $row)
			{
				$id_musics[] = $row->id_music;
			}
			
			$max = max($id_musics);
			$min = min($id_musics);
			$id_music_selected = rand($min, $max);

			$this->game_step($id_music_selected);
		
		}
	}
}