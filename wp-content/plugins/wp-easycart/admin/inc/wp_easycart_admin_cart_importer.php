<?php
class wp_easycart_admin_cart_importer{
	
	private $wpdb;
	
	public $cart_importer_file;
	public $settings_file;
		
	public function __construct( ){
		// Keep reference to wpdb
		global $wpdb;
		$this->wpdb =& $wpdb;
		
		// Setup File Names 
		$this->oscommerce_import_file	 	= WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/admin/template/settings/cart-importer/oscommerce-import.php';
		$this->woo_import_file	 			= WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/admin/template/settings/cart-importer/woo-import.php';
		$this->settings_file		 		= WP_PLUGIN_DIR . "/" . EC_PLUGIN_DIRECTORY . '/admin/template/settings/cart-importer/settings.php';
		
		// Actions
		//add_action( 'wpeasycart_admin_cart_importer', array( $this, 'load_success_messages' ) );
		add_action( 'wpeasycart_admin_cart_importer', array( $this, 'load_woo_importer' ) );
		add_action( 'wpeasycart_admin_cart_importer', array( $this, 'load_oscommerce_importer' ) );
		add_action( 'init', array( $this, 'save_settings' ) );
	}
	
	public function load_cart_importer( ){
		include( $this->settings_file );
	}
	
	public function load_success_messages( ){
		//include( $this->success_messages_file );
	}
	
	public function load_woo_importer( ){
		include( $this->woo_import_file );
	}
	public function load_oscommerce_importer( ){
		include( $this->oscommerce_import_file );
	}
	
	
	public function save_woo_importer_settings( ) {
		


	}
	
	public function save_oscommerce_importer_settings( ) {



	}
	
	public function save_settings( ){
		
	}
	
}

add_action( 'wp_ajax_ec_admin_ajax_save_woo_importer', 'ec_admin_ajax_save_woo_importer' );
function ec_admin_ajax_save_woo_importer( ){
	$woo_importer = new wp_easycart_admin_cart_importer( );
	$woo_importer->save_woo_importer_settings( );
	die( );
}
add_action( 'wp_ajax_ec_admin_ajax_save_oscommerce_importer', 'ec_admin_ajax_save_oscommerce_importer' );
function ec_admin_ajax_save_oscommerce_importer( ){
	$woo_importer = new wp_easycart_admin_cart_importer( );
	$woo_importer->save_oscommerce_importer_settings( );
	die( );
}