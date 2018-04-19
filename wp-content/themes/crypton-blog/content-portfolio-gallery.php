<?php
/**
 * The Gallery template to display posts
 *
 * Used for index/archive/search.
 *
 * @package WordPress
 * @subpackage CRYPTON_BLOG
 * @since CRYPTON_BLOG 1.0
 */

$crypton_blog_blog_style = explode('_', crypton_blog_get_theme_option('blog_style'));
$crypton_blog_columns = empty($crypton_blog_blog_style[1]) ? 2 : max(2, $crypton_blog_blog_style[1]);
$crypton_blog_post_format = get_post_format();
$crypton_blog_post_format = empty($crypton_blog_post_format) ? 'standard' : str_replace('post-format-', '', $crypton_blog_post_format);
$crypton_blog_animation = crypton_blog_get_theme_option('blog_animation');
$crypton_blog_image = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'full' );

?><article id="post-<?php the_ID(); ?>" 
	<?php post_class( 'post_item post_layout_portfolio post_layout_gallery post_layout_gallery_'.esc_attr($crypton_blog_columns).' post_format_'.esc_attr($crypton_blog_post_format) ); ?>
	<?php echo (!crypton_blog_is_off($crypton_blog_animation) ? ' data-animation="'.esc_attr(crypton_blog_get_animation_classes($crypton_blog_animation)).'"' : ''); ?>
	data-size="<?php if (!empty($crypton_blog_image[1]) && !empty($crypton_blog_image[2])) echo intval($crypton_blog_image[1]) .'x' . intval($crypton_blog_image[2]); ?>"
	data-src="<?php if (!empty($crypton_blog_image[0])) echo esc_url($crypton_blog_image[0]); ?>"
	>

	<?php

	// Sticky label
	if ( is_sticky() && !is_paged() ) {
		?><span class="post_label label_sticky"></span><?php
	}

	// Featured image
	$crypton_blog_image_hover = 'icon';	//crypton_blog_get_theme_option('image_hover');
	if (in_array($crypton_blog_image_hover, array('icons', 'zoom'))) $crypton_blog_image_hover = 'dots';
	$crypton_blog_components = crypton_blog_is_inherit(crypton_blog_get_theme_option_from_meta('meta_parts')) 
								? 'categories,date,counters,share'
								: crypton_blog_array_get_keys_by_value(crypton_blog_get_theme_option('meta_parts'));
	$crypton_blog_counters = crypton_blog_is_inherit(crypton_blog_get_theme_option_from_meta('counters')) 
								? 'comments'
								: crypton_blog_array_get_keys_by_value(crypton_blog_get_theme_option('counters'));
	crypton_blog_show_post_featured(array(
		'hover' => $crypton_blog_image_hover,
		'thumb_size' => crypton_blog_get_thumb_size( strpos(crypton_blog_get_theme_option('body_style'), 'full')!==false || $crypton_blog_columns < 3 ? 'masonry-big' : 'masonry' ),
		'thumb_only' => true,
		'show_no_image' => true,
		'post_info' => '<div class="post_details">'
							. '<h2 class="post_title"><a href="'.esc_url(get_permalink()).'">'. esc_html(get_the_title()) . '</a></h2>'
							. '<div class="post_description">'
								. (!empty($crypton_blog_components)
										? crypton_blog_show_post_meta(apply_filters('crypton_blog_filter_post_meta_args', array(
											'components' => $crypton_blog_components,
											'counters' => $crypton_blog_counters,
											'seo' => false,
											'echo' => false
											), $crypton_blog_blog_style[0], $crypton_blog_columns))
										: '')
								. '<div class="post_description_content">'
									. apply_filters('the_excerpt', get_the_excerpt())
								. '</div>'
								. '<a href="'.esc_url(get_permalink()).'" class="theme_button post_readmore"><span class="post_readmore_label">' . esc_html__('Learn more', 'crypton-blog') . '</span></a>'
							. '</div>'
						. '</div>'
	));
	?>
</article>