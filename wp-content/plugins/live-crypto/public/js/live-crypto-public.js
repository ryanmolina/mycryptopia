(function( $ ) {
	'use strict';

	$(document).ready(function() {

		var currentPrice = {};
		var socket = io.connect('https://streamer.cryptocompare.com/');
		//Format: {SubscriptionId}~{ExchangeName}~{FromSymbol}~{ToSymbol}
		//Use SubscriptionId 0 for TRADE, 2 for CURRENT and 5 for CURRENTAGG
		//For aggregate quote updates use CCCAGG as market

		var subscriptions = [];
		$('.cprice-container').each( function() { // find each price, and create subscriptions array

			var priceIdentity = $(this).data('identity');
			var insymbol = $(this).data("insym");
			var otsymbol = $(this).data("otsym");
			var crypto_exchange = $(this).data("exchange");
			var crypto_apirequest_string = "";

			if( !crypto_exchange || 0 === crypto_exchange.length ) {
				crypto_apirequest_string = '5~CCCAGG~'+insymbol+'~'+otsymbol+'';  // current aggregate quote
			}
			else {
				crypto_apirequest_string = '2~'+crypto_exchange+'~'+insymbol+'~'+otsymbol+'';  // specific exchange quote
			}
			if( $.inArray(crypto_apirequest_string, subscriptions) == -1 ) {
				subscriptions.push(crypto_apirequest_string);
				console.log('subscribing to '+crypto_apirequest_string);
			}
		}).promise().done( function(){

			socket.emit('SubAdd', { subs: subscriptions }); // subscribe us
			socket.on("m", function(message) {
				var messageType = message.substring(0, message.indexOf("~"));
				var res = {};
				//if (messageType == CCC.STATIC.TYPE.CURRENTAGG) {
					res = CCC.CURRENT.unpack(message);
					dataUnpack(res);
				//}
			});
		});

		// unpack the data on receive socket message
		var dataUnpack = function(data) {
			var from = data['FROMSYMBOL'];
			var to = data['TOSYMBOL'];
			var fsym = CCC.STATIC.CURRENCY.getSymbol(from);
			var tsym = CCC.STATIC.CURRENCY.getSymbol(to);
			var pair = from + to;

			if (!currentPrice.hasOwnProperty(pair)) {
				currentPrice[pair] = {};
			}

			for (var key in data) {
				currentPrice[pair][key] = data[key];
			}

			if (currentPrice[pair]['LASTTRADEID']) {
				currentPrice[pair]['LASTTRADEID'] = parseInt(currentPrice[pair]['LASTTRADEID']).toFixed(0);
			}
			currentPrice[pair]['CHANGE24HOUR'] = CCC.convertValueToDisplay(tsym, (currentPrice[pair]['PRICE'] - currentPrice[pair]['OPEN24HOUR']));
			currentPrice[pair]['CHANGE24HOURPCT'] = ((currentPrice[pair]['PRICE'] - currentPrice[pair]['OPEN24HOUR']) / currentPrice[pair]['OPEN24HOUR'] * 100).toFixed(2) + "%";;
			displayData(currentPrice[pair], from, tsym, fsym);
		};

		// display the data
		var displayData = function(current, from, tsym, fsym) {
			//console.log(current);
			var priceDirection = current.FLAGS;

			var priceidentifier = '.cprice-'+ current.FROMSYMBOL +'-'+ current.TOSYMBOL;
			if( current.MARKET != 'CCCAGG' ) {   priceidentifier += "-" + current.MARKET;   }


			// loop through returned data items, find matching price elements in the page
			for (var key in current) {
				if (key == 'CHANGE24HOURPCT') {
					$(priceidentifier + '-' + key).text('' + current[key] + '');
				}
				else if (key == 'PRICE') {


					$(priceidentifier + '-' + key).each( function() {
						//loop through all prices and update, take account of 'known prices'
						if( $(this).data('knownpriceusd') ) {
							var knownpriceusd = $(this).data('knownpriceusd');
							var reverseknownpriceusd = $(this).data('reverseknownpriceusd');   
							if( reverseknownpriceusd ) {
								$(this).text(CCC.convertValueToDisplay(tsym, current[key] / knownpriceusd  ));
							}
							else {
								$(this).text(CCC.convertValueToDisplay(tsym, knownpriceusd / current[key] ));
							}

						}
						else {
							$(this).text(CCC.convertValueToDisplay(tsym, current[key]));
						}

					});

				}
				else if (key == 'LASTVOLUMETO' || key == 'VOLUME24HOURTO') {
					$(priceidentifier + '-' + key).text(CCC.convertValueToDisplay(tsym, current[key]));
				}
				else if (key == 'LASTVOLUME' || key == 'VOLUME24HOUR' || key == 'OPEN24HOUR' || key == 'OPENHOUR' || key == 'HIGH24HOUR' || key == 'HIGHHOUR' || key == 'LOWHOUR' || key == 'LOW24HOUR') {
					$(priceidentifier + '-' + key).text(CCC.convertValueToDisplay(fsym, current[key]));
				}
				else {
					$(priceidentifier + '-' + key).text(current[key]);
				}
			}


			if (priceDirection & 1) {
				// $(priceidentifier + '-PRICE').removeClass("down").removeClass("up");
				// $(priceidentifier + '-PRICE').addClass("up");
			}
			else if (priceDirection & 2) {
				// $(priceidentifier + '-PRICE').removeClass("down").removeClass("up");
				// $(priceidentifier + '-PRICE').addClass("down");
			}
			if (current['PRICE'] > current['OPEN24HOUR']) {
				$(priceidentifier + '-CHANGE24HOURPCT').removeClass("down").removeClass("up");
				$(priceidentifier + '-CHANGE24HOURPCT').addClass("up");
			}
			else if (current['PRICE'] < current['OPEN24HOUR']) {
				$(priceidentifier + '-CHANGE24HOURPCT').removeClass("down").removeClass("up");
				$(priceidentifier + '-CHANGE24HOURPCT').addClass("down");
			}

		};
	});









//
// 	var quote = {};
//
// 	var createDom = function(pair) {
//
// 		//
// 		// var wrapper = document.getElementById("crypto-socket-content");
// 		// var div = document.createElement("div");
// 		// var html = '<div class="wrapper">';
// 		// html += '<h1><span id="fsym_'+ pair +'"></span> - <span id="tsym_'+ pair +'"></span>   <strong><span class="price" id="price_'+ pair +'"></span></strong></h1>';
// 		// html += '<div class="label">24h Change: <span class="value" id="change_'+ pair +'"></span> (<span class="value" id="changepct_'+ pair +'"></span>)</div>';
// 		// html += '<div class="label">Last Market: <span class="market" id="market_'+ pair +'"></span></div>';
// 		// html += '<div class="label">Last Trade Id: <span class="value" id="tradeid_'+ pair +'"></span></div>';
// 		// html += '<div class="label">Last Trade Volume: <span class="value" id="volume_'+ pair +'"></span></div>';
// 		// html += '<div class="label">Last Trade VolumeTo: <span class="value" id="volumeto_'+ pair +'"></span></div>';
// 		// html += '<div class="label">24h Volume: <span class="value" id="24volume_'+ pair +'"></span></div>';
// 		// html += '<div class="label">24h VolumeTo: <span class="value" id="24volumeto_'+ pair +'"></span></div>';
// 		// html += '</div>';
// 		// div.innerHTML = html;
// 		// wrapper.appendChild(div);
//
//
// 	};
//
//
//
// 	var displayQuote = function(_quote) {
//
// 		var fsym = CCC.STATIC.CURRENCY.SYMBOL[_quote.FROMSYMBOL];
// 		var tsym = CCC.STATIC.CURRENCY.SYMBOL[_quote.TOSYMBOL];
// 		var pair = _quote.FROMSYMBOL + _quote.TOSYMBOL;
//
//
//
// 		//console.log(_quote);
//
// 		if( undefined == _quote.FLAGS ) {
//
// 			console.log('price was undefined, fetch exchange info');
//
// 			console.log(_quote);
// 			console.log(pair);
// 			console.log(_quote.FROMSYMBOL);
//
// 			var possible_alternative_tsyms = "";
//
// 			// get data for the insymbol
// 			var cryptoCompareDataAPI = "https://min-api.cryptocompare.com/data/subs?";
// 			$.getJSON( cryptoCompareDataAPI, {
// 				fsym: _quote.FROMSYMBOL
// 			})
// 			.promise().done(function( data ) {
// 				console.log(data); // price was undefined, fetch exchange info
//
// 				for (var key in data) {
// 				    if (key === 'length' || !data.hasOwnProperty(key)) continue;
// 				    possible_alternative_tsyms += key + "<br/>";
// 				}
// 				$('.cprice-'+ _quote.FROMSYMBOL +'-'+ _quote.TOSYMBOL + ' .cprice-data-price').html( "<span class='flashred'>outsymbol not supported</span>" ); //update price
// 				$('.cprice-'+ _quote.FROMSYMBOL +'-'+ _quote.TOSYMBOL + ' .cprice-output-currency').html( "<div style='font-size:12px; padding:10px; clear:both; line-height:15px;'>The output currency "+ _quote.TOSYMBOL + " is not supported<br/><br/>Try the following:<br/>" + possible_alternative_tsyms+"<br/>&nbsp;<br/></div>");
// 			});
// 		}
// 		else {
//
// 			// update price
// 			if (_quote.FLAGS === "1"){
// 				//$('.cprice-'+ _quote.FROMSYMBOL +'-'+ _quote.TOSYMBOL + ' .cprice-price').removeClass("flashred").addClass("flashgreen");
// 				$('.cprice-'+ _quote.FROMSYMBOL +'-'+ _quote.TOSYMBOL + ' .cprice-data-price').html( CCC.convertValueToDisplay(tsym, _quote.PRICE) );
// 			}
// 			else if (_quote.FLAGS === "2") {
// 				//$('.cprice-'+ _quote.FROMSYMBOL +'-'+ _quote.TOSYMBOL + ' .cprice-price').removeClass("flashgreen").addClass("flashred");
// 				$('.cprice-'+ _quote.FROMSYMBOL +'-'+ _quote.TOSYMBOL + ' .cprice-data-price').html( CCC.convertValueToDisplay(tsym, _quote.PRICE) );
// 			}
// 			else if (_quote.FLAGS === "4") {
// 				//$('.cprice-'+ _quote.FROMSYMBOL +'-'+ _quote.TOSYMBOL + ' .cprice-price').removeClass("flashgreen").removeClass("flashred");
// 				$('.cprice-'+ _quote.FROMSYMBOL +'-'+ _quote.TOSYMBOL + ' .cprice-data-price').html( CCC.convertValueToDisplay(tsym, _quote.PRICE) );
// 			}
//
// 			// update other data
// 			$('.cprice-'+ _quote.FROMSYMBOL +'-'+ _quote.TOSYMBOL + ' .cprice-data-24high').html( _quote.HIGH24HOUR );
// 			$('.cprice-'+ _quote.FROMSYMBOL +'-'+ _quote.TOSYMBOL + ' .cprice-data-24high').html( _quote.OPEN24HOUR );
// 			$('.cprice-'+ _quote.FROMSYMBOL +'-'+ _quote.TOSYMBOL + ' .cprice-data-24low').html( _quote.LOW24HOUR );
// 			$('.cprice-'+ _quote.FROMSYMBOL +'-'+ _quote.TOSYMBOL + ' .cprice-data-24change').html( CCC.convertValueToDisplay(tsym, _quote.CHANGE24H) );
// 			$('.cprice-'+ _quote.FROMSYMBOL +'-'+ _quote.TOSYMBOL + ' .cprice-data-24changepct').html( _quote.CHANGEPCT24H.toFixed(2) + "%" );
// 			$('.cprice-'+ _quote.FROMSYMBOL +'-'+ _quote.TOSYMBOL + ' .cprice-data-24volume').html( CCC.convertValueToDisplay(fsym, _quote.VOLUME24HOUR).replace('undefined', '') );
//
//
// 			$('.cprice-'+ _quote.FROMSYMBOL +'-'+ _quote.TOSYMBOL + ' .cprice-data-lastmarket').html( _quote.LASTMARKET );
// 			$('.cprice-'+ _quote.FROMSYMBOL +'-'+ _quote.TOSYMBOL + ' .cprice-data-lastmarketvol').html( _quote.LASTVOLUME );
//
// 			$('.cprice-'+ _quote.FROMSYMBOL +'-'+ _quote.TOSYMBOL + ' .cprice-data-bid').html( _quote.BID );
// 			$('.cprice-'+ _quote.FROMSYMBOL +'-'+ _quote.TOSYMBOL + ' .cprice-data-ask').html( _quote.OFFER );
// 			$('.cprice-'+ _quote.FROMSYMBOL +'-'+ _quote.TOSYMBOL + ' .cprice-data-average').html( _quote.AVG );
//
// 			$('.cprice-'+ _quote.FROMSYMBOL +'-'+ _quote.TOSYMBOL + ' .cprice-data-1high').html( _quote.HIGHHOUR );
// 			$('.cprice-'+ _quote.FROMSYMBOL +'-'+ _quote.TOSYMBOL + ' .cprice-data-1low').html( _quote.LOWHOUR );
// 			$('.cprice-'+ _quote.FROMSYMBOL +'-'+ _quote.TOSYMBOL + ' .cprice-data-1open').html( _quote.OPENHOUR );
// 			$('.cprice-'+ _quote.FROMSYMBOL +'-'+ _quote.TOSYMBOL + ' .cprice-data-lastupdated').html( _quote.LASTUPDATE );
//
//
//
// 			// lastmarketval
// 			// lastmarketvol
// 			// bid
// 			// ask
// 			// average
// 			// 1high
// 			// 1low
// 			// 1open
// 			// lastupdated
//
//
//
//
// 			// 'TYPE'            : {'Show':false}
// 		  // , 'MARKET'          : {'Show':true, 'Filter':'Market'}
// 		  // , 'FROMSYMBOL'      : {'Show':false}
// 		  // , 'TOSYMBOL'        : {'Show':false}
// 		  // , 'FLAGS'           : {'Show':false}
// 		  // , 'PRICE'           : {'Show':true, 'Filter':'Number', 'Symbol':'TOSYMBOL'}
// 		  // , 'BID'             : {'Show':true, 'Filter':'Number', 'Symbol':'TOSYMBOL'}
// 		  // , 'OFFER'           : {'Show':true, 'Filter':'Number', 'Symbol':'TOSYMBOL'}
// 		  // , 'LASTUPDATE'      : {'Show':true, 'Filter':'Date'  , 'Format':'yyyy MMMM dd HH:mm:ss'}
// 		  // , 'AVG'             : {'Show':true,' Filter':'Number', 'Symbol':'TOSYMBOL'}
// 		  // , 'LASTVOLUME'      : {'Show':true, 'Filter':'Number', 'Symbol':'FROMSYMBOL'}
// 		  // , 'LASTVOLUMETO'    : {'Show':true, 'Filter':'Number', 'Symbol':'TOSYMBOL'}
// 		  // , 'LASTTRADEID'     : {'Show':true, 'Filter':'String'}
// 		  // , 'VOLUMEHOUR'      : {'Show':true, 'Filter':'Number', 'Symbol':'FROMSYMBOL'}
// 		  // , 'VOLUMEHOURTO'    : {'Show':true, 'Filter':'Number', 'Symbol':'TOSYMBOL'}
// 		  // , 'VOLUME24HOUR'    : {'Show':true, 'Filter':'Number', 'Symbol':'FROMSYMBOL'}
// 		  // , 'VOLUME24HOURTO'  : {'Show':true, 'Filter':'Number', 'Symbol':'TOSYMBOL'}
// 		  // , 'OPENHOUR'        : {'Show':true, 'Filter':'Number', 'Symbol':'TOSYMBOL'}
// 		  // , 'HIGHHOUR'        : {'Show':true, 'Filter':'Number', 'Symbol':'TOSYMBOL'}
// 		  // , 'LOWHOUR'         : {'Show':true, 'Filter':'Number', 'Symbol':'TOSYMBOL'}
// 		  // , 'OPEN24HOUR'      : {'Show':true, 'Filter':'Number', 'Symbol':'TOSYMBOL'}
// 		  // , 'HIGH24HOUR'      : {'Show':true, 'Filter':'Number', 'Symbol':'TOSYMBOL'}
// 		  // , 'LOW24HOUR'       : {'Show':true, 'Filter':'Number', 'Symbol':'TOSYMBOL'}
// 		  // , 'LASTMARKET'      : {'Show':true, 'Filter':'String'}
//           //
//
//
//
//
//
//
// 	  		// document.getElementById("market_" + pair).innerHTML = _quote.LASTMARKET;
// 	  		// document.getElementById("fsym_" + pair).innerHTML = _quote.FROMSYMBOL;
// 	  		// document.getElementById("tsym_" + pair).innerHTML = _quote.TOSYMBOL;
// 	  		// document.getElementById("price_" + pair).innerHTML = _quote.PRICE;
// 	  		// document.getElementById("volume_" + pair).innerHTML = CCC.convertValueToDisplay(fsym, _quote.LASTVOLUME);
// 	  		// document.getElementById("volumeto_" + pair).innerHTML = CCC.convertValueToDisplay(tsym, _quote.LASTVOLUMETO);
// 	  		// document.getElementById("24volume_" + pair).innerHTML = CCC.convertValueToDisplay(fsym, _quote.VOLUME24HOUR);
// 	  		// document.getElementById("24volumeto_" + pair).innerHTML = CCC.convertValueToDisplay(tsym, _quote.VOLUME24HOURTO);
// 	  		// document.getElementById("tradeid_" + pair).innerHTML = _quote.LASTTRADEID.toFixed(0);
// 	  		// document.getElementById("tradeid_" + pair).innerHTML = _quote.LASTTRADEID.toFixed(0);
// 	  		// document.getElementById("change_" + pair).innerHTML = CCC.convertValueToDisplay(tsym, _quote.CHANGE24H);
// 	  		// document.getElementById("changepct_" + pair).innerHTML = _quote.CHANGEPCT24H.toFixed(2) + "%";
//
//
//
//
//
//
// 		}
//
//
// 	}
//
//
//
// 	var updateQuote = function(result) {
//
// 		var keys = Object.keys(result);
// 		var pair = result.FROMSYMBOL + result.TOSYMBOL;
// 		if (!quote.hasOwnProperty(pair)) {
// 			quote[pair] = {}
// 			//createDom(pair);
// 		}
// 		for (var i = 0; i <keys.length; ++i) {
// 			quote[pair][keys[i]] = result[keys[i]];
// 		}
// 		quote[pair]["CHANGE24H"] = quote[pair]["PRICE"] - quote[pair]["OPEN24HOUR"];
// 		quote[pair]["CHANGEPCT24H"] = quote[pair]["CHANGE24H"]/quote[pair]["OPEN24HOUR"] * 100;
// 		displayQuote(quote[pair]);
// 	}
//
//
//
// 	var socket = io.connect('https://streamer.cryptocompare.com/');
//
// 	//Format: {SubscriptionId}~{ExchangeName}~{FromSymbol}~{ToSymbol}
// 	//Use SubscriptionId 0 for TRADE, 2 for CURRENT and 5 for CURRENTAGG
// 	//For aggregate quote updates use CCCAGG as market
// 	// var subscription = ['5~CCCAGG~BTC~USD','5~CCCAGG~ETH~USD'];
// 	var subscriptions = [];
//
// 	$(window).ready(function() {
//
//
// 		$('.cprice-container').each( function() {
//
// 			var priceIdentity = $(this).data('identity');
// 			var insymbol = $(this).data("insym");
// 			var otsymbol = $(this).data("otsym");
// 			var crypto_exchange = $(this).data("exchange");
// 			var crypto_apirequest_string = "";
//
//
//
// 			if( !crypto_exchange || 0 === crypto_exchange.length ) {
// 				crypto_apirequest_string = '5~CCCAGG~'+insymbol+'~'+otsymbol+'';
// 			}
// 			else {
// 			//	crypto_apirequest_string = '5~'+crypto_exchange+'~'+insymbol+'~'+otsymbol+'';
// 			}
//
// 			if( $.inArray(crypto_apirequest_string, subscriptions) == -1 ) {
// 				subscriptions.push(crypto_apirequest_string);
// 				console.log('subscribing to '+crypto_apirequest_string);
// 			}
//
//
// 		}).promise().done( function(){
//
// 		//	console.log('---------');
// 		//	console.log(subscriptions);
// 		//	console.log('---------');
//
// 			socket.emit('SubAdd', {subs:subscriptions} );
//
// 			socket.on("m", function(message){
// 				var messageType = message.substring(0, message.indexOf("~"));
// 				var res = {};
// 				if (messageType === CCC.STATIC.TYPE.CURRENTAGG) {
// 					res = CCC.CURRENT.unpack(message);
// 					//console.log(res);
// 					updateQuote(res);
// 				}
// 			});
//
//
// 		});
// 	});




})( jQuery );
