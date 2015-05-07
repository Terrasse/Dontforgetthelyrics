<div class="row">
	<div class="four columns">
		<div style="margin-bottom: 4%">
			<audio style="margin: 1% 0 2% 0" id="player2" src="<?php echo base_url(); ?>assets/musiques/<?php echo $id_music; ?>.mp3" type="audio/mp3" controls="controls"></audio>
		</div>
		<div>
			<h5 style="margin-bottom:0;">Title</h5>
			<?php echo $title; ?>
			<h5 style="margin-bottom:0;">Album</h5>
			<?php echo $album_name; ?>
			<h5 style="margin-bottom:0;">Artist</h5>
			<?php echo $name; ?>
		</div>
	</div>
	<div class="eight columns" style="text-align: justify">
		<?php
			echo $lyrics;
		?>
	</div>
</div>

<script>
$('audio,video').mediaelementplayer();
</script>