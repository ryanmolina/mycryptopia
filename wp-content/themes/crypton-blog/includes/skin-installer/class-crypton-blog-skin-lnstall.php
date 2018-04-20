<?php

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'Crypton_Blog_Theme_Updater' ) ) {

	if ( ! class_exists( 'WP_Upgrader_Skin' ) ) {
		include_once( ABSPATH . 'wp-admin/includes/class-wp-upgrader-skin.php' );
		include_once( ABSPATH . 'wp-admin/includes/class-wp-upgrader.php' );
		include_once( CRYPTON_BLOG_THEME_DIR . 'includes/skin-installer/class-crypton-blog-upgrader-skin.php' );
	}


	class Crypton_Blog_Skin_Install{

		/**
		 * Updater settings.
		 *
		 * @var array
		 */
		protected $settings = array();

		/**
		 * A reference to an instance of this class.
		 *
		 * @since 1.0.0
		 * @var   object
		 */
		private static $instance = null;

		/**
		 * Init class parameters.
		 *
		 * @since  1.0.0
		 */
		public function __construct() {
			add_filter( 'crypton_blog_skin_list', array( $this, 'return_skin_list' ) );
			add_action( 'admin_post_install_skin', array( $this, 'lnstall_skin' ) );
		}

		public function return_skin_list() {
			$json = $this->get_skin_list( CRYPTON_BLOG_THEME_DIR . 'includes/skin-installer/config.json' );

			if( ! $json || empty( $json['skins'] ) ){
				return;
			}

			$action_url = get_site_url() . '/wp-admin/admin-post.php';
			$first_checked = true;

			$output_html = '<form method="POST" name="skin-installer" enctype="multipart/form-data" id="skin-installer" action="' . $action_url . '">';
			$output_html .= '<div class="crypton_blog_about_block_description">' . esc_html__('Select skins: ', 'crypton-blog') . '</div>';
			$output_html .= '<input name="action" type="hidden" value="install_skin">';
			$output_html .= '<input name="action_nonce" type="hidden" value="' . wp_create_nonce( 'install_skin_nonce' ) . '">';
			$output_html .= '<ul class="skin-list">';

			foreach ( $json['skins'] as $key => $value) {
				$theme = wp_get_theme( $key);

				$theme_is_installed = 'publish' === $theme->get('Status') ? 'disabled': '' ;
				$value = $theme_is_installed ? $value . esc_html__( ' ( Installed )', 'crypton-blog' ) : $value ;
				$checked = '';
				if( $first_checked && 'disabled' !== $theme_is_installed ) {
					$checked = 'checked';
					$first_checked = false;
				}

				$img_href = get_template_directory_uri() . '/includes/skin-installer/img/' . $key . '.jpg';
				$output_html .= sprintf('<li><input type="radio" name="theme_skin" value="%1$s" id="%1$s" %3$s %4$s><label for="%1$s"><img src="%5$s" alt="%2$s">%2$s</label></li>', $key, $value, $checked, $theme_is_installed, $img_href );

			}
			$disabled_button = $first_checked ? 'disabled': '' ;

			$output_html .= '</ul>';
			$output_html .= '<hr>';
			$output_html .= '<button class="button button-primary skin-installer" type="submit" form="skin-installer" ' . $disabled_button . '>' . esc_html__('Install Skin', 'crypton-blog') . '</button>';
			$output_html .= '</form>';

			return $output_html;
		}

		private function get_skin_list( $json_dir ) {

			if ( ! file_exists( $json_dir ) ) {
				die( 'Dos not exist config file.' );

				return false;
			}

			return json_decode( file_get_contents( $json_dir ), true );
		}

		public function lnstall_skin() {
			$theme_slug = empty( $_POST['theme_skin'] ) ? false :  $_POST['theme_skin'];

			if( ! $theme_slug || ! wp_verify_nonce( $_POST['action_nonce'], 'install_skin_nonce') ){
				return;
			}

			$sub_domen = ( 'crypton-blog' === $theme_slug ) ? 'cryptonblog' : $theme_slug . '.cryptonblog' ;

			$url = sprintf( 'http://%1$s.themerex.net/demo/%2$s.zip', $sub_domen, $theme_slug );
			$nonce = 'install-theme_' . $theme_slug;
			$upgrader = new Theme_Upgrader( new Crypton_Blog_Upgrader_Skin( compact( 'url', 'nonce' ) ) );

			$install_result = $upgrader->run( array(
				'package' => $url,
				'destination' => get_theme_root(),
				'clear_destination' => false, //Do not overwrite files.
				'clear_working' => true,
				'hook_extra' => array(
					'type' => 'theme',
					'action' => 'install',
				),
			) );

			if( is_wp_error( $install_result ) ){
				$redirect_url = admin_url( 'themes.php' );
			}else{
				switch_theme( $install_result['destination_name'] );
			}

			update_option( 'crypton_blog_about_page', 0 );
			wp_safe_redirect( admin_url().'themes.php?page=crypton_blog_about' );
			exit();
		}

		/**
		 * Returns the instance.
		 *
		 * @since  1.0.0
		 * @return object
		 */
		public static function get_instance() {
			// If the single instance hasn't been set, set it now.
			if ( null == self::$instance ) {
				self::$instance = new self();
			}
			return self::$instance;
		}
	}

	/**
	 * Returns instanse.
	 *
	 * @since  1.0.0
	 * @return object
	 */
	function crypton_blog_skin_install() {
		return Crypton_Blog_Skin_Install::get_instance();
	}
	crypton_blog_skin_install();
}
