jQuery(document).ready(function($) {
	'use strict';
	// Function helper for string format
	console.log('ICO Calendar loaded');
	$('.ico-calendar-row:lt(10)').addClass('active');
  	var $rows = $('.ico-calendar-row');
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