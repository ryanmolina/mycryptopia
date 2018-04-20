<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://happyrobotstudio.com
 * @since      1.0.0
 *
 * @package    Live Crypto
 * @subpackage Live Crypto/admin/partials
 */

?>
<h1 class="livecrypto-settings-page-heading">

    <div class="livecrypto-settings-page-header-logo-container">
        <img class="livecrypto-settings-page-header-logo" src="<?php echo WP_PLUGIN_URL . '/' . $this->plugin_name . '/admin/assets/the_menu_icon_444.png'; ?>"/>
    </div>
    <?php echo esc_html( get_admin_page_title() ); ?>

</h1>




<div class='livecrypto-whitepanel'>
    <h1 class='livecrypto-blue'>Visual Composer</h1>

    <h2 class='livecrypto-grey'>Crypto Price Element</h2>
    There is a Visual Composer element available for adding crypto prices, use the element in Visual Composer, you can set the input and output currencies and other options.
</div>



<div class='livecrypto-whitepanel'>
    <h1 class='livecrypto-blue'>Shortcodes</h1>

    <h2 class='livecrypto-grey'>Crypto Price Shortcode</h2>

    <code>[cryptoprice insymbol="BTC" outymbol="USD"]</code><br/>
    <code>[cryptoprice insymbol="BTC" outymbol="USD"]</code><br/>
    <code>[cryptoprice insymbol="BTC" outymbol="USD"]</code><br/>
    <code>[cryptoprice insymbol="BTC" outymbol="USD"]</code><br/>
    <code>[cryptoprice insymbol="BTC" outymbol="USD"]</code><br/>

</div>



<div class='livecrypto-whitepanel'>
    <h1 class='livecrypto-blue'>Widgets</h1>

    <h2 class='livecrypto-grey'>Crypto Price Widget</h2>
    There is a Widget available for adding crypto prices, drag the widget to a widget location in Apprearance -> Widgets, you can set the input and output currencies and other options.

</div>
