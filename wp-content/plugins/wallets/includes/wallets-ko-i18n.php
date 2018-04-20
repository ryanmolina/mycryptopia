<?php

// Localize the frontend knockout script


$translation_array = array(
	'op_failed' => apply_filters( 'wallets_ui_text_op_failed', __( 'Wallet operation failed due to an unexpected error', 'wallets-front' ) ),
	'op_failed_msg' => apply_filters( 'wallets_ui_text_op_failed_msg', __( 'Wallet operation failed: %s', 'wallets-front' ) ),
	'contact_fail' => apply_filters( 'wallets_ui_text_contact_fail', __( 'Could not contact server. Status: %s Error: %s', 'wallets-front' ) ),
	'invalid_add' => apply_filters( 'wallets_ui_text_invalid_add', __( 'Check to see if you have typed the address correctly!', 'wallets-front' ) ),

	'deposit' => apply_filters( 'wallets_ui_text_deposit', __( 'deposit', 'wallets-front' ) ),
	'withdraw' => apply_filters( 'wallets_ui_text_withdraw', __( 'withdraw', 'wallets-front' ) ),
	'move' => apply_filters( 'wallets_ui_text_move', __( 'transfer', 'wallets-front' ) ),
	'trade' => apply_filters( 'wallets_ui_text_trade', __( 'trade', 'wallets-front' ) ),

	'unconfirmed' => apply_filters( 'wallets_ui_text_unconfirmed', __( 'unconfirmed', 'wallets-front' ) ),
	'pending' => apply_filters( 'wallets_ui_text_pending', __( 'pending', 'wallets-front' ) ),
	'done' => apply_filters( 'wallets_ui_text_done', __( 'done', 'wallets-front' ) ),
	'failed' => apply_filters( 'wallets_ui_text_failed', __( 'failed', 'wallets-front' ) ),
	'cancelled' => apply_filters( 'wallets_ui_text_cancelled', __( 'cancelled', 'wallets-front' ) ),
);

if ( Dashed_Slug_Wallets::get_option( 'wallets_confirm_move_user_enabled' ) ) {
	$translation_array['submit_tx'] = apply_filters(
		'wallets_ui_text_submit_tx',
		__( 'Successfully submitted a transaction request of %s %s. Please check your e-mail for confirmation instructions.', 'wallets-front' )
	);
} else {
	$translation_array['submit_tx'] = apply_filters(
		'wallets_ui_text_submit_tx',
		__( 'Successfully submitted a transaction request of %s %s.', 'wallets-front' )
	);
}

if ( Dashed_Slug_Wallets::get_option( 'wallets_confirm_withdraw_user_enabled' ) ) {
	$translation_array['submit_wd'] = apply_filters(
		'wallets_ui_text_submit_wd',
		__( 'Successfully submitted a withdrawal request of %s %s to %s. Please check your e-mail for confirmation instructions.', 'wallets-front' )
	);
} else {
	$translation_array['submit_wd'] = apply_filters(
		'wallets_ui_text_submit_wd',
		__( 'Successfully submitted a withdrawal request of %s %s.', 'wallets-front' )
	);
}

wp_localize_script( 'wallets_ko', 'wallets_ko_i18n', $translation_array );
