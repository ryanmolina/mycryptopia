<?php
/**
 * The template to display posts in widgets and/or in the search results
 *
 * @package WordPress
 * @subpackage CRYPTON_BLOG
 * @since CRYPTON_BLOG 1.0
 */

$crypton_blog_post_id    = get_the_ID();
$crypton_blog_post_date  = crypton_blog_get_date();
$crypton_blog_post_title = get_the_title();
$crypton_blog_post_link  = get_permalink();
$crypton_blog_post_author_id   = get_the_author_meta('ID');
$crypton_blog_post_author_name = get_the_author_meta('display_name');
$crypton_blog_post_author_url  = get_author_posts_url($crypton_blog_post_author_id, '');

$crypton_blog_args = get_query_var('crypton_blog_args_widgets_posts');
$crypton_blog_show_date = isset($crypton_blog_args['show_date']) ? (int) $crypton_blog_args['show_date'] : 1;
$crypton_blog_show_image = isset($crypton_blog_args['show_image']) ? (int) $crypton_blog_args['show_image'] : 1;
$crypton_blog_show_author = isset($crypton_blog_args['show_author']) ? (int) $crypton_blog_args['show_author'] : 1;
$crypton_blog_show_counters = isset($crypton_blog_args['show_counters']) ? (int) $crypton_blog_args['show_counters'] : 1;
$crypton_blog_show_categories = isset($crypton_blog_args['show_categories']) ? (int) $crypton_blog_args['show_categories'] : 1;

$crypton_blog_output = crypton_blog_storage_get('crypton_blog_output_widgets_posts');

$crypton_blog_post_counters_output = '';
if ( $crypton_blog_show_counters ) {
	$crypton_blog_post_counters_output = '<span class="post_info_item post_info_counters">'
								. crypton_blog_get_post_counters('comments')
							. '</span>';
}


$crypton_blog_output .= '<article class="post_item with_thumb">';

if ($crypton_blog_show_image) {
	$crypton_blog_post_thumb = get_the_post_thumbnail($crypton_blog_post_id, crypton_blog_get_thumb_size('tiny'), array(
		'alt' => get_the_title()
	));
	if ($crypton_blog_post_thumb) $crypton_blog_output .= '<div class="post_thumb">' . ($crypton_blog_post_link ? '<a href="' . esc_url($crypton_blog_post_link) . '">' : '') . ($crypton_blog_post_thumb) . ($crypton_blog_post_link ? '</a>' : '') . '</div>';
}

$crypton_blog_output .= '<div class="post_content">'
			. ($crypton_blog_show_categories 
					? '<div class="post_categories">'
						. crypton_blog_get_post_categories()
						. $crypton_blog_post_counters_output
						. '</div>' 
					: '')
			. '<h6 class="post_title">' . ($crypton_blog_post_link ? '<a href="' . esc_url($crypton_blog_post_link) . '">' : '') . ($crypton_blog_post_title) . ($crypton_blog_post_link ? '</a>' : '') . '</h6>'
			. apply_filters('crypton_blog_filter_get_post_info', 
								'<div class="post_info">'
									. ($crypton_blog_show_date 
										? '<span class="post_info_item post_info_posted">'
											. ($crypton_blog_post_link ? '<a href="' . esc_url($crypton_blog_post_link) . '" class="post_info_date">' : '') 
											. esc_html($crypton_blog_post_date) 
											. ($crypton_blog_post_link ? '</a>' : '')
											. '</span>'
										: '')
									. ($crypton_blog_show_author 
										? '<span class="post_info_item post_info_posted_by">' 
											. esc_html__('by', 'crypton-blog') . ' ' 
											. ($crypton_blog_post_link ? '<a href="' . esc_url($crypton_blog_post_author_url) . '" class="post_info_author">' : '') 
											. esc_html($crypton_blog_post_author_name) 
											. ($crypton_blog_post_link ? '</a>' : '') 
											. '</span>'
										: '')
									. (!$crypton_blog_show_categories && $crypton_blog_post_counters_output
										? $crypton_blog_post_counters_output
										: '')
								. '</div>')
		. '</div>'
	. '</article>';
crypton_blog_storage_set('crypton_blog_output_widgets_posts', $crypton_blog_output);
?>