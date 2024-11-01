<?php
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! defined( 'thpys-you-save-wc-main' ) ) exit;
?>

<div class="wrap">
	
	<h2 style="margin-top: 30px;"><?php _e( "Currently available blocks:", 'you-save-x-for-woocommerce' ); ?></h2>
	
	<div class="thpys-block-list-container">
		<div class="thpys-block-list-item">
			<div>
				<span class="dashicons dashicons-money-alt" style="font-size: 50px; width: 50px; height: 50px;"></span>
			</div>
			<div class="thpys-block-list-item-inner">
				<div>
					<h3><?php _e( "YS Total Save for Checkout", 'you-save-x-for-woocommerce' ); ?></h3>
				</div>
				<div>
					<?php _e( "Displays customer's total saves before items' TOTAL at checkout. Used on Checkout page with Woocommerce checkout block.", 'you-save-x-for-woocommerce' ); ?>
				</div>
			</div>
		</div>
	</div>
	
</div><!-- .wrap -->