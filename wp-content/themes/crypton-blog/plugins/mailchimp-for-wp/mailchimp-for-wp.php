<?php
/* Mail Chimp support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if (!function_exists('crypton_blog_mailchimp_theme_setup9')) {
	add_action( 'after_setup_theme', 'crypton_blog_mailchimp_theme_setup9', 9 );
	function crypton_blog_mailchimp_theme_setup9() {
		if (crypton_blog_exists_mailchimp()) {
			add_action( 'wp_enqueue_scripts',							'crypton_blog_mailchimp_frontend_scripts', 1100 );
			add_filter( 'crypton_blog_filter_merge_styles',					'crypton_blog_mailchimp_merge_styles');
		}
		if (is_admin()) {
			add_filter( 'crypton_blog_filter_tgmpa_required_plugins',		'crypton_blog_mailchimp_tgmpa_required_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'crypton_blog_mailchimp_tgmpa_required_plugins' ) ) {
	//Handler of the add_filter('crypton_blog_filter_tgmpa_required_plugins',	'crypton_blog_mailchimp_tgmpa_required_plugins');
	function crypton_blog_mailchimp_tgmpa_required_plugins($list=array()) {
		if (crypton_blog_storage_isset('required_plugins', 'mailchimp-for-wp')) {
			$list[] = array(
				'name' 		=> crypton_blog_storage_get_array('required_plugins', 'mailchimp-for-wp'),
				'slug' 		=> 'mailchimp-for-wp',
				'required' 	=> false
			);
		}
		return $list;
	}
}

// Check if plugin installed and activated
if ( !function_exists( 'crypton_blog_exists_mailchimp' ) ) {
	function crypton_blog_exists_mailchimp() {
		return function_exists('__mc4wp_load_plugin') || defined('MC4WP_VERSION');
	}
}



// Custom styles and scripts
//------------------------------------------------------------------------

// Enqueue custom styles
if ( !function_exists( 'crypton_blog_mailchimp_frontend_scripts' ) ) {
	//Handler of the add_action( 'wp_enqueue_scripts', 'crypton_blog_mailchimp_frontend_scripts', 1100 );
	function crypton_blog_mailchimp_frontend_scripts() {
		if (crypton_blog_exists_mailchimp()) {
			if (crypton_blog_is_on(crypton_blog_get_theme_option('debug_mode')) && crypton_blog_get_file_dir('plugins/mailchimp-for-wp/mailchimp-for-wp.css')!='')
				wp_enqueue_style( 'crypton_blog-mailchimp-for-wp',  crypton_blog_get_file_url('plugins/mailchimp-for-wp/mailchimp-for-wp.css'), array(), null );
		}
	}
}
	
// Merge custom styles
if ( !function_exists( 'crypton_blog_mailchimp_merge_styles' ) ) {
	//Handler of the add_filter( 'crypton_blog_filter_merge_styles', 'crypton_blog_mailchimp_merge_styles');
	function crypton_blog_mailchimp_merge_styles($list) {
		$list[] = 'plugins/mailchimp-for-wp/mailchimp-for-wp.css';
		return $list;
	}
}


// Add plugin-specific colors and fonts to the custom CSS
if (crypton_blog_exists_mailchimp()) { require_once CRYPTON_BLOG_THEME_DIR . 'plugins/mailchimp-for-wp/mailchimp-for-wp.styles.php'; }
?>