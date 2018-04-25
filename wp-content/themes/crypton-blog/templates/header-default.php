<?php
/**
 * The template to display default site header
 *
 * @package WordPress
 * @subpackage CRYPTON_BLOG
 * @since CRYPTON_BLOG 1.0
 */


$crypton_blog_header_css = $crypton_blog_header_image = '';
$crypton_blog_header_video = crypton_blog_get_header_video();
if (true || empty($crypton_blog_header_video)) {
	$crypton_blog_header_image = get_header_image();
	if (crypton_blog_trx_addons_featured_image_override()) $crypton_blog_header_image = crypton_blog_get_current_mode_image($crypton_blog_header_image);
}

?><header class="top_panel top_panel_default<?php
					echo !empty($crypton_blog_header_image) || !empty($crypton_blog_header_video) ? ' with_bg_image' : ' without_bg_image';
					if ($crypton_blog_header_video!='') echo ' with_bg_video';
					if ($crypton_blog_header_image!='') echo ' '.esc_attr(crypton_blog_add_inline_css_class('background-image: url('.esc_url($crypton_blog_header_image).');'));
					if (is_single() && has_post_thumbnail()) echo ' with_featured_image';
					if (crypton_blog_is_on(crypton_blog_get_theme_option('header_fullheight'))) echo ' header_fullheight crypton_blog-full-height';
					?> scheme_<?php echo esc_attr(crypton_blog_is_inherit(crypton_blog_get_theme_option('header_scheme')) 
													? crypton_blog_get_theme_option('color_scheme') 
													: crypton_blog_get_theme_option('header_scheme'));
					?>"><?php

	// Background video
	if (!empty($crypton_blog_header_video)) {
		get_template_part( 'templates/header-video' );
	}
	
	// Main menu
	if (crypton_blog_get_theme_option("menu_style") == 'top') {
		get_template_part( 'templates/header-navi' );
	}

	// Original location: get_template_part( 'templates/header-title');

	// Header widgets area
	get_template_part( 'templates/header-widgets' );

	// Header for single posts
	//get_template_part( 'templates/header-single' );

?></header>
<?php
	// Page title and breadcrumbs area
	get_template_part( 'templates/header-title');
?>