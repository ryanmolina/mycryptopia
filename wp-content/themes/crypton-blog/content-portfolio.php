<?php
/**
 * The Portfolio template to display the content
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

?><article id="post-<?php the_ID(); ?>" 
	<?php post_class( 'post_item post_layout_portfolio post_layout_portfolio_'.esc_attr($crypton_blog_columns).' post_format_'.esc_attr($crypton_blog_post_format).(is_sticky() && !is_paged() ? ' sticky' : '') ); ?>
	<?php echo (!crypton_blog_is_off($crypton_blog_animation) ? ' data-animation="'.esc_attr(crypton_blog_get_animation_classes($crypton_blog_animation)).'"' : ''); ?>>
	<?php

	// Sticky label
	if ( is_sticky() && !is_paged() ) {
		?><span class="post_label label_sticky"></span><?php
	}

	$crypton_blog_image_hover = crypton_blog_get_theme_option('image_hover');
	// Featured image
	crypton_blog_show_post_featured(array(
		'thumb_size' => crypton_blog_get_thumb_size(strpos(crypton_blog_get_theme_option('body_style'), 'full')!==false || $crypton_blog_columns < 3 
								? 'masonry-big' 
								: 'masonry'),
		'show_no_image' => true,
		'class' => $crypton_blog_image_hover == 'dots' ? 'hover_with_info' : '',
		'post_info' => $crypton_blog_image_hover == 'dots' ? '<div class="post_info">'.esc_html(get_the_title()).'</div>' : ''
	));
	?>
</article>