<?php
//Load Wordpress Connection Data
define( 'WP_USE_THEMES', false );
require( '../../../../../wp-load.php' );

// Init DB References
$ec_db_admin = new ec_db_admin( );
global $wpdb;

$body = @file_get_contents('php://input');
$json = json_decode( $body );

// Quick test, make sure something was sent with an id
if( !isset( $json->id ) )
	die( );

// Verify the Webhook is Legit
$paypal = new ec_paypal( );
if( !$paypal->verify_webhook( $json ) ){
	$ec_db_admin->insert_response( $order_id, 1, "PayPal Webhook Error", 'Did not pass verification --- ' . print_r( $json, true ) );
	die( );
}
	
// Replace json with the webhook event object
$ec_db_admin->insert_response( $order_id, 1, "PayPal Webhook Test", print_r( $json, true ) );

// Verify the Order is found in the system from the resource id
$paypal_order_id = $json->resource->id;
if( isset( $json->resource->sale_id ) )
	$paypal_order_id = $json->resource->sale_id;

$order_id = $wpdb->get_var( $wpdb->prepare( "SELECT order_id FROM ec_order WHERE gateway_transaction_id = %s", $paypal_order_id ) );
if( !$order_id ){
	$ec_db_admin->insert_response( $order_id, 1, "PayPal Webhook Error",'No order found for PayPal Order ID ' . $paypal_order_id );
	die( );
}

// Payment was voided
if( $json->event_type == 'PAYMENT.AUTHORIZATION.VOIDED' ){
	$ec_db_admin->update_order_status( $order_id, "19" );
	
// Captured Payment Completed!
}else if( $json->event_type == 'PAYMENT.CAPTURE.COMPLETED' || $json->event_type == 'PAYMENT.SALE.COMPLETED' || $json->event_type == 'CHECKOUT.ORDER.PROCESSED' ){
	$order_row = $ec_db_admin->get_order_row_admin( $order_id );
	$orderdetails = $ec_db_admin->get_order_details_admin( $order_id );
	$ec_db_admin->insert_response( $order_id, 0, "PayPal Webhook Complete Response", print_r( $json, true ) . " --- " . print_r( $order_row, true ) );
	if( $order_row ){
		$ec_db_admin->update_order_status( $order_id, "10" );
		do_action( 'wpeasycart_order_paid', $order_id );
		
		/* Update Stock Quantity */
		foreach( $orderdetails as $orderdetail ){
			$product = $wpdb->get_row( $wpdb->prepare( "SELECT ec_product.* FROM ec_product WHERE ec_product.product_id = %d", $orderdetail->product_id ) );
			if( $product ){
				if( $product->use_optionitem_quantity_tracking )	
					$ec_db_admin->update_quantity_value( $orderdetail->quantity, $orderdetail->product_id, $orderdetail->optionitem_id_1, $orderdetail->optionitem_id_2, $orderdetail->optionitem_id_3, $orderdetail->optionitem_id_4, $orderdetail->optionitem_id_5 );
				$ec_db_admin->update_product_stock( $orderdetail->product_id, $orderdetail->quantity );
			}
		}
		
		// send email
		$order_display = new ec_orderdisplay( $order_row, true, true );
		$order_display->send_email_receipt( );
		$order_display->send_gift_cards( );
	}
	
// Payment was Refunded
}else if( $json->event_type == 'PAYMENT.CAPTURE.REFUNDED' || $json->event_type == 'PAYMENT.SALE.REFUNDED' ){
	global $wpdb;
	$order = $wpdb->get_row( $wpdb->prepare( "SELECT orderstatus_id, refund_total, grand_total FROM ec_order WHERE order_id = %d", $order_id ) );
	$order_status = $order->orderstatus_id;
	
	if( $order_status != 16 && $order_status != 17 ){
		$original_amount = (float) $order->grand_total;
		$refund_total = (float) $order->refund_total + (float) $json->resource->amount->total;
		$order_status = ( $refund_total < $original_amount ) ? 17 : 16;
		$wpdb->query( $wpdb->prepare( "UPDATE ec_order SET orderstatus_id = %d, refund_total = %s WHERE order_id = %d", $order_status, $refund_total, $order_id ) );
		
		if( $order_status == "16" )
			do_action( 'wpeasycart_full_order_refund', $orderid );
		else if( $order_status == "17" )
			do_action( 'wpeasycart_partial_order_refund', $orderid );
	}
}else{
	$ec_db_admin->insert_response( $order_id, 1, "PayPal Webhook Error", 'No event type match! ---- ' . print_r( $json, true ) );
}