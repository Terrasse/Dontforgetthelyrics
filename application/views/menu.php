<a href="<?php echo site_url('game'); ?>">
	<div class="menu_bouton menu_first">Play game</div>
</a>

<?php if($this->session->userdata('connected')) 
{
?>
	<a href="<?php echo site_url('profile/'.$this->session->userdata('id_player')); ?>">
		<div class="menu_bouton menu_accueil">My profile</div>
	</a>
	<a href="<?php echo site_url('connection/logout'); ?>">
		<div class="menu_bouton menu_last">Log out</div>
	</a>
<?php
}
else
{
?>
	<a href="<?php echo site_url('connection'); ?>">
		<div class="menu_bouton menu_last">Log in</div>
	</a>
<?php
}
?>