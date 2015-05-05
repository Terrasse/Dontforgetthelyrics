<?php

function converDatetimeInShortDate($date_unconvert) 
{	
	$date = explode('-', $date_unconvert);
	$annee = substr($date[0], -2);
	$mois = $date[1];
	$j = explode(' ', $date[2]); 
	$jour = $j[0];
	return $jour."/".$mois."/".$annee;
}

function converDatetimeInDate($date_unconvert) 
{	
	$date = explode('-', $date_unconvert);
	$annee = $date[0];
	$mois = $date[1];
	$j = explode(' ', $date[2]); 
	$jour = $j[0];
	return $jour."/".$mois."/".$annee;
}

?>