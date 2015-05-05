<?php

function SlugUrl2( $url, $type = '' )
{
	$url = iconv('UTF-8', 'ASCII//TRANSLIT', $url);
	$url = preg_replace("`\[.*\]`U","",$url);
	$url = preg_replace('`&(amp;)?#?[a-z0-9]+;`i','-',$url);
	$url = htmlentities($url, ENT_NOQUOTES, 'ISO-8859-1');
	$url = preg_replace( "`&([a-z])(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig);`i","\\1", $url );
	$url = preg_replace( array("`[^a-z0-9]`i","`[-]+`") , "-", $url);
	$url = ( $url == "" ) ? $type : strtolower(trim($url, '-'));
	
	return $url;
}

setlocale(LC_ALL, 'en_US.UTF8');
function SlugUrl($str, $replace=array(), $delimiter='-') {
	if( !empty($replace) ) {
		$str = str_replace((array)$replace, ' ', $str);
	}

	$clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
	$clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
	$clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);
	$clean = strtolower(trim($clean, '-'));

	return $clean;
}

?>