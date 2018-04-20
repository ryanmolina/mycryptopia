<?php
/**
 * The template 'Style 1' to displaying related posts
 *
 * @package WordPress
 * @subpackage CRYPTON_BLOG
 * @since CRYPTON_BLOG 1.0
 */

$crypton_blog_link = get_permalink();
$crypton_blog_post_format = get_post_format();
$crypton_blog_post_format = empty($crypton_blog_post_format) ? 'standard' : str_replace('post-format-', '', $crypton_blog_post_format);
?><div id="post-<?php the_ID(); ?>" 
	<?php post_class( 'related_item related_item_style_1 post_format_'.esc_attr($crypton_blog_post_format) ); ?>><?php
	crypton_blog_show_post_featured(array(
		'thumb_size' => crypton_blog_get_thumb_size( (int) crypton_blog_get_theme_option('related_posts') == 1 ? 'huge' : 'big' ),
		'show_no_image' => false,
		'singular' => false,
		'post_info' => '<div class="post_header entry-header">'
							. '<div class="post_categories">'.wp_kses_post(crypton_blog_get_post_categories('')).'</div>'
							. '<h6 class="post_title entry-title"><a href="'.esc_url($crypton_blog_link).'">'.esc_html(get_the_title()).'</a></h6>'
							. (in_array(get_post_type(), array('post', 'attachment'))
									? '<span class="post_date"><a href="'.esc_url($crypton_blog_link).'">'.wp_kses_data(crypton_blog_get_date()).'</a></span>'
									: '')
						. '</div>'
		)
	);
?></div>