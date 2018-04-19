<?php
	function bitcion_calculator_widget()
	{
		
		$calculator_options = get_option('wp_bitcoin_calculator_options');
		$url = plugins_url();
		
	?>	
		
		
		<div class="bitcoin-curreny-calculator">
		
			<div class="heading">
				<img src="<?php echo $url."/bitcoin-currency-converter/bitcoin.png"; ?>"/>&nbsp;&nbsp;Bitcoin Currency Converter
			</div>
			
			<div class="sub-heading">
				Amount of BTC to convert
			</div>
			
			<div id="bitcoin-calculator-ammount">
				<input type="number" value="1" type="text" id="ammount-to-convert"/>
			</div>
			
			<div class="sub-heading">
				To currency:
			</div>
			
			<div class="bitcion-calculator-select">
				<?php	
		
					$currencyOptions = get_option('bitcoin_calculator_options');
										
					$items = array("USD", "GBP", "CNY", "EUR", "CAD", "AUD", "NZD");
							
					echo "<select id='calculator_dropdown_currency' name='bitcoin_calculator_options[currency]'>";
					
					foreach($items as $item) {
						$selected = (get_option('bitcoin_calculator_options')==$item) ? 'selected="selected"' : '';
						
						echo "<option value='$item' $selected>$item</option>";
					}
					
					echo "</select>";
				?>
			</div>
			
			
			
			<div class="bitcoin-calculator-exchanged">
				<span class="btc-converted-amount">1BTC =</span>
			</div>
			
			<div class="bitcoin-curreny-calculator-footer">
                <div class="bitcoin-curreny-calculator-link">
                    Powered by <a href="https://www.cryptogrind.com">cryptogrind - Bitcoin Freelance Platform</a>
                </div>
        	</div>
			
		</div>
		
		
		<script type="text/javascript">
		
			var j = jQuery.noConflict();

			j(function(){
				
				convert ();
				
				j('#calculator_dropdown_currency').change(function (){
										
					convert ();
					
				});
				
				j('#ammount-to-convert').change(function(){
				
					j('#ammount-to-convert').trigger("keyup");
				
				});
				
				j('#ammount-to-convert').keyup(function(){
				
					convert ();
				
				});
				
			});
			
			
			
			function convert ()
			{
				j('.btc-converted-amount').html('Converting...');
				var url = '<?php echo bloginfo('wpurl'); ?>' + '/wp-content/plugins/bitcoin-currency-converter/lib/exchange/exchange.php';
								
				var a = j('#ammount-to-convert').val();
				var c = j('#calculator_dropdown_currency').val();
				
				var data = "a="+a +"&c="+c;
				
				j.ajax({
				type: 'POST',
				url: url, 
				data: data, 
				}).success(function(d) {
					var data = JSON.parse(d);
					var price = data.price.bpi[j('#calculator_dropdown_currency').val()].rate_float * j('#ammount-to-convert').val();
					display = price.toFixed(2);
					j('.btc-converted-amount').html(data.sym + display);
				});
			}
			
		</script>
		
	<?php
	}
	
	
?>