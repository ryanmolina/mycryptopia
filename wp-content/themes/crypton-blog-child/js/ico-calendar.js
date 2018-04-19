jQuery(document).ready(function($) {	
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
});