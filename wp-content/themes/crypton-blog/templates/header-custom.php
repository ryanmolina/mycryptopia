<?php
/**
 * The template to display custom header from the ThemeREX Addons Layouts
 *
 * @package WordPress
 * @subpackage CRYPTON_BLOG
 * @since CRYPTON_BLOG 1.0.06
 */

$crypton_blog_header_css = $crypton_blog_header_image = '';
$crypton_blog_header_video = crypton_blog_get_header_video();
if (true || empty($crypton_blog_header_video)) {
	$crypton_blog_header_image = get_header_image();
	if (crypton_blog_trx_addons_featured_image_override()) $crypton_blog_header_image = crypton_blog_get_current_mode_image($crypton_blog_header_image);
}

$crypton_blog_header_id = str_replace('header-custom-', '', crypton_blog_get_theme_option("header_style"));
if ((int) $crypton_blog_header_id == 0) {
	$crypton_blog_header_id = crypton_blog_get_post_id(array(
												'name' => $crypton_blog_header_id,
												'post_type' => defined('TRX_ADDONS_CPT_LAYOUTS_PT') ? TRX_ADDONS_CPT_LAYOUTS_PT : 'cpt_layouts'
												)
											);
} else {
	$crypton_blog_header_id = apply_filters('crypton_blog_filter_get_translated_layout', $crypton_blog_header_id);
}
$crypton_blog_header_meta = get_post_meta($crypton_blog_header_id, 'trx_addons_options', true);

?><header class="top_panel top_panel_custom top_panel_custom_<?php echo esc_attr($crypton_blog_header_id); 
				?> top_panel_custom_<?php echo esc_attr(sanitize_title(get_the_title($crypton_blog_header_id)));
				echo !empty($crypton_blog_header_image) || !empty($crypton_blog_header_video) 
					? ' with_bg_image' 
					: ' without_bg_image';
				if ($crypton_blog_header_video!='') 
					echo ' with_bg_video';
				if ($crypton_blog_header_image!='') 
					echo ' '.esc_attr(crypton_blog_add_inline_css_class('background-image: url('.esc_url($crypton_blog_header_image).');'));
				if (!empty($crypton_blog_header_meta['margin']) != '') 
					echo ' '.esc_attr(crypton_blog_add_inline_css_class('margin-bottom: '.esc_attr(crypton_blog_prepare_css_value($crypton_blog_header_meta['margin'])).';'));
				if (is_single() && has_post_thumbnail()) 
					echo ' with_featured_image';
				if (crypton_blog_is_on(crypton_blog_get_theme_option('header_fullheight'))) 
					echo ' header_fullheight crypton_blog-full-height';
				?> scheme_<?php echo esc_attr(crypton_blog_is_inherit(crypton_blog_get_theme_option('header_scheme')) 
												? crypton_blog_get_theme_option('color_scheme') 
												: crypton_blog_get_theme_option('header_scheme'));
				?>"><?php

	// Background video
	if (!empty($crypton_blog_header_video)) {
		get_template_part( 'templates/header-video' );
	}
		
	// Custom header's layout
	do_action('crypton_blog_action_show_layout', $crypton_blog_header_id);

	// Header widgets area
	get_template_part( 'templates/header-widgets' );
		
?></header>