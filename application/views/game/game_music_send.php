<div class="container">
	<div class="row">
		<div class="two columns">&nbsp;</div>
		<div class="eight columns"><h4>Type the name of the track you're searching for</h4></div>
		<div class="two columns">&nbsp;</div>
	</div>
	<form action="<?php echo base_url(); ?>game/chooseMusic" method="post">
	<div class="row">
		<div class="two columns">&nbsp;</div>
		<div class="eight columns">
			<input type="text" class="twelve columns" name="track_name" placeholder="Track">
		</div>
		<div class="two columns">&nbsp;</div>
	</div>
	<div class="row">
		<div class="two columns">&nbsp;</div>
		<div class="eight columns">
			<input type="submit" class="button-primary twelve columns" name="form_sent" value="Search" />
		</div>
		<div class="two columns">&nbsp;</div>
	</div>
	</form>
</div>