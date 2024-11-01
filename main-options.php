<?php
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! defined( 'thpys-you-save-wc-main' ) ) exit;

function thp_ysxfw_yousave_admin_settings_menu() {
	add_submenu_page( 'woocommerce', __( 'You Save for Woocommerce Settings', 'you-save-x-for-woocommerce' ), __( 'You Save', 'you-save-x-for-woocommerce' ), 'manage_woocommerce', 'thpys-you-save-settings-front', 'thp_ysxfw_yousave_settings_front' );
}
add_action( 'admin_menu', 'thp_ysxfw_yousave_admin_settings_menu', 99 );


function thp_ysxfw_yousave_settings_front() {
	
	if (isset($_POST['action'])) {
		if ( $_POST['action'] === 'update-thpys-options' ) {
			thp_ysxfw_main_settings_handler();
		}
		else if (( $_POST['action'] === 'update-thpyspro-options' ) && ( thp_ysxfw_yspro_active() )) {
			thp_yspro_handler();
		}
		else {
			_e( "Error. Your changes might not be saved, please try again.", 'you-save-x-for-woocommerce' );
		}
	}
	?>
	
	<div class="wrap">
		
		<div style="align-items: center; display: flex; gap: 10px; flex-wrap: wrap;">
			<img src="<?php echo plugin_dir_url( __FILE__ ).'images/icon-256x256.png'; ?>" style="width: 80px; border-radius: 50%;" />
			<h1 style="text-decoration: underline dashed;">
				<?php _e( "You Save for Woocommerce Settings", 'you-save-x-for-woocommerce' ); ?>
			</h1>
		</div>
		
		<br />
		
		<?php
		if ( isset( $_GET[ 'tab' ] ) )
			$active_tab = filter_input(INPUT_GET, 'tab', FILTER_SANITIZE_STRING);
		else
			$active_tab = 'front';
		
		if ($active_tab == 'front') {
		?>
		
		<p style="font-size: 120%;"><?php _e( "Choose the type of store you have or the settings you want to set for your store:", 'you-save-x-for-woocommerce' ); ?></p>
		
		<div style="display: flex; flex-direction: row; justify-content: center; column-gap: 30px; align-items: center;">
			<a href="?page=thpys-you-save-settings-front&tab=shortcodes">
				<div style="padding: 30px; border: 3px solid #2ea2cc; text-align: center; flex-grow: 1; cursor: pointer; background: #e8effc;">
					<h3><?php _e( "Classic Woocommerce Shortcodes", 'you-save-x-for-woocommerce' ); ?></h3>
				</div>
			<a/>
			
			<a href="?page=thpys-you-save-settings-front&tab=blocks">
				<div style="padding: 30px; border: 3px solid #2ea2cc; text-align: center; flex-grow: 1; cursor: pointer; background: #e8effc;">
					<h3><?php _e( "The New Woocommerce Blocks", 'you-save-x-for-woocommerce' ); ?></h3>
				</div>
			<a/>
		</div><!-- flexbox -->
		
		<?php
		} //end tab front
		
		if ($active_tab == 'shortcodes') { ?>
			
			<nav class="nav-tab-wrapper">
				<a href="?page=thpys-you-save-settings-front&tab=shortcodes" class="nav-tab <?php echo $active_tab == 'shortcodes' ? 'nav-tab-active' : ''; ?>">
					<h1 style="font-size: 120%;"><?php _e( "Classic Woocommerce Shortcodes", 'you-save-x-for-woocommerce' ); ?></h1>
				</a>
				<a href="?page=thpys-you-save-settings-front&tab=blocks" class="nav-tab <?php echo $active_tab == 'blocks' ? 'nav-tab-active' : ''; ?>">
					<h1 style="font-size: 120%;"><?php _e( "New Woocommerce Blocks", 'you-save-x-for-woocommerce' ); ?></h1>
				</a>
			</nav>
			
			<?php
			include ( 'classic-shortcodes.php' );
		} //end tab shortcodes
		
		elseif ($active_tab == 'blocks') { ?>
			
			<nav class="nav-tab-wrapper">
				<a href="?page=thpys-you-save-settings-front&tab=shortcodes" class="nav-tab <?php echo $active_tab == 'shortcodes' ? 'nav-tab-active' : ''; ?>">
					<h1 style="font-size: 120%;"><?php _e( "Classic Woocommerce Shortcodes", 'you-save-x-for-woocommerce' ); ?></h1>
				</a>
				<a href="?page=thpys-you-save-settings-front&tab=blocks" class="nav-tab <?php echo $active_tab == 'blocks' ? 'nav-tab-active' : ''; ?>">
					<h1 style="font-size: 120%;"><?php _e( "New Woocommerce Blocks", 'you-save-x-for-woocommerce' ); ?></h1>
				</a>
			</nav>
			
			<?php 
			include ( 'blocks-list.php' );
		} //end tab blocks
		?>
		
	</div><!-- .wrap -->
<?php	
}


function thp_ysxfw_main_settings_handler() {
	
	if (isset($_POST['submit_ysfree'])) {
	
	if ( (isset( $_POST['thp_ysxfw_main_settings_nonce'])) && (wp_verify_nonce( $_POST['thp_ysxfw_main_settings_nonce'], 'update-options' )) ) {
		if ( current_user_can( 'manage_woocommerce' ) ) {
			
			$settings = filter_input(INPUT_POST, 'thp_ysxfw_options', FILTER_SANITIZE_STRING, FILTER_REQUIRE_ARRAY);
			
			$status = update_option( 'thp_ysxfw_options', $settings );
			
			if ($status) {
				echo '<div class="updated"><p>';
				_e( "Saved successfully!", 'you-save-x-for-woocommerce' );
				echo '</p></div>';
			}
			else {
				echo '<div class="error"><p>';
				_e( "Settings are not saved!", 'you-save-x-for-woocommerce' );
				echo '</p></div>';
			}
		}
	}
	else {
		echo '<div class="error"><p>';
		_e( "Sorry, nonce verification failed. Fields are not saved.", 'you-save-x-for-woocommerce' );
		echo '</p></div>';
		exit;
	}
	}
}