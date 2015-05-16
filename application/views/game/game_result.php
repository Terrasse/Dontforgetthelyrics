<div class="row">
	<div class="six columns" style="text-align: justify">
			<h4 style="margin-bottom:0;">My score</h4>
			<span class="result"><h5><?php echo $score; ?>%</h5></span>
	</div>
	<div class="six columns" style="text-align: justify">
			<h4 style="margin-bottom:0;">My rank for that song</h4>
			<span class="result"><h5><?php echo $rank; ?></h5></span>
	</div>
</div>
<div class="row">
	<div class="six columns" style="text-align: justify">
		<h5 style="margin-bottom:0;">Title</h5>
		<?php echo $title; ?>
		<h5 style="margin-bottom:0;">Album</h5>
		<?php echo $album_name; ?>
	</div>
	<div class="six columns" style="text-align: justify">
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
<div style="margin: 5% 0 0 0" class="row">
	<div class="three columns" style="text-align: justify">
		<h5 style="margin-bottom:0;">Right answers</h5>
		<?php
		for ($i = 1; $i < $nb_words; $i++) {
			echo '<span class="solution_result">';
			if ($solution[$i] == "") {
				echo '&times';
			} else {
				echo $solution[$i];
			}
			echo '</span><br />';
		}
		?>
	</div>
	<div class="one column" style="text-align: justify"></div>
	<div class="three columns" style="text-align: justify">
		<h5 style="margin-bottom:0;">My answers</h5>
		<?php
		for ($i = 1; $i < $nb_words; $i++) {
			echo '<span class="word_result';

			if (strtolower($word[$i]) == strtolower($solution[$i])){
				echo '_ok';
				$word[$i] = $solution[$i];
			}
				

			echo '">';
			if ($word[$i] == "") {
				echo '&times';
			} else {
				echo $word[$i];
			}
			echo '</span><br />';
		}
		?>
	</div>
</div>