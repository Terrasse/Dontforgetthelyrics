<div class="row">
	<div id="music_player" class="four columns">
		<div>
			<iframe src="https://embed.spotify.com/?uri=spotify:track:<?php echo $id_spotify; ?>" frameborder="0" allowtransparency="true"></iframe>
			<!--<audio style="margin: 1% 0 2% 0" id="player2" src="<?php // echo base_url(); ?>assets/musiques/<?php echo $id_music; ?>.mp3" type="audio/mp3" controls="controls"></audio>-->
		</div>
		<div>
			<h5 style="margin-bottom:0;">Title</h5>
			<?php echo $title; ?>
			<h5 style="margin-bottom:0;">Album</h5>
			<?php echo $album_name; ?>
			<h5 style="margin-bottom:0;">Artist</h5>
			<?php
			$i = 0;
			foreach ($artists as $artist) {
				if ($i != 0)
					echo ', ' . $artist;
				else
					echo $artist;

				$i++;
			}
			?>
		</div>
	</div>
	<div class="eight columns lyrics" style="text-align: center; float: right;">
		<form action="<?php echo base_url(); ?>game/result" method="post">
			<h5>Below in this lyrics' form, you got <?php echo $nb_words; ?>
			blank spaces. Fill in them and get your result !</h5>
			<?php
			if (isset($lyrics)) {
				foreach ($lyrics as $word)
					echo $word . ' ';
			} else {
				echo '<span style="color: red;">No lyrics !</span>';
			}
			?>
			<br />
			<?php echo $nb_words_form_hidden; ?>
			<br />
			<input type="hidden" value="<?php echo $id_music; ?>" name="id_music" />
			<?php
			if (isset($lyrics)) {
				echo '<input style="float: right;" class="button-primary" type="submit" value="Send my lyrics" />';
			}
			?>
		</form>
	</div>
</div>

<script>
	var positionElementInPage = $('#music_player').offset().top;
	$(window).scroll(function() {
		if ($(window).scrollTop() >= positionElementInPage) {
			// fixed
			$('#music_player').addClass("floatable");
		} else {
			// relative
			$('#music_player').removeClass("floatable");
		}
	})

	$('audio,video').mediaelementplayer(); 
</script>