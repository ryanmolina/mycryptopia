<?php
/**
 * Plugin support: learnpress
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.5
 */

// Check if plugin installed and activated
// Attention! This function is used in many files and was moved to the api.php

if ( !function_exists( 'trx_addons_exists_learnpress' ) ) {
	function trx_addons_exists_learnpress() {
		return class_exists('LearnPress');
	}
}




// One-click import support
//------------------------------------------------------------------------

// Check plugin in the required plugins
if ( !function_exists( 'trx_addons_learnpress_importer_required_plugins' ) ) {
	if (is_admin()) add_filter( 'trx_addons_filter_importer_required_plugins',	'trx_addons_learnpress_importer_required_plugins', 10, 2 );
	function trx_addons_learnpress_importer_required_plugins($not_installed='', $list='') {
		if (strpos($list, 'learnpress')!==false && !trx_addons_exists_learnpress() )
			$not_installed .= '<br>' . esc_html__('learnpress', 'trx_addons');
		return $not_installed;
	}
}

// Set plugin's specific importer options
if ( !function_exists( 'trx_addons_learnpress_importer_set_options' ) ) {
	if (is_admin()) add_filter( 'trx_addons_filter_importer_options',	'trx_addons_learnpress_importer_set_options' );
	function trx_addons_learnpress_importer_set_options($options=array()) {
		if ( trx_addons_exists_learnpress() && in_array('learnpress', $options['required_plugins']) ) {
			$options['additional_options'][]	= 'learn_press_%';					// Add slugs to export options for this plugin

			if (is_array($options['files']) && count($options['files']) > 0) {
				foreach ($options['files'] as $k => $v) {
					$options['files'][$k]['file_with_learnpress'] = str_replace('name.ext', 'learnpress.txt', $v['file_with_']);
				}
			}
		}
		return $options;
	}
}

// Add checkbox to the one-click importer
if ( !function_exists( 'trx_addons_learnpress_importer_show_params' ) ) {
	if (is_admin()) add_action( 'trx_addons_action_importer_params',	'trx_addons_learnpress_importer_show_params', 10, 1 );
	function trx_addons_learnpress_importer_show_params($importer) {
		if ( trx_addons_exists_learnpress() && in_array('learnpress', $importer->options['required_plugins']) ) {
			$importer->show_importer_params(array(
				'slug' => 'learnpress',
				'title' => esc_html__('Import learnpress', 'trx_addons'),
				'part' => 0
			));
		}
	}
}

// Import posts
if ( !function_exists( 'trx_addons_learnpress_importer_import' ) ) {
	if (is_admin()) add_action( 'trx_addons_action_importer_import',	'trx_addons_learnpress_importer_import', 10, 2 );
	function trx_addons_learnpress_importer_import($importer, $action) {
		if ( trx_addons_exists_learnpress() && in_array('learnpress', $importer->options['required_plugins']) ) {
			if ( $action == 'import_learnpress' ) {
				$importer->response['start_from_id'] = 0;
				$importer->import_dump('learnpress', esc_html__('LearPress meta', 'trx_addons'));
			}
		}
	}
}

// Check if the row will be imported
if ( !function_exists( 'trx_addons_learnpress_importer_check_row' ) ) {
	if (is_admin()) add_filter('trx_addons_filter_importer_import_row', 'trx_addons_learnpress_importer_check_row', 9, 4);
	function trx_addons_learnpress_importer_check_row($flag, $table, $row, $list) {
		if ($flag || strpos($list, 'learnpress')===false) return $flag;
		if ( trx_addons_exists_learnpress() ) {
			file_put_contents('testing.txt', 'trx_addons_exists_learnpress',FILE_APPEND);
			if ($table == 'posts') {
				file_put_contents('testing.txt', '!!!'.$row['post_type'],FILE_APPEND);
				$flag = in_array($row['post_type'], array('lp_course'));
			}
		}
		return $flag;
	}
}

// Display import progress
if ( !function_exists( 'trx_addons_learnpress_importer_import_fields' ) ) {
	if (is_admin()) add_action( 'trx_addons_action_importer_import_fields',	'trx_addons_learnpress_importer_import_fields', 10, 1 );
	function trx_addons_learnpress_importer_import_fields($importer) {
		if ( trx_addons_exists_learnpress() && in_array('learnpress', $importer->options['required_plugins']) ) {
			$importer->show_importer_fields(array(
				'slug'=>'learnpress', 
				'title' => esc_html__('Learnpress meta', 'trx_addons')
				)
			);
		}
	}
}

// Export posts
if ( !function_exists( 'trx_addons_learnpress_importer_export' ) ) {
	if (is_admin()) add_action( 'trx_addons_action_importer_export',	'trx_addons_learnpress_importer_export', 10, 1 );
	function trx_addons_learnpress_importer_export($importer) {

		if ( trx_addons_exists_learnpress() && in_array('learnpress', $importer->options['required_plugins']) ) {
			trx_addons_fpc(trx_addons_get_file_dir(TRX_ADDONS_PLUGIN_IMPORTER . 'export/learnpress.txt'), serialize( array(
				"wp_learnpress_review_logs"				=> $importer->export_dump("wp_learnpress_review_logs"),
				"wp_learnpress_sessions"				=> $importer->export_dump("wp_learnpress_sessions")
				) )
			);
		}
	}
}

// Display exported data in the fields
if ( !function_exists( 'trx_addons_learnpress_importer_export_fields' ) ) {
	if (is_admin()) add_action( 'trx_addons_action_importer_export_fields',	'trx_addons_learnpress_importer_export_fields', 10, 1 );
	function trx_addons_learnpress_importer_export_fields($importer) {
		if ( trx_addons_exists_learnpress() && in_array('learnpress', $importer->options['required_plugins']) ) {

			$importer->show_exporter_fields(array(
				'slug'	=> 'learnpress',
				'title' => esc_html__('LearnPress', 'trx_addons')
				)
			);
		}
	}
}
