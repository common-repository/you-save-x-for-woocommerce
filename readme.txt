=== You Save for Woocommerce ===
Contributors: tentenbiz
Donate link: https://wproot.dev/tips-and-donation/
Tags: you save, save, discount, deals, sale
Requires at least: 6.5
Tested up to: 6.6.2
Stable tag: 1.0.1
License: GPLv3
License URI: https://www.gnu.org/licenses/gpl-3.0.html

Convince your customers they have a good deal on your store by showing them how much they save on each product and deals.

== Description ==

A lightweight Woocommerce extension to display how much your customers save on products. Amounts can be shown in currency and in percentage on shop pages, single product pages, and in cart. Convince your customers they have a good deal on your store by showing them how much they save.

You can easily enable or disable "You Save" badges on Woocommerce pages that you want or don't want. Scroll down for screenshots.

[ [Live Demo](https://yousavedemo.10horizonsplugins.com/) ]

[ [Upgrade to PRO for more features](https://10horizonsplugins.com/plugin/woocommerce-you-save-plugin-for-wordpress-pro) ]

## How it works

The plugin will show something like this on your store under product price (you can change these texts in the plugin's settings page):

- You save 24%
- You save $10.90
- You save $10.90 (24%)

If you are using custom third party plugins to generate discounts and sales, it might or might not work with this plugin.

### How the calculation is done?

This plugin calculates the difference between a product's **regular price** and its **sale price**. 

The regular price and sale price are taken from product data, which is a Woocommerce core feature (***Product edit screen > Product data > General***). 

### On which Woocommerce pages this is shown?

- Shop/product category/product archive pages
- Single product pages
- In cart (on each item in cart)
- Below cart totals
- Checkout page before placing an order
- Order detail page after order is received
- View order page

You can easily enable or disable "You Save" badges on any of the pages above. Go to ***Woocommerce > You Save*** to configure settings.

## Compatibility with Woocommerce cart/checkout blocks 

Our plugin now **works** with:

- The new checkout block (scroll down to see screenshot number 4 and 5)
- As for Woocommerce cart block, Woocommerce core already has this feature
- Classic Woocommerce cart that uses Woocommerce shortcode `[woocommerce_cart]`
- Classic checkout that uses Woocommerce shortcode `[woocommerce_checkout]`
 

Our plugin is supposed to work as expected on **single product pages**, **shop page**, and **product category/archive pages**. If it doesn't, use our shortcode when you build your page. 

## Shortcodes

You can use shortcodes to display your "You Save" text badge anywhere you want it, like inside block editor, or other page builder elements. Please [upgrade to PRO](https://10horizonsplugins.com/plugin/woocommerce-you-save-plugin-for-wordpress-pro) to use shortcodes.

== Installation ==

1. Upload plugin folder to `/wp-content/plugins/` directory, or install the plugin from your WordPress dashboard `Plugins > Add New`.
2. Activate the plugin.
3. Go to `Woocommerce > You Save` to configure settings.

== Frequently Asked Questions ==

= Does this plugin have shortcodes? =

Yes. You have to [upgrade to PRO](https://10horizonsplugins.com/plugin/woocommerce-you-save-plugin-for-wordpress-pro) to use the shortcodes.

= How do I put the 'You save' badge on my product thumbnails to make it more noticeable? =

We have this feature on the PRO version of the plugin. Please [upgrade to PRO](https://10horizonsplugins.com/plugin/woocommerce-you-save-plugin-for-wordpress-pro).

= Does this plugin work with Woocommerce cart and checkout blocks? =

Our plugin works with Woocommerce checkout block. Just add the block from your block page editor when editing your Checkout page. As for Woocommerce cart block, Woocommerce core already has this feature.

= How can I translate the 'You save' text to my language? =

You can either use the .pot file translation in the /languages directory, or just translate the text from the plugin's main settings: Dashboard > Woocommerce > You Save. 

= How do I change or customize the 'You save' text? =

Go to the plugin's main settings: Dashboard > Woocommerce > You Save, you will be able to edit the text from this page.

= Something is not working! Who can I contact? =

You can create a thread here on the plugin's WordPress.org forum.

== Screenshots ==

1. Single product page.
2. Shop page.
3. Cart page (for cart that uses classic Woocommerce shortcode).
4. Checkout page (for cart that uses Woocommerce checkout block).
5. Adding our block to Woocommerce checkout block page in block editor.
6. Checkout page (for checkout page that uses classic Woocommerce shortcode).
7. Order detail page after order is received (for checkout that uses Woocommerce shortcode only).
8. View order page (for checkout that uses Woocommerce shortcode only).
9. Settings page.

== Changelog ==

= 1.0.1 =
* Fixed save amount and percentage not showing for affiliate/external product.

= 1.0.0 =
* Revamped UI/UX of plugin's main settings page.
* Changed how pro settings are accessed from settings page.
* Replaced thpys-options.php file with main-options.php with new include structure.
* Updated language file.

= 0.5.9 =
* Added block compatibility for Woocommerce checkout block.
* Removed admin warning about block compatibility.
* Tweaked settings page.

= 0.5.5 =
* Added admin notice about compatibility with Woocommerce cart and checkout block.
* Minor change of settings page, terms and wording change. Added link to Woocommerce cart and checkout block compatibility.
* Updated screenshots.

= 0.5.4 =
* Settings page minor revamp.
* Finetuned compatibility to pro.
* Making free version leaner, removed shadow styling options.

= 0.5.3 =
* Added additional check to catch fatal error for amount saved calculation functions.
* Tweaked option pages.

= 0.5.2 =
* Integrated compatibility to pro.
* Added colon symbol to badge's custom text on checkout and view order page.

= 0.4.2 =
* Fixed border shadow style not appearing on the front end.
* Added an option to enable/disable 'you save' badge on homepage/frontpage.
* Added 'you save' text to checkout page, order detail page after order is received, view order page.
* Tweaked js for slightly faster ajax call on the frontend.

= 0.4.1 =
* Improved sanitation, validation, and escaping.

= 0.4.0 =
* Added styling options for users to easily style the You Save text badge.
* Integrated PRO features for more usability.

= 0.3.0 =
* Added new options to easily translate and edit texts.
* Restructured and improved user interface for plugin main settings.
* Enabled all options by default for first time plugin activation.
* Finetuned PRO compatibility.

= 0.2.2 =
* Added translation file .pot.
* Added PRO compatibility.

= 0.2.1 =
* Added settings to enable/disable 'you save' on certain Woocommerce pages. 
* Added PRO compatibility.

= 0.1.0 =
* Initial release.

== Upgrade Notice ==

= 1.0.1 =
* Please upgrade!