<?php

if(defined('REST_REQUEST')) return;

if ( ! empty( $attributes['customText'] ) ) {
    $custom_txt_ys = $attributes['customText'];
} else {
    $custom_txt_ys = 'You save ';
}
?>
<div <?php echo get_block_wrapper_attributes(); ?> style="border-top: 1px solid rgba(18, 18, 18, 0.11); padding: 16px 0;">
	<div class="wc-block-components-totals-item ys-total-save-inner-wrapper">
		<span><?php echo esc_html( $custom_txt_ys ); ?></span>
		<span><?php echo wc_price(thp_ysxfw_calculate_cart_total_save()); ?></span>
	</div>
</div>