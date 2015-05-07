<section id="row">
	<div class="six columns" style="padding-bottom: 5%">
		<h4>Connection</h4>
		<form name="connection_form" style="margin-top: 2%;" action="<?php echo base_url().'connection/login'; ?>" method="post">
			<input name="username" type="text" placeholder="Username" value="<?php echo set_value('username'); ?>" />
			<input name="password" type="password" placeholder="Password" />
			<br />
			<input name="form_sent" value="Sign in" type="submit"/>
		</form>
		<?php echo form_error('username'); ?>
		<?php echo form_error('password'); ?>
	</div>
	<div class="six columns" style="padding-bottom: 5%">
		<h4>Are you registered?</h4>
		<form name="register_form" style="margin-top: 2%;" action="<?php echo base_url().'connection/register'; ?>" method="post">
			<input name="username" type="text" placeholder="Username" value="<?php echo set_value('username'); ?>" />
			<input name="password" type="password" placeholder="Password" />
			<br />
			<input name="passwordCheck" type="password" placeholder="Confirm password" />
			<br />
			<input name="form_sent" value="Sign up" type="submit"/>
		</form>
		<?php echo form_error('username'); ?>
		<?php echo form_error('password'); ?>
		<?php echo form_error('passwordCheck'); ?>
	</div>
</section>