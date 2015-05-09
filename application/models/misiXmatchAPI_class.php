<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class MisiXmatchAPI_class extends CI_Model {
	const API_URL = 'http://api.musixmatch.com/ws/1.1';
	const API_KEY = 'bc79e618625f18c0ae9ce6b71aeaa0f0';
	const TRACKS_PER_PAGE = 10;
	/**
	 * search Lyrics on misiXmatchAPI
	 * based on the most track rating
	 * @param title
	 * @param page
	 * @return if ok : array(spotify_id,lyrics)
	 *         if no tracks => empty array()
	 *
	 */
	public function searchLyrics($title, $page) {
		$output = self::_callAPI('/track.search', array('apikey' => self::API_KEY, 'q_track' => $title, 'f_has_lyrics' => 1, 's_track_rating' => 'desc', 'page' => $page, 'page_size' => self::TRACKS_PER_PAGE));
		// var_dump($output);

		// '4RY96Asd9IefaL3X4LOLZ8','In Da Club','50 Cent','Get Rich Or Die Tryin'
		// track_id = 17211366
		//
		// '4RY96Asd9IefaL3X4LOLZ8','USUM71211793', 'Diamonds', 'Rihanna', 'Unapologetic (Deluxe Explicit Version)'
		// spotify:track:1mwt9hzaH7idmC5UCoOUkz
		$lyrics=array();
		if (self::_verify($output)) {
			if (($output['message']['header']['available'] / self::TRACKS_PER_PAGE) >= $page) {
				foreach ($output['message']['body']['track_list'] as $track_key => $track_value) {
					if (isset($track_value['track']['track_spotify_id'])) {
						if (strlen($track_value['track']['track_spotify_id']) == 22) {
							$track_lyrics = $this -> extractLyrics($track_value['track']['track_share_url']);
							if ($track_lyrics != null && strlen($track_lyrics) > 600) $lyrics[$track_value['track']['track_spotify_id']]['lyrics']=$track_lyrics;
						}
					}
				}
			}
		}
		return $lyrics;
	}

	/**
	 * Extract the lyrics from the mixiXmachAPI
	 *
	 * @param $subtitles_url subtitles url from mixiXmachAPI
	 * @return lyrics lyrics of this title
	 */
	public function extractLyrics($subtitles_url) {
		$output = shell_exec('assets\scripts\misiXmatch_lyrics.sh "'.$subtitles_url.'"');
		$output = substr($output, 158);
		return $output;
	}

	/**
	 * Verify the ansewr of a misiXmachAPI request
	 *
	 * @param ouput_decoded output from request APi misiXmachAPI
	 * @return true if the output contains a responce
	 */
	private static function _verify($output_decoded) {
		if ($output_decoded['message']['header']['status_code'] == 200) {
			return TRUE;
		}
		return FALSE;
	}

	private static function _callAPI($function, $params) {
		$uri = self::_makeURI($function, $params);
		$output = shell_exec('assets\scripts\misiXmatchAPI_get.sh "' . $uri . '"');
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
	 * make a misiXmatchAPI URI
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
