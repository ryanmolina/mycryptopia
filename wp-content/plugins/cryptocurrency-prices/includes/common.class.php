<?php
class CPCommon {
  
  public static function cp_load_textdomain() {
  	load_plugin_textdomain( 'cryprocurrency-prices', false, dirname( plugin_basename(__FILE__) ).'/../languages/' );
  }

  public static function cp_load_scripts($type = '') {
    switch($type){
      case 'datatable':
        wp_enqueue_style('datatables-css', CP_URL . 'js/datatables/datatables.min.css');
        wp_enqueue_script( 'datatables-js', CP_URL . 'js/datatables/datatables.min.js');
        break;
      case 'lazy':
        wp_enqueue_script( 'jquery-lazy', CP_URL . 'js/jquery.lazy.min.js');
        break;     
      default:
        wp_enqueue_script( 'jquery' );
        if (get_option('cryptocurrency-payment-site-key') && get_option('cryptocurrency-payment-site-key') != '' && get_option('cryptocurrency-payment-secret-key') && get_option('cryptocurrency-payment-secret-key') != '') {
          wp_enqueue_script( 'recaptcha', 'https://www.google.com/recaptcha/api.js' );
        }        
        break;
    }
  }
  
  public static function cp_shortcode_widget_init(){
    register_widget('CP_Shortcode_Widget');
  }
}