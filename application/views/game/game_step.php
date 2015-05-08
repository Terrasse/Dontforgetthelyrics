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
		<form action="<?php echo base_url(); ?>game/result" method="post">
			<h5>You got <?php echo $nb_words; ?> holes through these lyrics. Complete them and get your result !</h5>
			<?php
				foreach($lyrics as $word)
					echo $word.' ';
			?>
			<br />
			<?php echo $nb_words_form_hidden; ?>
			<br />
			<input type="hidden" value="<?php echo $id_music; ?>" name="id_music" />
			<input type="submit" value="Send my lyrics" />
		</form>
	</div>
</div>

<script>
$('audio,video').mediaelementplayer();
</script>