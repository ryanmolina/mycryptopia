<?php

/**
 * Provides the markup for a colour selector
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

?><input
	class="<?php echo esc_attr( $atts['class'] ); ?>"
	id="<?php echo esc_attr( $atts['id'] ); ?>"
	name="<?php echo esc_attr( $atts['name'] ); ?>"
	placeholder="<?php echo esc_attr( $atts['placeholder'] ); ?>"
	type="<?php echo esc_attr( $atts['type'] ); ?>"
	value="<?php echo esc_attr( $atts['value'] ); ?>" /><?php

if ( ! empty( $atts['description'] ) ) {

	?>
	<div class="">
		<span class="description"><?php echo $atts['description']; ?></span>
	</div>
	<?php

}
