<?php
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! defined( 'thpys-you-save-wc-main' ) ) exit;
?>

<form name="thp_ysxfw_main_settings_form" method="post" action="">
			
				<?php wp_nonce_field('update-options', 'thp_ysxfw_main_settings_nonce');
				
				$thp_ysxfw_options = get_option( 'thp_ysxfw_options' );
				$thp_ysxfw_no_options = false;
				
				if (empty($thp_ysxfw_options)) {
					$thp_ysxfw_options = (array) null;
					$thp_ysxfw_no_options = true;
				}
				
				$keys = array_keys($thp_ysxfw_options);
				$thp_ysxfw_keys = array('enable_home', 'enable_shop', 'enable_single', 'enable_cartitem', 'enable_carttotals');
				
				foreach($thp_ysxfw_keys as $thp_ysxfw_key){
					if (in_array($thp_ysxfw_key, $keys)) continue;  //already set
					$thp_ysxfw_options[$thp_ysxfw_key] = '';
				}
				?>
				
				<p><?php _e( "These are settings for stores that mostly use classic Woocommerce shortcodes instead of Woocommerce blocks. However, you can still use some of the features here accordingly even if you use Woocommerce blocks.", 'you-save-x-for-woocommerce' ); ?></p>
				
				<h3><?php _e( "Homepage/Front Page", 'you-save-x-for-woocommerce' ); ?></h3>
				
				<p><?php _e( "Enable or disable You Save text badge on your homepage and front page.", 'you-save-x-for-woocommerce' ); ?></p>
				
				<table class="form-table">
				<tbody>
				
				<tr>
					<th scope="row"><?php _e( "Homepage & front page:", 'you-save-x-for-woocommerce' ); ?></th>
					<td>
						<label for="thp_ysxfw_options[enable_home]">
							
							<input type="checkbox" id="thp_ysxfw_options[enable_home]" name="thp_ysxfw_options[enable_home]" value="1" <?php echo ($thp_ysxfw_no_options)? 'checked="checked"' : checked( '1', $thp_ysxfw_options['enable_home'], false ); ?>>
							
							<?php _e( "Enable on both homepage and front page?", 'you-save-x-for-woocommerce' ); ?>
						</label>
					</td>
					</tr>
					
					<tr><td></td></tr>
					
				</tbody>
				</table>
				
				<h3><?php _e( "Shop/Single Product", 'you-save-x-for-woocommerce' ); ?></h3>
				
				<p><?php _e( "Enable or disable You Save text badge on shop, product category, archive, and single product pages. You can also customize your text badge.", 'you-save-x-for-woocommerce' ); ?></p>
				
				<table class="form-table">
				<tbody>
					
					<tr>
					<th scope="row"><?php _e( "Shop:", 'you-save-x-for-woocommerce' ); ?></th>
					<td>
						<label for="thp_ysxfw_options[enable_shop]">
						
							<input type="checkbox" id="thp_ysxfw_options[enable_shop]" name="thp_ysxfw_options[enable_shop]" value="1" <?php echo ($thp_ysxfw_no_options)? 'checked="checked"' : checked( '1', $thp_ysxfw_options['enable_shop'], false ); ?>>
							
							<?php _e( "Enable on shop, product category, and product archive pages?", 'you-save-x-for-woocommerce' ); ?>
						</label>
					</td>
					</tr>
					
					<tr>
					<th scope="row"><?php _e( "Single product:", 'you-save-x-for-woocommerce' ); ?></th>
					<td>
						<label for="thp_ysxfw_options[enable_single]">
							
							<input type="checkbox" id="thp_ysxfw_options[enable_single]" name="thp_ysxfw_options[enable_single]" value="1" <?php echo ($thp_ysxfw_no_options)? 'checked="checked"' : checked( '1', $thp_ysxfw_options['enable_single'], false ); ?>>
							
							<?php _e( "Enable on single product pages?", 'you-save-x-for-woocommerce' ); ?>
						</label>
					</td>
					</tr>
					
					<tr>
					<th scope="row"><label for="thp_ysxfw_options[customtxt]"><?php _e( "Custom text:", 'you-save-x-for-woocommerce' ); ?></label></th>
					<td>
						<textarea id="thp_ysxfw_options[customtxt]" name="thp_ysxfw_options[customtxt]" placeholder="You save: [currency] ([percentage])"  maxlength="150"><?php echo (!empty($thp_ysxfw_options['customtxt'])) ? esc_textarea($thp_ysxfw_options['customtxt']) : ''; ?></textarea>
						
						<p class="description">
							<?php _e( "Your custom text to replace the default 'You save: USDx (x%)'.", 'you-save-x-for-woocommerce' ); ?><br />
							<?php echo wp_kses( __( 'Use <span class="thpys-shortcode">[currency]</span> for the currency amount. Use <span class="thpys-shortcode">[percentage]</span> for the percentage amount.', 'you-save-x-for-woocommerce' ), array( 'span' => array( 'class' => array() ) ) ); ?><br /><br />
							
							<?php _e( "Examples:", 'you-save-x-for-woocommerce' ); ?><br />
							
							<?php echo wp_kses( __( '<span class="thpys-example">You get [percentage] off!</span> will print <span class="thpys-example">You get 10% off!</span><br /><span class="thpys-example">You save [currency] on this item!</span> will print <span class="thpys-example">You save $10 on this item!</span>', 'you-save-x-for-woocommerce' ), array( 'br' => array(), 'span' => array( 'class' => array() ) ) ); ?>
						</p>
					</td>
					</tr>
					
					<tr><td></td></tr>
					
				</tbody>
				</table>
				
				<h3><?php _e( "Cart Items (Shortcode Cart Only)", 'you-save-x-for-woocommerce' ); ?></h3>
				
				<p><?php _e( "Enable or disable You Save text badge on cart table under each cart item. You can also customize your text. (Doesn't work on the new Woocommerce cart block.)", 'you-save-x-for-woocommerce' ); ?></p>
				
				<table class="form-table">
				<tbody>
				
				<tr>
					<th scope="row"><?php _e( "Cart items:", 'you-save-x-for-woocommerce' ); ?></th>
					<td>
						<label for="thp_ysxfw_options[enable_cartitem]">
							
							<input type="checkbox" id="thp_ysxfw_options[enable_cartitem]" name="thp_ysxfw_options[enable_cartitem]" value="1" <?php echo ($thp_ysxfw_no_options)? 'checked="checked"' : checked( '1', $thp_ysxfw_options['enable_cartitem'], false ); ?>>
							
							<?php _e( "Enable on cart, below price of each cart item?", 'you-save-x-for-woocommerce' ); ?>
						</label>
					</td>
					</tr>
					
					<tr>
					<th scope="row"><label for="thp_ysxfw_options[txtcarttable]"><?php _e( "Custom text:", 'you-save-x-for-woocommerce' ); ?></label></th>
					<td>
						<input id="thp_ysxfw_options[txtcarttable]" type="text" size="30" name="thp_ysxfw_options[txtcarttable]" placeholder="You save [currency]" value="<?php echo (!empty($thp_ysxfw_options['txtcarttable'])) ? esc_attr($thp_ysxfw_options['txtcarttable']) : ''; ?>" maxlength="150" />
						
						<p class="description">
							<?php _e( "Custom text to replace the default 'You save USDx' under each item in cart table.", 'you-save-x-for-woocommerce' ); ?><br />
							<?php echo wp_kses( __( 'Use <span class="thpys-shortcode">[currency]</span> for the currency amount.', 'you-save-x-for-woocommerce' ), array( 'span' => array( 'class' => array() ) ) ); ?>
						</p>
					</td>
					</tr>
					
					<tr><td></td></tr>
					
				</tbody>
				</table>
				
				<h3><?php _e( "Cart Totals (Shortcode Cart Only)", 'you-save-x-for-woocommerce' ); ?></h3>
				
				<p><?php _e( "Enable or disable You Save text badge on cart page under cart totals. You can also customize your text. (Doesn't work on the new Woocommerce cart block.)", 'you-save-x-for-woocommerce' ); ?></p>
				
				<table class="form-table thpys-last-table">
				<tbody>
				
				<tr>
					<th scope="row"><?php _e( "Cart totals:", 'you-save-x-for-woocommerce' ); ?></th>
					<td>
						<label for="thp_ysxfw_options[enable_carttotals]">
							
							<input type="checkbox" id="thp_ysxfw_options[enable_carttotals]" name="thp_ysxfw_options[enable_carttotals]" value="1" <?php echo ($thp_ysxfw_no_options)? 'checked="checked"' : checked( '1', $thp_ysxfw_options['enable_carttotals'], false ); ?>>
							
							<?php _e( "Enable on cart, after cart subtotal and total?", 'you-save-x-for-woocommerce' ); ?>
						</label>
					</td>
					</tr>
					
					<tr>
					<th scope="row"><label for="thp_ysxfw_options[txtcarttotal]"><?php _e( "Custom text:", 'you-save-x-for-woocommerce' ); ?></label></th>
					<td>
						<input id="thp_ysxfw_options[txtcarttotal]" type="text" size="30" name="thp_ysxfw_options[txtcarttotal]" placeholder="You Save" value="<?php echo (!empty($thp_ysxfw_options['txtcarttotal'])) ? esc_attr($thp_ysxfw_options['txtcarttotal']) : ''; ?>" maxlength="150" />
						
						<p class="description">
							<?php _e( "Custom text to replace the default 'You Save' on cart page under Total.", 'you-save-x-for-woocommerce' ); ?>
						</p>
					</td>
					</tr>
					
					<tr><td></td></tr>
					
				</tbody>
				</table>
				
				<?php if (thp_ysxfw_yspro_active()) { ?>
					<input type="hidden" name="action" value="update-thpys-options" />
					<input type="hidden" name="thp_ysxfw_options[indicator]" value="1" />
					
					<p>
						<input class="button-primary" type="submit" name="submit_ysfree" value="<?php _e( "Save changes", 'you-save-x-for-woocommerce' ); ?>" />
					</p>
				<?php 
				echo "</form>"; //closing form tag
				} //pro active ?>
				
				<details>
					<summary style="cursor: pointer;  font-size: 17px;border: 2px solid #c2c2bc;padding: 17px;background: #e2e2df;">
						<?php _e( "Styles and Appearances (PRO)", 'you-save-x-for-woocommerce' ); ?>
					</summary>
					
					<?php if (!thp_ysxfw_yspro_active()) { ?>
					
					<p style="margin: 30px 20px;">
						<?php _e( "Upgrade to PRO to have access to the features shown below!", 'you-save-x-for-woocommerce' ); ?>
						<a href="https://10horizonsplugins.com/plugin/woocommerce-you-save-plugin-for-wordpress-pro" target="_blank" rel="noopener" style="font-weight: bold;"><?php _e( "Upgrade to PRO now!", 'you-save-x-for-woocommerce' ); ?></a>
					</p>
					
					<img src="<?php echo plugin_dir_url( __FILE__ ).'images/ss-pro-design-promo_2.png'; ?>" style="width: 100%; border: 2px dashed #ccc;" />
					
					<?php } //pro not active 
					
					else if (thp_ysxfw_yspro_active()) {
						thp_yspro_main_settings();
					} ?>
					
				</details>
				
				<details style="margin-top: 5px;">
					<summary style="cursor: pointer;  font-size: 17px;border: 2px solid #c2c2bc;padding: 17px;background: #e2e2df;">
						<?php _e( "Our Shortcodes (PRO)", 'you-save-x-for-woocommerce' ); ?>
					</summary>
					
					<?php if (!thp_ysxfw_yspro_active()) { ?>
					
					<p style="margin: 30px 20px;">
						<?php _e( "Use shortcodes to display your 'You Save' text badge anywhere you want, like inside block editor, or other page builder elements. Upgrade to PRO to use shortcodes.", 'you-save-x-for-woocommerce' ); ?>
					</p>
					
					<p style="margin: 30px 20px;">
						<a href="https://10horizonsplugins.com/plugin/woocommerce-you-save-plugin-for-wordpress-pro" target="_blank" rel="noopener" style="font-weight: bold;"><?php _e( "Upgrade to PRO now!", 'you-save-x-for-woocommerce' ); ?></a>
					</p>
					
					<?php } //pro not active 
					
					else if (thp_ysxfw_yspro_active()) {
						thp_yspro_shortcodes_tab();
					} ?>
					
				</details>
				
				<?php if (!thp_ysxfw_yspro_active()) { ?>
					<input type="hidden" name="action" value="update-thpys-options" />
					<input type="hidden" name="thp_ysxfw_options[indicator]" value="1" />
					
					<p>
						<input class="button-primary" type="submit" name="submit_ysfree" value="<?php _e( "Save changes", 'you-save-x-for-woocommerce' ); ?>" />
					</p>
				<?php 
				echo "</form>"; //closing form tag 
				} //pro not active ?>