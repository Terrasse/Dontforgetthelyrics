<strong>
<a href="<?php echo site_url('game'); ?>">
	<div class="menu_bouton menu_accueil">PLAY GAME</div>
</a>

<?php if($this->session->userdata('connected')) 
{
?>
	<a href="<?php echo site_url('profile/'.$this->session->userdata('id_player')); ?>">
		<div class="menu_bouton menu_accueil">PLAYER</div>
	</a>
	<a href="<?php echo site_url('connection/logout'); ?>">
		<div class="menu_bouton menu_accueil">LOG OUT</div>
	</a>
<?php
}
else
{
?>
	<a href="<?php echo site_url('connection'); ?>">
		<div class="menu_bouton menu_accueil">LOG IN</div>
	</a>
<?php
}
?>
</strong>