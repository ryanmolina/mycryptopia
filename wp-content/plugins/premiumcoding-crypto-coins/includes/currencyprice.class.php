<?phpclass PMCCurrencyInfo {  public static function pmc_currencyprice_pmc_shortcode( $atts ) {    if (isset($atts['currency1']) and $atts['currency1']!=''){      if (isset($atts['currency1']) and $atts['currency1']!=''){        $currency1_arr = explode(',', $atts['currency1']);      } else {        $currency1_arr = array('btc');      }            //set second currency      if (isset($atts['currency2']) and $atts['currency2']!=''){        $currency2_arr = explode(',', $atts['currency2']);      } else {        $currency2_arr = array('usd');      }      //set active shortcode daychange      if (isset($atts['daychange']) and $atts['daychange']!=''){        $daychange = $atts['daychange'];      } else {        $daychange = 'yes';      }            $html_prices = '';            //get data about cryptocurrencies      $data_json = self::pmc_convert_currency_multi($currency1_arr, $currency2_arr);      if (isset($data_json) and $data_json!=''){        $data_all_currencies_raw = json_decode($data_json, true);        $data_all_currencies = array();        //prepare data for easy search		$html = '<ul id="crypto-slider" class="crypto-slider">';        foreach ($data_all_currencies_raw['DISPLAY'] as $data_all_currencies_raw_key => $data_all_currencies_raw_value){				  		  foreach($data_all_currencies_raw_value as $key_currency => $value) {						if($key_currency == 'LTC' || $key_currency == 'ETH'){				$key_currency_echo = $key_currency ;			} else {				$key_currency_echo = '<i class = "fa fa-'.strtolower($key_currency).'"></i>';			}								$change_class = 'class="up"';			if($daychange == 'yes'){				if(!empty($value['CHANGEPCT24HOUR'])){					$change =  round($value['CHANGEPCT24HOUR'],2);					if((int)$change < 0 ) {$change_class = 'class="down"';}				} else {(int)$change = 0.0000;$change_class = 'class="up"'; }			}			$html .= '<li class="pmc-coin">'. $data_all_currencies_raw_key . ': '. $value['PRICE'] . ' <span '.$change_class.'>'.$change.'%</span></li>';		  }        }		$html .= '</ul>';                      } else {        $error = 'Error: No data from the server!';      }          } else {      $error = 'Error: No currency is set!';    }              	return $html;  }  public static function pmc_currencygraph_advance_shortcode( $atts ) {	isset($atts['coins'])? $coins = $atts['coins'] : $coins = 'BTC';	isset($atts['compare'])? $compare = $atts['compare'] : $compare = 'USD';	isset($atts['time'])? $time = $atts['time'] : $time = '1y';	isset($atts['onlygraph'])? $onlygraph = $atts['onlygraph'] : $onlygraph = 'false';	isset($atts['width'])? $width = $atts['width'] : $width = '100%';		isset($atts['height'])? $height = $atts['height'] : $height = '400px';		$coins = explode(',',$coins);	$coin_script = '';	foreach($coins as $coin){		if($compare == 'USD' || $compare == 'EUR' ){			$coin_script .= '"KRAKEN:'.$coin.$compare.'|'.$time.'",';		} else {			$coin_script .= '"BINANCE:'.$coin.$compare.'|'.$time.'",';		}	}	$graph_id = rand(0,1000);	return '	<!-- TradingView Widget BEGIN -->	<div class="tradingview-widget-container">	  <div id="tv-medium-widget-'.$graph_id.'" class="pmcgraphcrypto"></div>	  <div class="tradingview-widget-copyright advance-chart chart"><a href=\'https://premiumcoding.com\' target=\'_blank\' title=\'Plugin created by PremiumCoding\'>Plugin created by PremiumCoding</a></div>	  <script type="text/javascript" src="https://s3.tradingview.com/tv.js"></script>	  <script type="text/javascript">	  new TradingView.MediumWidget(	  {	  "container_id": "tv-medium-widget-'.$graph_id.'",	  "symbols": [			'.$coin_script.'	  ],	  "greyText": "Quotes by",	  "gridLineColor": "#e9e9ea",	  "fontColor": "#83888D",	  "underLineColor": "#dbeffb",	  "trendLineColor": "#4bafe9",	  "width": "'.$width.'",	  "height":  "'.$height.'",	  "locale": "en",	  "chartOnly": '.$onlygraph.'	}	  );	  </script>	</div>	<!-- TradingView Widget END -->				';      }    public static function pmc_currencygraph_realtime_shortcode( $atts ) {	isset($atts['coin'])? $coin = $atts['coin'] : $coin = 'BTC';	isset($atts['compare'])? $compare = $atts['compare'] : $compare = 'USD';	isset($atts['time'])? $time = $atts['time'] : $time = 'D';	isset($atts['style'])? $style = $atts['style'] : $style = '1';	$coin_script = '';	if($compare == 'USD' || $compare == 'EUR' ){		$coin_script = '"OKCOIN:'.$coin.$compare.'"';	} else {		$coin_script = '"BINANCE:'.$coin.$compare.'"';	}	$graph_id = rand(0,1000);	return '		<!-- TradingView Widget BEGIN -->		<div class="tradingview-widget-container">		   <div id="tradingview_'.$graph_id.'" class="pmcgraphcrypto"></div>	  <div class="tradingview-widget-copyright"><a href=\'https://premiumcoding.com\' target=\'_blank\' title=\'Plugin created by PremiumCoding\'>Plugin created by PremiumCoding</a></div>		  <script type="text/javascript" src="https://s3.tradingview.com/tv.js"></script>		  <script type="text/javascript">		  new TradingView.widget(		  {		  "width": "100%",		  "height": 500,		  "symbol": '.$coin_script.',		  "interval": "'.$time.'",		  "timezone": "Etc/UTC",		  "theme": "Light",		  "style": "'.$style.'",		  "locale": "en",		  "toolbar_bg": "#f1f3f6",		  "enable_publishing": false,		  "withdateranges": true,		  "allow_symbol_change": true,		  "hideideas": true,		  "container_id": "tradingview_'.$graph_id.'"		}		  );		  </script>		</div>		<!-- TradingView Widget END -->	';      }      public static function pmc_currency_text_hover_shortcode( $atts ) {	isset($atts['text'])? $text = $atts['text'] : $text = 'Crypto hover text';	isset($atts['coin'])? $coin = $atts['coin'] : $coin = 'BTC';	isset($atts['compare'])? $compare = $atts['compare'] : $compare = 'USD';	$data_json = self::pmc_convert_currency_multi(array($coin), array($compare));	$data = json_decode($data_json, true);	$change = explode(' ', $data['DISPLAY'][$coin][$compare]['CHANGEDAY']);	((float)$change[1] > 0 ) ? $style = 'up' : $style="down";	return '<div class = "crypto-hover-text">'.			'<span class="'.$style.'">'.$text.'</span>'.			'<div class = "crypto-hover-display">			<script type="text/javascript">			baseUrl = "https://widgets.cryptocompare.com/";			var scripts = document.getElementsByTagName("script");			var embedder = scripts[ scripts.length - 1 ];			(function (){			var appName = encodeURIComponent(window.location.hostname);			if(appName==""){appName="local";}			var s = document.createElement("script");			s.type = "text/javascript";			s.async = true;			var theUrl = baseUrl+"serve/v1/coin/chart?fsym='.$coin.'&tsym='.$compare.'";			s.src = theUrl + ( theUrl.indexOf("?") >= 0 ? "&" : "?") + "app=" + appName;			embedder.parentNode.appendChild(s);			})();			</script>			<div class="tradingview-widget-copyright"><a href=\'https://premiumcoding.com\' target=\'_blank\' title=\'Plugin created by PremiumCoding\'>Plugin created by PremiumCoding</a></div>			</div>'.			'</div>';      }      public static function pmc_currency_exchange_shortcode( $atts ) {	isset($atts['coin'])? $coin = $atts['coin'] : $coin = 'BTC';	isset($atts['compare'])? $compare = $atts['compare'] : $compare = 'USD';	return '<div class = "crypto-exchange">			<script type="text/javascript">			baseUrl = "https://widgets.cryptocompare.com/";			var scripts = document.getElementsByTagName("script");			var embedder = scripts[ scripts.length - 1 ];			(function (){			var appName = encodeURIComponent(window.location.hostname);			if(appName==""){appName="local";}			var s = document.createElement("script");			s.type = "text/javascript";			s.async = true;			var theUrl = baseUrl+"serve/v1/coin/tiles?fsym='.$coin.'&tsyms='.$compare.'";			s.src = theUrl + ( theUrl.indexOf("?") >= 0 ? "&" : "?") + "app=" + appName;			embedder.parentNode.appendChild(s);			})();			</script>			</div>';      }       public static function pmc_currencygraph_ticker_shortcode( $atts ) {	isset($atts['coins'])? $coins = $atts['coins'] : $coins = 'BTCUSD';	isset($atts['desc'])? $desc = $atts['desc'] : $desc = '';	$coins = explode(',',$coins);	$coin_script = '';	$currency_array = array('USD','EUR');	foreach($coins as $coin){		$separator = '';		if($coin !== end($coins)) {$separator = ',';}		if(strpos(strtoupper($coin), 'USD') || strpos(strtoupper($coin), 'EUR')){			if(strpos(strtoupper($coin), 'BTC')  !== false ){				$coin_script .= '{"description": "'.$desc.'","proName":"COINBASE:'.strtoupper($coin).'"}'.$separator.'';			} else {				$coin_script .= '{"description": "'.$desc.'","proName":"KRAKEN:'.strtoupper($coin).'"}'.$separator.'';			}		} else {			$coin_script .= '{"description": "","proName":"BINANCE:'.strtoupper($coin).'"}'.$separator.'';		}			}	$graph_id = rand(0,1000);	return '		<!-- TradingView Widget BEGIN -->		<div class="tradingview-widget-container crypto-ticker">		  <div class="tradingview-widget-container__widget"></div>	  <div class="tradingview-widget-copyright advance-chart"><a href=\'https://premiumcoding.com\' target=\'_blank\' title=\'Plugin created by PremiumCoding\'>Plugin created by PremiumCoding</a></div>		  <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-tickers.js" async>		  {		  "symbols": [			'.$coin_script.'		  ],		  "locale": "en"		}		  </script>		</div>		<!-- TradingView Widget END -->	';  }        public static function pmc_currencygraph_ticker_2_shortcode( $atts ) {	isset($atts['coins'])? $coins = $atts['coins'] : $coins = 'BTC';	isset($atts['compare'])? $compare = $atts['compare'] : $compare = 'USD';	isset($atts['width'])? $width = $atts['width'] : $width = '100%';	$rand = rand(0,1000);	return '		<style scoped>.crypto-ticker-2-'.$rand.',.crypto-ticker-2-'.$rand.' .ccc-widget{width:'.$width.' !important;}</style>		<div class="crypto-ticker-2-'.$rand.' crypto-ticker-2">		<i class="fa fa-spinner fa-pulse"></i>		<script type="text/javascript">		baseUrl = "https://widgets.cryptocompare.com/";		var scripts = document.getElementsByTagName("script");		var embedder = scripts[ scripts.length - 1 ];		var cccTheme = {"General":{"float":"left"}};		(function (){		var appName = encodeURIComponent(window.location.hostname);		if(appName==""){appName="local";}		var s = document.createElement("script");		s.type = "text/javascript";		s.async = true;		var theUrl = baseUrl+"serve/v2/coin/header?fsyms='.$coins.'&tsyms='.$compare.'";		s.src = theUrl + ( theUrl.indexOf("?") >= 0 ? "&" : "?") + "app=" + appName;		embedder.parentNode.appendChild(s);		})();		</script>		</div>	';  }       public static function pmc_currencyprice_shortcode( $atts ) {    if (isset($atts['currency1']) and $atts['currency1']!=''){      //set first currency      $currency1 = $atts['currency1'];      //set default data for first currency      $currency1_data = self::pmc_prepare_currency_data($currency1, 1);             //set second currency      if (isset($atts['currency2']) and $atts['currency2']!=''){        $currency2_arr = explode(',', $atts['currency2']);      } else {        $currency2_arr = array('usd');      }            //set active shortcode feature      if (isset($atts['feature']) and $atts['feature']!=''){        $feature = $atts['feature'];      } else {        $feature = 'all';      }            $html_prices = '';      $html_calc = '';            //get data about cryptocurrencies      $data_json = self::pmc_convert_currency($currency1_data['name'], $currency2_arr);            if (isset($data_json) and $data_json!=''){        $data_all_currencies_raw = json_decode($data_json, true);        $data_all_currencies = array();        //prepare data for easy search        foreach ($data_all_currencies_raw as $data_all_currencies_raw_key => $data_all_currencies_raw_value){          $key_lower = trim(strtolower($data_all_currencies_raw_key));          $data_all_currencies[$key_lower] = $data_all_currencies_raw_value;        }                         $html_prices .= '<table class="prices-table">';                    foreach ($currency2_arr as $currency2) {            $currency2_filtered = trim(strtolower($currency2));          $currency2_data = self::pmc_prepare_currency_data($currency2_filtered, $data_all_currencies[$currency2_filtered]);                    $html_prices .= self::pmc_render_price($currency1_data, $currency2_data);            }        $html_prices .= '</table>';                          } else {        $error = 'Error: No data from the server!';      }          } else {      $error = 'Error: No currency is set!';    }        //prepate final data    $html = '';    if (!isset($error) or !$error){      if ($feature == 'prices' or $feature == 'all'){        $html .= $html_prices;      }    } else {      $html = $error;    }        $html .= '';      	return $html;  }  public static function pmc_currencygraph_shortcode( $atts ) {    global $pmc_chart_js_loaded;    $html = '';        //load javascript library    wp_enqueue_script( "gcharts", "https://www.gstatic.com/charts/loader.js" );      if (isset($atts['currency1']) and $atts['currency1']!=''){      $currency1 = $atts['currency1'];            if (isset($atts['currency2']) and $atts['currency2']!=''){        $currency2 = $atts['currency2'];      } else {        $currency2 = array('btc');      }        //generate random chart id      $chart_id = rand(1000,9999);        //check if library is loaded      if (!$pmc_chart_js_loaded){                           //load javascript functions        $html .= '        <script type="text/javascript">          function setCandlestickPeriod(candlestickChartDataOptions, period){            if (period == "1hour"){              candlestickChartDataOptions.group_by = "minute";              candlestickChartDataOptions.data_points = 20;              candlestickChartDataOptions.aggregate = 3;            } else if (period == "24hours"){              candlestickChartDataOptions.group_by = "hour";              candlestickChartDataOptions.data_points = 24;              candlestickChartDataOptions.aggregate = 1;            } else if  (period == "30days"){              candlestickChartDataOptions.group_by = "day";              candlestickChartDataOptions.data_points = 30;              candlestickChartDataOptions.aggregate = 1;                    } else if  (period == "1year"){              candlestickChartDataOptions.group_by = "day";              candlestickChartDataOptions.data_points = 73;              candlestickChartDataOptions.aggregate = 5;                    }          }                    function candlestickLoadData(candlestickChartDataOptions, chart_id){             var candlestickDataUrl = "https://min-api.cryptocompare.com/data/"+              "histo"+candlestickChartDataOptions.group_by+              "?fsym="+candlestickChartDataOptions.currency1+              "&tsym="+candlestickChartDataOptions.currency2+              "&limit="+candlestickChartDataOptions.data_points+              "&aggregate="+candlestickChartDataOptions.aggregate+              "&e=CCCAGG";            jQuery.get(candlestickDataUrl, function( rawData ) {              console.log("Data loaded");                            //reset any old data              var candlestickChartData = [];              rawData.Data.forEach(function(rawDataSingle) {                var singleDateTime = convertCandlestickTime(candlestickChartDataOptions, rawDataSingle.time);                candlestickChartData.push([singleDateTime, rawDataSingle.low, rawDataSingle.open, rawDataSingle.close, rawDataSingle.high]);              });                          google.charts.load("current", {"packages":["corechart"]});              google.charts.setOnLoadCallback( function(){drawChart(candlestickChartDataOptions, candlestickChartData, chart_id);} );            });          }                    function drawChart(candlestickChartDataOptions, candlestickChartData, chart_id) {            var data = google.visualization.arrayToDataTable(candlestickChartData, true);            var options = {              legend:"none",              title:candlestickChartDataOptions.currency1+" price in "+candlestickChartDataOptions.currency2,              bar: { groupWidth: "70%" }, // sets space between bars              candlestick: {                fallingColor: { strokeWidth: 0, fill: "#a52714" }, // red                risingColor: { strokeWidth: 0, fill: "#0f9d58" }   // green              }            };            var chart = new google.visualization.CandlestickChart(document.getElementById(chart_id));                        chart.draw(data, options);          }                    function convertCandlestickTime(candlestickChartDataOptions, UNIX_timestamp){            var a = new Date(UNIX_timestamp * 1000);            var year = a.getFullYear();            var month = dateFormatNumber(a.getMonth()+1, 2);            var date = dateFormatNumber(a.getDate(), 2);            var hour = dateFormatNumber(a.getHours(), 2);            var min = dateFormatNumber(a.getMinutes(), 2);            var sec = dateFormatNumber(a.getSeconds(), 2);                if (candlestickChartDataOptions.group_by == "minute"){              var time = hour+":"+min;            } else if (candlestickChartDataOptions.group_by == "hour"){              var time = hour+":"+min+" "+date+"."+month;            } else {              var time = date+"."+month+"."+year;            }                        return time;          }                    function dateFormatNumber(n, p, c) {            var pad_char = typeof c !== "undefined" ? c : "0";            var pad = new Array(1 + p).join(pad_char);            return (pad + n).slice(-pad.length);          }        </script>              ';                //set flag - chart js is loaded        $pmc_chart_js_loaded = 1;      }            //generate javascript for the graphic            $html .= '        <script type="text/javascript">          candlestickChartDataOptions_'.$chart_id.' = {            currency1 : "'.strtoupper($currency1).'",             currency2 : "'.strtoupper($currency2).'",             group_by: "day",             data_points: 30,             aggregate: 1          };                    jQuery( document ).ready(function() {            setCandlestickPeriod(candlestickChartDataOptions_'.$chart_id.', "30days");            candlestickLoadData(candlestickChartDataOptions_'.$chart_id.', "'.$chart_id.'");                        jQuery( "select#chart_period_'.$chart_id.'" ).change(function() {              setCandlestickPeriod(candlestickChartDataOptions_'.$chart_id.', jQuery(this).val());              candlestickLoadData(candlestickChartDataOptions_'.$chart_id.', "'.$chart_id.'");            });          });        </script>      ';        //generate html for the graphic          $html .= '        <div class="chart_wrap">          <div class="chart_options">            <form>              <label>'.__('Select interval', 'pmc-crypto').':</label>              <select name="chart_period" id="chart_period_'.$chart_id.'">                <option value="1hour">'.__('1 hour', 'pmc-crypto').'</option>                <option value="24hours">'.__('24 hours', 'pmc-crypto').'</option>                <option value="30days" selected="selected">'.__('30 days', 'pmc-crypto').'</option>                <option value="1year">'.__('1 year', 'pmc-crypto').'</option>              </select>            </form>          </div>          <div id="'.$chart_id.'"></div>        </div>      ';            //discard old data      unset($data_json);    } else {      $html .= 'Error: No currency is set!';    }        $html .= '';      	return $html;  }  public static function pmc_all_currencies_shortcode($atts){    $html = '';        if (isset($atts['algorithm']) and $atts['algorithm']=='no'){      $display_algorithm = 0;    } else {      $display_algorithm = 1;    }    if (isset($atts['supply']) and $atts['supply']=='no'){      $display_supply = 0;    } else {      $display_supply = 1;    }    if (isset($atts['url']) and $atts['url']=='yes'){      $display_url = 1;    } else {      $display_url = 0;    }      $data_url = 'https://www.cryptocompare.com/api/data/coinlist/';    //send api request    $data_json = PMCCommon::pmc_get_url_data_curl($data_url);    $data_all_currencies_raw = json_decode($data_json, true);    $data_all_currencies = $data_all_currencies_raw['Data'];        //sort currencies by order    usort($data_all_currencies, array('PMCCurrencyInfo', 'sortByOrder') );        $html .= '<table class="cryptocurrencies-table">';    $html .= '<tr>';    $html .= '<th>'.__('Coin', 'pmc-crypto').'</th>';    if ($display_algorithm){ $html .= '<th>'.__('Algorithm; Proof type', 'pmc-crypto').'</th>'; }    if ($display_supply){ $html .= '<th>'.__('Total supply', 'pmc-crypto').'</th>'; }    $html .= '</tr>';        foreach ($data_all_currencies as $data_currency){      $picture = PMCCommon::pmc_get_currency_image($data_currency['Name']);            if ( isset($data_currency['TotalCoinSupply']) && $data_currency['TotalCoinSupply']!= 0 ){        $total_supply = htmlspecialchars($data_currency['TotalCoinSupply']);      } else {        $total_supply = '-';      }            if ($display_url){        $url_start = '<a href="https://www.cryptocompare.com'.$data_currency['Url'].'" target="_blank">';        $url_end = '</a>';      } else {        $url_start = '';        $url_end = '';      }            $html .=  '<tr>';      $html .=  '        <td>          '.$url_start.'            <img src="'.$picture.'" alt="'.htmlspecialchars($data_currency['FullName']).'" />          '.htmlspecialchars($data_currency['FullName']).'          '.$url_end.'        </td>      ';            if ($display_algorithm){        $html .=  '<td>'.htmlspecialchars($data_currency['Algorithm']).'; '.htmlspecialchars($data_currency['ProofType']).' </td>';            }      if ($display_supply){        $html .=  '<td>'.$total_supply.'</td>';      }      $html .=  '</tr>';      }        $html .= '</table>';        $html .= '';        return $html;  }  public static function pmc_convert_currency($currency1, $currency2_arr){    //prepate api url    $data_url_currency_1 = trim(strtoupper($currency1));    $data_url_currency_2 = '';    foreach ($currency2_arr as $currency2) {      if ($data_url_currency_2 != ''){        $data_url_currency_2 .= ',';      }      $data_url_currency_2 .= trim(strtoupper($currency2));    }        $data_url = 'https://min-api.cryptocompare.com/data/price?fsym='.$data_url_currency_1.'&tsyms='.$data_url_currency_2;    //send api request    $data_json = PMCCommon::pmc_get_url_data_curl($data_url);    return $data_json;   }   public static function pmc_convert_currency_multi($currency1_arr, $currency2_arr){    //prepate api url	$data_url_currency_1 = $data_url_currency_2 = '';	$currency1_arr = array_slice($currency1_arr , 0 , 50 );    foreach ($currency1_arr as $currency1) {       $data_url_currency_1 .= trim(strtoupper($currency1)). ',';    }  	    foreach ($currency2_arr as $currency2) {      $data_url_currency_2 .= trim(strtoupper($currency2)) . ',';    }        $data_url = 'https://min-api.cryptocompare.com/data/pricemultifull?fsyms='.$data_url_currency_1.'&tsyms='.$data_url_currency_2;    //send api request    $data_json = PMCCommon::pmc_get_url_data_curl($data_url);    return $data_json;   }   private static function pmc_render_price($currency1, $currency2) {      //draws the actual ticker prices for table      $picture1 = PMCCommon::pmc_get_currency_image($currency1['name']);    $picture2 = PMCCommon::pmc_get_currency_image($currency2['name']);        //calculate the price    $price_per_unit = self::pmc_calculate_price_per_unit($currency1['price'], $currency2['price']);    if ($price_per_unit >= 10000){      $price_per_unit_string = number_format(round($price_per_unit, 4), 4, '.', '');    } elseif ($price_per_unit >= 1000){      $price_per_unit_string = number_format(round($price_per_unit, 5), 5, '.', '');    } elseif ($price_per_unit >= 100){      $price_per_unit_string = number_format(round($price_per_unit, 6), 6, '.', '');    } elseif ($price_per_unit >= 10){      $price_per_unit_string = number_format(round($price_per_unit, 7), 7, '.', '');      } else {      $price_per_unit_string = number_format(round($price_per_unit, 8), 8, '.', '');    }        $result = '      <tr>    		<td>    			<img src="'.$picture1.'" title="'.$currency1['name'].'" class="crypto-ticker-icon" />          1 '.strtoupper($currency1['name']).' =     		</td>    		<td>          <img src="'.$picture2.'" title="'.$currency2['name'].'" class="crypto-ticker-icon" />    			'.$price_per_unit_string.' '.strtoupper($currency2['name']).'    		</td>      </tr>    ';      return $result;  }    private static function pmc_calculate_price_per_unit($currency1, $currency2){    //calculate the price    if ($currency2 != 0){      $price_per_unit = $currency1 / $currency2;    } else {      //error in the data, avoid diviion by zero       $price_per_unit = 0;    }        return $price_per_unit;   }    private static function pmc_prepare_currency_data($currency, $currency_price){    $currency_data = array(      'name' => trim(strtolower($currency)),    );        if (!isset($currency_price) or $currency_price == 0 or $currency_price == null){      //fix null price value      $currency_data['price'] = 0;    } else {      //price is ok      $currency_data['price'] = 1/$currency_price;    }        return $currency_data;  }  private static function sortByOrder($a, $b) {    return $a['SortOrder'] - $b['SortOrder'];  }}