<a href="#header">
	<img id="haut_de_page" style="display: none; position: fixed;" src="<?php echo base_url().'assets/images/go_top.png'; ?>" height="50" width="50" />
</a>

<script>
// GESTION DU BOUTON HAUT DE PAGE

	var margin = "<?php echo $padding_left; ?>";
	// Le bouton apparait ou non
	$("#haut_de_page").fadeIn( "fast" );
	$("#haut_de_page").fadeOut( "fast" );
	
	$(window).scroll( function() {
		if($(window).scrollTop() < ($("#menu_bg").offset().top)) // si je suis au dessus du menu
		{
			$("#haut_de_page").fadeOut( "fast" );
			$("#haut_de_page").css( "margin-left", margin);
		}
		else
		{
			$("#haut_de_page").fadeIn( "fast" );
		}
	})
	
	// effet de slide sur le retour
	$(document).ready( function () {
		$('#haut_de_page').click(function() {
			$('html,body').animate({scrollTop: $("#header").offset().top}, 'slow');
		});
	})
</script>


