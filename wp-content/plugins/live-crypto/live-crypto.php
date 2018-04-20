<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * Dashboard. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @author 				Happyrobotstudio
 * @link 				http://happyrobotstudio.com
 * @since 				1.0.0
 * @package 			Live_Crypto
 *
 * @wordpress-plugin
 * Plugin Name: 			Live Crypto
 * Plugin URI: 			http://happyrobotstudio.com/
 * Description: 			Live crypto prices for wordpress
 * Version: 			1.0.0
 * Author: 				Happyrobotstudio
 * Author URI: 			http://happyrobotstudio.com/
 * License: 			Regular Licence
 * License URI: 			http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: 			live-crypto
 * Domain Path: 			/languages
 */

// If this file is called directly, abort
if ( ! defined( 'WPINC' ) ) {
	die;
}



// Used for referring to the plugin file or basename
if ( ! defined( 'LEGAL_POPUPFILE' ) ) {
	define( 'LEGAL_POPUPFILE', plugin_basename( __FILE__ ) );
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-live-crypto-activator.php
 */
function activate_Live_Crypto() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-live-crypto-activator.php';
	Live_Crypto_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-live-crypto-deactivator.php
 */
function deactivate_Live_Crypto() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-live-crypto-deactivator.php';
	Live_Crypto_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_Live_Crypto' );
register_deactivation_hook( __FILE__, 'deactivate_Live_Crypto' );

/**
 * The core plugin class that is used to define internationalization,
 * dashboard-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-live-crypto.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since 		1.0.0
 */
function run_Live_Crypto() {

	$plugin = new Live_Crypto();
	$plugin->run();

}
run_Live_Crypto();






/* 	WP_AJAX actions
	we are doing this here, as the namespace from within
	the class itself is hard to get right .. fix later on
*/

add_action("wp_ajax_livecryptoajax", "livecryptoajax");
add_action("wp_ajax_nopriv_livecryptoajax", "livecryptoajax");

function livecryptoajax() {

   if ( !wp_verify_nonce( $_REQUEST['nonce'], "livecryptoajax_nonce") ) {
      exit("");
   }


   /* Lets update the ACCEPT LOG */
   global $wpdb;
   require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

   $livecrypto_sql ="
		INSERT INTO  `".$wpdb->prefix."livecryptolog` (
			`id` ,
			`ip_address` ,
			`date_accepted`
		)
		VALUES (
			NULL ,
			'". $_SERVER['REMOTE_ADDR']. "',
			CURRENT_TIMESTAMP
		);
   ";

   $livecrypto_result = dbDelta($livecrypto_sql);

   var_dump($livecrypto_result);


   $result['type'] = "success";
   $result['vote_count'] = "1337";


   if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
      $result = json_encode($result);
      echo $result;
   }
   else {
      header("Location: ".$_SERVER["HTTP_REFERER"]);
   }

   die();

}
