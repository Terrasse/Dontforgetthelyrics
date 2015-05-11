<?php

function Preview($contenu, $lgMax) 
{
	$contenu = strip_tags($contenu);
	$contenuTab = array(); $contenuTab = explode(' ', $contenu);
	
	$i=0; $lg=0; $contenuNew='';
	
	while($lg < $lgMax AND $i < count($contenuTab))
	{
		if (($contenuTab[$i] != "&nbsp;") && ($contenuTab[$i] != "&nbsp;&nbsp;"))
		{
			$lg = $lg + strlen($contenuTab[$i]);
			$contenuNew = $contenuNew.' '.$contenuTab[$i];
		}
		$i++;
	}
	
	if ($i < count($contenuTab))
		$contenuNew .= ' [...]';
	
	return $contenuNew;
}

?>