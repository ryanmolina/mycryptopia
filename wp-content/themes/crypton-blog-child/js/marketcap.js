jQuery(document).ready(function($) {
	// Function helper for string format
	var $sortCategory = $('#marketcap-sort-category');
	var $sortBy = $('#marketcap-sort-by');	
	var selected = $sortCategory.add('option:first-child').attr('value');
	$sortCategory.on('change',function() {
		selected = $(this).find("option:selected").attr('value');
		var tableHeader = '#marketcap-'+selected;
		toggleSortingArrows(tableHeader);
	});
	$sortBy.on('click', function() {
		var tableHeader = '#marketcap-'+selected;
		$(tableHeader).click();
		delay(function() {
			toggleSortingArrows(tableHeader)
		}
		, 1); // I need to delay 1 millisecond to have the updated DOM.
	});


	var $arrowUp = $sortBy.add('.icon-arrow-up');
	var $arrowDown = $sortBy.add('.icon-arrow-down');
	function toggleSortingArrows(tableHeader) {
		if ($(tableHeader).hasClass('tablesorter-headerDesc')) {
			$arrowDown.removeClass('active');
			$arrowUp.addClass('active');
		} else if ($(tableHeader).hasClass('tablesorter-headerAsc')) {
			$arrowDown.addClass('active');
			$arrowUp.removeClass('active');
		} else if ($(tableHeader).hasClass('tablesorter-headerUnSorted')) {
			$arrowDown.removeClass('active');
			$arrowUp.removeClass('active');
		}
	}


	$('#marketcap').tablesorter();
	var step = 5;
	var start = 0;
	function loadMoreMarketcap() {
		$("#marketcap-load-more").attr("disabled", true);
		$.ajax({
		  url: "https://api.coinmarketcap.com/v1/ticker/?start={0}&limit={1}".format(start, step),
		  type: 'GET',
		  success: function(data) {
		  	  data.forEach(function(crypto) {
			      $tr = $('<tr class="crypto-table-row">').append(
			          $('<td data-column="Rank" class="crypto-table-data">').text(crypto.rank),
			          $('<td data-column="Name" class="crypto-table-data" style="font-weight: bold;">').text(crypto.name),
			          $('<td data-column="Price" class="crypto-table-data">').text(crypto.price_usd).addClass(crypto.price_usd < 0 ? 'negative' : 'positive'),
			          $('<td data-column="Market Cap" class="crypto-table-data">').text(crypto.market_cap_usd).addClass(crypto.market_cap_usd < 0 ? 'negative' : 'positive'),
			          $('<td data-column="Volume 24H" class="crypto-table-data">').text(crypto['24h_volume_usd']).addClass(crypto['24_volume_usd'] < 0 ? 'negative' : 'positive'),
			          $('<td data-column="Change 24H" class="crypto-table-data">').text(crypto.percent_change_24h).addClass(crypto.percent_change_24h < 0 ? 'negative' : 'positive'),
			      );
			      $('#marketcap').find('tbody').append($tr).trigger('addRows', [$tr, true]);
			      $('#marketcap').trigger('update');
				  $("#marketcap-load-more").attr("disabled", false);
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