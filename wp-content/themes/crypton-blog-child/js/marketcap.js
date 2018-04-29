jQuery(document).ready(function($) {
	// Function helper for string format
	var selected = $('#sort-category:first-child').attr('value');
	$('#sort-category').on('change',function() {
		selected = $(this).find("option:selected").attr('value');
		var tableHeader = '#marketcap-'+selected;
		toggleSortingArrows(tableHeader);
	});

	$('#sort-by').on('click', function() {
		var tableHeader = '#marketcap-'+selected;
		$(tableHeader).click();
		delay(function() {
			toggleSortingArrows(tableHeader)
		}
		, 1);
		/*
		I need to delay 1 millisecond to have the updated DOM.
		*/
	});

	function toggleSortingArrows(tableHeader) {
		console.log(tableHeader);
		console.log($(tableHeader).attr("class"));
		if ($(tableHeader).hasClass('tablesorter-headerDesc')) {
			$('#sort-by .icon-arrow-down').removeClass('active');
			$('#sort-by .icon-arrow-up').addClass('active');
		} else if ($(tableHeader).hasClass('tablesorter-headerAsc')) {
			$('#sort-by .icon-arrow-down').addClass('active');
			$('#sort-by .icon-arrow-up').removeClass('active');
		} else if ($(tableHeader).hasClass('tablesorter-headerUnSorted')) {
			$('#sort-by .icon-arrow-down').removeClass('active');
			$('#sort-by .icon-arrow-up').removeClass('active');
		}
	}

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
			          $('<td data-column="Price" class="marketcap-table-data">').text(crypto.price_usd).addClass(crypto.price_usd < 0 ? 'negative' : 'positive'),
			          $('<td data-column="Market Cap" class="marketcap-table-data">').text(crypto.market_cap_usd).addClass(crypto.market_cap_usd < 0 ? 'negative' : 'positive'),
			          $('<td data-column="Volume 24H" class="marketcap-table-data">').text(crypto['24h_volume_usd']).addClass(crypto['24_volume_usd'] < 0 ? 'negative' : 'positive'),
			          $('<td data-column="Change 24H" class="marketcap-table-data">').text(crypto.percent_change_24h).addClass(crypto.percent_change_24h < 0 ? 'negative' : 'positive'),
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
	$('#marketcap-load-more').click(loadMoreMarketcap);
});