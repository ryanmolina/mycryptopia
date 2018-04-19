<?php

/**
 * Fired during plugin activation
 *
 * @link 		http://happyrobotstudio.com
 * @since 		1.0.0
 *
 * @package 	Live_Crypto
 * @subpackage 	Live_Crypto/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since 		1.0.0
 * @package 	Live_Crypto
 * @subpackage 	Live_Crypto/includes
 * @author 		Happyrobotstudio <hello@happyrobotstudio.com>
 */
class Live_Crypto_Activator {

	/**
	 * Declare custom post types, taxonomies, and plugin settings
	 * Flushes rewrite rules afterwards
	 *
	 * @since 		1.0.0
	 */
	public static function activate() {

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-live-crypto-admin.php';

		Live_Crypto_Admin::new_cpt_livecrypto();
		// Live_Crypto_Admin::new_taxonomy_type();
		Live_Crypto_Admin::create_db_tables();


		flush_rewrite_rules();

		$opts 		= array();
		$options 	= Live_Crypto_Admin::get_options_list();

		foreach ( $options as $option ) {

			$opts[ $option[0] ] = $option[2];

		}

		update_option( 'live-crypto-options', $opts );

		Live_Crypto_Admin::add_admin_notices();

	} // activate()
} // class
