<?php

/**
 * Provide the view for a metabox
 *
 * @link 		http://happyrobotstudio.com
 * @since 		1.0.0
 *
 * @package 	Live_Crypto
 * @subpackage 	Live_Crypto/admin/partials
 */

wp_nonce_field( $this->plugin_name, 'livecrypto_files' );

$setatts 					= array();
$setatts['class'] 			= 'repeater';
$setatts['id'] 				= 'file-repeater';
$setatts['label-add'] 		= 'Add File';
$setatts['label-edit'] 		= 'Edit file';
$setatts['label-header'] 	= 'File Name';
$setatts['label-remove'] 	= 'Remove File';
$setatts['title-field'] 	= 'label-file'; // which field provides the title for each fieldset?
$i 							= 0;

$setatts['fields'][$i]['text']['class'] 				= 'widefat label-file repeater-title';
$setatts['fields'][$i]['text']['description'] 			= '';
$setatts['fields'][$i]['text']['id'] 					= 'label-file';
$setatts['fields'][$i]['text']['label'] 				= 'File Name';
$setatts['fields'][$i]['text']['name'] 					= 'label-file';
$setatts['fields'][$i]['text']['placeholder'] 			= 'File Name';
$setatts['fields'][$i]['text']['type'] 					= 'text';
$setatts['fields'][$i]['text']['value'] 				= '';
$i++;

$setatts['fields'][$i]['file-upload']['class'] 			= 'widefat url-file';
$setatts['fields'][$i]['file-upload']['description'] 	= '';
$setatts['fields'][$i]['file-upload']['id'] 			= 'url-file';
$setatts['fields'][$i]['file-upload']['label'] 			= 'File';
$setatts['fields'][$i]['file-upload']['label-remove'] 	= 'Remove File';
$setatts['fields'][$i]['file-upload']['label-upload'] 	= 'Choose/Upload File';
$setatts['fields'][$i]['file-upload']['name'] 			= 'url-file';
$setatts['fields'][$i]['file-upload']['placeholder'] 	= '';
$setatts['fields'][$i]['file-upload']['type'] 			= 'url';
$setatts['fields'][$i]['file-upload']['value'] 			= '';
$i++;

apply_filters( $this->plugin_name . '-field-repeater-livecrypto-files', $setatts );

$count 		= 1;
$repeater 	= array();

if ( ! empty( $this->meta[$setatts['id']] ) ) {

	$repeater = maybe_unserialize( $this->meta[$setatts['id']][0] );

}

if ( ! empty( $repeater ) ) {

	$count = count( $repeater );

}



//var_dump( $setatts );

include( plugin_dir_path( __FILE__ ) . $this->plugin_name . '-admin-field-repeater.php' );
