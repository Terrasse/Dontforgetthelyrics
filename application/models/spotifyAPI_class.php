<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class SpotifyAPI_class extends CI_Model {
	// const
	const API_URL = 'https://api.spotify.com/v1';
	const API_URL_AUTH = 'https://accounts.spotify.com/api/token';
	const API_ID = '102dff6f5f0f420990f0f5ff65d2ede0';
	const API_SECRET = 'dd731a87c2bc4bfb8024b762e75a8c93';
	
	// db table
	protected $tSpotify = 'spotify';

	/**
	 * search musics on Spotify API
	 */
	public function searchMusics($name_musique, $offset) {
		$output = $this->callAPI('/search', array('q' => $name_musique, 'type' => "track", 'market' => "US", 'limit' => 50, 'offset' => $offset));
		if ($output['tracks']['total'] != 0) {
			foreach ($output['tracks']['items'] as $key => $tracks_values) {
				if ($tracks_values['explicit'] == TRUE) {
					$musics[$tracks_values['uri']]['name'] = $tracks_values['name'];
					$musics[$tracks_values['uri']]['album'] = $tracks_values['album']['name'];
					foreach ($tracks_values['artists'] as $key_artist => $artiste_values) {
						$musics[$tracks_values['uri']]['artists'][$key_artist] = $artiste_values['name'];
					}
				}

			}
			return $musics;
		} else
			return array();
	}

	/**
	 * search musics details on Spotify API
	 */
	public function searchDetails($spotify_id) {
		$output = $this->callAPI('/tracks/' . $spotify_id, array('market' => 'US'));
		$music_details['name'] = $output['name'];
		$music_details['album'] = $output['album']['name'];
		foreach ($output['artists'] as $key_artist => $artiste_values) {
			$music_details['artists'][$key_artist] = $artiste_values['name'];
		}
		return $music_details;
	}

	/**
	 * call the Spotify API with the access token
	 *
	 * @param string $function              API resource path
	 * @param array $params                 Request parameters
	 * @return mixed
	 */
	private function callAPI($function, $params) {
		$uri = self::_makeURI($function, $params);
		$output = shell_exec('assets\scripts\SpotifyAPI_get.sh "' . $uri . '" "'.$this->getToken().'"');
		if ($output != NULL) {
			// delete git header
			$output = substr($output, 158);

			// decode the string
			$decoded = json_decode($output, true);
			return $decoded;
		} else {
			return 0;
		}
	}

	/**
	 * make a Spotify URI
	 * @param string $function              API resource path
	 * @param array $params                 Request parameters
	 * @return mixed
	 */
	private static function _makeURI($function, $params) {
		$params = '?' . utf8_encode(http_build_query($params));
		$apiCall = self::API_URL . $function . $params;
		return $apiCall;
	}


	/**
	 * get a new token to discuss more faster to the spotifyAPI
	 */
	public function getToken(){
		$query = $this -> db -> query("
								SELECT *
								FROM " . $this -> tSpotify . " 
								WHERE id_spotify = (
									SELECT MAX(id_spotify)
									FROM " . $this -> tSpotify . "
									)
								");
		if ($query -> num_rows() > 0) {
			$result = $query->result();
			// if the token do not expires in the next two minutes
			if ( $result['0']->expires_at >= time()+120) {
				// return the current token
				return$result['0']->access_token;
			}
		} 
		// if the table is empty or if the token will expire in the next two mintes
		// then create a new token
		$this->createToken();
		// recursive call
		return $this->getToken();
	}

	/** 
	 * create a new token to disccuss more faster to the spotify api 
	 */
	private function createToken() {
		// encode base 64 our application credential on spotifyAPI => <client_id:client_secret> 
		$encoded = base64_encode(self::API_ID . ':' . self::API_SECRET);
		
		// sent the request to the spotify API with a shell script
		$output = shell_exec('assets\scripts\SpotifyAPI_auth.sh "' . self::API_URL_AUTH . '" "' . $encoded . '"');
		
		// delete git header
		$output = substr($output, 158);
		$token = json_decode($output, true);

		// compute the token expires time
		$token_expires_time = time() + $token['expires_in'];
		
		// save it in DB
		$this -> db -> set('access_token', $token['access_token']);
		$this -> db -> set('expires_at', $token_expires_time);
		$this -> db -> insert($this -> tSpotify);
		return $this -> db -> insert_id();
	}

}
