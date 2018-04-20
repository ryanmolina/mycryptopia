<?php
/**
 * The style "default" of the Widget "Recent posts"
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.10
 */

$args = get_query_var('trx_addons_args_widget_recent_posts');
extract($args);
		
// Before widget (defined by themes)
trx_addons_show_layout($before_widget);
			
// Widget title if one was input (before and after defined by themes)
trx_addons_show_layout($title, $before_title, $after_title);
	
// Widget body
trx_addons_show_layout($output);

if ($link_title!='' && $link!='') {
	echo '<div class="go_link"><a class="sc_button sc_button_bordered sc_button_size_large" href="'.esc_url($link).'">'.esc_html($link_title).'</a></div>';
}

// After widget (defined by themes)
trx_addons_show_layout($after_widget);
?>