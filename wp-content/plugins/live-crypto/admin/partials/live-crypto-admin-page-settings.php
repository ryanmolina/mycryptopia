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
<div class="livecrypto-settings-page-quote">
      Coin charts allows you to display cryptocurrency prices and market caps using shortcodes, widgets, or visual composer.
</div>
<div class="livecrypto-settings-page-desc">
      <ul>
      	<li>Easily display one or many cryptocurrency prices</li>
      	<li>Prices are updated live every 15 seconds (or longer as you wish)</li>
        <li>Display a list of multiple currencies, with sortable columns and search</li>
      </ul>
</div>
<form method="post" action="options.php"><?php

settings_fields( $this->plugin_name . '-options' );

do_settings_sections( $this->plugin_name );

echo "<br/><br/>";


submit_button( 'Save Symbol Settings' );

?></form>
