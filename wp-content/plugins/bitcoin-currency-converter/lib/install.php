<?php



	/* ------------------------------*/

	/* INSTALL/UNINSTALL */

	/* ------------------------------*/

	

	add_action( 'wp_head', 'bitcoin_calculator_head_css_jq' );

	

	function bitcoin_calculator_head_css_jq() 

	{

		$url = plugins_url();

	?>

		

        <link rel="stylesheet" type="text/css" href="<?php echo $url."/bitcoin-currency-converter/css/bitcoin-calculator.css" ?>"/>

        

 	<?php

	

	}

	

	// Add settings on activate.

	

	add_action('admin_init', 'bitcoin_calculator_plugin_install');


	function bitcoin_calculator_plugin_install()
	{
		register_setting('bitcoin_calculator_options', 'bitcoin_calculator_options');
	}

	

	// Unregister settings on deactivate.

	

	add_action('admin_init', 'bitcoin_calculator_plugin_unininstall');

	function bitcoin_calculator_plugin_unininstall ()

	{

		unregister_setting('bitcoin_calculator_options', 'bitcoin_calculator_options');

	}



	// Create admin page.
	

	add_action('admin_menu','create_bitcoin_calculator_admin');

	

	function create_bitcoin_calculator_admin ()

	{

		$mypage = add_options_page("Bitcoin Calculator Options", "Bitcoin Calculator Settings", 10, "bitcoin_calculator_settings_page", "bitcoin_calculator_html");

	}

	

	add_action('admin_init', 'add_bitcoin_calculator_options');

	

	function add_bitcoin_calculator_options()

	{

		// feed settings

		add_settings_section('bitcoin_calculator_section', 'Bitcoin Calculator Settings', 'sctn_bitcoin_calculator', 'bitcoin_calculator_settings_page');

		add_settings_field('bitcoin_calculator_dropdown_currency', 'Default calculator currency', 'set_bitcoin_calculator_dropdown', 'bitcoin_calculator_settings_page', 'bitcoin_calculator_section');

				

	}

	

	function sctn_bitcoin_calculator ()

	{

		echo "<p>Choose which currency to use on the converter by default.</p>";

	}


	// Widgetise the plugin for sidebar.

		 

	function widget_bitcoin_calculator($args) {

		

		bitcion_calculator_widget();

	}

	 

	function bitcoinCalculatorWidget_init()

	{

	  register_sidebar_widget(__('Bitcoin Calculator Widget'), 'widget_bitcoin_calculator');     

	}

	

	add_action("plugins_loaded", "bitcoinCalculatorWidget_init");

	

	//shortcode

	

	

	function bitcoin_currency_calculator_fn( $attributes ) {

	    return bitcion_calculator_widget();

	}

	

	add_shortcode( 'bitcoin-currency-calculator','bitcoin_currency_calculator_fn' );

	

	

?>