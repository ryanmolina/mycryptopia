<?php

	if(isset($_POST["a"]))
	{
		$a = (float)$_POST["a"];
	}
	
	if(isset($_POST["c"]))
	{
		$c = $_POST["c"];
	}
	
		
	if($a != 0 && $a > 0)
	{
	
		switch($c){
			case "USD";
				$sym = "&#36;";
			break;
			case "GBP";
				$sym = "&#8356;";
			break;
			case "CNY";
				$sym = "&#xa5;";
			break;
			case "EUR";
				$sym = "&#8364;";
			break;
			case "CAD";
				$sym = "&#36;";
			break;
			case "AUD";
				$sym = "&#36;";
			break;
			case "NZD";
				$sym = "&#36;";
			break;
		}
		
		$url = "https://api.coindesk.com/v1/bpi/currentprice/". $c;
		
		//echo $url;
		
		try {
			
			$curl = curl_init($url);
		
			if (is_resource($curl) === true)
			{
				curl_setopt($curl, CURLOPT_FAILONERROR, true);
				curl_setopt($curl, CURLOPT_FOLLOWLOCATION, false);
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
				curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		
				$result = curl_exec($curl);
				curl_close($curl);
			}
						
			echo '{ "sym": "' .$sym. '", "price" : ' .$result.' }';
			
				
			
		} catch (Exception $e) {
			
		    echo 'Caught exception: ',  $e->getMessage(), "\n";
		}
	
	}
	else
	{
		echo "Invalid Input";
	}
	
	
?>