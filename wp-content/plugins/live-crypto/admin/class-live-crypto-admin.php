<?php

/**
 * The dashboard-specific functionality of the plugin.
 *
 * @link 		http://happyrobotstudio.com
 * @since 		1.0.0
 *
 * @package 	Live_Crypto
 * @subpackage 	Live_Crypto/admin
 */

/**
 * The dashboard-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the dashboard-specific stylesheet and JavaScript.
 *
 * @package 	Live_Crypto
 * @subpackage 	Live_Crypto/admin
 * @author 		Happyrobotstudio <hello@happyrobotstudio.com>
 */
class Live_Crypto_Admin {

	/**
	 * The plugin options.
	 *
	 * @since 		1.0.0
	 * @access 		private
	 * @var 		string 			$options    The plugin options.
	 */
	private $options;

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

		$this->set_options();

	}

	/**
     * Adds notices for the admin to display.
     * Saves them in a temporary plugin option.
     * This method is called on plugin activation, so its needs to be static.
     */
    public static function add_admin_notices() {

    	$notices 	= get_option( 'live_crypto_deferred_admin_notices', array() );
  		//$notices[] 	= array( 'class' => 'updated', 'notice' => esc_html__( 'Live Crypto: Custom Activation Message', 'live-crypto' ) );
  		//$notices[] 	= array( 'class' => 'error', 'notice' => esc_html__( 'Live Crypto: Problem Activation Message', 'live-crypto' ) );

  		apply_filters( 'live_crypto_admin_notices', $notices );
  		update_option( 'live_crypto_deferred_admin_notices', $notices );

    } // add_admin_notices



	/**
	 * Adds a settings page link to a menu
	 *
	 * @link 		https://codex.wordpress.org/Administration_Menus
	 * @since 		1.0.0
	 * @return 		void
	 */
	public function add_menu() {

		// Top-level page
		// add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );

		// Submenu Page
		/* add_submenu_page( $parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function); */

		// add_submenu_page(
		// 	'edit.php?post_type=cryptosymbol',
		// 	apply_filters( $this->plugin_name . '-settings-page-title', esc_html__( 'Live Crypto Settings', 'live-crypto' ) ),
		// 	apply_filters( $this->plugin_name . '-settings-menu-title', esc_html__( 'Settings', 'live-crypto' ) ),
		// 	'manage_options',
		// 	$this->plugin_name . '-settings',
		// 	array( $this, 'page_options' )
		// );

		// add_submenu_page(
		// 	'edit.php?post_type=cryptosymbol',
		// 	apply_filters( $this->plugin_name . '-settings-page-title', esc_html__( 'Live Crypto Usage', 'live-crypto' ) ),
		// 	apply_filters( $this->plugin_name . '-settings-menu-title', esc_html__( 'Usage', 'live-crypto' ) ),
		// 	'manage_options',
		// 	$this->plugin_name . '-help',
		// 	array( $this, 'page_help' )
		// );

		add_submenu_page(
		 	'edit.php?post_type=cryptosymbol',
		 	apply_filters( $this->plugin_name . '-settings-page-title', esc_html__( 'Live Crypto Import Symbols', 'live-crypto' ) ),
		 	apply_filters( $this->plugin_name . '-settings-menu-title', esc_html__( 'Import Symbols', 'live-crypto' ) ),
		 	'manage_options',
		 	$this->plugin_name . '-importsymbols',
		 	array( $this, 'page_importsymbols' )
		);



		// remove menu items directly here if need be
		global $submenu;
		// unset($submenu["edit.php?post_type=cryptosymbol"][5]); // edit.php?post_type=cryptosymbol
		// unset($submenu["edit.php?post_type=cryptosymbol"][10]); // post-new.php?post_type=cryptosymbol
		//unset($submenu["edit.php?post_type=cryptosymbol"][11]); // post-new.php?post_type=cryptosymbol "Import Symbols, we dont need the menu link for this page"
		//
		//



	} // add_menu()

	/**
     * Manages any updates or upgrades needed before displaying notices.
     * Checks plugin version against version required for displaying
     * notices.
     */
	 public function admin_notices_init() {

         //
 		// if ( $this->version !== $current_version ) {
         //
 		// 	// Do whatever upgrades needed here.
         //
 		// 	update_option('my_plugin_version', $current_version);
         //
 		// 	//$this->add_notices_and_upgrade();
 		//
 		// 	  // undefined function left spare for any upgrade tasks and notices
 		// 	  // called upon 'admin_init' action in wordpress
         //
 		// }

 	} // admin_notices_init()

	/**
	 * Displays admin notices
	 *
	 * @return 	string 			Admin notices
	 */
	public function display_admin_notices() {

		$notices = get_option( 'live_crypto_deferred_admin_notices' );

		if ( empty( $notices ) ) { return; }

		foreach ( $notices as $notice ) {

			echo '<div class="' . esc_attr( $notice['class'] ) . '"><p>' . $notice['notice'] . '</p></div>';

		}

		delete_option( 'live_crypto_deferred_admin_notices' );

    } // display_admin_notices()

	/**
	 * Register the stylesheets for the Dashboard.
	 *
	 * @since 		1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/live-crypto-admin.css', array(), $this->version, 'all' );

	} // enqueue_styles()



	/**
	 * Register the JavaScript for the dashboard.
	 *
	 * @since 		1.0.0
	 */
	public function enqueue_scripts( $hook_suffix ) {

		global $post_type;

		$screen = get_current_screen();


		//echo  "<h1 style='padding:100px;'> $screen->id</h1>";
		// die();


		if ( 	$screen->id == "cryptosymbol_page_live-crypto-settings"
				|| 	$screen->id == "cryptosymbol_page_live-crypto-importsymbols"
				|| 	('cryptosymbol' == $post_type  &&  ($hook_suffix == 'post-new.php' || $hook_suffix == 'post.php' || $hook_suffix == 'edit.php') )
				|| 	('fiatsymbol' == $post_type  &&  ($hook_suffix == 'post-new.php' || $hook_suffix == 'post.php' || $hook_suffix == 'edit.php') )
			)
			{   //|| $screen->id === $hook_suffix



			// register AngularJS
			// wp_register_script($this->plugin_name . '-angular-core', 'https://ajax.googleapis.com/ajax/libs/angularjs/1.2.14/angular.js', array(), null, false);
			//
			// // register our app.js, which has a dependency on angular-core
			// wp_register_script($this->plugin_name . '-angular-app',  plugin_dir_url( __FILE__ ) . 'js/live-crypto-app.js', array(), null, false);
			//
			//
			// // enqueue all scripts
			// wp_enqueue_script($this->plugin_name . '-angular-core');
			// wp_enqueue_script($this->plugin_name . '-angular-app');
			//
			// // we need to create a JavaScript variable to store our API endpoint...
			// wp_localize_script($this->plugin_name . '-angular-core', 'AppAPI', array( 'url' => get_bloginfo('wpurl').'/api/') ); // this is the API address of the JSON API plugin
			// // ... and useful information such as the theme directory and website url
			// wp_localize_script($this->plugin_name . '-angular-core', 'BlogInfo', array( 'url' => get_bloginfo('template_directory').'/', 'site' => get_bloginfo('wpurl')) );






		//	wp_enqueue_script( $this->plugin_name . '-angular', plugin_dir_url( __FILE__ ) . 'js/' . $this->plugin_name . '-angular.js', array( 'jquery' ), $this->version, true );

			wp_enqueue_script( $this->plugin_name . '-fileuploader', plugin_dir_url( __FILE__ ) . 'js/' . $this->plugin_name . '-file-uploader.min.js', array( 'jquery' ), $this->version, true );
			//wp_enqueue_script( $this->plugin_name . '-repeater', plugin_dir_url( __FILE__ ) . 'js/' . $this->plugin_name . '-repeater.min.js', array( 'jquery' ), $this->version, true );
			wp_enqueue_script( $this->plugin_name . '-multiselect', plugin_dir_url( __FILE__ ) . 'js/' . $this->plugin_name . '-multiselect.js', array( 'jquery' ), $this->version, true );
			wp_enqueue_script( $this->plugin_name . '-colorselect', plugin_dir_url( __FILE__ ) . 'js/' . $this->plugin_name . '-colorselect.js', array( 'jquery' ), $this->version, true );

			wp_enqueue_script( $this->plugin_name . '-admin', plugin_dir_url( __FILE__ ) . 'js/' . $this->plugin_name . '-admin.js', array( 'jquery' ), $this->version, true );
			wp_enqueue_script( 'jquery-ui-datepicker' );

			$localize['repeatertitle'] = __( 'File Name', 'live-crypto' );
			wp_localize_script( 'live-crypto', 'nhdata', $localize );





		}

	} // enqueue_scripts()







	/**
	 * No crypto symbols existing message
	 *
	 * @since 		1.0.2
	 * @return 		void
	 */
	public function no_crypto_symbols_existing_message() {
		?>
		<div class="error notice">
		    <p>Live Crypto has no Crypto Symbols existing, please go to Crypto Symbols and Import.</p>
		</div>
		<?php
	}


	/**
	 * No Fiat symbols existing message
	 *
	 * @since 		1.0.2
	 * @return 		void
	 */
	public function no_fiat_symbols_existing_message() {
		?>
		<div class="error notice">
		    <p>Live Crypto has no Fiat Symbols existing, please go to Fiat Symbols and Import.</p>
		</div>
		<?php
	}








	/*  BEGIN METABOX FIELDS */

	/**
	 * Creates a colorselect field
	 *
	 * @param 	array 		$args 			The arguments for the field
	 * @return 	string 						The HTML field
	 */
	public function field_colorselect( $args ) {

		$defaults['class'] 			= 'colorselector';
		$defaults['description'] 	= '';
		$defaults['label'] 			= '';
		$defaults['name'] 			= $this->plugin_name . '-options[' . $args['id'] . ']';
		$defaults['placeholder'] 	= '';
		$defaults['type'] 			= 'text';
		$defaults['value'] 			= '';

		apply_filters( $this->plugin_name . '-field-colorselect-options-defaults', $defaults );

		$atts = wp_parse_args( $args, $defaults );

		if ( ! empty( $this->options[$atts['id']] ) ) {

			$atts['value'] = $this->options[$atts['id']];

		}

		include( plugin_dir_path( __FILE__ ) . 'partials/' . $this->plugin_name . '-admin-field-colorselect.php' );

	} // field_text()

	/**
	 * Creates a checkbox field
	 *
	 * @param 	array 		$args 			The arguments for the field
	 * @return 	string 						The HTML field
	 */
	public function field_checkbox( $args ) {

		$defaults['class'] 			= '';
		$defaults['description'] 	= '';
		$defaults['label'] 			= '';
		$defaults['name'] 			= $this->plugin_name . '-options[' . $args['id'] . ']';
		$defaults['value'] 			= 0;

		apply_filters( $this->plugin_name . '-field-checkbox-options-defaults', $defaults );

		$atts = wp_parse_args( $args, $defaults );

		if ( ! empty( $this->options[$atts['id']] ) ) {

			$atts['value'] = $this->options[$atts['id']];

		}

		include( plugin_dir_path( __FILE__ ) . 'partials/' . $this->plugin_name . '-admin-field-checkbox.php' );

	} // field_checkbox()


	/**
	 * Creates an editor field
	 *
	 * NOTE: ID must only be lowercase letter, no spaces, dashes, or underscores.
	 *
	 * @param 	array 		$args 			The arguments for the field
	 * @return 	string 						The HTML field
	 */
	public function field_editor( $args ) {

		$defaults['description'] 	= '';
		$defaults['settings'] 		= array( 'textarea_name' => $this->plugin_name . '-options[' . $args['id'] . ']' );
		$defaults['value'] 			= '';

		apply_filters( $this->plugin_name . '-field-editor-options-defaults', $defaults );

		$atts = wp_parse_args( $args, $defaults );

		if ( ! empty( $this->options[$atts['id']] ) ) {

			$atts['value'] = $this->options[$atts['id']];

		}

		include( plugin_dir_path( __FILE__ ) . 'partials/' . $this->plugin_name . '-admin-field-editor.php' );

	} // field_editor()

	/**
	 * Creates a set of radios field
	 *
	 * @param 	array 		$args 			The arguments for the field
	 * @return 	string 						The HTML field
	 */
	public function field_radios( $args ) {

		$defaults['class'] 			= '';
		$defaults['description'] 	= '';
		$defaults['label'] 			= '';
		$defaults['name'] 			= $this->plugin_name . '-options[' . $args['id'] . ']';
		$defaults['value'] 			= 0;

		apply_filters( $this->plugin_name . '-field-radios-options-defaults', $defaults );

		$atts = wp_parse_args( $args, $defaults );

		if ( ! empty( $this->options[$atts['id']] ) ) {

			$atts['value'] = $this->options[$atts['id']];

		}

		include( plugin_dir_path( __FILE__ ) . 'partials/' . $this->plugin_name . '-admin-field-radios.php' );

	} // field_radios()

	public function field_repeater( $args ) {

		$defaults['class'] 			= 'repeater';
		$defaults['fields'] 		= array();
		$defaults['id'] 			= '';
		$defaults['label-add'] 		= 'Add Item';
		$defaults['label-edit'] 	= 'Edit Item';
		$defaults['label-header'] 	= 'Item Name';
		$defaults['label-remove'] 	= 'Remove Item';
		$defaults['title-field'] 	= '';

/*
		$defaults['name'] 			= $this->plugin_name . '-options[' . $args['id'] . ']';
*/
		apply_filters( $this->plugin_name . '-field-repeater-options-defaults', $defaults );

		$setatts 	= wp_parse_args( $args, $defaults );
		$count 		= 1;
		$repeater 	= array();

		if ( ! empty( $this->options[$setatts['id']] ) ) {

			$repeater = maybe_unserialize( $this->options[$setatts['id']][0] );

		}

		if ( ! empty( $repeater ) ) {

			$count = count( $repeater );

		}

		include( plugin_dir_path( __FILE__ ) . 'partials/' . $this->plugin_name . '-admin-field-repeater.php' );

	} // field_repeater()

	/**
	 * Creates a select field
	 *
	 * Note: label is blank since its created in the Settings API
	 *
	 * @param 	array 		$args 			The arguments for the field
	 * @return 	string 						The HTML field
	 */
	public function field_select( $args ) {

		$defaults['aria'] 			= '';
		$defaults['blank'] 			= '';
		$defaults['class'] 			= '';
		$defaults['context'] 		= '';
		$defaults['description'] 	= '';
		$defaults['label'] 			= '';
		$defaults['name'] 			= $this->plugin_name . '-options[' . $args['id'] . ']';
		$defaults['selections'] 	= array();
		$defaults['value'] 			= '';

		apply_filters( $this->plugin_name . '-field-select-options-defaults', $defaults );

		$atts = wp_parse_args( $args, $defaults );

		if ( ! empty( $this->options[$atts['id']] ) ) {

			$atts['value'] = $this->options[$atts['id']];

			var_dump($atts['value']);

		}

		if ( empty( $atts['aria'] ) && ! empty( $atts['description'] ) ) {

			$atts['aria'] = $atts['description'];

		} elseif ( empty( $atts['aria'] ) && ! empty( $atts['label'] ) ) {

			$atts['aria'] = $atts['label'];

		}

		include( plugin_dir_path( __FILE__ ) . 'partials/' . $this->plugin_name . '-admin-field-select.php' );

	} // field_select()

	/**
	 * Creates a text field
	 *
	 * @param 	array 		$args 			The arguments for the field
	 * @return 	string 						The HTML field
	 */
	public function field_text( $args ) {

		$defaults['class'] 			= 'text';
		$defaults['description'] 	= '';
		$defaults['label'] 			= '';
		$defaults['name'] 			= $this->plugin_name . '-options[' . $args['id'] . ']';
		$defaults['placeholder'] 	= '';
		$defaults['type'] 			= 'text';
		$defaults['value'] 			= '';

		apply_filters( $this->plugin_name . '-field-text-options-defaults', $defaults );

		$atts = wp_parse_args( $args, $defaults );

		if ( ! empty( $this->options[$atts['id']] ) ) {

			$atts['value'] = $this->options[$atts['id']];

		}

		include( plugin_dir_path( __FILE__ ) . 'partials/' . $this->plugin_name . '-admin-field-text.php' );

	} // field_text()


	/**
	 * Creates a number field
	 *
	 * @param 	array 		$args 			The arguments for the field
	 * @return 	string 						The HTML field
	 */
	public function field_number( $args ) {

		$defaults['class'] 			= 'number';
		$defaults['description'] 	= '';
		$defaults['label'] 			= '';
		$defaults['name'] 			= $this->plugin_name . '-options[' . $args['id'] . ']';
		$defaults['placeholder'] 	= '';
		$defaults['type'] 			= 'number';
		$defaults['value'] 			= '';

		apply_filters( $this->plugin_name . '-field-number-options-defaults', $defaults );

		$atts = wp_parse_args( $args, $defaults );

		if ( ! empty( $this->options[$atts['id']] ) ) {

			$atts['value'] = $this->options[$atts['id']];

		}

		include( plugin_dir_path( __FILE__ ) . 'partials/' . $this->plugin_name . '-admin-field-number.php' );

	} // field_number()



	/**
	 * Creates a number decimal field
	 *
	 * @param 	array 		$args 			The arguments for the field
	 * @return 	string 						The HTML field
	 */
	public function field_numberdecimal( $args ) {

		$defaults['class'] 			= 'number';
		$defaults['description'] 	= '';
		$defaults['label'] 			= '';
		$defaults['name'] 			= $this->plugin_name . '-options[' . $args['id'] . ']';
		$defaults['placeholder'] 	= '';
		$defaults['type'] 			= 'number';
		$defaults['value'] 			= '';

		apply_filters( $this->plugin_name . '-field-numberdecimal-options-defaults', $defaults );

		$atts = wp_parse_args( $args, $defaults );

		if ( ! empty( $this->options[$atts['id']] ) ) {

			$atts['value'] = $this->options[$atts['id']];

		}

		include( plugin_dir_path( __FILE__ ) . 'partials/' . $this->plugin_name . '-admin-field-numberdecimal.php' );

	} // field_numberdecimal()





	/**
	 * Creates a textarea field
	 *
	 * @param 	array 		$args 			The arguments for the field
	 * @return 	string 						The HTML field
	 */
	public function field_textarea( $args ) {

		$defaults['class'] 			= 'large-text';
		$defaults['cols'] 			= 50;
		$defaults['context'] 		= '';
		$defaults['description'] 	= '';
		$defaults['label'] 			= '';
		$defaults['name'] 			= $this->plugin_name . '-options[' . $args['id'] . ']';
		$defaults['rows'] 			= 10;
		$defaults['value'] 			= '';

		apply_filters( $this->plugin_name . '-field-textarea-options-defaults', $defaults );

		$atts = wp_parse_args( $args, $defaults );

		if ( ! empty( $this->options[$atts['id']] ) ) {

			$atts['value'] = $this->options[$atts['id']];

		}

		include( plugin_dir_path( __FILE__ ) . 'partials/' . $this->plugin_name . '-admin-field-textarea.php' );

	} // field_textarea()



	/**
	 * Adds links to the plugin links row
	 *
	 * @since 		1.0.0
	 * @param 		array 		$links 		The current array of row links
	 * @param 		string 		$file 		The name of the file
	 * @return 		array 					The modified array of row links
	 */
	public function link_row( $links, $file ) {

		//if ( COIN_CHARTS_FILE === $file ) {

			// add a link in the plugin install area
			//   $links[] = '<a href="http://twitter.com/">Twitter</a>';

		//}

		return $links;

	} // link_row()

	/**
	 * Adds a link to the plugin settings page
	 *
	 * @since 		1.0.0
	 * @param 		array 		$links 		The current array of links
	 * @return 		array 					The modified array of links
	 */
	public function link_settings( $links ) {

		$links[] = sprintf( '<a href="%s">%s</a>', esc_url( admin_url( 'edit.php?post_type=livecrypto&page=' . $this->plugin_name . '-settings' ) ), esc_html__( 'Settings', 'live-crypto' ) );

		return $links;

	} // link_settings()



	/**
	 * Creates a new taxonomy for a custom post type
	 *
	 * @since 	1.0.0
	 * @access 	public
	 * @uses 	register_taxonomy()
	 */
	public static function create_db_tables() {

		global $wpdb;

		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

		$create_tables_sql="
			CREATE TABLE IF NOT EXISTS `".$wpdb->prefix."livecryptolog`
			(
				`id` bigint(20) NOT NULL auto_increment,
				`ip_address` varchar(255) NOT NULL,
				`date_accepted` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
			PRIMARY KEY  (`id`)
			);
		";

		dbDelta($create_tables_sql);



	} // create_db_tables()







	/**
	 * Creates a new custom post type
	 *
	 * @since 	1.0.0
	 * @access 	public
	 * @uses 	register_post_type()
	 */
	public static function new_cpt_livecrypto() {

		$cap_type = 'post';
		$menu_name = 'Live Crypto';
		$plural = 'Crypto Symbols';
		$single = 'Crypto Symbol';
		$cpt_name = 'cryptosymbol';

		$opts['can_export']								= TRUE;
		$opts['capability_type']						= $cap_type;
		$opts['description']							= '';
		$opts['exclude_from_search']					= TRUE;
		$opts['has_archive']							= TRUE;
		$opts['hierarchical']							= TRUE;
		$opts['map_meta_cap']							= TRUE;
		$opts['menu_icon']								= 	plugin_dir_url( __FILE__ ) . 'assets/the_menu_icon.png';
		$opts['menu_position']							= 75;
		$opts['public']									= FALSE; //TRUE;
		$opts['publicly_querable']						= FALSE; //TRUE;
		$opts['query_var']								= TRUE;
		$opts['register_meta_box_cb']					= '';
		$opts['rewrite']								= FALSE;
		$opts['show_in_admin_bar']						= TRUE;
		$opts['show_in_menu']							= TRUE;
		$opts['show_in_nav_menu']						= TRUE;
		$opts['show_ui']								= TRUE;
		$opts['supports']								= array( 'title', 'thumbnail' ); //, 'editor', 'page-attributes'  ); //, 'thumbnail' );
		$opts['taxonomies']								= array();

		$opts['capabilities']['delete_others_posts']	= "delete_others_{$cap_type}s";
		$opts['capabilities']['delete_post']			= "delete_{$cap_type}";
		$opts['capabilities']['delete_posts']			= "delete_{$cap_type}s";
		$opts['capabilities']['delete_private_posts']	= "delete_private_{$cap_type}s";
		$opts['capabilities']['delete_published_posts']	= "delete_published_{$cap_type}s";
		$opts['capabilities']['edit_others_posts']		= "edit_others_{$cap_type}s";
		$opts['capabilities']['edit_post']				= "edit_{$cap_type}";
		$opts['capabilities']['edit_posts']				= "edit_{$cap_type}s";
		$opts['capabilities']['edit_private_posts']		= "edit_private_{$cap_type}s";
		$opts['capabilities']['edit_published_posts']	= "edit_published_{$cap_type}s";
		$opts['capabilities']['publish_posts']			= "publish_{$cap_type}s";
		$opts['capabilities']['read_post']				= "read_{$cap_type}";
		$opts['capabilities']['read_private_posts']		= "read_private_{$cap_type}s";
		$opts['capabilities']['create_posts']			= FALSE; // disable adding new posts directly, we will update CRYPTO symbols via API call

		$opts['labels']['add_new']						= esc_html__( "Add New {$single}", 'live-crypto' );
		$opts['labels']['add_new_item']					= esc_html__( "Add New {$single}", 'live-crypto' );
		$opts['labels']['all_items']					= esc_html__( $plural, 'live-crypto' );
		$opts['labels']['edit_item']					= esc_html__( "Edit {$single}" , 'live-crypto' );
		$opts['labels']['menu_name']					= esc_html__( $menu_name, 'live-crypto' );
		$opts['labels']['name']							= esc_html__( $plural, 'live-crypto' );
		$opts['labels']['name_admin_bar']				= esc_html__( $single, 'live-crypto' );
		$opts['labels']['new_item']						= esc_html__( "New {$single}", 'live-crypto' );
		$opts['labels']['not_found']					= esc_html__( "No {$plural} Found", 'live-crypto' );
		$opts['labels']['not_found_in_trash']			= esc_html__( "No {$plural} Found in Trash", 'live-crypto' );
		$opts['labels']['parent_item_colon']			= esc_html__( "Parent {$plural} :", 'live-crypto' );
		$opts['labels']['search_items']					= esc_html__( "Search {$plural}", 'live-crypto' );
		$opts['labels']['singular_name']				= esc_html__( $single, 'live-crypto' );
		$opts['labels']['view_item']					= esc_html__( "View {$single}", 'live-crypto' );
		//
		// $opts['rewrite']['ep_mask']						= EP_PERMALINK;
		// $opts['rewrite']['feeds']						= FALSE;
		// $opts['rewrite']['pages']						= TRUE;
		// $opts['rewrite']['slug']						= esc_html__( strtolower( $plural ), 'live-crypto' );
		// $opts['rewrite']['with_front']					= FALSE;

		$opts = apply_filters( 'live-crypto-cpt-options', $opts );

		register_post_type( strtolower( $cpt_name ), $opts );

	} // new_cpt_livecrypto()



	/**
	 * Creates a new taxonomy for our first post type
	 *
	 * @since 	1.0.0
	 * @access 	public
	 * @uses 	register_taxonomy()
	 */
	public static function new_taxonomy_type() {


		$plural 	= 'Symbol Types';
		$single 	= 'Symbol Type';
		$tax_name 	= 'livecrypto_type';

		$opts['hierarchical']							= TRUE;
		//$opts['meta_box_cb'] 							= '';
		$opts['public']									= TRUE;
		$opts['query_var']								= $tax_name;
		$opts['show_admin_column'] 						= FALSE;
		$opts['show_in_nav_menus']						= TRUE;
		$opts['show_tag_cloud'] 						= TRUE;
		$opts['show_ui']								= TRUE;
		$opts['sort'] 									= '';
		//$opts['update_count_callback'] 					= '';

		$opts['capabilities']['assign_terms'] 			= 'edit_posts';
		$opts['capabilities']['delete_terms'] 			= 'manage_categories';
		$opts['capabilities']['edit_terms'] 			= 'manage_categories';
		$opts['capabilities']['manage_terms'] 			= 'manage_categories';

		$opts['labels']['add_new_item'] 				= esc_html__( "Add New {$single}", 'live-crypto' );
		$opts['labels']['add_or_remove_items'] 			= esc_html__( "Add or remove {$plural}", 'live-crypto' );
		$opts['labels']['all_items'] 					= esc_html__( $plural, 'live-crypto' );
		$opts['labels']['choose_from_most_used'] 		= esc_html__( "Choose from most used {$plural}", 'live-crypto' );
		$opts['labels']['edit_item'] 					= esc_html__( "Edit {$single}" , 'live-crypto');
		$opts['labels']['menu_name'] 					= esc_html__( $plural, 'live-crypto' );
		$opts['labels']['name'] 						= esc_html__( $plural, 'live-crypto' );
		$opts['labels']['new_item_name'] 				= esc_html__( "New {$single} Name", 'live-crypto' );
		$opts['labels']['not_found'] 					= esc_html__( "No {$plural} Found", 'live-crypto' );
		$opts['labels']['parent_item'] 					= esc_html__( "Parent {$single}", 'live-crypto' );
		$opts['labels']['parent_item_colon'] 			= esc_html__( "Parent {$single}:", 'live-crypto' );
		$opts['labels']['popular_items'] 				= esc_html__( "Popular {$plural}", 'live-crypto' );
		$opts['labels']['search_items'] 				= esc_html__( "Search {$plural}", 'live-crypto' );
		$opts['labels']['separate_items_with_commas'] 	= esc_html__( "Separate {$plural} with commas", 'live-crypto' );
		$opts['labels']['singular_name'] 				= esc_html__( $single, 'live-crypto' );
		$opts['labels']['update_item'] 					= esc_html__( "Update {$single}", 'live-crypto' );
		$opts['labels']['view_item'] 					= esc_html__( "View {$single}", 'live-crypto' );

		// $opts['rewrite']['ep_mask']					= EP_NONE;
		// $opts['rewrite']['hierarchical']				= FALSE;
		// $opts['rewrite']['slug']						= esc_html__( strtolower( $tax_name ), 'live-crypto' );
		// $opts['rewrite']['with_front']				= FALSE;

		$opts = apply_filters( 'live-crypto-taxonomy-options', $opts );

		register_taxonomy( $tax_name, 'livecrypto', $opts );


	} // new_taxonomy_type()






	/**
	 * Creates custom columns for our first post type
	 *
	 * @since 	1.0.0
	 * @access 	public
	 */
	// public static function new_cpt_columns( $columns ) {
	//
	// 	$columns['duration'] = 'Duration';
	//
	// 	return $columns;
	// }
	//
	// public static function new_cpt_manage_columns( $column, $post_id ) {
	//
	//
	// 	switch( $column ) {
	//
	// 		/* If displaying the 'duration' column. */
	// 		case 'duration' :
	//
	// 			/* Get the post meta. */
	// 			//$duration = get_post_meta( $post_id, 'duration', true );
	// 			echo 'duration';
	//
	// 			break;
	//
	// 		default :
	// 			break;
	// 	}
	// }




	/**
	 * Creates a new (second) custom post type
	 *
	 * @since 	1.0.0
	 * @access 	public
	 * @uses 	register_post_type()
	 */
	public static function new_cpt_livecrypto2() {

		$cap_type = 'post';
		$menu_name = 'MENU UNUSED';
		$plural = 'Fiat Symbols';
		$single = 'Fiat Symbol';
		$cpt_name = 'fiatsymbol';

		$opts['can_export']								= TRUE;
		$opts['capability_type']						= $cap_type;
		$opts['description']							= '';
		$opts['exclude_from_search']					= TRUE;
		$opts['has_archive']							= TRUE;
		$opts['hierarchical']							= TRUE;
		$opts['map_meta_cap']							= TRUE;
		$opts['menu_icon']								= 	plugin_dir_url( __FILE__ ) . 'assets/the_menu_icon.png';
		$opts['menu_position']							= 75;
		$opts['public']									= FALSE; //TRUE;
		$opts['publicly_querable']						= FALSE; //TRUE;
		$opts['query_var']								= TRUE;
		$opts['register_meta_box_cb']					= '';
		$opts['rewrite']								= FALSE;
		$opts['show_in_admin_bar']						= TRUE;
		$opts['show_in_menu']							= 'edit.php?post_type=cryptosymbol';
		$opts['show_in_nav_menu']						= TRUE;
		$opts['show_ui']								= TRUE;
		$opts['supports']								= array( 'title', 'thumbnail' ); //, 'editor', 'page-attributes'  ); //, 'thumbnail' );
		$opts['taxonomies']								= array();

		$opts['capabilities']['delete_others_posts']	= "delete_others_{$cap_type}s";
		$opts['capabilities']['delete_post']			= "delete_{$cap_type}";
		$opts['capabilities']['delete_posts']			= "delete_{$cap_type}s";
		$opts['capabilities']['delete_private_posts']	= "delete_private_{$cap_type}s";
		$opts['capabilities']['delete_published_posts']	= "delete_published_{$cap_type}s";
		$opts['capabilities']['edit_others_posts']		= "edit_others_{$cap_type}s";
		$opts['capabilities']['edit_post']				= "edit_{$cap_type}";
		$opts['capabilities']['edit_posts']				= "edit_{$cap_type}s";
		$opts['capabilities']['edit_private_posts']		= "edit_private_{$cap_type}s";
		$opts['capabilities']['edit_published_posts']	= "edit_published_{$cap_type}s";
		$opts['capabilities']['publish_posts']			= "publish_{$cap_type}s";
		$opts['capabilities']['read_post']				= "read_{$cap_type}";
		$opts['capabilities']['read_private_posts']		= "read_private_{$cap_type}s";
		$opts['capabilities']['create_posts']			= TRUE; //FALSE; // disable adding new posts directly

		$opts['labels']['add_new']						= esc_html__( "Add New {$single}", 'live-crypto' );
		$opts['labels']['add_new_item']					= esc_html__( "Add New {$single}", 'live-crypto' );
		$opts['labels']['all_items']					= esc_html__( $plural, 'live-crypto' );
		$opts['labels']['edit_item']					= esc_html__( "Edit {$single}" , 'live-crypto' );
		$opts['labels']['menu_name']					= esc_html__( $menu_name, 'live-crypto' );
		$opts['labels']['name']							= esc_html__( $plural, 'live-crypto' );
		$opts['labels']['name_admin_bar']				= esc_html__( $single, 'live-crypto' );
		$opts['labels']['new_item']						= esc_html__( "New {$single}", 'live-crypto' );
		$opts['labels']['not_found']					= esc_html__( "No {$plural} Found", 'live-crypto' );
		$opts['labels']['not_found_in_trash']			= esc_html__( "No {$plural} Found in Trash", 'live-crypto' );
		$opts['labels']['parent_item_colon']			= esc_html__( "Parent {$plural} :", 'live-crypto' );
		$opts['labels']['search_items']					= esc_html__( "Search {$plural}", 'live-crypto' );
		$opts['labels']['singular_name']				= esc_html__( $single, 'live-crypto' );
		$opts['labels']['view_item']					= esc_html__( "View {$single}", 'live-crypto' );
		//
		// $opts['rewrite']['ep_mask']					= EP_PERMALINK;
		// $opts['rewrite']['feeds']					= FALSE;
		// $opts['rewrite']['pages']					= TRUE;
		// $opts['rewrite']['slug']						= esc_html__( strtolower( $plural ), 'live-crypto' );
		// $opts['rewrite']['with_front']				= FALSE;

		$opts = apply_filters( 'live-crypto-cpt-options2', $opts );

		register_post_type( strtolower( $cpt_name ), $opts );

	} // new_cpt_livecrypto2()



	/**
	 * Creates a new taxonomy for a (second) custom post type
	 *
	 * @since 	1.0.0
	 * @access 	public
	 * @uses 	register_taxonomy()
	 */
	public static function new_taxonomy_type2() {


		return; // taxonomy not required for mega footer



		$plural 	= 'Symbol Types';
		$single 	= 'Symbol Type';
		$tax_name 	= 'livecrypto_type';

		$opts['hierarchical']							= TRUE;
		//$opts['meta_box_cb'] 							= '';
		$opts['public']									= TRUE;
		$opts['query_var']								= $tax_name;
		$opts['show_admin_column'] 						= FALSE;
		$opts['show_in_nav_menus']						= TRUE;
		$opts['show_tag_cloud'] 						= TRUE;
		$opts['show_ui']								= TRUE;
		$opts['sort'] 									= '';
		//$opts['update_count_callback'] 					= '';

		$opts['capabilities']['assign_terms'] 			= 'edit_posts';
		$opts['capabilities']['delete_terms'] 			= 'manage_categories';
		$opts['capabilities']['edit_terms'] 			= 'manage_categories';
		$opts['capabilities']['manage_terms'] 			= 'manage_categories';

		$opts['labels']['add_new_item'] 				= esc_html__( "Add New {$single}", 'live-crypto' );
		$opts['labels']['add_or_remove_items'] 			= esc_html__( "Add or remove {$plural}", 'live-crypto' );
		$opts['labels']['all_items'] 					= esc_html__( $plural, 'live-crypto' );
		$opts['labels']['choose_from_most_used'] 		= esc_html__( "Choose from most used {$plural}", 'live-crypto' );
		$opts['labels']['edit_item'] 					= esc_html__( "Edit {$single}" , 'live-crypto');
		$opts['labels']['menu_name'] 					= esc_html__( $plural, 'live-crypto' );
		$opts['labels']['name'] 						= esc_html__( $plural, 'live-crypto' );
		$opts['labels']['new_item_name'] 				= esc_html__( "New {$single} Name", 'live-crypto' );
		$opts['labels']['not_found'] 					= esc_html__( "No {$plural} Found", 'live-crypto' );
		$opts['labels']['parent_item'] 					= esc_html__( "Parent {$single}", 'live-crypto' );
		$opts['labels']['parent_item_colon'] 			= esc_html__( "Parent {$single}:", 'live-crypto' );
		$opts['labels']['popular_items'] 				= esc_html__( "Popular {$plural}", 'live-crypto' );
		$opts['labels']['search_items'] 				= esc_html__( "Search {$plural}", 'live-crypto' );
		$opts['labels']['separate_items_with_commas'] 	= esc_html__( "Separate {$plural} with commas", 'live-crypto' );
		$opts['labels']['singular_name'] 				= esc_html__( $single, 'live-crypto' );
		$opts['labels']['update_item'] 					= esc_html__( "Update {$single}", 'live-crypto' );
		$opts['labels']['view_item'] 					= esc_html__( "View {$single}", 'live-crypto' );

		// $opts['rewrite']['ep_mask']						= EP_NONE;
		// $opts['rewrite']['hierarchical']				= FALSE;
		// $opts['rewrite']['slug']						= esc_html__( strtolower( $tax_name ), 'live-crypto' );
		// $opts['rewrite']['with_front']					= FALSE;

		$opts = apply_filters( 'live-crypto-taxonomy-options', $opts );

		register_taxonomy( $tax_name, 'livecrypto', $opts );


	} // new_taxonomy_type2()




	/**
	 * Creates the help page
	 *
	 * @since 		1.0.0
	 * @return 		void
	 */
	public function page_help() {

		include( plugin_dir_path( __FILE__ ) . 'partials/live-crypto-admin-page-help.php' );

	} // page_help()



	/**
	 * Creates the importsymbols page
	 *
	 * @since 		1.0.0
	 * @return 		void
	 */
	public function page_importsymbols() {

		include( plugin_dir_path( __FILE__ ) . 'partials/live-crypto-admin-page-importsymbols.php' );

	} // page_importsymbols()



	/**
	 * Creates the options page
	 *
	 * @since 		1.0.0
	 * @return 		void
	 */
	public function page_options() {

		include( plugin_dir_path( __FILE__ ) . 'partials/live-crypto-admin-page-settings.php' );

	} // page_options()





	/**
	 * Returns an array of options names, fields types, and default values
	 *
	 * @return 		array 			An array of options
	 */
	public static function get_options_list() {

		$options = array();



		$options[] = array( 'live-crypto-cookie-expiry-days', 	'textarea', '' );
		$options[] = array( 'live-crypto-reject-location', 		'textarea', '' );



		// $options[] = array( 'text-test', 'text', 'Thank you for your interest! There are no livecrypto openings at this time.' );
		// $options[] = array( 'editor-test', 'editor', '' );
		// $options[] = array( 'repeater-test', 'repeater', array( array( 'test1', 'text' ), array( 'test2', 'text' ), array( 'test3', 'text' ) ) );

		return $options;

	} // get_options_list()



	/**
	 * Registers settings fields with WordPress
	 */
	public function register_fields() {

		// add_settings_field( $id, $title, $callback, $menu_slug, $section, $args );



		add_settings_field(
			'live-crypto-cryptolist',
			apply_filters( $this->plugin_name . 'label-live-crypto-cryptolist', esc_html__( 'Symbols', 'live-crypto' ) ),
			array( $this, 'field_textarea' ),
			$this->plugin_name,
			$this->plugin_name . '-cryptosection',
			array(
				'units' 		=> 'days',
				'description' 	=> 'The list of CRYPTO currencies available for use',
				'id' 			=> 'live-crypto-cryptolist',
				'value' 		=> '',
			)
		);



		add_settings_field(
			'live-crypto-fiatlist',
			apply_filters( $this->plugin_name . 'label-live-crypto-fiatlist', esc_html__( 'Symbols', 'live-crypto' ) ),
			array( $this, 'field_textarea' ),
			$this->plugin_name,
			$this->plugin_name . '-fiatsection',
			array(
				'units' 		=> 'days',
				'description' 	=> 'The list of FIAT currencies available for use',
				'id' 			=> 'live-crypto-fiatlist',
				'value' 		=> '',
			)
		);





	} // register_fields()




	/**
	 * Registers settings sections with WordPress
	 */
	public function register_sections() {

		// add_settings_section( $id, $title, $callback, $menu_slug );

		add_settings_section(
			$this->plugin_name . '-cryptosection',
			apply_filters( $this->plugin_name . 'section-title-messages', esc_html__( 'Crypto Currencies', 'live-crypto' ) ),
			array( $this, 'section_adminsettings' ),
			$this->plugin_name
		);

		add_settings_section(
			$this->plugin_name . '-fiatsection',
			apply_filters( $this->plugin_name . 'section-title-messages', esc_html__( 'Fiat Currencies', 'live-crypto' ) ),
			array( $this, 'section_adminsettings' ),
			$this->plugin_name
		);





	} // register_sections()

	/**
	 * Registers plugin settings
	 *
	 * @since 		1.0.0
	 * @return 		void
	 */
	public function register_settings() {

		// register_setting( $option_group, $option_name, $sanitize_callback );

		register_setting(
			$this->plugin_name . '-options',
			$this->plugin_name . '-options',
			array( $this, 'validate_options' )
		);

	} // register_settings()

	private function sanitizer( $type, $data ) {

		if ( empty( $type ) ) { return; }
		if ( empty( $data ) ) { return; }

		$return 	= '';
		$sanitizer 	= new Live_Crypto_Sanitize();

		$sanitizer->set_data( $data );
		$sanitizer->set_type( $type );

		$return = $sanitizer->clean();

		unset( $sanitizer );

		return $return;

	} // sanitizer()

	/**
	 * Creates a settings section
	 *
	 * @since 		1.0.0
	 * @param 		array 		$params 			Array of parameters for the section
	 * @return 		mixed 						The settings section
	 */
	public function section_adminsettings( $params ) {

		include( plugin_dir_path( __FILE__ ) . 'partials/live-crypto-admin-section-messages.php' );

	} // section_adminsettings()

	/**
	 * Sets the class variable $options
	 */
	private function set_options() {

		$this->options = get_option( $this->plugin_name . '-options' );

	} // set_options()

	/**
	 * Validates saved options
	 *
	 * @since 		1.0.0
	 * @param 		array 		$input 			array of submitted plugin options
	 * @return 		array 						array of validated plugin options
	 */
	public function validate_options( $input ) {

		//wp_die( print_r( $input ) );

		$valid 		= array();
		$options 	= $this->get_options_list();


		foreach ( $options as $option ) {

			$name = $option[0];
			$type = $option[1];


			if ( 'repeater' === $type && is_array( $option[2] ) ) {

				$clean = array();

				foreach ( $option[2] as $field ) {

					foreach ( $input[$field[0]] as $data ) {

						if ( empty( $data ) ) { continue; }

						$clean[$field[0]][] = $this->sanitizer( $field[1], $data );

					} // foreach

				} // foreach

				$count = live_crypto_get_max( $clean );

				for ( $i = 0; $i < $count; $i++ ) {

					foreach ( $clean as $field_name => $field ) {

						$valid[$option[0]][$i][$field_name] = $field[$i];

					} // foreach $clean

				} // for

			} else {

				$valid[$option[0]] = $this->sanitizer( $type, $input[$name] );

			}

			/*if ( ! isset( $input[$option[0]] ) ) { continue; }

			$sanitizer = new Live_Crypto_Sanitize();

			$sanitizer->set_data( $input[$option[0]] );
			$sanitizer->set_type( $option[1] );

			$valid[$option[0]] = $sanitizer->clean();

			if ( $valid[$option[0]] != $input[$option[0]] ) {

				add_settings_error( $option[0], $option[0] . '_error', esc_html__( $option[0] . ' error.', 'live-crypto' ), 'error' );

			}

			unset( $sanitizer );*/

		}

		return $valid;

	} // validate_options()

} // class
