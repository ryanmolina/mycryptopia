=== Cryptocurrency All-in-One ===
Contributors: byankov
Donate link: http://creditstocks.com/donate/
Tags: bitcoin, cryptocurrency, bitcoin, ethereum, ripple, exchange, prices, rates, trading, payments, orders, token, btc, eth, etc, ltc, zec, xmr, ppc, dsh, candlestick, usd, eur  
Requires at least: 3.0
Tested up to: 4.9.4
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Cryptocurrency features: displaying prices and exchange rates, candlestick price chart, calculator, accepting orders and payments, accepting donations.

== Description ==

Notice: The plugin has been updated to a new major version - 3.0. Untortunately, some of the old features are not compatible with the WordPress repository. You will still find them in the premium version. [Get premium now](https://creditstocks.com/cryptocurrency-one-wordpress-plugin/) 

= Cryptocurrency All-in-One free version features: = 
* coin market cap - list of all cryptocurrencies with prices and market capitalization,
* accept donations: Bitcoin (BTC), Ethereum (ETH), Litecon (LTC), Monero (XMR), Zcash (ZEC),
* Ethereum node support: address balance, view block,
* plugin translations: German, Italian, .pot file provided. 

= Cryptocurrency All-in-One premium version features: = 
* all free version features plus:
* easily accept orders and payments: Bitcoin (BTC), Ethereum (ETH), Litecon (LTC), Zcash (ZEC),
* display prices and exchange rates (all cryptocurrencies),
* cryptocurrency to fiat calculator (all cryptocurrencies),
* display candlestick price charts (all cryptocurrencies), 
* custom designs themes: light, dark, and option to write your own CSS.

[Get premium now](https://creditstocks.com/cryptocurrency-one-wordpress-plugin/)

= Instructions to display a list of all cryptocurrencies on your web site. =

Add a shortcode to the text of the pages or posts where you want to display Coin Market Cap style list of all cryptocurrencies. The list is paginated, sortable, searchable. The shortcode supports selecting the base currency for showing the prices, default is USD. Exapmle shortcodes:

`[allcurrencies]`
`[allcurrencies basecurrency="eur"]`

= Instructions to accept cryptocurrency donations on your web site. = 

Add a shortcode to the text of the pages or posts where you want to accept donations. 

Supported currencies are: Bitcoin (BTC) (default), Ethereum (ETH), Litecon (LTC), Monero (XMR), Zcash (ZEC). Exapmle shortcodes (do not forget to put your wallet address):

`[cryptodonation address="1ABwGVwbna6DnHgPefSiakyzm99VXVwQz9"]`
`[cryptodonation address="0xc85c5bef5a9fd730a429b0e04c69b60d9ef4c64b" currency="eth"]`
`[cryptodonation address="463tWEBn5XZJSxLU6uLQnQ2iY9xuNcDbjLSjkn3XAXHCbLrTTErJrBWYgHJQyrCwkNgYvyV3z8zctJLPCZy24jvb3NiTcTJ" paymentid="a1be1fb24f1e493eaebce2d8c92dc68552c165532ef544b79d9d36d1992cff07" currency="xmr"]`

= Instructions for Ethereum node integration = 

Currently supported features are: check Ethereum address balance, view ethereum block. Before using the shortcodes you need to fill in your Ethereum node API URL in the plugin settings (http://localhost:8545 or a public node at infura.io). Exapmle shortcodes:

`[cryptoethereum feature="balance"]`
`[cryptoethereum feature="block"]`

= Instructions to use the plugin in a widget or from the theme =

To use the plugin in a widget, use the provided "CP Shortcode Widget" and put the shortcode in the "Content" section.
You can also call all plugin features directly from the theme - see the plugin settings page for PHP samples.

This plugin uses data from third party public APIs. By installing this plugin you agree with their terms: [CoinMarketCap Public API](https://coinmarketcap.com/api/) - no API key required. Special thanks to: Emil Samsarov, theox89.

== Installation ==

1. Unzip the `cryptocurrency-prices.zip` folder.
2. Upload the `cryptocurrency-prices` folder to your `/wp-content/plugins` directory.
3. In your WordPress dashboard, head over to the *Plugins* section.
4. Activate *Cryptocurrency Prices*.

== Frequently Asked Questions ==

= Can I show the plugin from the theme code or from another plugin? =

Yes. You can use a PHP code, which handles and shows the plugin shortcode - see the plugin settings page for PHP sample. 

= Can I show the plugin in a widget? =

Yes! Use the provided "CP Shortcode Widget" and put the shortcode in the "Content" section, for example: [currencyprice currency1="btc" currency2="usd,eur"].

= The plugin does not work - I just see the shortcode? =

Make sure you have activated the plugin. Try to add the shortcode to a page to see if it works. If you use a widget - add the shortcode in the widget provided by the plugin. If you call the plugin from the theme, make sure the code is integrated correctly. 

= The plugin does not work - I see no data or an error message? =

Try to activate compatibility mode from the plugin settings. It may be due to data provider server downtime. 

= How to style the plugin? / I don't like the design? =

This plugin is provided with design styles that you can set in the admin. You can also write CSS code for custom styles - use the "Custom design" field in the plugin settings. 

= Can the plugin cache the data? =

The plugin itself does not cache the data. But it is compatible with caching plugins. 

= How to remove the credits (link to developer and link to API)? =

You can easily remove all axternal links by visiting the plugin settings page.  

== Screenshots ==

== Changelog ==

= 3.0 =
* Refactored plugin to use CoinMarketCap API. Created free plugin version again. Features that rely on CryptoCompare API moved to premium version.

= 2.7 =
* Refactored "allcurrencies" shortcode - coin market cap view with pagination, sorting, search. 

= 2.6.4 =
* Added DataTables support for the "allcurrencies" shortcode - pagination, sorting, search.

= 2.6.3 =
* Added captcha support for payments.

= 2.6.2 =
* Bugfixes. Added feature for ZCash (ZEC) payments in the premium version.

= 2.6.1 =
* Bugfixes. Added feature for altcoin payments in the premium version (ETH, LTC).

= 2.6 =
* Many improvements. Free and premium plugin versions. 

= 2.5.5 =
* Added default CSS.

= 2.5.4 =
* Fixed bugs. Improved plugin styling capabilities.

= 2.5.3 =
* Plugin is now translatable. German translation is provided. Minor improvements.

= 2.5.2 =
* Added support of parameters for [allcurrencies] shortcode.

= 2.5.1 =
* Added support for Ethereum block viewer by connecting to an Ethereum blockchain node. Other minor improvements.

= 2.5 =
* Added Ethereum blockchain node support with web3.js. Removed Counterparty support. Bugfixes.

= 2.4.5 =
* Improved cryptocurrency payments: amount can be specified in fiat currency, multiple payment forms supported on single page, orders can be deleted.  Added a feature for accepting donations in Litecon (LTC), Monero (XMR), Zcash (ZEC).

= 2.4.4 =
* Added a feature for accepting donations in Ethereum (ETH). Improved help section.

= 2.4.3 =
* Bugfixes and improvements of the payments module. Some code rewritten in OOP.

= 2.4.2 =
* Minor improvements of the payments module.

= 2.4.1 =
* Minor improvements.

= 2.4 =
* Added a basic feature for accepting payments in BTC.

= 2.3.4 =
* Added support for multiple charts per page. Added Bitcoin Cash (BCC / BCH) cryptocurrency with its icons supported.

= 2.3.3 =
* Added 30 more cryptocurrencies with their icons supported: dgb, iot, btcd, xpy, prc, craig, xbs, ybc, dank, give, kobo, geo, ac, anc, arg, aur, bitb, blk, xmy, moon, sxc, qtl, btm, bnt, cvc, pivx, ubq, lenin, bat, plbt

= 2.3.2 =
* Added feature to support custom CSS. Fixed minor bugs.

= 2.3.1 =
* Added feature to show only calculator or prices table. Added compatibility mode for servers without CURL support. Fixed minor bugs. 

= 2.3 =
* Changed plugin name. Added better widget support. Improved plugin administration. Improved readme. 

= 2.2 =
* Added coins list feature. Improved plugin code architecture. 

= 2.1.1 =
* Improved price formatting and support of currencies with smaller prices. Added Lana coin icon.

= 2.1 =
* Added cryptocurrency charts feature. Added icons for many currencies: GBP, JPY, XRP, DASH, ZEC, etc.

= 2.0 =
* Major release with many new features: more cryptocurrencies, fiat currencies support, cryptocurrency donations support, counterparty assets explorer support. The new version is backward compatible - you need to update!

= 1.1 =
* Bugs fixed - you need to update.

= 1.0 =
* Plugin released.  Everything is new!

== Upgrade Notice ==

### No upgrades yet. ###