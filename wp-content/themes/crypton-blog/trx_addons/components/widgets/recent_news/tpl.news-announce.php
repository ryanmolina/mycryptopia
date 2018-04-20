<?php
/**
 * The "Announce" template to show post's content
 *
 * Used in the widget Recent News.
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.0
 */
 
$widget_args = get_query_var('trx_addons_args_recent_news');
$style = $widget_args['style'];
$number = min(8, $widget_args['number']);
$count = min(8, $widget_args['count']);
$post_format = get_post_format();
$post_format = empty($post_format) ? 'standard' : str_replace('post-format-', '', $post_format);
$animation = apply_filters('trx_addons_blog_animation', '');

$comments = '';
if (!is_singular() || have_comments() || comments_open()) {
	$post_comments = get_comments_number();
	$comments = '<a href="'. esc_url(get_comments_link()).'" class="post_meta_item post_counters_item post_counters_comments trx_addons_icon-comment">
<span class="post_counters_number">'. esc_html($post_comments). '</span></a>';
}

$grid = array(
	array('full'),
	array('big', 'big'),
	array('big', 'medium', 'medium'),
	array('big', 'medium', 'small', 'small'),
	array('big', 'small', 'small', 'small', 'small'),
	array('medium', 'medium', 'small', 'small', 'small', 'small'),
	array('medium', 'small', 'small', 'small', 'small', 'small', 'small'),
	array('small', 'small', 'small', 'small', 'small', 'small', 'small', 'small')
);
$thumb_size = $grid[$count-$number >= 8 ? 8 : ($count-1)%8][($number-1)%8];

if ($thumb_size == 'full') {
	$maxlen = 36;
}
else if ($thumb_size == 'big') {
	$maxlen = 30;
}
else if ($thumb_size == 'medium') {
	$maxlen = 33;
}
else if ($thumb_size == 'small') {
	$maxlen = 28;
}
$title = '<span>' . get_the_title() . '</span>';
$st = wordwrap($title, $maxlen, "</span><span class='del'></span><span>");

?><article 
	<?php post_class( 'post_item post_layout_'.esc_attr($style)
					.' post_format_'.esc_attr($post_format)
					.' post_size_'.esc_attr($thumb_size)
					); ?>
	<?php echo (!empty($animation) ? ' data-animation="'.esc_attr($animation).'"' : ''); ?>
	>

	<?php
	if ( is_sticky() && is_home() && !is_paged() ) {
		?><span class="post_label label_sticky"></span><?php
	}
	
	trx_addons_get_template_part('templates/tpl.featured.php',
								'trx_addons_args_featured',
								apply_filters('trx_addons_filter_args_featured', array(
										'post_info' => '<div class="post_info">'
														. '<span class="post_categories">'.trx_addons_get_post_categories().'</span>'
														. '<h5 class="post_title entry-title"><a href="'.esc_url(get_permalink()).'" rel="bookmark">'.$st.'</a></h5>'
														. ( in_array( get_post_type(), array( 'post', 'attachment' ) ) 
																? '<div class="post_meta">'
																	. '<span class="post_date"><a href="'.esc_url(get_permalink()).'">'.get_the_date().'</a></span>'
																	. ($comments ? $comments : '')
																	. '</div>'
																: '')
														. '</div>',
										'thumb_bg' => true,
										'thumb_size' => ($thumb_size == 'full' || $thumb_size == 'big') ? trx_addons_get_thumb_size('full') : trx_addons_get_thumb_size('big')
										),
										'recent_news-announce')
								);
	?>
</article>