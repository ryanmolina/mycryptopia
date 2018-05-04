jQuery(document).ready(function($) {
	var $sortCategory = $('#ico-calendar-sort-category');
	var $sortBy = $('#ico-calendar-sort-by');
	var selected = $sortCategory.add('option:first-child').attr('value');
	$sortCategory.on('change',function() {
		selected = $(this).find("option:selected").attr('value');
		var tableHeader = '#ico-calendar-'+selected;
		toggleSortingArrows(tableHeader);
	});
	$sortBy.on('click', function() {
		var tableHeader = '#ico-calendar-'+selected;
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

	// Function helper for string format
	$('#ico-calendar').tablesorter({dateFormat: 'dd.mm.yyyy',});

	$('#ico-calendar .crypto-table-row:lt(10)').addClass('active');
  	var $rows = $('.crypto-table-row');
	var icoTableSize = $rows.length;
	var currentActiveIndex = $rows.filter('.active:last').index() + 1;

	if (currentActiveIndex >= icoTableSize) {
	  	$('#ico-calendar-load-more').hide();
	}

	$('#ico-calendar-load-more').on('click', function(e) {
		var lastActiveIndex = $rows.filter('.active:last').index()+1;
	  	if (lastActiveIndex + 10 >= icoTableSize) {
	 		$(this).hide();
		}
		$rows.filter(':lt(' + (lastActiveIndex + 10) + ')').addClass('active');
	});
  
});