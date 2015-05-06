<?php
	echo $id_music.' '.$title.'<br />'.$lyrics;
?>

<h5>Local link - <?php echo base_url(); ?>assets/musiques/<?php echo $id_music; ?>.mp3</h5>
<audio id="player2" src="<?php echo base_url(); ?>assets/musiques/<?php echo $id_music; ?>.mp3" type="audio/mp3" controls="controls">		
</audio>

<h5>Url - http://jplayer.org/audio/mp3/Miaow-07-Bubble.mp3</h5>
<audio id="player2" src="http://jplayer.org/audio/mp3/Miaow-07-Bubble.mp3" type="audio/mp3" controls="controls">		
</audio>

<script>
$('audio,video').mediaelementplayer();
</script>