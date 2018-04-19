<?php
/**
 * Globally-accessible functions
 *
 * @link 		http://happyrobotstudio.com
 * @since 		1.0.0
 *
 * @package		Live_Crypto
 * @subpackage 	Live_Crypto/includes
 */



/**
 * Returns the result of the get_max global function
 */
function live_crypto_get_max( $array ) {

	return Live_Crypto_Globals::get_max( $array );

}

/**
 * Returns the result of the get_svg global function
 */
function live_crypto_get_svg( $svg ) {

	return Live_Crypto_Globals::get_svg( $svg );

}

/**
 * Returns the result of the get_template global function
 */
function live_crypto_get_template( $name ) {

	return Live_Crypto_Globals::get_template( $name );

}


/**
 * Crypto currency functions
 */
function crypto_symbols( $name ) {

	return Live_Crypto_Globals::crypto_symbols();

}
function get_fiat_currency_symbol( $fiat_country_code ) {

	return Live_Crypto_Globals::get_fiat_currency_symbol( $fiat_country_code );

}










class Live_Crypto_Globals {

	/**
	 * Returns the count of the largest arrays
	 *
	 * @param 		array 		$array 		An array of arrays to count
	 * @return 		int 					The count of the largest array
	 */
 	public static function get_max( $array ) {

 		if ( empty( $array ) ) { return '$array is empty!'; }

 		$count = array();

		foreach ( $array as $name => $field ) {

			$count[$name] = count( $field );

		} //

		$count = max( $count );

		return $count;

 	} // get_max()

 	/**
 	 * Returns the requested SVG.
 	 *
 	 * @param 		string 		$svg 		The name of an SVG
 	 * @return 		mixed 					The SVG code
 	 */
 	public static function get_svg( $svg ) {

 		$return = '';

		switch ( $svg ) {

			case 'drag': $return = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" class="drag" height="20px" width="20px"><path d="M19.7 10.5l-2.8 2.8c-.1.1-.3.2-.5.2-.4 0-.7-.3-.7-.7v-1.4h-4.3v4.3h1.4c.4 0 .7.3.7.7 0 .2-.1.4-.2.5l-2.8 2.8c-.1.1-.3.2-.5.2s-.4-.1-.5-.2l-2.8-2.8c-.1-.1-.2-.3-.2-.5 0-.4.3-.7.7-.7h1.4v-4.3H4.3v1.4c0 .4-.3.7-.7.7-.2 0-.4-.1-.5-.2L.3 10.5c-.1-.1-.2-.3-.2-.5s.1-.4.2-.5l2.8-2.8c.1-.1.3-.2.5-.2.4 0 .7.3.7.7v1.4h4.3V4.3H7.2c-.4 0-.7-.3-.7-.7 0-.2.1-.4.2-.5L9.5.3c.1-.1.3-.2.5-.2s.4.1.5.2l2.8 2.8c.1.1.2.3.2.5 0 .4-.3.7-.7.7h-1.4v4.3h4.3V7.2c0-.4.3-.7.7-.7.2 0 .4.1.5.2l2.8 2.8c.1.1.2.3.2.5s0 .4-.2.5z"/></svg>'; break;

		} // switch

		return $return;

 	} // get_svg()

 	/**
	 * Returns the path to a template file
	 *
	 * Looks for the file in these directories, in this order:
	 * 		Current theme
	 * 		Parent theme
	 * 		Current theme templates folder
	 * 		Parent theme templates folder
	 * 		This plugin
	 *
	 * To use a custom list template in a theme, copy the
	 * file from public/templates into a templates folder in your
	 * theme. Customize as needed, but keep the file name as-is. The
	 * plugin will automatically use your custom template file instead
	 * of the ones included in the plugin.
	 *
	 * @param 	string 		$name 			The name of a template file
	 * @return 	string 						The path to the template
	 */
 	public static function get_template( $name ) {

 		$template = '';

		$locations[] = "{$name}.php";
		$locations[] = "/templates/{$name}.php";

		/**
		 * Filter the locations to search for a template file
		 *
		 * @param 	array 		$locations 			File names and/or paths to check
		 */
		apply_filters( 'live-crypto-template-paths', $locations );

		$template = locate_template( $locations, TRUE );

		if ( empty( $template ) ) {

			$template = plugin_dir_path( dirname( __FILE__ ) ) . 'public/templates/' . $name . '.php';

		}

		return $template;

 	} // get_template()





	/**
	 * Symbol API
	 *
	 * Lists all available symbols
	 *
	 * @return 	array 							An array of all available currencies
	 */
 	public static function crypto_symbols( ) {

		$output = "";
		$output .= "<h3>Available Crypto Currencies</h3>";

		// cryptocompare
		//
		$cryptocompare_source ="https://www.cryptocompare.com/api/data/coinlist/";
		$cryptocompare_json = "";

		$cryptocompare_ch = curl_init($cryptocompare_source);
		curl_setopt($cryptocompare_ch, CURLOPT_RETURNTRANSFER, true);
		if( ($cryptocompare_json = curl_exec($cryptocompare_ch) ) === false) {   $output .= 'error: ' . curl_error($cryptocompare_ch);   }
		curl_close($cryptocompare_ch);

		$cryptocompare_json = json_decode( $cryptocompare_json, true );
		$cryptocompare_json = $cryptocompare_json["Data"];

		ksort($cryptocompare_json);

		return $cryptocompare_json;

	}



	/**
	 * Price API
	 *
	 * Get an individual price in the format CRYPTO/FIAT
	 *
	 * @param 	string 		$insymbol 			The name of a crypto-currency eg BTC/ETH
	 * @param 	string 		$outsymbol 			The name of a currency eg USD/EUR
	 * @param 	string 		$crypto_exchange 			The name of a desired exchange, or else use average
	 * @return 	float 							The latest price of the symbol pair
	 */
 	public static function get_fiat_currency_symbol( $fiat_country_code ) {


		 $fiat_currency_symbols = array(
		    'AED' => '&#1583;.&#1573;', // ?
		    'AFN' => '&#65;&#102;',
		    'ALL' => '&#76;&#101;&#107;',
		    'AMD' => '',
		    'ANG' => '&#402;',
		    'AOA' => '&#75;&#122;', // ?
		    'ARS' => '&#36;',
		    'AUD' => '&#36;',
		    'AWG' => '&#402;',
		    'AZN' => '&#1084;&#1072;&#1085;',
		    'BAM' => '&#75;&#77;',
		    'BBD' => '&#36;',
		    'BDT' => '&#2547;', // ?
		    'BGN' => '&#1083;&#1074;',
		    'BHD' => '.&#1583;.&#1576;', // ?
		    'BIF' => '&#70;&#66;&#117;', // ?
		    'BMD' => '&#36;',
		    'BND' => '&#36;',
		    'BOB' => '&#36;&#98;',
		    'BRL' => '&#82;&#36;',
		    'BSD' => '&#36;',
		    'BTN' => '&#78;&#117;&#46;', // ?
		    'BWP' => '&#80;',
		    'BYR' => '&#112;&#46;',
		    'BZD' => '&#66;&#90;&#36;',
		    'CAD' => '&#36;',
		    'CDF' => '&#70;&#67;',
		    'CHF' => '&#67;&#72;&#70;',
		    'CLF' => '', // ?
		    'CLP' => '&#36;',
		    'CNY' => '&#165;',
		    'COP' => '&#36;',
		    'CRC' => '&#8353;',
		    'CUP' => '&#8396;',
		    'CVE' => '&#36;', // ?
		    'CZK' => '&#75;&#269;',
		    'DJF' => '&#70;&#100;&#106;', // ?
		    'DKK' => '&#107;&#114;',
		    'DOP' => '&#82;&#68;&#36;',
		    'DZD' => '&#1583;&#1580;', // ?
		    'EGP' => '&#163;',
		    'ETB' => '&#66;&#114;',
		    'EUR' => '&#8364;',
		    'FJD' => '&#36;',
		    'FKP' => '&#163;',
		    'GBP' => '&#163;',
		    'GEL' => '&#4314;', // ?
		    'GHS' => '&#162;',
		    'GIP' => '&#163;',
		    'GMD' => '&#68;', // ?
		    'GNF' => '&#70;&#71;', // ?
		    'GTQ' => '&#81;',
		    'GYD' => '&#36;',
		    'HKD' => '&#36;',
		    'HNL' => '&#76;',
		    'HRK' => '&#107;&#110;',
		    'HTG' => '&#71;', // ?
		    'HUF' => '&#70;&#116;',
		    'IDR' => '&#82;&#112;',
		    'ILS' => '&#8362;',
		    'INR' => '&#8377;',
		    'IQD' => '&#1593;.&#1583;', // ?
		    'IRR' => '&#65020;',
		    'ISK' => '&#107;&#114;',
		    'JEP' => '&#163;',
		    'JMD' => '&#74;&#36;',
		    'JOD' => '&#74;&#68;', // ?
		    'JPY' => '&#165;',
		    'KES' => '&#75;&#83;&#104;', // ?
		    'KGS' => '&#1083;&#1074;',
		    'KHR' => '&#6107;',
		    'KMF' => '&#67;&#70;', // ?
		    'KPW' => '&#8361;',
		    'KRW' => '&#8361;',
		    'KWD' => '&#1583;.&#1603;', // ?
		    'KYD' => '&#36;',
		    'KZT' => '&#1083;&#1074;',
		    'LAK' => '&#8365;',
		    'LBP' => '&#163;',
		    'LKR' => '&#8360;',
		    'LRD' => '&#36;',
		    'LSL' => '&#76;', // ?
		    'LTL' => '&#76;&#116;',
		    'LVL' => '&#76;&#115;',
		    'LYD' => '&#1604;.&#1583;', // ?
		    'MAD' => '&#1583;.&#1605;.', //?
		    'MDL' => '&#76;',
		    'MGA' => '&#65;&#114;', // ?
		    'MKD' => '&#1076;&#1077;&#1085;',
		    'MMK' => '&#75;',
		    'MNT' => '&#8366;',
		    'MOP' => '&#77;&#79;&#80;&#36;', // ?
		    'MRO' => '&#85;&#77;', // ?
		    'MUR' => '&#8360;', // ?
		    'MVR' => '.&#1923;', // ?
		    'MWK' => '&#77;&#75;',
		    'MXN' => '&#36;',
		    'MYR' => '&#82;&#77;',
		    'MZN' => '&#77;&#84;',
		    'NAD' => '&#36;',
		    'NGN' => '&#8358;',
		    'NIO' => '&#67;&#36;',
		    'NOK' => '&#107;&#114;',
		    'NPR' => '&#8360;',
		    'NZD' => '&#36;',
		    'OMR' => '&#65020;',
		    'PAB' => '&#66;&#47;&#46;',
		    'PEN' => '&#83;&#47;&#46;',
		    'PGK' => '&#75;', // ?
		    'PHP' => '&#8369;',
		    'PKR' => '&#8360;',
		    'PLN' => '&#122;&#322;',
		    'PYG' => '&#71;&#115;',
		    'QAR' => '&#65020;',
		    'RON' => '&#108;&#101;&#105;',
		    'RSD' => '&#1044;&#1080;&#1085;&#46;',
		    'RUB' => '&#1088;&#1091;&#1073;',
		    'RWF' => '&#1585;.&#1587;',
		    'SAR' => '&#65020;',
		    'SBD' => '&#36;',
		    'SCR' => '&#8360;',
		    'SDG' => '&#163;', // ?
		    'SEK' => '&#107;&#114;',
		    'SGD' => '&#36;',
		    'SHP' => '&#163;',
		    'SLL' => '&#76;&#101;', // ?
		    'SOS' => '&#83;',
		    'SRD' => '&#36;',
		    'STD' => '&#68;&#98;', // ?
		    'SVC' => '&#36;',
		    'SYP' => '&#163;',
		    'SZL' => '&#76;', // ?
		    'THB' => '&#3647;',
		    'TJS' => '&#84;&#74;&#83;', // ? TJS (guess)
		    'TMT' => '&#109;',
		    'TND' => '&#1583;.&#1578;',
		    'TOP' => '&#84;&#36;',
		    'TRY' => '&#8356;', // New Turkey Lira (old symbol used)
		    'TTD' => '&#36;',
		    'TWD' => '&#78;&#84;&#36;',
		    'TZS' => '',
		    'UAH' => '&#8372;',
		    'UGX' => '&#85;&#83;&#104;',
		    'USD' => '&#36;',
		    'UYU' => '&#36;&#85;',
		    'UZS' => '&#1083;&#1074;',
		    'VEF' => '&#66;&#115;',
		    'VND' => '&#8363;',
		    'VUV' => '&#86;&#84;',
		    'WST' => '&#87;&#83;&#36;',
		    'XAF' => '&#70;&#67;&#70;&#65;',
		    'XCD' => '&#36;',
		    'XDR' => '',
		    'XOF' => '',
		    'XPF' => '&#70;',
		    'YER' => '&#65020;',
		    'ZAR' => '&#82;',
		    'ZMK' => '&#90;&#75;', // ?
		    'ZWL' => '&#90;&#36;',
		 );


		 return $fiat_currency_symbols[$fiat_country_code];

	 }















} // class
