<?php

/**
 * Provides the markup for any textarea field
 *
 * @link       http://happyrobotstudio.com
 * @since      1.0.0
 *
 * @package    Live_Crypto
 * @subpackage Live_Crypto/admin/partials
 */

if ( ! empty( $atts['label'] ) ) {

	?><label for="<?php echo esc_attr( $atts['id'] ); ?>"><?php esc_html_e( $atts['label'], 'live-crypto' ); ?>: </label><?php

}

?><textarea
	class="<?php echo esc_attr( $atts['class'] ); ?>"
	cols="<?php echo esc_attr( $atts['cols'] ); ?>"
	id="<?php echo esc_attr( $atts['id'] ); ?>"
	name="<?php echo esc_attr( $atts['name'] ); ?>"
	rows="<?php echo esc_attr( $atts['rows'] ); ?>"><?php

	echo esc_textarea( $atts['value'] );

?></textarea>
<div class="livecrypto-label-descript">
	<span class="description"><?php echo $atts['description']; ?></span>
</div>
