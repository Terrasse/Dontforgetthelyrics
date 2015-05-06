<?php if($this->session->userdata('connected')) 
{
?>
	<a href="<?php echo site_url('home'); ?>">
		<div class="menu_bouton menu_accueil">ACCUEIL</div>
	</a>
	<a href="<?php echo site_url('profile/'.$this->session->userdata('connected')); ?>">
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
	<a href="<?php echo site_url('home'); ?>">
		<div class="menu_bouton menu_accueil">ACCUEIL</div>
	</a>
	<a href="<?php echo site_url('connection'); ?>">
		<div class="menu_bouton menu_accueil">LOG IN</div>
	</a>
<?php
}
?>