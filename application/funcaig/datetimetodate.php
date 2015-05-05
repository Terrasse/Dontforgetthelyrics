<?php

function converDatetimeSansHeure($date_unconvert) 
	{	
		$date = explode('-', $date_unconvert);
		$annee = $date[0];
		$mois = $date[1];
		$m = array(
		'Janvier', 
		'Février',
		'Mars',
		'Avril',
		'Mai',
		'Juin',
		'Juillet',
		'Aout',
		'Septembre',
		'Octobre',
		'Novembre',
		'Décembre'
		);
		$j = explode(' ', $date[2]); 
		$h = explode(':', $j[1]); 
		$heure = $h[0]; $minute = $h[1];
		$jour = $j[0];
		$timestamp = mktime(0, 0, 0, $mois, $jour, $annee);
		$JourF = date('j', $timestamp);
		$mois--;
		$MoisF = $m[$mois];
		$AnF = date('Y', $timestamp);
		
		return $JourF." ".$MoisF." ".$AnF;
	}
	
?>