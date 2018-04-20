=== Bitcoin Currency Calculator ===

Contributors: suicidalfish
Tags: bitcoin, currency converter, USD, GBP, CNY, EUR, CAD, AUD, NZD, exchange, calculator
Donate link: https://www.cryptogrind.com/
Requires at least: 3.0.1
Tested up to: 4.3.1
Stable tag: 2.1.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

== Description ==

A bitcoin currency converter powerered by Bitcoin Freelance platform https://www.cryptogrind.com

A sidebar widget or shortcode entry to display a Bitcoin to USD, GBP, CNY, EUR, CAD, AUD, and NZD.

Plugin uses live data from MT Gox to convert Bitcoin to real currency.

Plugin data gathers data from API found at http://www.coindesk.com/api/


== Installation ==

Manual Install

1. Upload contents of bitcoin-calculator to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Use the widgets menu on your wordpress admin to add the widget to the sidebar.
4. The widget will now appear on your sidebar.
5. Use the shortcode entry `[bitcoin-currency-calculator]` to display the converter on a page or a post.

Automatic Install

1. Search for the plugin on the wordpress plugin market.
2. Click 'Install Plugin' and then Activate the plugin.
3. Use the widgets menu on your wordpress admin to add the widget to the sidebar.
4. The widget will now appear on your sidebar.
5. Use the shortcode entry `[bitcoin-currency-calculator]` to display the converter on a page or a post.

Setting the default currency.

You can set the default currency for the calculator in your wordpress admin.  Go to Settings -> Bitcoin Calculator Settings and choose your default.


== Frequently Asked Questions ==

1. Q: No data is displaying?  A: Please make sure CURL is enabled on your php.ini for your hosting.

If you have any questions please e-mail me at richardmacarthy@hotmail.com and I'll be happy to answer them.

== Screenshots ==

1. Screenshot showing converter.

== Changelog ==

= 0.1 =
* Initial release.

= 2.0.0 =
Added more currencies to the ticker

= 2.1.1 =
Change rate to coindesk because bitcoin average API sucks, really...Returns as 0, 50% of the time.