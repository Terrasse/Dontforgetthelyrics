<div class="row" style="margin-top: 2%;margin-bottom: 2%;">
	<div class="four columns">
		<audio id="player2" src="<?php echo base_url(); ?>assets/musiques/<?php echo $id_music; ?>.mp3" type="audio/mp3" controls="controls">		
		</audio>
	</div>
	<div class="eight columns">
		<?php
			echo $id_music.' '.$title.'<br />'.$lyrics;
		?>
	</div>
</div>

<script>
$('audio,video').mediaelementplayer();
</script>