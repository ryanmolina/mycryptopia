<?php
/**
 * The Classic template to display the content
 *
 * Used for index/archive/search.
 *
 * @package WordPress
 * @subpackage CRYPTON_BLOG
 * @since CRYPTON_BLOG 1.0
 */

$crypton_blog_blog_style = explode('_', crypton_blog_get_theme_option('blog_style'));
$crypton_blog_columns = empty($crypton_blog_blog_style[1]) ? 2 : max(2, $crypton_blog_blog_style[1]);
$crypton_blog_expanded = !crypton_blog_sidebar_present() && crypton_blog_is_on(crypton_blog_get_theme_option('expand_content'));
$crypton_blog_post_format = get_post_format();
$crypton_blog_post_format = empty($crypton_blog_post_format) ? 'standard' : str_replace('post-format-', '', $crypton_blog_post_format);
$crypton_blog_animation = crypton_blog_get_theme_option('blog_animation');
$crypton_blog_components = crypton_blog_is_inherit(crypton_blog_get_theme_option_from_meta('meta_parts')) 
							? 'categories,date,counters'.($crypton_blog_columns < 3 ? ',edit' : '')
							: crypton_blog_array_get_keys_by_value(crypton_blog_get_theme_option('meta_parts'));
$crypton_blog_counters = crypton_blog_is_inherit(crypton_blog_get_theme_option_from_meta('counters')) 
							? 'comments'
							: crypton_blog_array_get_keys_by_value(crypton_blog_get_theme_option('counters'));

?><div class="<?php echo $crypton_blog_blog_style[0] == 'classic' ? 'column' : 'masonry_item masonry_item'; ?>-1_<?php echo esc_attr($crypton_blog_columns); ?>"><article id="post-<?php the_ID(); ?>" 
	<?php post_class( 'post_item post_format_'.esc_attr($crypton_blog_post_format)
					. ' post_layout_classic post_layout_classic_'.esc_attr($crypton_blog_columns)
					. ' post_layout_'.esc_attr($crypton_blog_blog_style[0]) 
					. ' post_layout_'.esc_attr($crypton_blog_blog_style[0]).'_'.esc_attr($crypton_blog_columns)
					); ?>
	<?php echo (!crypton_blog_is_off($crypton_blog_animation) ? ' data-animation="'.esc_attr(crypton_blog_get_animation_classes($crypton_blog_animation)).'"' : ''); ?>>
	<?php

	// Sticky label
	if ( is_sticky() && !is_paged() ) {
		?><span class="post_label label_sticky"></span><?php
	}

	// Featured image
	crypton_blog_show_post_featured( array( 'thumb_size' => crypton_blog_get_thumb_size($crypton_blog_blog_style[0] == 'classic'
													? (strpos(crypton_blog_get_theme_option('body_style'), 'full')!==false 
															? ( $crypton_blog_columns > 2 ? 'big' : 'huge' )
															: (	$crypton_blog_columns > 2
																? ($crypton_blog_expanded ? 'med' : 'small')
																: ($crypton_blog_expanded ? 'big' : 'med')
																)
														)
													: (strpos(crypton_blog_get_theme_option('body_style'), 'full')!==false 
															? ( $crypton_blog_columns > 2 ? 'masonry-big' : 'full' )
															: (	$crypton_blog_columns <= 2 && $crypton_blog_expanded ? 'masonry-big' : 'masonry')
														)
								) ) );

	if ( !in_array($crypton_blog_post_format, array('link', 'aside', 'status', 'quote')) ) {
		?>
		<div class="post_header entry-header">
			<?php 
			do_action('crypton_blog_action_before_post_title'); 

			// Post title
			the_title( sprintf( '<h4 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h4>' );

			do_action('crypton_blog_action_before_post_meta'); 

			// Post meta
			if (!empty($crypton_blog_components))
				crypton_blog_show_post_meta(apply_filters('crypton_blog_filter_post_meta_args', array(
					'components' => $crypton_blog_components,
					'counters' => $crypton_blog_counters,
					'seo' => false
					), $crypton_blog_blog_style[0], $crypton_blog_columns)
				);

			do_action('crypton_blog_action_after_post_meta'); 
			?>
		</div><!-- .entry-header -->
		<?php
	}		
	?>

	<div class="post_content entry-content">
		<div class="post_content_inner">
			<?php
			$crypton_blog_show_learn_more = false; //!in_array($crypton_blog_post_format, array('link', 'aside', 'status', 'quote'));
			if (has_excerpt()) {
				the_excerpt();
			} else if (strpos(get_the_content('!--more'), '!--more')!==false) {
				the_content( '' );
			} else if (in_array($crypton_blog_post_format, array('link', 'aside', 'status'))) {
				the_content();
			} else if ($crypton_blog_post_format == 'quote') {
				if (($quote = crypton_blog_get_tag(get_the_content(), '<blockquote>', '</blockquote>'))!='')
					crypton_blog_show_layout(wpautop($quote));
				else
					the_excerpt();
			} else if (substr(get_the_content(), 0, 1)!='[') {
				the_excerpt();
			}
			?>
		</div>
		<?php
		// Post meta
		if (in_array($crypton_blog_post_format, array('link', 'aside', 'status', 'quote'))) {
			if (!empty($crypton_blog_components))
				crypton_blog_show_post_meta(apply_filters('crypton_blog_filter_post_meta_args', array(
					'components' => $crypton_blog_components,
					'counters' => $crypton_blog_counters
					), $crypton_blog_blog_style[0], $crypton_blog_columns)
				);
		}
		// More button
		if ( $crypton_blog_show_learn_more ) {
			?><p><a class="more-link" href="<?php echo esc_url(get_permalink()); ?>"><?php esc_html_e('Read more', 'crypton-blog'); ?></a></p><?php
		}
		?>
	</div><!-- .entry-content -->

</article></div>