
jQuery(window).load(function(){
	/*crpyto ticker scrolling*/
    var speed = 3;
    var items, scroller = jQuery('.crypto-slider');
    var width = 0;
    scroller.children().each(function(){
        width += jQuery(this).outerWidth(true);
    });
    scroller.css('width', width);
    scroll();
    function scroll(){
        items = scroller.children();
        var scrollWidth = items.eq(0).outerWidth();
        scroller.animate({'left' : 0 - scrollWidth}, scrollWidth * 100 / speed, 'linear', changeFirst);
    }
    function changeFirst(){
        scroller.append(items.eq(0).remove()).css('left', 0);
        scroll();
    }
	jQuery('.tradingview-widget-copyright').fadeIn();
	/*tciker 2 div widths*/
	jQuery('.ccc-widget').each(function(){
		jQuery(this).find('.ccc-coin-container:gt(15)').remove();
		var width = jQuery(this).width();
		var div_width = (width / jQuery(this ).find('.ccc-coin-container').size()) - 42;
		jQuery(this).find('.ccc-coin-container .ccc-price').css('width',div_width+'px')
		
	});
	//jQuery('.ccc-widget').fadeIn();
	jQuery('.crypto-ticker-2 .fa-spinner').hide();
	jQuery('.ccc-widget').fadeIn();
	
});

jQuery(document).ready(function($){


});


