<?php
	echo $id_music.' '.$title.'<br />'.$lyrics;
?>

<audio id="player2" src="<?php echo base_url(); ?>assets/musiques/<?php echo $id_music; ?>.mp3" type="audio/mp3" controls="controls">		
</audio>	

<script>
$('audio,video').mediaelementplayer();
</script>