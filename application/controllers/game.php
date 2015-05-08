<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Game extends MY_Controller {
	
	public function __construct()
	{
		parent::__construct();
		
		// Bibliothèque de chargment des vues de template
		$this->load->library('layout');
		$this->load->library('form_validation');
		
		// Modeles
		$this->load->model('music_class');
		$this->load->model('result_class');
		
		// $this->output->enable_profiler(TRUE);
	}
	
	public function index()
	{
		$this->layout->view('game/launch_game');
	}
	
	public function launch_game($mode = null)
	{
		if ($this->session->userdata('connected'))
		{
			if($mode == "randompick")
				redirect('game/randomMusic');
			else if($mode == "pick")
				redirect('game/chooseMusic');
			else
				$this->layout->view('game/game_choice');
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
				
				$i = 0;
				$lyrics = explode(' ', $row->lyrics);
				foreach($lyrics as $word){
					$hole = rand(0, 8);
					if(($hole == 8) && ($i<35)){
						$datas_music['lyrics'][] = '<input type="text" placeholder="Complete the field" name="word'.$i.'">';
						$datas_music['lyrics'][] = '<input type="text" placeholder="Complete the field" value="'.$word.'" name="solution'.$i.'">';
						$i++;
					}
					else
					{
						$datas_music['lyrics'][] = $word;
					}
				}
				
				$datas_music['nb_words'] = $i;
				$datas_music['nb_words_form_hidden'] = '<input type="hidden" placeholder="Complete the field" value="'.$i.'" name="nb_words_form_hidden">';
				
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
	
	public function chooseMusic()
	{
		
		$this->form_validation->set_rules('track_name', '"Name of the track"', 'trim|required|min_length[1]|max_length[52]|alpha_dash|encode_php_tags|xss_clean');
		$track_name = $this->input->post('track_name');
		
		if($this->form_validation->run())
		{
			//	Le formulaire est valide
			$query_music = $this->music_class->searchMusic($track_name,9,0);
		}
		else
		{
			//	Le formulaire est invalide ou vide
			$this->layout->view('game/game_music_pick');
		}
	}
	
	public function result()
	{
		$nb_words = $this->input->post('nb_words_form_hidden');
		$id_music = $this->input->post('id_music');

		for($i=0;$i<$nb_words;$i++)
		{
			$word[] = $this->input->post('word'.$i);
			$solution[] = $this->input->post('solution'.$i);
		}
		
		$numerateur = 0;
		for($i=0;$i<$nb_words;$i++)
		{
			if($word[$i] == $solution[$i])
				$numerateur++;
		}
		
		$score = $numerateur / $nb_words;
		$score = (int)($score*100);
		
		$this->result_class->addresult($this->session->userdata('id_player'), $id_music, $score);
		
		$query_music = $this->music_class->getMusic($id_music);
		if ($query_music->num_rows() > 0)
		{
			foreach($query_music->result() as $row)
			{
				$data_result['title'] = $row->title;
				$data_result['album_name'] = $row->album_name;
				$data_result['name'] = $row->name;
				$data_result['firstname'] = $row->firstname;
			}
		}
		
		$query_rank = $this->result_class->getRankResult($id_music, $score);
		if ($query_rank->num_rows() > 0)
		{
			$rank = 1;
			foreach($query_rank->result() as $row)
			{
				if($score == $row->result)
					break;
				
				$rank++;
			}
		}
		
		$data_result['rank'] = $rank;
		$data_result['score'] = $score;
		
		$this->layout->view('game/game_result', $data_result);
	}
	
}