<?php
// This is a payment gateway basic structure,
// child classes will be based on this class.

class ec_square extends ec_gateway{
	
	/****************************************
	* GATEWAY SPECIFIC HELPER FUNCTIONS
	*****************************************/
	
	function get_gateway_data( ){
		
		$json_arr = array( 	"card_nonce"			=> $_POST['nonce'],
							"amount_money"			=> array(
								"amount"				=> (integer) number_format( $this->order_totals->grand_total * 100, 0, "", "" ),
								"currency"				=> get_option( 'ec_option_square_currency' )
							),
							"idempotency_key"		=> uniqid( ),
							"reference_id"			=> (string) $this->order_id,
							"billing_address"		=> array( 
								"address_line_1"	=> (string) $this->user->billing->address_line_1,
								"address_line_2"	=> (string) $this->user->billing->address_line_2,
								"locality"			=> (string) $this->user->billing->city,
								"administrative_district_level_1"	=> (string) $this->user->billing->state,
								"postal_code"		=> (string) $this->user->billing->zip,
								"country"			=> (string) $this->user->billing->country
							),
							"shipping_address"		=> array( 
								"address_line_1"	=> (string) $this->user->shipping->address_line_1,
								"address_line_2"	=> (string) $this->user->shipping->address_line_2,
								"locality"			=> (string) $this->user->shipping->city,
								"administrative_district_level_1"	=> (string) $this->user->shipping->state,
								"postal_code"		=> (string) $this->user->shipping->zip,
								"country"			=> (string) $this->user->shipping->country
							),
							"buyer_email_address"	=> (string) $this->user->email );
		
		$application_fee = number_format( $this->order_totals->grand_total * 100 * apply_filters( 'wp_easycart_stripe_connect_fee_rate', 2 ) * .01, 0, '', '' );
		if( $application_fee > 0 ){
			$json_arr["additional_recipients"] = array(
				(object) array(
								"location_id"		=> "D3G74XXQYM8Y5",
								"description"		=> "Application Fees",
								"amount_money"		=> (object) array(
									"amount"		=> (int) $application_fee,
									"currency"		=> get_option( 'ec_option_square_currency' )
								)
				)
			);
		}
		
		return $json_arr;
		
	}
	
	function get_gateway_url( ){
		
		$location_id = get_option( 'ec_option_square_location_id' );
		if( !$location_id )
			$location_id = $this->get_location_id( );
		return "https://connect.squareup.com/v2/locations/" . $location_id . "/transactions";

	}
	
	function handle_gateway_response( $response ){
		
		$response_arr = json_decode( $response );
		
		$error_text = "";
		if( isset( $response_arr->errors ) && count( $response_arr->errors ) > 0 ){
			$this->is_success = 0;
			$error_text = $response_arr->errors[0]->detail;
		}else{
			$this->is_success = 1;
			$ids = array( "transaction_id"	=> $response_arr->transaction->id, "tender_id" => $response_arr->transaction->tenders[0]->id );
			$this->mysqli->update_order_transaction_id( $this->order_id, json_encode( $ids ) );
		}
		
		$this->mysqli->insert_response( $this->order_id, !$this->is_success, "Square", $error_text );
		
		if( !$this->is_success )
			$this->error_message = $error_text;
			
	}
	
	function get_gateway_response( $gateway_url, $gateway_data, $gateway_headers ){
		
		if( get_option( 'ec_option_square_application_id' ) == '' ){
			$this->renew_token( );
		}
		
		$access_token = get_option( 'ec_option_square_access_token' );
		$headr = array();
		$headr[] = 'Accept: application/json';
		$headr[] = 'Content-Type: application/json';
		$headr[] = 'Authorization: Bearer ' . $access_token;
		
		$ch = curl_init( );
		curl_setopt($ch, CURLOPT_URL, $gateway_url );
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headr );
		curl_setopt($ch, CURLOPT_POST, true ); 
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode( $gateway_data ) );
		curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_DEFAULT );
		curl_setopt($ch, CURLOPT_TIMEOUT, (int)30);
		$response = curl_exec($ch);
		if( $response === false )
			$this->mysqli->insert_response( 0, 1, "SQUARE CURL ERROR", curl_error( $ch ) );
		else
			$this->mysqli->insert_response( 0, 0, "Square Charge Response", print_r( $response, true ) );
		
		curl_close ($ch);
		
		return $response;
		
	}
	
	function get_location_id( ){
		$access_token = get_option( 'ec_option_square_access_token' );
		$headr = array();
		$headr[] = 'Accept: application/json';
		$headr[] = 'Authorization: Bearer ' . $access_token;
		
		$ch = curl_init( );
		curl_setopt($ch, CURLOPT_URL, "https://connect.squareup.com/v2/locations" );
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headr );
		curl_setopt($ch, CURLOPT_POST, false ); 
		curl_setopt($ch, CURLOPT_HTTPGET, true );
		curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_DEFAULT );
		curl_setopt($ch, CURLOPT_TIMEOUT, (int)30);
		$response = curl_exec($ch);
		if( $response === false )
			$this->mysqli->insert_response( 0, 1, "SQUARE CURL ERROR", curl_error( $ch ) );
		else
			$this->mysqli->insert_response( 0, 0, "Square Location Response", print_r( $response, true ) );
		
		curl_close ($ch);
		
		$response_arr = json_decode( $response );
		
		return $response_arr->locations[0]->id;
	}
	
	function set_currency( ){
		$locations = $this->get_locations( );
		if( count( $locations ) > 0 ){
			update_option( 'ec_option_square_currency', $locations[0]->currency );
		}
	}
	
	function get_locations( ){
		$access_token = get_option( 'ec_option_square_access_token' );
		$headr = array();
		$headr[] = 'Accept: application/json';
		$headr[] = 'Authorization: Bearer ' . $access_token;
		
		$ch = curl_init( );
		curl_setopt($ch, CURLOPT_URL, "https://connect.squareup.com/v2/locations" );
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headr );
		curl_setopt($ch, CURLOPT_POST, false ); 
		curl_setopt($ch, CURLOPT_HTTPGET, true );
		curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_DEFAULT );
		curl_setopt($ch, CURLOPT_TIMEOUT, (int)30);
		$response = curl_exec($ch);
		if( $response === false )
			$this->mysqli->insert_response( 0, 1, "SQUARE CURL ERROR", curl_error( $ch ) );
		else
			$this->mysqli->insert_response( 0, 0, "Square Location Response", print_r( $response, true ) );
		
		curl_close ($ch);
		
		$response_arr = json_decode( $response );
		
		return $response_arr->locations;
	}
	
	function refund_charge( $transaction_id, $refund_amount ){
		
		if( get_option( 'ec_option_square_application_id' ) == '' ){
			$this->renew_token( );
		}
		
		$ids = json_decode( $transaction_id );
		$access_token = get_option( 'ec_option_square_access_token' );
		$location_id = get_option( 'ec_option_square_location_id' );
		if( !$location_id )
			$location_id = $this->get_location_id( );
		$gateway_url = "https://connect.squareup.com/v2/locations/" . $location_id . "/transactions/" . $ids->transaction_id . "/refund";
		$gateway_data = array( 	"idempotency_key"	=> uniqid( ),
								"tender_id"			=> $ids->tender_id,
								"amount_money"		=> array(
									"amount"			=> (integer) number_format( $refund_amount * 100, 0, "", "" ),
									"currency"			=> get_option( 'ec_option_square_currency' )
								)
						);
		
		$headr = array();
		$headr[] = 'Accept: application/json';
		$headr[] = 'Content-Type: application/json';
		$headr[] = 'Authorization: Bearer ' . $access_token;
		
		$ch = curl_init( );
		curl_setopt($ch, CURLOPT_URL, $gateway_url );
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headr );
		curl_setopt($ch, CURLOPT_POST, true ); 
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode( $gateway_data ) );
		curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_DEFAULT );
		curl_setopt($ch, CURLOPT_TIMEOUT, (int)30);
		$response = curl_exec($ch);
		if( $response === false )
			$this->mysqli->insert_response( 0, 1, "SQUARE CURL ERROR", curl_error( $ch ) );
		else
			$this->mysqli->insert_response( 0, 0, "Square Refund Response", print_r( $response, true ) );
		
		curl_close ($ch);
		
		$response_arr = json_decode( $response );
		
		if( isset( $response_arr->errors ) && count( $response_arr->errors ) > 0 ){
			return false;
		}else{
			return true;
		}
		
	}
	
	function renew_token( ){
		$access_token = get_option( 'ec_option_square_access_token' );
		$response = file_get_contents( "https://support.wpeasycart.com/square/refresh.php?access_token=" . $access_token );
		$response_obj = json_decode( $response );
		
		$access_token = preg_replace( "/[^A-Za-z0-9 \-\._\~\+\/]/", '', $response_obj->access_token );
		$expires = preg_replace( "/[^A-Za-z0-9 \:\-]/", '', $response_obj->expires );
		
		update_option( 'ec_option_square_access_token', $access_token );
		update_option( 'ec_option_square_token_expires', $expires );
	}
	
}

?>