<?php

/**
 * Provides the markup for any WP Editor field
 *
 * @link       http://happyrobotstudio.com
 * @since      1.0.0
 *
 * @package    Live_Crypto
 * @subpackage Live_Crypto/admin/partials
 */

// wp_editor( $content, $editor_id, $settings = array() );

if ( ! empty( $atts['label'] ) ) {

	?><label for="<?php

	echo esc_attr( $atts['id'] );

	?>"><?php

		esc_html_e( $atts['label'], 'live-crypto' );

	?>: </label><?php

}

wp_editor( html_entity_decode( $atts['value'] ), $atts['id'], $atts['settings'] );

?>
<div class="livecrypto-label-descript">
	<span class="description"><?php echo $atts['description']; ?></span>
</div>
