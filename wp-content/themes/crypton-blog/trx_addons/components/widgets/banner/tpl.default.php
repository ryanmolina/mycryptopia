<?php
/**
 * The style "default" of the Widget "Banner"
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.10
 */

$args = get_query_var('trx_addons_args_widget_banner');
extract($args);
		
// Before widget (defined by themes)
if ( trx_addons_is_on($fullwidth) ) $before_widget = str_replace('class="widget ', 'class="widget widget_fullwidth ', $before_widget);
trx_addons_show_layout($before_widget);
			
// Widget title if one was input (before and after defined by themes)
trx_addons_show_layout($title, $before_title, $after_title);
	
// Widget body
if ($banner_image!='') {
	$attr = trx_addons_getimagesize($banner_image);
	echo (!empty($banner_link) ? '<a href="' . esc_url($banner_link) . '"' : '<div') . ' class="image_wrap'.(!empty($banner_title_first_part) || !empty($banner_title_second_part) || !empty($banner_subtitle) || !empty($banner_before_price) || !empty($banner_price) || !empty($banner_after_price) || !empty($banner_button_url) ? ' with_banner_content' : '').'">'
			. '<img src="' . esc_url($banner_image) . '" alt="' . esc_attr($title) . '"' . (!empty($attr[3]) ? ' '.trim($attr[3]) : '')	. '>'
			. (empty($banner_link)
				? (!empty($banner_title_first_part) || !empty($banner_title_second_part) || !empty($banner_subtitle) || !empty($banner_before_price) || !empty($banner_price) || !empty($banner_after_price) || !empty($banner_button_url) ? '<div class="banner_container"><div class="banner_content">' : '')
				 .(!empty($banner_title_first_part) || !empty($banner_title_second_part) ? '<div class="banner_title_content">' : '')
				 .(!empty($banner_title_first_part) ? '<span class="banner_title first_part">'. esc_attr($banner_title_first_part).'</span>' : '')
				 .(!empty($banner_title_first_part) && !empty($banner_title_second_part) ? '<span class="del"></span>' : '')
				 .(!empty($banner_title_second_part) ? '<span class="banner_title second_part">'. esc_attr($banner_title_second_part).'</span>' : '')
				 .(!empty($banner_title_first_part) || !empty($banner_title_second_part) ? '</div>' : '')
				 .(!empty($banner_subtitle) ? '<div class="banner_subtitle">'. esc_attr($banner_subtitle).'</div>' : '')
				 .(!empty($banner_before_price) || !empty($banner_price) || !empty($banner_after_price) ? '<span class="banner_price_container">' : '')
				 .(!empty($banner_before_price) ? '<span class="banner_before_price">'. esc_attr($banner_before_price).'</span>' : '')
				 .(!empty($banner_price) ? '<span class="banner_price">'. esc_attr($banner_price).'</span>' : '')
				 .(!empty($banner_after_price) ? '<span class="banner_after_price">'. esc_attr($banner_after_price).'</span>' : '')
				 .(!empty($banner_before_price) || !empty($banner_price) || !empty($banner_after_price) ? '</span>' : '')
				 .(!empty($banner_button_url) ? '<a href="'.esc_url($banner_button_url).'" class="banner_button icon-right"></a>' : '')
				 .(!empty($banner_title_first_part) || !empty($banner_title_second_part) || !empty($banner_subtitle) || !empty($banner_before_price) || !empty($banner_price) || !empty($banner_after_price) || !empty($banner_button_url) ? '</div></div>' : '')
				: '')
		 	. (!empty($banner_button_url) ? '<a href="'.esc_url($banner_button_url).'" class="banner_button"></a>' : '')
			. (!empty($banner_link) ? '</a>': '</div>');
}
if ($banner_code!='') {
	echo force_balance_tags(do_shortcode($banner_code));
}
	
// After widget (defined by themes)
trx_addons_show_layout($after_widget);
?>