<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://happyrobotstudio.com
 * @since      1.0.0
 *
 * @package    Live_Crypto
 * @subpackage Live_Crypto/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Live_Crypto
 * @subpackage Live_Crypto/public
 * @author     Happyrobotstudio <happyrobotstudio@gmail.com>
 */
class Live_Crypto_Public {

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
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		$this->set_options();
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Live_Crypto_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Live_Crypto_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/live-crypto-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Live_Crypto_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Live_Crypto_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */




		 // Import React for Crypto Tables


		 // cryptocompare API and SOCKET.IO
     	 wp_enqueue_script( 'socket-io', 'https://cdnjs.cloudflare.com/ajax/libs/socket.io/1.7.2/socket.io.js', array( ), '1.7.2', false );
		 wp_enqueue_script( 'crypto-api-helpers', plugin_dir_url( __FILE__ ) . 'js/live-crypto-crypto-api-helpers.js', array( ), '1.0.0.7', false );

		 // set up everything, subscribe to the api above
		 wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/live-crypto-public.js', array( 'jquery' ), $this->version, false );




	}




	/**
	 * Registers shortcodes
	 *
	 * @return
	 */
	public function register_shortcodes() {

		add_shortcode( 'cryptoprice', array( $this, 'output_crypto_price' ) );


	} // register_shortcodes()




	/**
	 * Processes shortcode
	 *
	 * @param   array	$atts		The attributes from the shortcode
	 *
	 * @uses	get_option
	 * @uses	get_layout
	 *
	 * @return	mixed	$output		Output of the buffer
	 */
	public function output_crypto_price( $atts ) {


		$_insymbol = $atts['insymbol'];
		$_outsymbol = $atts['outsymbol'];

		$_showsymbols = $atts['showsymbols'];
		$_showname = $atts['showname'];
		$_showpercentchange = $atts['showpercentchange'];
		$_showlogo = $atts['showlogo'];

		$_marketdata = $atts['marketdata'];

		$_exchange = $atts['exchange'];
		$_showexchange = $atts['showexchange'];


		$_type = $atts['type'];
		$_width = $atts['width'];

		// a fixed price conversion to USD
		$_outsymbolknownprice = $atts['outsymbolknownprice'];
		$_reverseknownprice = $atts['reverseknownprice'];
		if( $_outsymbolknownprice != "" ){
			$_outsymbolknownprice_label = $_outsymbol;
			$_outsymbol = "USD";
		}

		if( $_insymbol == "" ){ return 'Empty insymbol'; }
		if( $_outsymbol == "" ){ return 'Empty outsymbol'; }
		if( $_type == "" ) {   $_type = "small";   }
		if( $_width == "" ) {   $_width = "auto";   }
		if( is_numeric($_width) ) {   $_width = $_width . "px";   }


		// style elements
		$_pricecolor = $atts['pricecolor'];
		$_textcolor = $atts['textcolor'];
		$_datacolor = $atts['datacolor'];

		$_pricesize = $atts['pricesize'];
		$_textsize = $atts['textsize'];
		$_datasize = $atts['datasize'];


		$_updowncolor = $atts['updowncolor'];
		$_bordercolor = $atts['bordercolor'];
		$_bordersize = $atts['bordersize'];
		$_borderradius = $atts['borderradius'];

		$_backgroundcolor = $atts['backgroundcolor'];
		$_backgroundimage = $atts['backgroundimage'];

		$_logoimage = $atts['logoimage'];
		$_float = $atts['float'];
		$_margin = $atts['margin'];



		$output = "";




		$symbol_page = get_page_by_title($_insymbol, OBJECT, 'cryptosymbol');
		if( !$symbol_page ) { return 'Could not find this symbol, please run "Live Crypto -> Crypto Symbols -> Import Symbols" in wordpress admin'; }

		$symbol_coinname = trim( str_replace( "/","", get_post_meta( $symbol_page->ID, 'api_CoinName', true ) ) );
		$symbol_id = get_post_meta( $symbol_page->ID, 'api_Id', true );

		$symbol_img = "https://www.cryptocompare.com/" . get_post_meta( $symbol_page->ID, 'api_ImageUrl', true );





		$div_identity = "cprice-{$_insymbol}-{$_outsymbol}". (!empty($_exchange) ? "-".$_exchange."": "") ."";




		// output the structure of the crypto price
		$output .= "
				<div class='cprice cprice-".$_type."' style='width: {$_width}; ". ($_margin != "" ? "margin: {$_margin};": "") ." ". ($_float != "" ? "float: {$_float};": "") ." ". ($_backgroundcolor != "" ? "background-color: {$_backgroundcolor};": "") ." ". ($_backgroundimage != "" ? "background-image: url({$_backgroundimage}); background-size:cover; background-position:center center;": "") ." ". ($_bordercolor != "" ? "border-color: {$_bordercolor};": "") ." ". ($_bordersize != "" ? "border-style: solid; border-width: {$_bordersize};": "") ." ". ($_borderradius != "" ? "border-radius: {$_borderradius};": "") ." '>


					<div class='cprice-container {$div_identity}' data-identity='{$div_identity}' data-insym='{$_insymbol}' data-insymid='{$symbol_id}' data-otsym='{$_outsymbol}' ". (!empty($_exchange) ? "data-exchange='{$_exchange}'": "") .">

						". ($_showlogo != "false"  ? "<img class='cprice-logo' src='". ($_logoimage != "" ? "{$_logoimage}": "{$symbol_img}") ."' />" : "") ."


						<div class='cprice-price' style='". ($_pricecolor != "" ? "color: {$_pricecolor};": "") ." ". ($_pricesize != "" ? "font-size: {$_pricesize};": "") ."'>
							<span class='{$div_identity}-currencysymbol'>". ($_outsymbolknownprice != ""  ? "" :  get_fiat_currency_symbol($_outsymbol)) ."</span> <span class='{$div_identity}-PRICE PRICE' ". ($_outsymbolknownprice != ""  ? "data-knownpriceusd='{$_outsymbolknownprice}'" : "") ." ". ($_reverseknownprice != ""  ? "data-reverseknownpriceusd='{$_reverseknownprice}'" : "") ."></span>
						</div>


						<div class='cprice-name' style='". ($_textcolor != "" ? "color: {$_textcolor};": "") ." ". ($_textsize != "" ? "font-size: {$_textsize};": "") ."'>

								". ($_showsymbols != "false" ? "<span class='cprice-symbol SYMBOLS'>". ($_reverseknownprice != "" ? "{$_outsymbolknownprice_label}": "{$_insymbol}") ."</span><span class='cprice-separator'>/</span><span class='cprice-output-currency'>". ($_outsymbolknownprice != "" ? ($_reverseknownprice == "" ? $_outsymbolknownprice_label: $_insymbol) : "{$_outsymbol}") ."</span>": "") ."

								". ($_showname != "false" ? "<span class='{$div_identity}-name NAME'>{$symbol_coinname}</span>": "") ."

								". ($_showexchange != "false" && !empty($_exchange) ? "<span class='{$div_identity}-exchange EXCHANGE'>{$_exchange}</span>": "") ."

								". ($_showpercentchange != "false" ? "<span style='". ($_updowncolor != "" ? "color: {$_updowncolor} !important;": "") ."' class='{$div_identity}-CHANGE24HOURPCT CHANGE24HOURPCT'> </span>": "") ."
						</div>



						<div class='cprice-info'  style='". ($_datacolor != "" ? "color: {$_datacolor};": "") ." ". ($_datasize != "" ? "font-size: {$_datasize};": "") ."'>
							". (strpos($_marketdata, '24high') !== false ? "<div class='cprice-info-item'>24h High: <span class='{$div_identity}-HIGH24HOUR HIGH24HOUR'> </span></div>": "") ."
							". (strpos($_marketdata, '24low') !== false ? "<div class='cprice-info-item'>24h Low: <span class='{$div_identity}-LOW24HOUR LOW24HOUR'> </span></div>": "") ."
							". (strpos($_marketdata, '24open') !== false ? "<div class='cprice-info-item'>24h Open: <span class='{$div_identity}-OPEN24HOUR OPEN24HOUR'> </span></div>": "") ."
							". (strpos($_marketdata, '24change') !== false ? "<div class='cprice-info-item'>24h Change: <span class='{$div_identity}-CHANGE24HOUR CHANGE24HOUR'> </span></div>": "") ."
							". (strpos($_marketdata, '24changepct') !== false ? "<div class='cprice-info-item'>24h Change: <span class='{$div_identity}-CHANGE24HOURPCT CHANGE24HOURPCT'> </span></div>": "") ."
							". (strpos($_marketdata, '24volume') !== false ? "<div class='cprice-info-item'>24h Volume: <span class='{$div_identity}-VOLUME24HOUR VOLUME24HOUR'> </span></div>": "") ."
							". (strpos($_marketdata, 'lastmarket') !== false ? "<div class='cprice-info-item'>Last Market: <span class='{$div_identity}-LASTMARKET LASTMARKET'> </span></div>": "") ."
							". (strpos($_marketdata, 'lastmarketvol') !== false ? "<div class='cprice-info-item'>Last Market Vol: <span class='{$div_identity}-LASTVOLUME LASTVOLUME'> </span></div>": "") ."
							". (strpos($_marketdata, '1high') !== false ? "<div class='cprice-info-item'>1h High: <span class='{$div_identity}-HIGHHOUR HIGHHOUR'> </span></div>": "") ."
							". (strpos($_marketdata, '1low') !== false ? "<div class='cprice-info-item'>1h Low: <span class='{$div_identity}-LOWHOUR LOWHOUR'> </span></div>": "") ."
							". (strpos($_marketdata, '1open') !== false ? "<div class='cprice-info-item'>1h Open: <span class='{$div_identity}-OPENHOUR OPENHOUR'> </span></div>": "") ."
							". (strpos($_marketdata, '1volume') !== false ? "<div class='cprice-info-item'>1h Volume: <span class='{$div_identity}-VOLUMEHOUR VOLUMEHOUR'> </span></div>": "") ."
							". (strpos($_marketdata, 'lastupdated') !== false ? "<div class='cprice-info-item'>Last Time Updated: <span class='{$div_identity}-LASTUPDATE LASTUPDATE'> </span></div>": "") ."
						</div>

					</div>

				</div>
		";








		return $output;

	} // output_crypto_price()





	/**
	 * Sets the class variable $options
	 */
	private function set_options() {

		$this->options = get_option( $this->plugin_name . '-options' );

	} // set_options()



	/**
	 * Sets the class variable $options
	 */
	public function get_meta( $postobj ) {

		if ( empty( $postobj ) ) { return; }
		if ( 'livecrypto' != $postobj->post_type ) { return; }

		return get_post_custom( $postobj->ID );

	} // set_meta()




	/**
	 * Adds a default single view template for custom post type
	 *
	 * @param 	string 		$template 		The name of the template
	 * @return 	mixed 						The single template
	 */
	public function single_cpt_template( $template ) {

		global $post;

		$return = $template;

	    	if ( $post->post_type == 'livecrypto' ) {
			$return = "";
		}

		return $return;

	} // single_cpt_template()


















}
