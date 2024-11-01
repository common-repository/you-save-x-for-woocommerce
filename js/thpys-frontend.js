jQuery(document).ready(function($) {
	$('input.variation_id').change( function(){
	
		if( '' != $('input.variation_id').val() ) {
			
			$( '.woocommerce-variation-price' ).append( '<div id="thp-ysxfw-varprod-badge-ajax"></div>' );
			
			var var_id = $('input.variation_id').val();
			
			$.ajax({
				url: thp_ysxfw_frontend_vars.ajaxurl,
				data: {'action':'thp_ysxfw_calc_percentage_saved','vari_id': var_id} ,
				success: function(data) {
					if (jQuery.trim(data)) {
						document.getElementById("thp-ysxfw-varprod-badge-ajax").innerHTML = data;
					}
				},
				error: function(errorThrown){
					console.log(errorThrown);
				}
			});                       
		}
	});
});