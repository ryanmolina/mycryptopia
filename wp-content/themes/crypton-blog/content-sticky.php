<?php
/**
 * The Sticky template to display the sticky posts
 *
 * Used for index/archive
 *
 * @package WordPress
 * @subpackage CRYPTON_BLOG
 * @since CRYPTON_BLOG 1.0
 */

$crypton_blog_columns = max(1, min(3, count(get_option( 'sticky_posts' ))));
$crypton_blog_post_format = get_post_format();
$crypton_blog_post_format = empty($crypton_blog_post_format) ? 'standard' : str_replace('post-format-', '', $crypton_blog_post_format);
$crypton_blog_animation = crypton_blog_get_theme_option('blog_animation');

?><div class="column-1_<?php echo esc_attr($crypton_blog_columns); ?>"><article id="post-<?php the_ID(); ?>" 
	<?php post_class( 'post_item post_layout_sticky post_format_'.esc_attr($crypton_blog_post_format) ); ?>
	<?php echo (!crypton_blog_is_off($crypton_blog_animation) ? ' data-animation="'.esc_attr(crypton_blog_get_animation_classes($crypton_blog_animation)).'"' : ''); ?>
	>

	<?php
	if ( is_sticky() && is_home() && !is_paged() ) {
		?><span class="post_label label_sticky"></span><?php
	}

	// Featured image
	crypton_blog_show_post_featured(array(
		'thumb_size' => crypton_blog_get_thumb_size($crypton_blog_columns==1 ? 'big' : ($crypton_blog_columns==2 ? 'med' : 'avatar'))
	));

	if ( !in_array($crypton_blog_post_format, array('link', 'aside', 'status', 'quote')) ) {
		?>
		<div class="post_header entry-header">
			<?php
			// Post title
			the_title( sprintf( '<h6 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h6>' );
			// Post meta
			crypton_blog_show_post_meta(apply_filters('crypton_blog_filter_post_meta_args', array(), 'sticky', $crypton_blog_columns));
			?>
		</div><!-- .entry-header -->
		<?php
	}
	?>
</article></div>