<?php

/**
 * Provides the markup for any checkbox field
 *
 * @link       http://happyrobotstudio.com
 * @since      1.0.0
 *
 * @package    Live_Crypto
 * @subpackage Live_Crypto/admin/partials
 */

?><label for="<?php echo esc_attr( $atts['id'] ); ?>">
	<div class="livecrypto-onoffswitch" >
		<input aria-role="checkbox"
			<?php checked( 1, $atts['value'], true ); ?>
			class="livecrypto-onoffswitch-checkbox <?php echo esc_attr( $atts['class'] ); ?>"
			id="<?php echo esc_attr( $atts['id'] ); ?>"
			name="<?php echo esc_attr( $atts['name'] ); ?>"
			type="checkbox"
			value="1" />

		<label class="livecrypto-onoffswitch-label" for="<?php echo esc_attr( $atts['id'] ); ?>"></label>
      </div>

</label>

<div class="livecrypto-label-descript">
	<span class="description"><?php echo $atts['description']; ?></span>
</div>
