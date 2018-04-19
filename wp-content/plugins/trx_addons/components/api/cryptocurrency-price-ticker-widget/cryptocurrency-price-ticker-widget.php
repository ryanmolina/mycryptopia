<?php
/**
 * Plugin support: Cryptocurrency Price Ticker Widget
 */


// Check if plugin installed and activated
if ( !function_exists( 'trx_addons_exists_cryptocurrency_price_ticker_widget' ) ) {
	function trx_addons_exists_cryptocurrency_price_ticker_widget() {
		return defined('Crypto_Currency_Price_Widget_VERSION');
	}
}

// One-click import support
//------------------------------------------------------------------------

// Check plugin in the required plugins
if ( !function_exists( 'trx_addons_cryptocurrency_price_ticker_widget_importer_required_plugins' ) ) {
	if (is_admin()) add_filter( 'trx_addons_filter_importer_required_plugins',	'trx_addons_cryptocurrency_price_ticker_widget_importer_required_plugins', 10, 2 );
	function trx_addons_cryptocurrency_price_ticker_widget_importer_required_plugins($not_installed='', $list='') {
		if (strpos($list, 'cryptocurrency-price-ticker-widget')!==false && !trx_addons_exists_cryptocurrency_price_ticker_widget() )
			$not_installed .= '<br>' . esc_html__('Cryptocurrency Price Ticker Widget', 'trx_addons');
		return $not_installed;
	}
}

// Set plugin's specific importer options
if ( !function_exists( 'trx_addons_cryptocurrency_price_ticker_widget_importer_set_options' ) ) {
	if (is_admin()) add_filter( 'trx_addons_filter_importer_options',	'trx_addons_cryptocurrency_price_ticker_widget_importer_set_options' );
	function trx_addons_cryptocurrency_price_ticker_widget_importer_set_options($options=array()) {
		if ( trx_addons_exists_cryptocurrency_price_ticker_widget() && in_array('cryptocurrency-price-ticker-widget', $options['required_plugins']) ) {
			$options['additional_options'][]	= 'ccpw-%';					// Add slugs to export options for this plugin
		}
		return $options;
	}
}

// Add checkbox to the one-click importer
if ( !function_exists( 'trx_addons_cryptocurrency_price_ticker_widget_importer_show_params' ) ) {
	if (is_admin()) add_action( 'trx_addons_action_importer_params',	'trx_addons_cryptocurrency_price_ticker_widget_importer_show_params', 10, 1 );
	function trx_addons_cryptocurrency_price_ticker_widget_importer_show_params($importer) {
		if ( trx_addons_exists_cryptocurrency_price_ticker_widget() && in_array('cryptocurrency-price-ticker-widget', $importer->options['required_plugins']) ) {
			$importer->show_importer_params(array(
				'slug' => 'cryptocurrency-price-ticker-widget',
				'title' => esc_html__('Import Cryptocurrency Price Ticker Widget', 'trx_addons'),
				'part' => 0
			));
		}
	}
}

// Check if the row will be imported
if ( !function_exists( 'trx_addons_cryptocurrency_price_ticker_widget_importer_check_row' ) ) {
	if (is_admin()) add_filter('trx_addons_filter_importer_import_row', 'trx_addons_cryptocurrency_price_ticker_widget_importer_check_row', 9, 4);
	function trx_addons_cryptocurrency_price_ticker_widget_importer_check_row($flag, $table, $row, $list) {
		if ($flag || strpos($list, 'cryptocurrency-price-ticker-widget')===false) return $flag;
		if ( trx_addons_exists_cryptocurrency_price_ticker_widget() ) {
			if ($table == 'posts')
				$flag = in_array($row['post_type'], array('ccpw'));
		}
		return $flag;
	}
}

// Display import progress
if ( !function_exists( 'trx_addons_cryptocurrency_price_ticker_widget_importer_import_fields' ) ) {
	if (is_admin()) add_action( 'trx_addons_action_importer_import_fields',	'trx_addons_cryptocurrency_price_ticker_widget_importer_import_fields', 10, 1 );
	function trx_addons_cryptocurrency_price_ticker_widget_importer_import_fields($importer) {
		if ( trx_addons_exists_cryptocurrency_price_ticker_widget() && in_array('cryptocurrency-price-ticker-widget', $importer->options['required_plugins']) ) {
			$importer->show_importer_fields(array(
					'slug'=>'cryptocurrency-price-ticker-widget',
					'title' => esc_html__('Cryptocurrency Price Ticker Widget', 'trx_addons')
				)
			);
		}
	}
}

?>