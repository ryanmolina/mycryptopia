<?php



function bitcoin_calculator_html ()

{		

?>

	<h2>

		Bitcoin Currency Converter

	</h2>

    <div>

    	<form action="options.php" method="post" name="options">
			<? echo wp_nonce_field('update-options') ?>
			<select id='bitcoin_calculator_dropdown_currency' name='bitcoin_calculator_options' >
				<option <? echo get_option('bitcoin_calculator_options') === 'USD' ?  'selected="selected"' : ''; ?> value='USD'>USD</option>
				<option <? echo get_option('bitcoin_calculator_options') === 'GBP' ?   'selected="selected"' : ''; ?> value='GBP'>GBP</option>
				<option <? echo get_option('bitcoin_calculator_options') === 'CNY' ?  'selected="selected"' : ''; ?> value='CNY'>CNY</option>
				<option <? echo get_option('bitcoin_calculator_options') === 'EUR' ?  'selected="selected"' : ''; ?> value='EUR'>EUR</option>
				<option <? echo get_option('bitcoin_calculator_options') === 'CAD' ?  'selected="selected"' : ''; ?> value='CAD'>CAD</option>
				<option <? echo get_option('bitcoin_calculator_options') === 'AUD' ?  'selected="selected"' : ''; ?> value='AUD'>AUD</option>
				<option <? echo get_option('bitcoin_calculator_options') === 'NZD'?  'selected="selected"' : ''; ?> value='NZD'>NZD</option>
			</select>
			
            <p class="submit">
                <input name="Submit" type="submit" class="button-primary" value="<?php esc_attr_e('Save Changes'); ?>" />
				<input type="hidden" name="action" value="update" />
				<input type="hidden" name="page_options" value="bitcoin_calculator_options" />
            </p>
			 
        </form>

    	

    </div>

	
	<h4>
		Earn bitcoin and hire freelancers at http://www.cryptogrind.com 
	</h4>



<?php

}

?>