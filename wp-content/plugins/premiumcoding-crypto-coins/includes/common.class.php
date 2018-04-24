<?php
class PMCCommon {
  
  public static function pmc_get_url_data_curl($url) {
  
    if (get_option('cryptocurrency-prices-file-get-contents') != 1) {
      $ch = curl_init();
    	$timeout = 5;
    	curl_setopt($ch, CURLOPT_URL, $url);
    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    	$data = curl_exec($ch);
    	curl_close($ch);
    } else {
      //compatibility mode	  	  	$request = wp_remote_get( $url );		$data = wp_remote_retrieve_body( $request ); 
    }
  	
  	return $data;
  }

  public static function pmc_get_currency_image($currency){
    $supported_icons = array(
    //flat currencies
    'aud', 'usd', 'cad', 'gbp', 'eur', 'chf', 'bgn', 'jpy', 'cny', 
    // cryptocurrencies 
    'btc', 'eth', 'xrp', 'dash', 'ltc', 'etc', 'xmr', 'xem', 'rep', 'maid', 'pivx', 'gnt', 'dcr', 'zec', 'strat', 'bccoin', 'fct', 'steem', 'waves', 'game', 'doge', 'round', 'dgd', 'lisk', 'sngls', 'icn', 'bcn', 'xlm', 'bts', 'ardr', '1st', 'ppc', 'nav', 'xpmc', 'nxt', 'lana', 'dgb', 'iot', 'btcd', 'xpy', 'prc', 'craig', 'xbs', 'ybc', 'dank', 'give', 'kobo', 'geo', 'ac', 'anc', 'arg', 'aur', 'bitb', 'blk', 'xmy', 'moon', 'sxc', 'qtl', 'btm', 'bnt', 'cvc', 'pivx', 'ubq', 'lenin', 'bat', 'plbt', 'bch'
    );
    
    $coinname_escaped = trim(strtolower($currency));
      
    if (in_array($coinname_escaped, $supported_icons)){
      $picture = PMC_URL.'images/'.$coinname_escaped.'.png';
    } else {
      $picture = PMC_URL.'images/coin.png';
    }
    
    return $picture; 
  }

  public static function pmc_get_plugin_credit($api = ''){
    $credit = '';
    
    //show credit if allowed by user
    if (get_option('cryptocurrency-prices-hide-credit') != 1) {
      $credit .= '';
    } else {
      $credit .= '';
    }
    
    if (isset($api) and $api == 'cryptocompare'){
      //give credit to the API - required by the API terms
      $credit .= '<a href="https://www.cryptocompare.com/api/" style="font-size:small">'.__('Data by', 'pmc-crypto').' CryptoCompare API</a>';
    }
    
    return $credit;
  }
  
  public static function pmc_custom_styles(){
    if (get_option('cryptocurrency-prices-css') and get_option('cryptocurrency-prices-css')!=''){
      echo '
        <style type="text/css">
          '.esc_html(get_option('cryptocurrency-prices-css')).'
        </style>
      ';
    }
  }

  public static function pmc_load_textdomain() {
    //echo dirname( plugin_basename(__FILE__) ).'/../lang/';
  	load_plugin_textdomain( 'pmc-crypto', false, dirname( plugin_basename(__FILE__) ).'/../languages/' );
  }

  
  public static function pmc_plugin_activate() {
    //handle plugin activation
    global $wpdb;
    
    //setup plugin database
    
    $charset_collate = $wpdb->get_charset_collate();
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    $table_name = $wpdb->prefix.'pmc_orders';
    
    $sql = "CREATE TABLE $table_name (
      id mediumint(9) NOT NULL AUTO_INCREMENT,
      item text NOT NULL,
      price text NULL,
      currency text NULL,
      payment_address text NULL,
      name text NOT NULL,
      email text NOT NULL,
      address text NULL,
      telephone text NULL,
      description text NULL,
      time timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL,
      PRIMARY KEY  (id)
    ) $charset_collate;";
    
    $result = dbDelta( $sql );
  }

}