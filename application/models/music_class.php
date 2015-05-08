<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Music_class extends CI_Model {
	const API_URL = 'https://api.spotify.com/v1';
	const API_URL_AUTHORIZE = 'https://accounts.spotify.com/authorize';
	protected $SPOTIFY_REDIRECT_URI_MUSIC = "http://127.0.0.1:80/music/";
	protected $tMusic = 'music';
	protected $tArtist = 'artist';
	protected $tAlbum = 'album';

	/**
	 *	Add a music to the db
	 */
	public function add_music($path, $title, $lyrics, $id_artist, $id_album) {
		//	Ces donn�es seront automatiquement �chapp�es
		$this -> db -> set('title', $title);
		$this -> db -> set('path', $path);
		$this -> db -> set('lyrics', $lyrics);
		$this -> db -> set('id_artist', $id_artist);
		$this -> db -> set('id_album', $id_album);

		//	Ces donn�es ne seront pas �chapp�es
		// $this->db->set('date', 'NOW()', false);

		//	Une fois que tous les champs ont bien �t� d�finis, on "insert" le tout
		$this -> db -> insert($this -> tMusic);

		return $this -> db -> insert_id();
	}

	/**
	 *	Remove a music from the db
	 */
	public function remove_music($id_music) {
		return $this -> db -> where('id_music', $id_music) -> delete($this -> tMusic);
	}

	/**
	 *	Return datas from a music
	 */
	public function getMusic($id_music) {
		return $this -> db -> query("
								SELECT *
								FROM " . $this -> tMusic . " 
								INNER JOIN " . $this -> tArtist . " ON " . $this -> tArtist . ".id_artist = " . $this -> tMusic . ".id_artist
								INNER JOIN " . $this -> tAlbum . " ON " . $this -> tAlbum . ".id_album = " . $this -> tMusic . ".id_album
								WHERE id_music = " . $id_music . "
								");
	}

	/**
	 *	Return datas from all musics
	 */
	public function getMusics() {
		return $this -> db -> query("
								SELECT *
								FROM " . $this -> tMusic . " 
								INNER JOIN " . $this -> tArtist . " ON " . $this -> tArtist . ".id_artist = " . $this -> tMusic . ".id_artist
								INNER JOIN " . $this -> tAlbum . " ON " . $this -> tAlbum . ".id_album = " . $this -> tMusic . ".id_album
								");
	}

	public function donwloadMusic() {
		// récuperer la musique
		// puis ajouter bdd
		// puis sauvegarder le .mp3 dans le bon dossier
		// $output[0]
		$output = array();
		$status;
		$vartest = exec("", $output, $status);
		foreach ($output as $row) {
			echo $row;
		}
	}

	public function searchMusic($name_musique, $limit, $offset) {
		$musiques = array();

		self::_makeCall('/search', array('q' => $name_musique, 'type' => "track", 'market' => "US", 'limit' => $limit, 'offset' => $offset));

		return $musiques;
	}

	/**
	 * The call operator
	 *
	 * @param string $function              API resource path
	 * @param array $params                 Request parameters
	 * @return mixed
	 */
	private static function _makeCall($function, $params) {
		$params = '?' . utf8_encode(http_build_query($params));
		$apiCall = self::API_URL . $function . $params;

		echo $apiCall;
		$cookie = "_ga=GA1.2.213723637.1428608412; sp_landing=http%3A%2F%2Fopen.spotify.com%2Ftrack%2F0eGsygTp906u18L0Oimnem; sp_cc=1; plp=e6e94d678d6ebc404cf77d5b7869462cb0a22231; from_wp=1; campanja_id=0-2101834124-11703452180-1431076085163; spot=%7B%22t%22%3A1431076119%2C%22m%22%3A%22fr%22%2C%22p%22%3A%22open%22%2C%22w%22%3Anull%7D; optimizelySegments=%7B%22172210784%22%3A%22brand_fr_exact%22%2C%22172815652%22%3A%22campaign%22%2C%22173064250%22%3A%22ff%22%2C%22172898846%22%3A%22false%22%7D; optimizelyEndUserId=oeu1431076097321r0.9962966030074917; optimizelyBuckets=%7B%7D; __utma=269535539.213723637.1428608412.1431076098.1431076098.1; __utmz=269535539.1431076098.1.1.utmcsr=google|utmgclid=CjwKEAjwvbGqBRCs3eH4o5C74CYSJAB3TODsWiTXMJsdk8oQykz50BrVJ6KZ_4G40R1CH4FybaVo9RoCCCzw_wcB|utmccn=brand_fr_exact|utmcmd=growth_paid|utmctr=(not%20provided); __tdev=8Q0YQku6; fbm_174829003346=base_domain=.spotify.com; __tumi=bd7b996a3fe71c7ee15b; mp_329e66c6399f2a6f728674b8c0062881_mixpanel=%7B%22distinct_id%22%3A%20%2214d32c850cc304-0f815ae493e8578-44564136-1fa400-14d32c850cd233%22%2C%22%24search_engine%22%3A%20%22google%22%2C%22utm_source%22%3A%20%22google%22%2C%22utm_medium%22%3A%20%22growth_paid%22%2C%22utm_campaign%22%3A%20%22brand_fr_exact%22%2C%22%24initial_referrer%22%3A%20%22http%3A%2F%2Fwww.google.fr%2Faclk%3Fsa%3Dl%26ai%3DClqx7_nxMVfKOG4i4jAa9goCgDu3FrtAGhZyzgfYB5M-PyycIABABYPuRg4OUCqABsPa0xAPIAQGqBCJP0F2D8gGsOLriYyCnbQ4qWrmV_dhFk50k75x9Daif5M0DgAet1ewviAcBkAcCqAemvhvYBwE%26sig%3DAOD64_14lzrfA_svBqG76TCbf0ll-OiWAQ%26rct%3Dj%26q%3D%26ved%3D0CB4Q0Qw%26adurl%3Dhttps%3A%2F%2Fwww.spotify.com%2Ffr%2Fpremium%253F%2526ca_source%253Dgaw%2526ca_ace%253D%2526ca_nw%253Dg%2526ca_dev%253Dc%2526ca_pl%253D%2526ca_pos%253D1t1%2526ca_cid%253D66079385181%2526ca_agid%253D12947080581%2526ca_caid%253D217082661%2526ca_adid%253D66079385181%2526ca_chid%253D2001882%2526ca_kwt%253Dspotify%2526ca_mt%253De%2526ca_fid%253D%2526ca_tid%253Dkwd-10626525156%2526ca_lp%253D9055641%2526ca_li%253D%2526ca_devm%253D%2526ca_plt%253D%2526ca_sadt%253D%257Badtype%257D%2526ca_smid%253D%257Bmerchant_id%257D%2526ca_spc%253D%257Bproduct_channel%257D%2526ca_spid%253D%257Bproduct_id%257D%2526ca_sco%253D%257Bproduct_country%257D%2526ca_sla%253D%257Bproduct_language%257D%2526ca_sptid%253D%257Bproduct_partition_id%257D%2526ca_ssc%253D%257Bstore_code%257D%2526utm_source%253Dgoogle%2526utm_medium%253Dgrowth_paid%2526utm_campaign%253Dbrand_fr_exact%22%2C%22%24initial_referring_domain%22%3A%20%22www.google.fr%22%7D; link_spb=1; fbsr_174829003346=nCQB-Wpxv6Tgfi_yHy8rZo38KAkeE7lRV993_f8cIfU.eyJhbGdvcml0aG0iOiJITUFDLVNIQTI1NiIsImNvZGUiOiJBUUQzc01EUThzWUFhSnRRdFVkeHkzU0VHcXRPcEhYRzNfTW8yY3lRNG1nbGI2Z3ZWbTNvcDVxQXpYTEZUN0plTHFob1h4Y0FDZ3RtT2JPYjhFUEU0Y0pYcnM1Mmg1NHZicXY0ZkRDejh1czhpNkFfaUp1Z1JLNlYxRzhmUXVnQk1QODZUSGNLWXZKRWhqT255RlBHS3hIU0Vld0lKLWhGeWhidmY4RjVIZXV0aE1YZGhlMzRpbjlwSG52YUo2MHIyWFhjbjVuN2VyTTMwZWU2eHJiRnA1aTVjTjU2dlliTHl3Y2VYQW1IZTJyOXhJcUVBQ3RqbjN5bVhTYXU5VjNBbmxNdlhZY1kwaTlFOHh6TG54VnE5OV9tWDFmendYMGlFUGo4VkxLSWxFSEZMbnpVcG9aNUJXeTNRUmhQSy14Wlp5ayIsImlzc3VlZF9hdCI6MTQzMTA5NDcyOSwidXNlcl9pZCI6IjEwMDAwMTM2MDk1MjE4NiJ9";
		$ch = curl_init($apiCall);

		curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json'));
		curl_setopt($ch, CURLOPT_ENCODING, 'gzip,deflate');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 50);
		$jsonData = curl_exec($ch);
		curl_close($ch);

		// stop all services from Wamp-Server and close the programm

		// Open .../wamp/bin/apache/Apache2../bin/php.ini
		//
		// copy php.ini to desktop and open it
		//
		// set safe_mode_exec_dir (line after = is empty, so IT IS ON!!!) set it off!
		//
		// save
		//
		// copy back to dir (maybe you need admin rights)
		//
		// start wamp-server
		//
		// enjoy exec() and co.
		var_dump($jsonData);
		// exec_shell('curl -X GET "' . $apiCall . '" -H "Accept: application/json" >>' . base_url() . 'application\logs\log_curl.php ');
		return $jsonData;
	}

	public function autorization() {

		// curl -H "Authorization: Basic ZjM4ZjAw...WY0MzE=" -d grant_type=client_credentials https://accounts.spotify.com/api/token
		// Authorization Required. Base 64 encoded string that contains the client ID and client secret key.
		// The field must have the format: Authorization: Basic <base64 encoded client_id:client_secret>
		// ours : Client ID : 102dff6f5f0f420990f0f5ff65d2ede0
		// Client Secret : dd731a87c2bc4bfb8024b762e75a8c93
		$header = array("Authorization: Basic <base64 encoded 102dff6f5f0f420990f0f5ff65d2ede0:dd731a87c2bc4bfb8024b762e75a8c93>");
		$data = array('grant_type' => 'client_credentials');
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'https://accounts.spotify.com/api/token');
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		$jsonData = curl_exec($ch);
		var_dump($jsonData);
		$token = json_decode($jsonData);
		curl_close($ch);

		var_dump($token);

	}

	public function test() {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'https://www.google.fr/');
		$data = curl_exec($ch);
		var_dump($data);

	}

}
