jQuery(document).ready(function($) {
	// Function helper for string format
	String.prototype.format = function() {
		var formatted = this;
		for (var i = 0; i < arguments.length; i++) {
		    var regexp = new RegExp('\\{'+i+'\\}', 'gi');
		    formatted = formatted.replace(regexp, arguments[i]);
		}
		return formatted;
	};


	$('.ico-calendar-row:lt(10)').addClass('active');
  	var $rows = $('.ico-calendar-row');
	var icoTableSize = $rows.length;
	var currentActiveIndex = $rows.filter('.active:last').index()+1;
	if (currentActiveIndex >= icoTableSize) {
	  	$('.load-more').hide();
	}

	$('.load-more').on('click', function(e) {
	  e.preventDefault();  
	  var lastActiveIndex = $rows.filter('.active:last').index()+1;

	  if (lastActiveIndex+10 >= icoTableSize) {
	  	$(this).hide();
	  }
	  $rows.filter(':lt(' + (lastActiveIndex + 10) + ')').addClass('active');
	});
  
	$('#sort-by').on('change',function() {
		let selected = $(this).find("option:selected").attr('value');
		$('#marketcap-'+selected).click();
	});
	$('#marketcap').tablesorter();

	var step = 5;
	var start = 0;

	// Initial content
	function loadMoreMarketcap() {
		$.ajax({
		  url: "https://api.coinmarketcap.com/v1/ticker/?start={0}&limit={1}".format(start, step),
		  type: 'GET',
		  success: function(data) {
		  	  data.forEach(function(crypto) {
			      $tr = $('<tr class="marketcap-table-row">').append(
			          $('<td data-column="Rank" class="marketcap-table-data">').text(crypto.rank),
			          $('<td data-column="Name" class="marketcap-table-data">').text(crypto.name),
			          $('<td data-column="Price" class="marketcap-table-data">').text(crypto.price_usd),
			          $('<td data-column="Market Cap" class="marketcap-table-data">').text(crypto.market_cap_usd),
			          $('<td data-column="Volume 24H" class="marketcap-table-data">').text(crypto['24h_volume_usd']),
			          $('<td data-column="Change 24H" class="marketcap-table-data">').text(crypto.percent_change_24h+'%'),
			      );
			      $('#marketcap').trigger('update');
			      $('#marketcap').find('tbody').append($tr).trigger('addRows', [$tr, true]);
			      $("#marketcap").trigger("sorton", [$tr]);
		      });
		  	  start += step;
		    }
		}); 
	}
	
	// Initial 5 Marketcap	
	loadMoreMarketcap();
	// Add content when 'Load More' is clicked
	$('#load-more-marketcap').click(loadMoreMarketcap);


});