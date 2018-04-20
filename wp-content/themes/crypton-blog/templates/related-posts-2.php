<?php
/**
 * The template 'Style 2' to displaying related posts
 *
 * @package WordPress
 * @subpackage CRYPTON_BLOG
 * @since CRYPTON_BLOG 1.0
 */

$crypton_blog_link = get_permalink();
$crypton_blog_post_format = get_post_format();
$crypton_blog_post_format = empty($crypton_blog_post_format) ? 'standard' : str_replace('post-format-', '', $crypton_blog_post_format);
?><div id="post-<?php the_ID(); ?>" 
	<?php post_class( 'related_item related_item_style_2 post_format_'.esc_attr($crypton_blog_post_format) ); ?>><?php
	crypton_blog_show_post_featured(array(
		'thumb_size' => crypton_blog_get_thumb_size( (int) crypton_blog_get_theme_option('related_posts') == 1 ? 'huge' : 'med' ),
		'show_no_image' => false,
		'singular' => false,
		'post_info' => '<div class="cat_in_image">'.crypton_blog_get_post_categories('').'</div>'
		)
	);
	?><div class="post_header entry-header">
		<h6 class="post_title entry-title"><a href="<?php echo esc_url($crypton_blog_link); ?>"><?php the_title(); ?></a></h6>
		<div class="post_meta">
		<?php
		if ( in_array(get_post_type(), array( 'post', 'attachment' ) ) ) {
			?><span class="post_date"><a href="<?php echo esc_url($crypton_blog_link); ?>"><?php echo wp_kses_data(crypton_blog_get_date()); ?></a></span><?php
		$post_comments = get_comments_number();
		?>
		<a href="<?php echo esc_url(get_comments_link()); ?>" class="post_meta_item post_counters_item post_counters_comments icon-comment-light"><?php
			?><span class="post_counters_number"><?php
				echo esc_html($post_comments);
				?></span><?php
		}
		?>
		</a>
	</div>
	</div>
</div>