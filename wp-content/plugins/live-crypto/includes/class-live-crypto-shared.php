<?php

/**
 * The public & admin-facing shared functionality of the plugin.
 *
 * @link 		http://happyrobotstudio.com
 * @since 		1.0.0
 *
 * @package 	Live_Crypto
 * @subpackage 	Live_Crypto/includes
 */

/**
 * The public & admin-facing shared functionality of the plugin.
 *
 * @package 	Live_Crypto
 * @subpackage 	Live_Crypto/includes
 * @author 		Happyrobotstudio <hello@happyrobotstudio.com>
 */

 // Prevent direct file access
if ( ! defined ( 'ABSPATH' ) ) { exit; }

class Live_Crypto_Shared {

	/**
	 * The ID of this plugin.
	 *
	 * @since 		1.0.0
	 * @access 		private
	 * @var 		string 			$plugin_name 		The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since 		1.0.0
	 * @access 		private
	 * @var 		string 			$version 			The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since 		1.0.0
	 * @param 		string 			$Live_Crypto 		The name of this plugin.
	 * @param 		string 			$version 			The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Flushes widget cache
	 *
	 * @since 		1.0.0
	 * @access 		public
	 * @param 		int 		$post_id 		The post ID
	 * @return 		void
	 */
	public function flush_widget_cache( $post_id ) {

		if ( wp_is_post_revision( $post_id ) ) { return; }

		$post = get_post( $post_id );

		if ( 'livecrypto' == $post->post_type ) {

			wp_cache_delete( $this->plugin_name, 'widget' );

		}

	} // flush_widget_cache()







	/**
	 * Registers widgets with WordPress
	 *
	 * @since 		1.0.0
	 * @access 		public
	 */
	public function widgets_init() {

		register_widget( 'live_crypto_widget' );

	} // widgets_init()

} // class
