<?php


if ( ! empty( $instance['title'] ) ) {
	$title = apply_filters( 'widget_title', $instance['title'] );
}

if ( ! empty( $instance['insymbol'] ) ) {
	$insymbol = apply_filters( 'widget_insymbol', $instance['insymbol'] );
}

if ( ! empty( $instance['outsymbol'] ) ) {
	$outsymbol = apply_filters( 'widget_outsymbol', $instance['outsymbol'] );
}



?><div class="live-crypto-widget"><?php




echo crypto_price($insymbol, $outsymbol);




?></div><!-- End of .live-crypto-widget --><?php
