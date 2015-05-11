<section id="row">
	<div class="six columns" style="padding-bottom: 5%">
		<div id="row">
			<h4>My profile</h4>
		</div>
		<div id="row">
			<h5 class="six columns">Username</h5><span class="result"><h5 class="six columns"><?php echo $username; ?></h5></span>
		</div>
		<div id="row">
			<h5 class="six columns">My level</h5>
			<span class="result">			
				<form action="<?php echo base_url(); ?>player/set_level" method="post">
					<select name="level">
					<?php echo $level; ?>
					</select>
					<br />
					<input class="button-primary"name="form_sent" value="Update my level" type="submit"/>
				</form>
			</span>
		</div>
	</div>
	<div class="six columns" style="padding-bottom: 5%">
		<div id="row">
			<h4>My best result</h4>
		</div>
		<div id="row">
			<h5 class="one columns">N°</h5><h5 class="ten columns">Music title</h5><h5 class="one columns">Result</h5>
		</div>
		<div class="result">
			<?php 
			if($empty_result)
			{
			?>
			You have to play at least one game before seeing your scoreboard
			<?php
			}
			else
			{
			?>
				<div id="row">
					<h5 class="one columns">1</h5><h5 class="ten columns"><?php echo $result[1]['name'].' - '.$result[1]['music']; ?></h5><h5 class="one columns"><?php echo $result[1]['result']; ?>%</h5>
				</div>
				<div id="row">
					<h5 class="one columns">2</h5><h5 class="ten columns"><?php echo $result[2]['name'].' - '.$result[2]['music']; ?></h5><h5 class="one columns"><?php echo $result[2]['result']; ?>%</h5>
				</div>
				<div id="row">
					<h5 class="one columns">3</h5><h5 class="ten columns"><?php echo $result[3]['name'].' - '.$result[3]['music']; ?></h5><h5 class="one columns"><?php echo $result[3]['result']; ?>%</h5>
				</div>
				<div id="row">
					<h5 class="one columns">4</h5><h5 class="ten columns"><?php echo $result[4]['name'].' - '.$result[4]['music']; ?></h5><h5 class="one columns"><?php echo $result[4]['result']; ?>%</h5>
				</div>
				<div id="row">
					<h5 class="one columns">5</h5><h5 class="ten columns"><?php echo $result[5]['name'].' - '.$result[5]['music'];; ?></h5><h5 class="one columns"><?php echo $result[5]['result']; ?>%</h5>
				</div>
			<?php
			}
			?>
		</div>
	</div>
</section>
