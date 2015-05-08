<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class SpotifyAPI_class extends CI_Model {
	const API_URL = 'https://api.spotify.com/v1';
	
	/** 
	 * search musics on Spotify API
	 */
	public function searchMusics($name_musique, $offset) {
		$output = self::_callAPI('/search', array('q' => $name_musique, 'type' => "track", 'market' => "US", 'limit' => 50, 'offset' => $offset));
		if ($output != 0) {
			foreach ($output['tracks']['items'] as $key => $tracks_values) {
				$current_tracks = $output['tracks']['items'][$key];
				if ($current_tracks['explicit'] == TRUE) {
					$musics[$current_tracks['name']]["spotify_id"] = $current_tracks['uri'];
					$musics[$current_tracks['name']]["album"] = $current_tracks['album']['name'];
					foreach($current_tracks['artists'] as $key_artist => $artiste_values){
						$musics[$current_tracks['name']]['artists'][$key_artist]= $artiste_values['name'];
					}
				}
				
			}
			return $musics;
		} else
			return array();

	}

	/**
	 * call the Spotify API
	 *
	 * @param string $function              API resource path
	 * @param array $params                 Request parameters
	 * @return mixed
	 */
	private static function _callAPI($function, $params) {
		$uri = self::_makeURI($function, $params);
		$output = shell_exec('assets\scripts\curl.sh "' . $uri . '"');
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

}
