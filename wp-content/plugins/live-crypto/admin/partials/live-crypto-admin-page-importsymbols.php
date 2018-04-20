<?php

/**
 * Import Crypto and Fiat symbols from cryptocompare.com API
 *
 *
 * @link       http://happyrobotstudio.com
 * @since      1.0.0
 *
 * @package    Live Crypto
 * @subpackage Live Crypto/admin/partials
 */

?>

<h1 class="livecrypto-settings-page-heading">
      <div class="livecrypto-settings-page-header-logo-container">
            <img class="livecrypto-settings-page-header-logo" src="<?php echo WP_PLUGIN_URL . '/' . $this->plugin_name . '/admin/assets/the_menu_icon_444.png'; ?>"/>
      </div>
      <?php /*echo esc_html( get_admin_page_title() );*/ ?>

      Live Crypto Import Symbols
</h1>



<!--
<a href="edit.php?post_type=cryptosymbol&page=live-crypto-importsymbols&import=crypto" class="page-title-action">Refresh CRYPTO Symbols</a>
<a href="edit.php?post_type=cryptosymbol&page=live-crypto-importsymbols&import=fiat" class="page-title-action">Set up default FIAT Symbols</a>
 -->


<?php

function import_crypto_symbols() {

    // Get api/data/coinlist
    $cryp_ch = curl_init();
    curl_setopt_array(
        $cryp_ch, array(
        CURLOPT_URL => 'https://www.cryptocompare.com/api/data/coinlist/',
        CURLOPT_RETURNTRANSFER => true
    ));
    $cryp_output = curl_exec($cryp_ch);
    $decode = json_decode($cryp_output);
    $decode = $decode->Data;

    //echo "<pre style='font-size:10px;'>"; var_dump($decode); die();

    echo "<h3 style='margin-top:60px;'>Refreshing Cryptocurrencies from cryptocompare.com API</h3>";
    echo "<h5>This routine will gather the latest list of Cryptocurrencies from the cryptocompare.com API.</h5>";




    foreach ($decode as $cryptosymbol => $cryptoobj) {

        // echo "<pre>"; var_dump($cryptoobj); die();

        // clean the title from non alphanumeric
        $cryptosymbol = preg_replace("/[^A-Za-z0-9 ]/", '', $cryptosymbol);



        // $cryptoobj->Id
        // $cryptoobj->Url
        // $cryptoobj->ImageUrl
        // $cryptoobj->Name
        // $cryptoobj->CoinName
        // $cryptoobj->FullName
        // $cryptoobj->Algorithm
        // $cryptoobj->ProofType
        // $cryptoobj->FullyPremined
        // $cryptoobj->TotalCoinSupply
        // $cryptoobj->PreMinedValue
        // $cryptoobj->TotalCoinsFreeFloat
        // $cryptoobj->SortOrder

        // create a cryptosymbol custom post per symbol if none exists
        if( null == get_page_by_title($cryptosymbol, OBJECT, 'cryptosymbol') ) {

        	$post_id = wp_insert_post(
        		array(
        			'comment_status'	=>	'closed',
        			'ping_status'		=>	'closed',
        			'post_author'		=>	get_current_user_id(),
        			'post_name'		    =>	$cryptosymbol,
        			'post_title'		=>	$cryptosymbol,
        			'post_status'		=>	'publish',
        			'post_type'		    =>	'cryptosymbol'
        		)
        	);



            if( $post_id == 0 ) {
                echo "<span style='color:red;'>error while creating $cryptosymbol  </span><br/> ";
            }
            else {

                echo "<span style='color:green;'>$cryptosymbol created</span> |  ";

                update_post_meta( $post_id, 'api_CoinName', $cryptoobj->CoinName );
                update_post_meta( $post_id, 'api_Symbol', $cryptoobj->Symbol );
                update_post_meta( $post_id, 'api_ImageUrl', $cryptoobj->ImageUrl );
                update_post_meta( $post_id, 'api_Id', $cryptoobj->Id );


            }


        } else {
            //echo "<span style='color:grey; font-size:8px;'>$cryptosymbol exists</span> | ";
        }



    }


    echo "<h1 class=''>Cryptosymbol Import Complete!</h1>";

}



function import_fiat_symbols() {
    // For FIAT currencies, we will simply set up a default set
    // .. the manual 'add new' button is made available for manual post addition

    $decode['USD'] = 'init';
    $decode['JPY'] = 'init';
    $decode['EUR'] = 'init';
    $decode['GBP'] = 'init';
    $decode['CHF'] = 'init';
    $decode['CAD'] = 'init';
    $decode['AUD'] = 'init';
    $decode['NZD'] = 'init';
    $decode['SGD'] = 'init';
    $decode['CNY'] = 'init';
    $decode['KRW'] = 'init';

    echo "<h3>Setting Up Default FIAT Currencies</h3>";
    echo "<h5>This routine will add a set of default Fiat Currencies</h5>";
    echo "<h5>View results and add further Fiat Currencies in <i>Live Crypto -> Fiat Symbols</i></h5>";

    foreach ($decode as $fiatsymbol => $fiatobj) {

        // create a cryptosymbol custom post per symbol if none exists
        if( null == get_page_by_title($fiatsymbol, OBJECT, 'fiatsymbol') ) {

        	$post_id = wp_insert_post(
        		array(
        			'comment_status'	=>	'closed',
        			'ping_status'		=>	'closed',
        			'post_author'		=>	get_current_user_id(),
        			'post_name'		    =>	$fiatsymbol,
        			'post_title'		=>	$fiatsymbol,
        			'post_status'		=>	'publish',
        			'post_type'		    =>	'fiatsymbol'
        		)
        	);

            if( $post_id == 0 ) {
                echo "<span style='color:red;'>$fiatsymbol error while creating new post</span><br/> ";
            }
            else {
                echo "<span style='color:green;'>$fiatsymbol created</span><br/> ";
            }

        } else {
            echo "<span style='color:grey;'>$fiatsymbol exists</span><br/> ";
        }

    }
}



$importswitch = $_GET['import'];
if($importswitch){

    if( $importswitch == 'crypto' ) {
        import_crypto_symbols();
    }
    else if( $importswitch == 'fiat' ) {
        import_fiat_symbols();
    }

}


// gather all of the ACCEPTS from the wpdb
// global $wpdb;
// $livecrypto_all_acceptances = $wpdb->get_results("SELECT * FROM `".$wpdb->prefix."livecryptolog` ORDER BY id DESC;");

// $all_of_the_acceptances = json_encode(  );
// if( true ) { //empty($all_of_the_acceptances) ) {
//       $all_of_the_acceptances = '[{"id":"1","ip_address":"BEGIN_ACCEPTANCE_LOG","date_accepted":"2017-01-01 00:00:00"},]';
// }
//var_dump($all_of_the_acceptances);
?>



<?php
// foreach(  $livecrypto_all_acceptances as $livecrypto_item ) {
//           echo '"id": '.$livecrypto_item->id.', "ip_address": "'.$livecrypto_item->ip_address.'", "date_accepted": "'.$livecrypto_item->date_accepted.'"<br/>';
// }
?>
