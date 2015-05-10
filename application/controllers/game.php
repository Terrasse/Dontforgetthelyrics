<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Game extends MY_Controller {

	public function __construct() {
		parent::__construct();

		// Bibliothèque de chargment des vues de template
		$this -> load -> library('layout');
		$this -> load -> library('form_validation');

		// Modeles
		$this -> load -> model('music_class');
		$this -> load -> model('album_class');
		$this -> load -> model('artist_class');
		$this -> load -> model('result_class');
		$this -> load -> model('misiXmatchAPI_class');
		$this -> load -> model('spotifyAPI_class');

		//$this -> output -> enable_profiler(TRUE);
	}

	public function index() {
		$this -> layout -> view('game/launch_game');
	}

	public function launch_game($mode = null) {
		if ($this -> session -> userdata('connected')) {
			if ($mode == "randompick")
				redirect('game/randomMusic');
			else if ($mode == "pick")
				redirect('game/chooseMusic');
			else
				$this -> layout -> view('game/game_choice');
		} else {
			redirect('connection');
		}
	}

	public function game_step($id_music) {
		$query_music = $this -> music_class -> getMusic($id_music);
		if ($query_music -> num_rows() > 0) {
			foreach ($query_music->result() as $row) {
				$datas_music['id_music'] = $row -> id_music;
				$datas_music['id_spotify'] = $row ->id_spotify;
				$datas_music['title'] = $row -> title;

				$i = 0;
				$sentences = explode('<br>', $row -> lyrics);
				if (count($sentences) > 1)
				{
					foreach($sentences as $sentence) {
					
						$lyrics = explode(' ', $sentence);
						
						//Boolean
						$boolNoLyrics = FALSE;
						
						if (count($lyrics) > 1)
						{
							foreach ($lyrics as $word) {
								$hole = rand(0, 8);
								
								//Length
								$length = strlen($word);
								
								//Temporary
								$tmpFirst = "";
								$tmpLast = "";
								
								//First & Last character
								$firstChar = $word[0];
								$lastChar = substr($word, -1, 1);
								
								//To avoid [word] OR (word)
								if ($firstChar == '[' || $firstChar == '(')
									$boolNoLyrics = TRUE;
								
								if(($hole == 8) && ($i<35) && ($boolNoLyrics == FALSE)){
									
									//First character => , OR '
									if ($firstChar == "'")
									{
										$word = substr($word, 1);
										$tmpFirst = "'";
									}
									elseif ($firstChar == ",")
									{
										$word = substr($word, 1);
										$tmpFirst = ",";
									}
									
									//Last character => , OR '
									if ($lastChar == "'")
									{
										$word = substr($word, 0, $length - 1);
										$tmpLast = "'";
									}
									elseif ($lastChar == ",")
									{
										$word = substr($word, 0, $length - 1);
										$tmpLast = ",";
									}
									
									$datas_music['lyrics'][] = $tmpFirst.'<input type="text" placeholder="Complete the field" name="word' . $i . '">'.$tmpLast;
									$datas_music['lyrics'][] = '<input type="text" placeholder="Complete the field" value="' . $word . '" name="solution' . $i . '">';
									
									$i++;
									
								} else {
									$datas_music['lyrics'][] = $word;
								}
								
								//End of [Lyrics] OR (Lyrics)
								if ($lastChar == ']' || $lastChar == ')')
									$boolNoLyrics = FALSE;
							}
							
							// Ajout BR dans Lyrics, à la fin d'une phrase
							$datas_music['lyrics'][] = '<br />';
						}
					}
				}

				$datas_music['nb_words'] = $i;
				$datas_music['nb_words_form_hidden'] = '<input type="hidden" placeholder="Complete the field" value="' . $i . '" name="nb_words_form_hidden">';

				$datas_music['album_name'] = $row -> album_name;
				$datas_music['name'] = $row -> name;
				$datas_music['firstname'] = $row -> firstname;
			}
		}

		$this -> layout -> view('game/game_step', $datas_music);
	}

	public function randomMusic() {
		$query_music = $this -> music_class -> getMusics();
		if ($query_music -> num_rows() > 0) {
			foreach ($query_music->result() as $row) {
				$id_musics[] = $row -> id_music;
			}

			$max = max($id_musics);
			$min = min($id_musics);
			$id_music_selected = rand($min, $max);

			$this -> game_step($id_music_selected);

		}
	}

	public function chooseMusic() {

		$this -> form_validation -> set_rules('track_name', '"Name of the track"', 'trim|required|min_length[1]|max_length[52]|encode_php_tags');
		$track_name = $this -> input -> post('track_name');

		//	Le formulaire est valide
		if ($this -> form_validation -> run()) {
			$this -> layout -> views('game/game_music_choose_top');

			// Normal
			$query_musics = $this -> music_class -> searchMusics($track_name);
			if ($query_musics -> num_rows() > 0) {
				foreach ($query_musics->result() as $row) {
					$datas_info_musics['id_music'] = $row -> id_music;
					$datas_info_musics['title'] = $row -> title;
					$datas_info_musics['album'] = $row -> album_name;

					$query_artists = $this -> artist_class -> getArtists($row -> id_music);
					if ($query_artists -> num_rows() > 0) {
						foreach ($query_artists->result() as $artist) {
							$datas_info_musics['artists'][] = $artist -> name;
						}
					} else {
						$datas_info_musics['artists'][] = 'Unknown';
					}

					$this -> layout -> views('game/game_music_choose', $datas_info_musics);
				}
			} else {
				// Spotify
				$table_musics = $this -> misiXmatchAPI_class -> searchLyrics($track_name, 0);

				if (count($table_musics) == 0) {
					$fail['reason'] = "We don't have this track";
				} else {
					
					foreach ($table_musics as $key => $value) {
						$music_details = $this -> spotifyAPI_class -> searchDetails($key);
						$table_musics[$key]['name'] = $music_details['name'];
						$table_musics[$key]['album'] = $music_details['album'];
						$table_musics[$key]['artists'] = $music_details['artists'];
					}

					foreach ($table_musics as $key => $row) {
						
						$datas_info_musics['id_spotify'] = trim($key);
						$datas_info_musics['title'] = trim($row['name']);
						$datas_info_musics['album'] = trim($row['album']);
						$datas_info_musics['lyrics'] = trim($row['lyrics']);
						$id_album = $this -> album_class -> add_album(trim($row['album']));

						// public function add_music($id_spotify, $path, $title, $lyrics, $id_album) {
						$id_music = $this -> music_class -> add_music($datas_info_musics['id_spotify'], '', $datas_info_musics['title'], $datas_info_musics['lyrics'], $id_album);

						$datas_info_musics['id_music'] = $id_music;

						foreach ($row['artists'] as $artist) {
							$datas_info_musics['artists'][] = $artist;

							// Insert SQl
							$this -> artist_class -> add_artist_by_spotify($id_music, $artist);
						}

						$this -> layout -> views('game/game_music_choose', $datas_info_musics);
					}
				}

			}
			if (isset($fail['reason'])) {
				$this -> layout -> view('game/game_music_pick.php', $fail);
			} else {
				$this -> layout -> view('game/game_music_choose_bot');
			}

		} else {
			//	Le formulaire est invalide ou vide
			$this -> layout -> view('game/game_music_pick');
		}
	}

	public function result() {
		$nb_words = $this -> input -> post('nb_words_form_hidden');
		$id_music = $this -> input -> post('id_music');

		for ($i = 0; $i < $nb_words; $i++) {
			$word[] = $this -> input -> post('word' . $i);
			$solution[] = $this -> input -> post('solution' . $i);
		}

		$numerateur = 0;
		for ($i = 0; $i < $nb_words; $i++) {
			
			if ($word[$i] == $solution[$i]){
				$numerateur++;
				$data_result['right_answer'][] = $solution[$i];
			}
			else
			{
				$data_result['false_answer'][] = $word[$i];
			}
		}

		$score = $numerateur / $nb_words;
		$score = (int)($score * 100);

		$this -> result_class -> addresult($this -> session -> userdata('id_player'), $id_music, $score);

		$query_music = $this -> music_class -> getMusic($id_music);
		if ($query_music -> num_rows() > 0) {
			foreach ($query_music->result() as $row) {
				$data_result['title'] = $row -> title;
				$data_result['album_name'] = $row -> album_name;
				$data_result['name'] = $row -> name;
				$data_result['firstname'] = $row -> firstname;
			}
		}

		$query_rank = $this -> result_class -> getRankResult($id_music, $score);
		if ($query_rank -> num_rows() > 0) {
			$rank = 1;
			foreach ($query_rank->result() as $row) {
				if ($score == $row -> result)
					break;

				$rank++;
			}
		}

		$data_result['rank'] = $rank;
		$data_result['score'] = $score;

		$this -> layout -> view('game/game_result', $data_result);
	}

}
