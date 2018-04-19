/* global jQuery:false */
/* global CRYPTON_BLOG_STORAGE:false */
/* global cryptocurrency_STORAGE:false */

(function() {
	"use strict";
	jQuery(document).on('action.init_shortcodes', crypton_blog_cryptocurrency_init);
	jQuery(document).on('action.init_hidden_elements', crypton_blog_cryptocurrency_init);
	
    function crypton_blog_cryptocurrency_init(e, container) {
		if (arguments.length < 2) var container = jQuery('body');
		if (container===undefined || container.length === undefined || container.length == 0) return;

		if (jQuery('.donation-address:not(.inited)', container).length > 0) {

			container.find('.donation-address:not(.inited)', container).addClass('inited');

			var cryptodonation_widget = jQuery('.donation-address', container).closest('.widget');

			if (cryptodonation_widget.length < 1) {
				cryptodonation_widget = jQuery('.donation-address', container).closest('.trx-cryptodonation');
			}

			cryptodonation_widget.each(function (ind, el) {
				var cryptodonation_widget_text = jQuery(el).find('p:first strong:first'),
					widget_text = cryptodonation_widget_text.text().trim().replace(/\:$/i, ''),
					data_tooltip = jQuery('.donation-address', el).text();

				jQuery(el).addClass('cryptodonation-widget');

				jQuery(el).find('p:first').addClass('light_background');
				cryptodonation_widget_text
					.text(widget_text)
					.append('<span class="cryptodonation-widget-info trx_widget_tooltip">&#xe8b4;<span class="tooltiptext">' + data_tooltip + '</span></span>');
			});
		}

	}

})();