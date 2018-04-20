<?php

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if (!function_exists('crypton_blog_live_crypto_theme_setup9')) {
	add_action( 'after_setup_theme', 'crypton_blog_live_crypto_theme_setup9', 9 );
	function crypton_blog_live_crypto_theme_setup9() {
		if (crypton_blog_exists_cryptocurrency_price_ticker_widget()) {

		}
		if (is_admin()) {
			add_filter( 'crypton_blog_filter_tgmpa_required_plugins',		'crypton_blog_live_crypto_tgmpa_required_plugins' );
		}
	}
}
// Filter to add in the required plugins list
if ( !function_exists( 'crypton_blog_live_crypto_tgmpa_required_plugins' ) ) {
	function crypton_blog_live_crypto_tgmpa_required_plugins($list=array()) {
		if (crypton_blog_storage_isset('required_plugins', 'live-crypto')) {
			$path = crypton_blog_get_file_dir('plugins/live-crypto/live-crypto.zip');
			if (!empty($path) || crypton_blog_get_theme_setting('tgmpa_upload')) {
				$list[] = array(
					'name' => crypton_blog_storage_get_array('required_plugins', 'live-crypto'),
					'slug' => 'live-crypto',
					'source'	=> !empty($path) ? $path : 'upload://live-crypto.zip',
					'required' => false
				);
			}
		}
		return $list;
	}
}

// Check if plugin installed and activated
if ( !function_exists( 'crypton_blog_exists_cryptocurrency_price_ticker_widget' ) ) {
	function crypton_blog_exists_cryptocurrency_price_ticker_widget() {
		return defined('LEGAL_POPUPFILE');
	}
}

?>