<?php
/**
 * Plugin Name: You Save for Woocommerce
 * Plugin URI: https://10horizonsplugins.com/wordpress-plugins/
 * Description: Displays how much your customers save on products, amounts can be shown in currency and in percentage. Convince your customers they have a good deal on your store.
 * Version: 1.0.1
 * Author: 10Horizons Plugins
 * Author URI: https://10horizonsplugins.com
 * Text Domain: you-save-x-for-woocommerce
 */

if ( ! defined( 'ABSPATH' ) ) exit;

define ( 'thpys-you-save-wc-main', TRUE );
include ( 'main-options.php' );

$thp_ysxfw_current_theme = wp_get_theme();
$thp_ysxfw_current_theme_name = $thp_ysxfw_current_theme->get( 'Name' );


function thp_ysxfw_plug_init() {
	load_plugin_textdomain( 'you-save-x-for-woocommerce', false, basename( dirname( __FILE__ ) ) . '/languages' );
}
add_action( 'plugins_loaded', 'thp_ysxfw_plug_init' );


function thp_ysxfw_yspro_active() {
	if ( ! function_exists('is_plugin_active')) {
	    require_once( ABSPATH . '/wp-admin/includes/plugin.php' );
	}
	
	if( is_plugin_active( 'you-save-x-for-woocommerce-pro/index.php' ) ) {
		return true; //pro version is active
	}
return false;
}


function thp_ysxfw_version_check() {
	
	if ( thp_ysxfw_yspro_active() ) {
		$yspro_latest_v = '1.3.0';
		
		$yspro_data = get_plugin_data( plugin_dir_path( __DIR__ ).'you-save-x-for-woocommerce-pro/index.php', false, false );
		$yspro_user_v = $yspro_data['Version'];
		
		if ( version_compare($yspro_user_v, $yspro_latest_v, '<') ) {
			$url = 'https://10horizonsplugins.com/my-account/';
			$notice_string = sprintf( wp_kses( __( 'There is a new update available for You Save for Woocommerce PRO. Please login to <a href="%s" target="_blank" rel="noopener noreferrer">your account</a> to download the latest version.', 'you-save-x-for-woocommerce' ), array(  'a' => array( 'href' => array(), 'target' => array(), 'rel' => array() ) ) ), esc_url( $url ) );
			echo '<div class="notice notice-warning is-dismissible">';
			echo '<p>'.$notice_string.'</p>';
			echo '</div>';
		}
	}
}
add_action('admin_notices', 'thp_ysxfw_version_check');


function thp_ysxfw_create_totalsave_checkout_block_init() {
	register_block_type( __DIR__ . '/build/totalsave-checkout' );
}
add_action( 'init', 'thp_ysxfw_create_totalsave_checkout_block_init' );


/* To show data-* attributes on the frontend HTML */
add_filter(
	'__experimental_woocommerce_blocks_add_data_attributes_to_block',
	function ( $allowed_blocks ) {
		$allowed_blocks[] = 'you-save-x-for-woocommerce/totalsave-checkout';
		return $allowed_blocks;
	},
	10,
	1
);


function thp_ysxfw_admin_scripts( $hook ) {
	if ( 'woocommerce_page_thpys-you-save-settings-front' != $hook )
		return;
	
	wp_enqueue_style( 'thpys-admin-css', plugin_dir_url( __FILE__ ).'css/thpys-admin.min.css' );
	wp_enqueue_script( 'thpys-jscolor', plugin_dir_url( __FILE__ ).'js/jscolor.min.js', array(), false, false );
	wp_enqueue_script( 'thpys-admin-js', plugin_dir_url( __FILE__ ).'js/thpys-admin.min.js', array( 'jquery', 'thpys-jscolor' ), false, true );
}
add_action( 'admin_enqueue_scripts', 'thp_ysxfw_admin_scripts' );


function thp_ysxfw_frontend_scripts_enqueuing() {
	wp_enqueue_style( 'thpys-frontend-css', plugin_dir_url( __FILE__ ).'css/thpys-frontend.min.css' );
	
	$thp_ysxfw_options = ( !empty(get_option( 'thp_ysxfw_options' )) ? get_option( 'thp_ysxfw_options' ) : '' );
	$single_enabled = ( !empty($thp_ysxfw_options['enable_single']) ? filter_var($thp_ysxfw_options['enable_single'], FILTER_SANITIZE_NUMBER_INT) : '' );
	
	if ( ($thp_ysxfw_options && $single_enabled) || (!$thp_ysxfw_options && !$single_enabled) ) {
		wp_enqueue_script( 'thpys-frontend-js', plugin_dir_url( __FILE__ ).'js/thpys-frontend.min.js', array( 'jquery' ), false, true );
		wp_localize_script( 'thpys-frontend-js', 'thp_ysxfw_frontend_vars', array(
			'ajaxurl' => admin_url( 'admin-ajax.php' )
		));
	}
}
add_action( 'wp_enqueue_scripts', 'thp_ysxfw_frontend_scripts_enqueuing' );


function thp_ysxfw_get_calculated_amount_saved( $prod_id = 0, $quantity = 1 ) {
	
	if (!$prod_id)
		global $product;
	else
		$product = wc_get_product( $prod_id );
	
	if (!(array)$product) //product object empty
		return;
	
	$product_type = $product->get_type();
	
	$amount_saved = 0;
	$amount_saved_curency = '';
	
	if (( 'simple' == $product_type ) || ( 'variation' == $product_type ) || ( 'external' == $product_type )) {
		
		$regular_price = $product->get_regular_price();
		$sale_price = $product->get_sale_price();
		
		if( !empty($sale_price) )
			$amount_saved = ($regular_price - $sale_price) * $quantity;
		else
			return;
	}
	elseif ( 'variable' == $product_type ) {
		$prices = $product->get_variation_prices();
		$amounts  = array();
		
		foreach ( $prices['price'] as $key => $price ) {
			if ( $prices['regular_price'][ $key ] !== $price ) {
				$amounts[] = $prices['regular_price'][ $key ] - $price;
			}
		}
		if( !empty($amounts) ) 
			$amount_saved = max( $amounts );
		else
			return;
	}
	
	$amount_saved_curency = wc_price( number_format($amount_saved,2, '.', '') );
	return $amount_saved_curency;
}


function thp_ysxfw_get_calculated_percentage_saved( $prod_id = 0 ) {
	
	if (!$prod_id)
		global $product;
	else
		$product = wc_get_product( $prod_id );
	
	if ( !(array)$product ) //product object empty
		return;
	
	$product_type = $product->get_type();
	
	$percentage = 0;
	$with_percentage_symbol = '';
	
	if (( 'simple' == $product_type ) || ( 'variation' == $product_type ) || ( 'external' == $product_type )) {
		$regular_price = $product->get_regular_price();
		$sale_price = $product->get_sale_price();
		
		if(!empty($sale_price)) {
			$percentage = round( ( ( $regular_price - $sale_price ) / $regular_price ) * 100 );
		}
		else { return; }
	}
	elseif ( 'variable' == $product_type ) {
		$prices = $product->get_variation_prices();
		$percentages  = array();
		
		foreach ( $prices['price'] as $key => $price ) {
			//Only on sale variations
			if ( $prices['regular_price'][ $key ] !== $price ) {
				$percentages[] = round( 100 - ( floatval( $prices['sale_price'][ $key ] ) / floatval( $prices['regular_price'][ $key ] ) * 100 ) );
			}
		}
		if(!empty($percentages)) {
			$percentage = max( $percentages );
		}
		else { return; }
	}
	
	$with_percentage_symbol = number_format($percentage,0, '', '') .'%';
	return $with_percentage_symbol;
}


function thp_ysxfw_custom_styles() {
	$stylestring = thp_ysxfw_get_custom_styles();
	return $stylestring;
}


function thp_ysxfw_custom_text() {
	$thp_ysxfw_options = get_option( 'thp_ysxfw_options' );
	$customtxt = (!empty($thp_ysxfw_options['customtxt'])) ? filter_var($thp_ysxfw_options['customtxt'], FILTER_SANITIZE_STRING) : '';
	
	if (!$customtxt)
		return;
	
	return $customtxt;
}


function thp_ysxfw_custom_text_cart_table() {
	$thp_ysxfw_options = get_option( 'thp_ysxfw_options' );
	$customtxtcarttable = (!empty($thp_ysxfw_options['txtcarttable'])) ? filter_var($thp_ysxfw_options['txtcarttable'], FILTER_SANITIZE_STRING) : '';
	
	if (!$customtxtcarttable)
		return;
	
	return $customtxtcarttable;
}


function thp_ysxfw_custom_text_cart_total() {
	$thp_ysxfw_options = get_option( 'thp_ysxfw_options' );
	$customtxtcarttotal = (!empty($thp_ysxfw_options['txtcarttotal'])) ? filter_var($thp_ysxfw_options['txtcarttotal'], FILTER_SANITIZE_STRING) : '';
	
	if (!$customtxtcarttotal)
		return;
	
	return $customtxtcarttotal;
}


function thp_ysxfw_calculate_cart_total_save() {
	global $woocommerce;
	$discount_total = 0;
	
	if (is_admin())
		return;
	
	foreach ( $woocommerce->cart->get_cart() as $cart_item_key => $values ) {
	
		$_product = $values['data'];
	
		if ( $_product->is_on_sale() ) {
			$regular_price = $_product->get_regular_price();
			$sale_price = $_product->get_sale_price();
			$discount = ($regular_price - $sale_price) * $values['quantity'];
			$discount_total += $discount;
		}
    }
	$discount_total = $discount_total + $woocommerce->cart->discount_cart;
	return $discount_total;
}


function thp_ysxfw_cart_total_save() {
	
	$thp_ysxfw_options = ( !empty(get_option( 'thp_ysxfw_options' )) ? get_option( 'thp_ysxfw_options' ) : '' );
	$carttotals_enabled = ( !empty($thp_ysxfw_options['enable_carttotals']) ? filter_var($thp_ysxfw_options['enable_carttotals'], FILTER_SANITIZE_NUMBER_INT) : '' );
	
	if ($thp_ysxfw_options && !$carttotals_enabled)
		return;
	
	$discount_total = 0;
	$discount_total = thp_ysxfw_calculate_cart_total_save();
	
	if ( $discount_total > 0 ) {
		
		if (thp_ysxfw_custom_text_cart_total())
			$yousavetxt = thp_ysxfw_custom_text_cart_total();
		else
			$yousavetxt = __( "You Save", 'you-save-x-for-woocommerce' );
		
		if (strpos( thp_ysxfw_custom_styles(), 'padding' ) !== false)
			$thp_ysxfw_custom_styles = substr(thp_ysxfw_custom_styles(), 0, strpos(thp_ysxfw_custom_styles(), "padding")) . '"';
		else
			$thp_ysxfw_custom_styles = thp_ysxfw_custom_styles();
		
		$output = '<tr class="cart-discount thpys-total-save-cell">
		<th>'. esc_html($yousavetxt) .'</th>
		<td '. $thp_ysxfw_custom_styles .' data-title="'. __( 'You save', 'you-save-x-for-woocommerce' ) .'">'
		. wc_price( $discount_total ) .'</td>
		</tr>';
		
		$output .= '<input type="hidden" id="thp-ysxfw-order-detail-yousaved-amount" name="thp-ysxfw-order-detail-yousaved-amount" value="'. $discount_total .'">';
		
		echo wp_kses( $output, array(
		'td' => array(
			'style' => array(),
			'data-title' => array()),
		'tr' => array(
			'class' => array()),
		'th' => array(),
		'span' => array(
			'class' => array()),
		'bdi' => array(),
		'input' => array(
			'type' => array(),
			'id' => array(),
			'name' => array(),
			'value' => array())
		));
	}
}
add_action( 'woocommerce_cart_totals_after_order_total', 'thp_ysxfw_cart_total_save', 99 );
add_action( 'woocommerce_review_order_after_order_total', 'thp_ysxfw_cart_total_save', 99 );


function thp_ysxfw_save_yousaved_field_checkout( $order_id ) {
    if ( isset( $_POST['thp-ysxfw-order-detail-yousaved-amount'] ) )
        update_post_meta( $order_id, 'thp_ysxfw_order_detail_yousaved_amount', esc_attr($_POST['thp-ysxfw-order-detail-yousaved-amount']));
}
add_action('woocommerce_checkout_update_order_meta', 'thp_ysxfw_save_yousaved_field_checkout');


function thp_ysxfw_add_yousaved_field_order_item_totals( $total_rows, $order ) {
	$raw_amount = get_post_meta( $order->id, 'thp_ysxfw_order_detail_yousaved_amount', true );
	$raw_amount = filter_var( $raw_amount, FILTER_SANITIZE_STRING );
	
	if ($raw_amount) {
		if (thp_ysxfw_custom_text_cart_total())
			$yousavetxt = thp_ysxfw_custom_text_cart_total().':';
		else
			$yousavetxt = __( "You saved: ", 'you-save-x-for-woocommerce' );
		
		$total_rows['thp_ysxfw_saving_totals']['label'] = $yousavetxt;
		$total_rows['thp_ysxfw_saving_totals']['value'] = wc_price( $raw_amount );
	}
	return $total_rows;
}
add_filter( 'woocommerce_get_order_item_totals', 'thp_ysxfw_add_yousaved_field_order_item_totals', 10, 2 );


function thp_ysxfw_you_save_single_product_page() {
	
	$thp_ysxfw_options = ( !empty(get_option( 'thp_ysxfw_options' )) ? get_option( 'thp_ysxfw_options' ) : '' );
	
	if ( is_home() || is_front_page() ) {
		$home_enabled = ( !empty($thp_ysxfw_options['enable_home']) ? filter_var($thp_ysxfw_options['enable_home'], FILTER_SANITIZE_NUMBER_INT) : '' );
		
		if ($thp_ysxfw_options && !$home_enabled) return;
	}
	elseif ( is_product() ){
		$single_enabled = ( !empty($thp_ysxfw_options['enable_single']) ? filter_var($thp_ysxfw_options['enable_single'], FILTER_SANITIZE_NUMBER_INT) : '' );
		
		if ($thp_ysxfw_options && !$single_enabled)	return;
		
		global $product;
		$product_type = $product->get_type();
		
		if ( 'variable' == $product_type ) return;
	}
	elseif ( is_shop() || is_archive() ) {
		$shop_enabled = ( !empty($thp_ysxfw_options['enable_shop']) ? filter_var($thp_ysxfw_options['enable_shop'], FILTER_SANITIZE_NUMBER_INT) : '' );
		
		if ($thp_ysxfw_options && !$shop_enabled) return;
	}
	
	$amount_saved = thp_ysxfw_get_calculated_amount_saved();
	$percentage = thp_ysxfw_get_calculated_percentage_saved();
	
	if (!$amount_saved) return;
	
	if (thp_ysxfw_custom_text()) {
		$customtxt = thp_ysxfw_custom_text();
		$customtxt = str_replace("[currency]", $amount_saved, $customtxt);
		$customtxt = str_replace("[percentage]", $percentage, $customtxt);
	}
	else {
		$customtxt = __( "You save: ", 'you-save-x-for-woocommerce' );
		$customtxt .= $amount_saved . " (". esc_html($percentage) .")";
	}
	
	$output = '<br />';
	$output .= '<p class="thpys-you-save-single" '. thp_ysxfw_custom_styles() .' >';
	$output .= $customtxt;
	$output .= '</p>';
	
	echo wp_kses( $output, array(
		'p' => array(
			'class' => array(),
			'style' => array()),
		'span' => array(
			'class' => array()),
		'bdi' => array(),
		'br' => array()
	));
	?>
	<div class="thpys-clearing"></div>
	<?php
}
add_action( 'woocommerce_single_product_summary', 'thp_ysxfw_you_save_single_product_page', 11 );


function thp_ysxfw_add_allowed_style($styleattr) {
	array_push($styleattr, '-webkit-box-shadow', '-moz-box-shadow', 'box-shadow');
	return $styleattr;
}
add_filter( 'safe_style_css', 'thp_ysxfw_add_allowed_style' );


if ($thp_ysxfw_current_theme_name != 'Astra') { //NOT Astra
	add_action( 'woocommerce_after_shop_loop_item', 'thp_ysxfw_you_save_single_product_page', 10 );
	//remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
	//add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 20 );
}
else { //Astra
	add_action( 'woocommerce_after_shop_loop_item', 'thp_ysxfw_you_save_single_product_page', 20 );
}


function thp_ysxfw_calc_percentage_saved(){
	//variable prod on single prod page
	
	if ( isset($_REQUEST) ) {
		
		$returnstring = '';
		$variation_id = sanitize_text_field($_REQUEST['vari_id']);
		$variation_id = filter_var($variation_id, FILTER_VALIDATE_INT);
		
		$amount_saved = thp_ysxfw_get_calculated_amount_saved($variation_id);
		$percentage = thp_ysxfw_get_calculated_percentage_saved($variation_id);
		
		if (!$amount_saved && !$percentage) die();
		
		if (thp_ysxfw_custom_text()) {
			$customtxt = thp_ysxfw_custom_text();
			$customtxt = str_replace("[currency]", $amount_saved, $customtxt);
			$customtxt = str_replace("[percentage]", $percentage, $customtxt);
			
			$returnstring = '<div class="thpys-clearing"></div><p '. thp_ysxfw_custom_styles() .' class="thpys-you-save-single">'. $customtxt .'</p>';
		}
		else {
			$yousave = __( 'You save: ', 'you-save-x-for-woocommerce' ). $amount_saved ." (". $percentage .")";
			$returnstring = '<div class="thpys-clearing"></div><p '. thp_ysxfw_custom_styles() .' class="thpys-you-save-single">'. $yousave .'</p>';
		}
		
		$output = wp_kses( $returnstring, array(
		'p' => array(
			'class' => array(),
			'style' => array()),
		'div' => array(
			'class' => array()),
		'span' => array(
			'class' => array()),
		'bdi' => array()
		));
		
		die($output);
	}
}
add_action( 'wp_ajax_thp_ysxfw_calc_percentage_saved', 'thp_ysxfw_calc_percentage_saved' );
add_action( 'wp_ajax_nopriv_thp_ysxfw_calc_percentage_saved', 'thp_ysxfw_calc_percentage_saved');


function thp_ysxfw_you_save_cart_table_price ( $price, $cart_item ) {
	
	$thp_ysxfw_options = ( !empty(get_option( 'thp_ysxfw_options' )) ? get_option( 'thp_ysxfw_options' ) : '' );
	$cartitem_enabled = ( !empty($thp_ysxfw_options['enable_cartitem']) ? filter_var($thp_ysxfw_options['enable_cartitem'], FILTER_SANITIZE_NUMBER_INT) : '' );
	
	if ($thp_ysxfw_options && !$cartitem_enabled)
		return $price;
	
	$var_id = $cart_item['variation_id'];
	
	if ($var_id)
		$prod_id = $var_id;
	else
		$prod_id = $cart_item['product_id'];
	
	$quantity = $cart_item['quantity'];
	$amount_saved = thp_ysxfw_get_calculated_amount_saved($prod_id, $quantity );
	
	if (!$amount_saved)
		return $price;
	
	$append_yousave = $amount_saved;
	
	if (thp_ysxfw_custom_text_cart_table()) {
		$yousavetxt = thp_ysxfw_custom_text_cart_table();
		$yousavetxt = str_replace("[currency]", $append_yousave, $yousavetxt);
		
		$price .= ' <br /><span '. thp_ysxfw_custom_styles() .' class="thpys-appended-cart-table">(';
		$price .= $yousavetxt .')</span>';
	}
	else {
		$price .= ' <br /><span '. thp_ysxfw_custom_styles() .' class="thpys-appended-cart-table">(';
		$price .= __( "You save ", 'you-save-x-for-woocommerce' );
		$price .= $append_yousave .')</span>';
	}
	
	$price = wp_kses( $price, array(
		'span' => array(
			'class' => array(),
			'style' => array()),
		'bdi' => array(),
		'br' => array()
	));
	
    return $price;
}
add_filter( 'woocommerce_cart_item_price', 'thp_ysxfw_you_save_cart_table_price', 10, 2 );


function thp_ysxfw_get_custom_styles() {
	
	$stylestring = '';
	
	if (thp_ysxfw_yspro_active()) {
		$stylestring = thp_yspro_get_custom_styles();
	}
	
	if ($stylestring == '') {
		
		$txtcolor = '#ff4747';
		$txtbgcolor = '#fff1f1';
		
		$txtpaddingtop = '2';
		$txtpaddingright = '2';
		$txtpaddingbottom = '2';
		$txtpaddingleft = '2';
		
		$txtradiustopleft = '0';
		$txtradiustopright = '0';
		$txtradiusbottomleft = '0';
		$txtradiusbottomright = '0';
		
		$stylestring = 'style="color: '.$txtcolor.'; background-color: '.$txtbgcolor.'; padding: '.$txtpaddingtop.'px '.$txtpaddingright.'px '.$txtpaddingbottom.'px '.$txtpaddingleft.'px; ';
		
		$stylestring .= 'border-radius: '.$txtradiustopleft.'px '.$txtradiustopright.'px '.$txtradiusbottomleft.'px '.$txtradiusbottomright.'px; ';
		
		$stylestring .= 'box-shadow: none;"';
	}
	
	return $stylestring;
}