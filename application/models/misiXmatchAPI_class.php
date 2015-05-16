<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class MisiXmatchAPI_class extends CI_Model {
	const API_URL = 'http://api.musixmatch.com/ws/1.1';
	const API_KEY = 'bc79e618625f18c0ae9ce6b71aeaa0f0';
	const TRACKS_PER_PAGE = 5;

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

		// init
		$lyrics = array();
		$spotify_id = "";
		$lyrics_url = "";
		$lyrics_id = "";
		if (self::_verify($output)) {
			if (($output['message']['header']['available'] / self::TRACKS_PER_PAGE) >= $page) {
				foreach ($output['message']['body']['track_list'] as $track_key => $track_value) {
					if (isset($track_value['track']['track_spotify_id'])) {
						if (strlen($track_value['track']['track_spotify_id']) == 22) {
							if (isset($track_value['track']['lyrics_id'])) {
								// avoid first space
								if ($spotify_id != "") {
									$spotify_id = $spotify_id . " ";
									$lyrics_url = $lyrics_url . " ";
									$lyrics_id = $lyrics_id . " ";
								}
								// prepare request to download lyrics
								$spotify_id = $spotify_id . $track_value['track']['track_spotify_id'];
								$lyrics_url = $lyrics_url . $track_value['track']['track_share_url'];
								$lyrics_id = $lyrics_id . $track_value['track']['lyrics_id'];
							}
						}
					}
				}
			}
		}
		return $this -> extractLyrics_v2($lyrics_url, $lyrics_id, $spotify_id);
	}

	/**
	 * Extract the lyrics from the mixiXmachAPI
	 *
	 * @param $subtitles_url subtitles url from mixiXmachAPI
	 * @return lyrics lyrics of this title
	 */
	public function extractLyrics($subtitles_url) {
		$output = shell_exec('assets\scripts\misiXmatch_lyrics.sh "' . $subtitles_url . '"');
		$output = substr($output, 158);
		return $output;
	}

	/**
	 * Extract the lyrics from the mixiXmachAPI
	 * priority : crowd lyrics
	 * @param $lyrics_url subtitles url from mixiXmachAPI => "url1 url2 .. urln"
	 * @param $lyrics_id from misiXmachAPI => "id1 id2 .. idn"
	 * @param $spotify_id from misiXmachAPI => "id1 id2 .. idn"
	 * @return mixed
	 */
	public function extractLyrics_v2($lyrics_url, $lyrics_id, $spotify_id) {
		$output = shell_exec('assets\scripts\misiXmatch_lyrics_v2.sh ' . $lyrics_url);
		// delete git header + first ' EOR '
		$output = substr($output, 163);
		$output = explode(' EOR ', $output);
		$right_lyrics_id = explode(' ', $lyrics_id);
		$spotify_id = explode(' ', $spotify_id);
		$lyrics = array();

		foreach ($output as $key => $record) {
			$record = json_decode($record, true);
			$lyrics[$spotify_id[$key]] = array();
			$lyrics[$spotify_id[$key]]['lyrics'] = "";
			if (isset($record['track'])) {
				if (isset($record['track']['crowdLyrics'])) {
					if ($record['track']['crowdLyrics']['attributes']['lyrics_id'] == $right_lyrics_id[$key])
						$lyrics[$spotify_id[$key]]['lyrics'] = $record['track']['crowdLyrics']['attributes']['lyrics_body'];
				}
				if (strlen($lyrics[$spotify_id[$key]]['lyrics']) == 0  && isset($record['track']['lyrics'])) {
					if ($record['track']['lyrics']['attributes']['lyrics_id'] == $right_lyrics_id[$key])
						$lyrics[$spotify_id[$key]]['lyrics'] = $record['track']['lyrics']['attributes']['lyrics_body'];
				}
			}
			if (strlen($lyrics[$spotify_id[$key]]['lyrics']) == 0 && isset($record['lyrics'])) {
				if ($record['lyrics']['attributes']['lyrics_id'] == $right_lyrics_id[$key])
					$lyrics[$spotify_id[$key]]['lyrics'] = $record['lyrics']['attributes']['lyrics_body'];
			}
			//  if we don't have enough subtitles then delete else replace \n by <br>
			if (strlen($lyrics[$spotify_id[$key]]['lyrics']) < 200)
				unset($lyrics[$spotify_id[$key]]);
			else
				$lyrics[$spotify_id[$key]]['lyrics'] = str_replace("\n", "<br>", $lyrics[$spotify_id[$key]]['lyrics']);

		}
		return $lyrics;
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
