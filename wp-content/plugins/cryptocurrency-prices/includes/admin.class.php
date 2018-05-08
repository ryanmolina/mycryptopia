<?php
class CPAdmin {
  const NONCE = 'cp-admin-settings';
  
  private static $initiated = false;
	
  public static function init() {
    if ( ! self::$initiated ) {
			self::init_hooks();
		}
  }
  
	public static function init_hooks() {
    self::$initiated = true;
    
    //add admin menu
    add_action('admin_menu', array( 'CPAdmin', 'register_menu_page' ));
	}
  
  public static function register_menu_page() {
    add_menu_page(
      __( 'Cyptocurrency All-in-One', 'cryptocurrency' ),
      __( 'Cyptocurrency', 'cryptocurrency' ),
      'manage_options',
      'cryptocurrency-prices',
      array('CPAdmin', 'cryptocurrency_prices_admin_settings'),
      CP_URL.'images/btc.png',
      81
    );
  }
  
  public static function cryptocurrency_prices_admin_settings(){
    //check if user has admin capability
    if (current_user_can( 'manage_options' )){ 
      $admin_message_html = '';
      
      if (isset($_POST['ethereum-api'])){
        //check nonce
        check_admin_referer( self::NONCE );
        
        $sanitized_ethereum_api = sanitize_text_field($_POST['ethereum-api']);
        update_option('ethereum-api', $sanitized_ethereum_api);
        $admin_message_html = '<div class="notice notice-success"><p>Plugin settings have been updated!</p></div>';
      }
      
      echo '
      <div class="wrap cryptocurrency-admin">
        '.$admin_message_html.'
        <h1>Cyptocurrency All-in-One Settings:</h1>
          
        <form action="" method="post">

          <h2>Ethereum blockchain node API URL:</h2>
          <p>You need to set it up, if you will use the ethereum blockchain features. Example URLs http://localhost:8545 for your own node or register for a public node https://mainnet.infura.io/[your key].</p>
          <input type="text" name="ethereum-api" value="'.get_option('ethereum-api').'" />
          
          <br /><br />
          '.wp_nonce_field( self::NONCE ).'        
          <input type="submit" value="Save options" />
        </form>
      </div>
      ';
    
    }
  }
  
}