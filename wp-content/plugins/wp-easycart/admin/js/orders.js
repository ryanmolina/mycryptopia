var ec_admin_order_details_order_info_show = false;
var ec_admin_order_details_shipping_method_show = false;
var ec_admin_order_details_customer_notes_show = false;

jQuery( document ).ready( function( ){
	jQuery( document.getElementById( 'ec_admin_order_details_shipping_method_save' ) ).on( 'click', ec_admin_process_shipping_method );
} );

function ec_admin_resend_giftcard( script_order_id, script_orderdetail_id ){
	jQuery( document.getElementById( "ec_admin_process_order_line_item" ) ).fadeIn( 'fast' );
	
	var data = {
		action: 'ec_admin_ajax_resend_giftcard_email',
		order_id: script_order_id,
		orderdetail_id: script_orderdetail_id,
	};
	
	jQuery.ajax({url: ajax_object.ajax_url, type: 'post', data: data, success: function(data){ 
		ec_admin_hide_loader( 'ec_admin_process_order_line_item' );
	} } );
	
	return false;
}
function ec_admin_copy_billing_address(button) {
	 document.getElementById( "shipping_first_name" ).value = document.getElementById( "billing_first_name" ).value;
	 document.getElementById( "shipping_last_name" ).value = document.getElementById( "billing_last_name" ).value;
	 document.getElementById( "shipping_company_name" ).value = document.getElementById( "billing_company_name" ).value;
	 document.getElementById( "shipping_address_line_1" ).value = document.getElementById( "billing_address_line_1" ).value;
	 document.getElementById( "shipping_address_line_2" ).value = document.getElementById( "billing_address_line_2" ).value;
	 document.getElementById( "shipping_city" ).value = document.getElementById( "billing_city" ).value;
	 document.getElementById( "shipping_state" ).value = document.getElementById( "billing_state" ).value;
	 document.getElementById( "shipping_country" ).value = document.getElementById( "billing_country" ).value;
	 document.getElementById( "shipping_zip" ).value = document.getElementById( "billing_zip" ).value;
	 document.getElementById( "shipping_phone" ).value = document.getElementById( "billing_phone" ).value;
}

function ec_admin_edit_order_status(button) {
	jQuery( document.getElementById( "ec_admin_order_management" ) ).fadeIn( 'fast' );
	
	var data = {
		action: 'ec_admin_ajax_edit_orderstatus',
		order_id: ec_admin_get_value( 'order_id', 'text' ),
		orderstatus_id: ec_admin_get_value( 'orderstatus_id', 'select' ),
	
	};
	
	jQuery.ajax({url: ajax_object.ajax_url, type: 'post', data: data, success: function(data){ 
		ec_admin_hide_loader( 'ec_admin_order_management' );
	} } );
	
	return false;
}

function ec_admin_process_order_info( ){
	jQuery( document.getElementById( "ec_admin_order_management" ) ).fadeIn( 'fast' );
	
	var data = {
		action: 'ec_admin_ajax_edit_order_info',
		order_id: ec_admin_get_value( 'order_id', 'text' ),
		order_weight: ec_admin_get_value( 'order_weight', 'text' ),
		giftcard_id: ec_admin_get_value( 'giftcard_id', 'text' ),
		promo_code: ec_admin_get_value( 'promo_code', 'text' ),
		order_notes: ec_admin_get_value( 'order_notes', 'text' )
	};
	
	jQuery.ajax({url: ajax_object.ajax_url, type: 'post', data: data, success: function(data){
		ec_admin_hide_loader( 'ec_admin_order_management' );
	} } );
	
	ec_admin_order_details_order_info_show = false;
}

function ec_admin_process_shipping_method( ){
	
	if( ec_admin_order_details_shipping_method_show ){
		jQuery( document.getElementById( "ec_admin_shipping_details" ) ).fadeIn( 'fast' );
		if( ec_admin_get_value( 'use_expedited_shipping', 'select' ) == '1' ){
			jQuery( document.getElementById( 'ec_admin_order_details_shipping_type' ) ).html( 'Expedite Shipping<br />' );
		}else{
			jQuery( document.getElementById( 'ec_admin_order_details_shipping_type' ) ).html( '' );
		}
		if( ec_admin_get_value( 'shipping_carrier', 'text' ) != '' ){
			jQuery( document.getElementById( 'ec_admin_order_details_shipping_carrier' ) ).html( ec_admin_get_value( 'shipping_carrier', 'text' ) + '<br />' );
		}else{
			jQuery( document.getElementById( 'ec_admin_order_details_shipping_carrier' ) ).html( '' );
		}
		if( ec_admin_get_value( 'shipping_method', 'text' ) != '' ){
			jQuery( document.getElementById( 'ec_admin_order_details_shipping_method' ) ).html( ec_admin_get_value( 'shipping_method', 'text' ) + '<br />' );
		}else{
			jQuery( document.getElementById( 'ec_admin_order_details_shipping_method' ) ).html( '' );
		}
		if( ec_admin_get_value( 'tracking_number', 'text' ) != '' ){
			jQuery( document.getElementById( 'ec_admin_order_details_tracking_number' ) ).html( ec_admin_get_value( 'tracking_number', 'text' ) );
			jQuery( document.getElementById( 'ec_admin_order_details_shipping_empty_message' ) ).hide( );
		}else{
			jQuery( document.getElementById( 'ec_admin_order_details_tracking_number' ) ).html( '' );
			jQuery( document.getElementById( 'ec_admin_order_details_shipping_empty_message' ) ).show( );
		}
		var data = {
			action: 'ec_admin_ajax_edit_shipping_method_info',
			order_id: ec_admin_get_value( 'order_id', 'text' ),
			use_expedited_shipping: ec_admin_get_value( 'use_expedited_shipping', 'select' ),
			shipping_method: ec_admin_get_value( 'shipping_method', 'text' ),
			shipping_carrier: ec_admin_get_value( 'shipping_carrier', 'text' ),
			tracking_number: ec_admin_get_value( 'tracking_number', 'text' )
		};
		
		jQuery.ajax({url: ajax_object.ajax_url, type: 'post', data: data, success: function(data){
			jQuery( document.getElementById( 'ec_admin_order_details_shipping_method_form' ) ).hide( );
			jQuery( document.getElementById( 'ec_admin_view_shipping_method' ) ).show( );
			ec_admin_hide_loader( 'ec_admin_shipping_details' );
		} } );
		
		ec_admin_order_details_shipping_method_show = false;
		
	}else{
		jQuery( document.getElementById( 'ec_admin_order_details_shipping_method_form' ) ).show( );
		jQuery( document.getElementById( 'ec_admin_view_shipping_method' ) ).hide( );
		ec_admin_order_details_shipping_method_show = true;
	}
}

function ec_admin_process_customer_notes( ){
	if( ec_admin_order_details_customer_notes_show ){
		jQuery( document.getElementById( "ec_admin_shipping_details" ) ).fadeIn( 'fast' );
		
		jQuery( document.getElementById( 'ec_admin_order_details_customer_notes' ) ).html( ec_admin_get_value( 'order_customer_notes', 'text' ) );
		if( ec_admin_get_value( 'order_customer_notes', 'text' ) != '' ){
			jQuery( document.getElementById( 'ec_admin_order_details_customer_notes_empty_message' ) ).hide( );
		}else{
			jQuery( document.getElementById( 'ec_admin_order_details_customer_notes_empty_message' ) ).show( );
		}
		
		var data = {
			action: 'ec_admin_ajax_edit_customer_notes',
			order_id: ec_admin_get_value( 'order_id', 'text' ),
			order_customer_notes: ec_admin_get_value( 'order_customer_notes', 'text' )
		};
		
		jQuery.ajax({url: ajax_object.ajax_url, type: 'post', data: data, success: function(data){
			jQuery( document.getElementById( 'ec_admin_order_details_customer_notes_form' ) ).hide( );
			jQuery( document.getElementById( 'ec_admin_order_details_customer_notes_content' ) ).show( );
			ec_admin_hide_loader( 'ec_admin_shipping_details' );
		} } );
		
		ec_admin_order_details_customer_notes_show = false;
	}else{
		jQuery( document.getElementById( 'ec_admin_order_details_customer_notes_form' ) ).show( );
		jQuery( document.getElementById( 'ec_admin_order_details_customer_notes_content' ) ).hide( );
		ec_admin_order_details_customer_notes_show = true;
	}
}

function ec_admin_send_order_shipped_email( ){
	jQuery( document.getElementById( "ec_admin_order_management" ) ).fadeIn( 'fast' );
	
	var data = {
		action: 'ec_admin_ajax_order_details_send_order_shipped_email',
		order_id: ec_admin_get_value( 'order_id', 'text' ),
	};
	
	jQuery.ajax({url: ajax_object.ajax_url, type: 'post', data: data, success: function(data){
		ec_admin_hide_loader( 'ec_admin_order_management' );
	} } );
	
	ec_admin_order_details_order_info_show = false;
}