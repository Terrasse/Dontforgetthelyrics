<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Lyrics_masking_class extends CI_Model {
	const LEVEL_HIGH = 3;
	const LEVEL_MEDIUM = 2;
	const LEVEL_LOW = 1;

	const MASKING_HIGH = 4;
	const MASKING_MEDIUM = 6;
	const MASKING_LOW = 8;

	const COMBO_HIGH = 10;
	const COMBO_MEDIUM = 15;
	const COMBO_LOW = 5000;

	// input data
	private $level;

	// algorithme param
	private $percent_combo;
	private $percent_masking;

	// output data
	private $nb_words;
	private $nb_masking_words;
	private $output_lyrics;

	// processing data
	private $sentences;
	private $index_sentences;
	private $size_sentences;

	private $words;
	private $index_words;
	private $size_words;

	private $buffer_end_word;

	private $mode_combo;
	private $mode_no_lyrics;

	/**
	 * Apply the right algorithme according to player level
	 *
	 * @return array of lyrics
	 */
	public function lyricsMasking($lyrics, $level) {

		$this -> level = $level;

		// instanciate tampons
		$this -> tempon_start = null;
		$this -> buffer_end_word = null;

		// instanciate sentences
		$this -> sentences = explode('<br>', $lyrics);
		$this -> index_sentences = 0;
		$this -> size_sentences = count($this -> sentences);

		// instanciate words
		$this -> words = explode(' ', $this -> sentences[0]);
		$this -> index_words = 0;

		$this -> size_words = count($this -> words);
		$this -> addAsUnmaskedLyrics();
		$this -> nb_words = 1;
		$this -> nb_masking_words = 0;
		$this -> mode_no_lyrics = FALSE;

		// set algorithme param
		switch ($this->level) {
			case self::LEVEL_HIGH :
				$this -> percent_combo = self::COMBO_HIGH;
				$this -> percent_masking = self::MASKING_HIGH;
				break;
			case self::LEVEL_MEDIUM :
				$this -> percent_combo = self::COMBO_MEDIUM;
				$this -> percent_masking = self::MASKING_MEDIUM;
				break;
			case self::LEVEL_LOW :
			default :
				$this -> percent_combo = self::COMBO_LOW;
				$this -> percent_masking = self::MASKING_LOW;
				break;
		}

		// instanciate combo mode
		$this -> mode_combo = false;

		// making algorithme
		$this -> runMasking();

		return $this -> output_lyrics;
	}

	public function getNbWords() {
		return $this -> nb_masking_words;
	}

	public function getFormNbHidden() {
		return '<input type="hidden" placeholder="Complete the field" value="' . $this -> nb_masking_words . '" name="nb_words_form_hidden">';
	}

	public function runMasking() {
		while (TRUE) {
			$word = $this -> nextWord();
			if (isset($word)) {
				$this -> nb_words++;
				switch ($word) {
					case 'STOP_MODE_NO_LYRICS' :
						$this -> mode_no_lyrics = FALSE;
					case 'EMPTY_LINE' :
					case 'USELESS_WORD' :
						$this -> addAsUnmaskedLyrics();
						break;
					default :
						if ($this -> mode_combo) {
							$this -> addAsMaskedLyrics();
						} else {
							if (!$this -> mode_no_lyrics) {
								$hole = rand(0, $this -> percent_masking);
								if ($hole == $this -> percent_masking)
									$this -> addAsMaskedLyrics();
								else
									$this -> addAsUnmaskedLyrics();
							}
						}
				}
			} else
				break;
		}
	}

	/**
	 * Mask the next word on the lyrics_output
	 */
	private function addAsMaskedLyrics() {
		$this -> nb_masking_words++;
		// if combo adapt size
		$prop = "height";
		if ($this -> mode_combo)
			$prop = "width: 10%;height: 10%;";
		$this -> output_lyrics[] = '<input type="text"  style="' . $prop . '" placeholder="Fill in !" name="word' . $this -> nb_masking_words . '">';
		$this -> output_lyrics[] = '<input type="hidden" placeholder="Complete the field" value="' . $this -> words[$this -> index_words] . '" name="solution' . $this -> nb_masking_words . '">';
	}

	/**
	 * add the next word on the lyrics_output
	 */
	private function addAsUnmaskedLyrics() {
		$this -> output_lyrics[] = $this -> words[$this -> index_words];
	}

	/**
	 * Return the next word in the processing
	 *
	 * 	avoid :
	 * 	 	[word] OR (word)
	 * 		, OR '
	 * 		, OR '
	 */
	private function nextWord() {
		// private $sentences;
		// private $index_sentences;

		// private $words;
		// private $index_words;

		// we add the buffer into the output lyrics
		if (isset($this -> buffer_end_word)) {
			$last_insert_word = count($this -> output_lyrics) - 1;
			$this -> output_lyrics[$last_insert_word] = $this -> output_lyrics[$last_insert_word] . $this -> buffer_end_word;
			$this -> buffer_end_word = null;
		}

		// if we are at the end of line
		$this -> index_words++;
		if ($this -> index_words >= $this -> size_words) {
			$next_line = $this -> nextLine();
			if (isset($next_line)) {
				$this -> words = explode(' ', $next_line);
				if ($this -> words['0'] == '')
					return "EMPTY_LINE";
				$this -> index_words = '0';
				$this -> size_words = count($this -> words);

			} else {
				return null;
			}
		}

		$firstChar = $this -> words[$this -> index_words]['0'];

		// To avoid masking [word] OR (word)
		if ($firstChar == '[' || $firstChar == '(') {

			$length = strlen($this -> words[$this -> index_words]);
			$lastChar = $this -> words[$this -> index_words][($length - 1)];
			if ($firstChar == '(' && $lastChar != ')') {
				$this -> mode_no_lyrics = TRUE;
			} elseif ($firstChar == '[' && $lastChar != ']') {
				$this -> mode_no_lyrics = TRUE;
			}
			return "USELESS_WORD";
		}

		$length = strlen($this -> words[$this -> index_words]);
		$lastChar = $this -> words[$this -> index_words][($length - 1)];

		if ($this -> mode_no_lyrics) {
			// avoid ] )
			if ($lastChar == ']' || $lastChar == ')') {
				return "STOP_MODE_NO_LYRICS";
			}
			return "USELESS_WORD";
		}

		//First character => , OR '
		if ($firstChar == "'") {
			$this -> output_lyrics[] = "'";
			$this -> words[$this -> index_words] = substr($this -> words[$this -> index_words], 1);

		} elseif ($firstChar == ",") {
			$this -> output_lyrics[] = ",";
			$this -> words[$this -> index_words] = substr($this -> words[$this -> index_words], 1);
		}

		//End of the world is ... (we have to do this before Last character , ' ? ! .)
		$length = strlen($this -> words[$this -> index_words]);
		if ($length > 3) {
			$result = preg_replace('/(\\w+)\.\.\./i', '\\1', $this -> words[$this -> index_words], -1, $count);
			if ($count > 0) {
				$this -> words[$this -> index_words] = $result;
				$this -> buffer_end_word = "...";
				return $this -> words[$this -> index_words];
			}
		}

		//Last character => , OR ' ? !
		$length = strlen($this -> words[$this -> index_words]);
		if ( $lastChar == "," || $lastChar == "?" || $lastChar == "!" || $lastChar == ".") {
			$this -> words[$this -> index_words] = substr($this -> words[$this -> index_words], 0, $length - 1);
			$this -> buffer_end_word = $lastChar;
		}
		
		// avoid word'
		if( $lastChar == "'"){
			return "USELESS_WORD";
		}

				
		

		// avoid naa?
		if(preg_match('/^naa?/i',$this -> words[$this -> index_words],$matches,0)){
			return "USELESS_WORD";
		}
		// avoid na-.?
		if(preg_match('/na-.?/i',$this -> words[$this -> index_words],$matches,0)){
			return "USELESS_WORD";
		}
		// avoid whoa.?
		if(preg_match('/whoa.?/i',$this -> words[$this -> index_words],$matches,0)){
			return "USELESS_WORD";
		}
		// avoid yeah.?
		if(preg_match('/yeah.?/i',$this -> words[$this -> index_words],$matches,0)){
			return "USELESS_WORD";
		}
		// avoid o*h
		if(preg_match('/oo?h/i',$this -> words[$this -> index_words],$matches,0)){
			return "USELESS_WORD";
		}
		// // avoid oh
		if(preg_match('/^ow$/i',$this -> words[$this -> index_words],$matches,0)){
			return "USELESS_WORD";
		}
		// avoid wo-.?
		if(preg_match('/^wo-.*/i',$this -> words[$this -> index_words],$matches,0)){
			return "USELESS_WORD";
		}


		return $this -> words[$this -> index_words];
	}

	/**
	 * Change the current line and active the COMBO MODEEEEE
	 *
	 * @return the next line in the sentences of lyrics or null if we have no next sentences
	 */
	private function nextLine() {
		$this -> output_lyrics[] = '<br />';
		$this -> index_sentences++;
		if ($this -> index_sentences >= $this -> size_sentences) {
			return null;
		} else {
			$this -> sentences[$this -> index_sentences] = trim($this -> sentences[$this -> index_sentences]);
			while ((strlen($this -> sentences[$this -> index_sentences])) == 0) {
				return $this -> nextLine();
			}
			// enable/disable the combo mode
			$hole = rand(0, $this -> percent_combo);
			if ($hole == $this -> percent_combo)
				$this -> mode_combo = true;
			else
				$this -> mode_combo = false;
			return $this -> sentences[$this -> index_sentences];
		}
	}

}
?>