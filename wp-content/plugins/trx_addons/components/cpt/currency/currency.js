/* global jQuery:false */
/* global TRX_ADDONS_STORAGE:false */

// Switch tabs content in the currency
jQuery(document).on('action.ready_trx_addons', function() {

	"use strict";
	
	// Tabs with side titles and effects
	jQuery('.sc_currency_tabs:not(.inited)')
		.addClass('inited')
		.on('click', '.sc_currency_tabs_list_item:not(.sc_currency_tabs_list_item_active)', function(e) {
			jQuery(this).siblings().removeClass('sc_currency_tabs_list_item_active');
			jQuery(this).addClass('sc_currency_tabs_list_item_active');
			var content = jQuery(this).parent().siblings('.sc_currency_tabs_content');
			var items = content.find('.sc_currency_item');
			content.find('.sc_currency_item_active').addClass('sc_currency_item_flip').removeClass('sc_currency_item_active');
			items.eq(jQuery(this).index()).addClass('sc_currency_item_active');
			setTimeout(function() {
				content.find('.sc_currency_item_flip').addClass('trx_addons_hidden').removeClass('sc_currency_item_flip');
				items.removeClass('sc_currency_item_flipping');
				setTimeout(function() {
					items.removeClass('trx_addons_hidden');
				}, 600);
			}, 600);
			// Patch for Webkit - after the middle motion add class 'flipping' to move active item above old item
			// Attention! Latest versions of Firefox also need this patch!
			if (true || /Chrome/.test(navigator.userAgent) && /Google Inc/.test(navigator.vendor)) {
				setTimeout(function() {
					content.find('.sc_currency_item_active').addClass('sc_currency_item_flipping');
				}, 250);
			}
			e.preventDefault();
			return false;
		});

	// Simple Tabs with top titles and excerpt
	jQuery('.sc_currency_tabs_simple:not(.inited)')
		.addClass('inited')
		.on('click', '.sc_currency_tabs_list_item:not(.sc_currency_tabs_list_item_active)', function(e) {
			jQuery(this).siblings().removeClass('sc_currency_tabs_list_item_active');
			jQuery(this).addClass('sc_currency_tabs_list_item_active');
			var content = jQuery(this).parent().siblings('.sc_currency_tabs_content');
			var items = content.find('.sc_currency_tabs_content_item');
			content.find('.sc_currency_tabs_content_item_active').addClass('sc_currency_item_flip').removeClass('sc_currency_tabs_content_item_active');
			items.eq(jQuery(this).index()).addClass('sc_currency_tabs_content_item_active');
			setTimeout(function() {
				content.find('sc_currency_item_flip').removeClass('sc_currency_item_flip');
			}, 600);
			e.preventDefault();
			return false;
		});
});