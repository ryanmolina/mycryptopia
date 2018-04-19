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

wp_nonce_field( $this->plugin_name, 'livecrypto_requirements_nonce' );

$atts 					= array();
$atts['description'] 	= '';
$atts['id'] 			= 'livecrypto-requirements-skills';
$atts['label'] 			= 'Skills/Qualifications';
$atts['settings']['textarea_name'] = 'livecrypto-requirements-skills';
$atts['value'] 			= '';

if ( ! empty( $this->meta[$atts['id']][0] ) ) {

	$atts['value'] = $this->meta[$atts['id']][0];

}

apply_filters( $this->plugin_name . '-field-livecrypto-requirements-skills', $atts );

?><p><?php

include( plugin_dir_path( __FILE__ ) . $this->plugin_name . '-admin-field-editor.php' );

?></p><?php

$atts 					= array();
$atts['description'] 	= '';
$atts['id'] 			= 'livecrypto-requirements-education';
$atts['label'] 			= 'Education';
$atts['settings']['textarea_name'] = 'livecrypto-requirements-education';
$atts['value'] 			= '';

if ( ! empty( $this->meta[$atts['id']][0] ) ) {

	$atts['value'] = $this->meta[$atts['id']][0];

}

apply_filters( $this->plugin_name . '-field-livecrypto-requirements-education', $atts );

?><p><?php

include( plugin_dir_path( __FILE__ ) . $this->plugin_name . '-admin-field-editor.php' );

?></p><?php

$atts 					= array();
$atts['description'] 	= '';
$atts['id'] 			= 'livecrypto-requirements-experience';
$atts['label'] 			= 'Experience';
$atts['settings']['textarea_name'] = 'livecrypto-requirements-experience';
$atts['value'] 			= '';

if ( ! empty( $this->meta[$atts['id']][0] ) ) {

	$atts['value'] = $this->meta[$atts['id']][0];

}

apply_filters( $this->plugin_name . '-field-livecrypto-requirements-experience', $atts );

?><p><?php

include( plugin_dir_path( __FILE__ ) . $this->plugin_name . '-admin-field-editor.php' );

?></p>
