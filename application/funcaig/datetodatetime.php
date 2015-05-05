<?php
	function converDateInDatetime($date_unconvert) 
	{
		$date = explode('/', $date_unconvert);
		$jour = $date[0];
		$mois = $date[1];
		$an = $date[2]; 
		return $an."-".$mois."-".$jour;
	}
?>