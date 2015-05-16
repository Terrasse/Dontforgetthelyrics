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
		$this -> load -> model('player_class');
		$this -> load -> model('result_class');
		$this -> load -> model('misiXmatchAPI_class');
		$this -> load -> model('spotifyAPI_class');
		$this -> load -> model('lyrics_masking_class');
		// $this -> output -> enable_profiler(TRUE);
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
				$datas_music['id_spotify'] = $row -> id_spotify;
				$datas_music['title'] = $row -> title;

				$player_level = $this -> player_class -> getLevelPlayer($this -> session -> userdata('id_player'));
				$datas_music['lyrics'] = $this -> lyrics_masking_class -> lyricsMasking($row -> lyrics, $player_level);

				$datas_music['nb_words'] = $this -> lyrics_masking_class -> getNbWords();
				$datas_music['nb_words_form_hidden'] = $this -> lyrics_masking_class -> getFormNbHidden();

				$datas_music['album_name'] = $row -> album_name;
				$datas_music['artists'] = $this -> artist_class -> getArtistsName($row -> id_music);
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

				// for each music
				foreach ($query_musics->result() as $row) {

					$datas_info_musics['id_music'] = $row -> id_music;
					$datas_info_musics['title'] = $row -> title;

					// search it album name
					$datas_info_musics['album'] = $this -> album_class -> getAlbumName($row -> id_album);

					// search it artists
					$datas_info_musics['artists'] = $this -> artist_class -> getArtistsName($row -> id_music);

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

						// create an empty array
						$datas_info_musics['artists'] = array();
						
						// add links betweek the music and it authors (if they are known)
						if (count($row['artists']) == 0) {
							$this -> artist_class -> add_artist_by_spotify($id_music, "unknown" );
							$datas_info_musics['artists'][] = "unknown";
							} else {
							foreach ($row[
						'artists'] as $artist) {
								$datas_info_musics['artists'][] = $artist;

								// Insert SQl
								$this -> artist_class -> add_artist_by_spotify($id_music, $artist);
							}
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

		for ($i = 1; $i <= $nb_words; $i++) {
			$word[] = $this -> input -> post('word' . $i);
			$solution[] = $this -> input -> post('solution' . $i);
		}

		$numerateur = 0;
		for ($i = 0; $i < $nb_words; $i++) {

			if (strtolower($word[$i]) == strtolower($solution[$i])) {
				$numerateur++;
			}
		}
	
		$data_result['word'] = $word;
		$data_result['solution'] = $solution;
		$data_result['nb_words'] = $nb_words;

		$score = $numerateur / $nb_words;
		$score = (int)($score * 100);

		$this -> result_class -> addresult($this -> session -> userdata('id_player'), $id_music, $score);

		$query_music = $this -> music_class -> getMusic($id_music);
		if ($query_music -> num_rows() > 0) {
			foreach ($query_music->result() as $row) {
				$data_result['title'] = $row -> title;
				$data_result['album_name'] = $row -> album_name;
				$data_result['artists'] = $this -> artist_class -> getArtistsName($row -> id_music);
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
