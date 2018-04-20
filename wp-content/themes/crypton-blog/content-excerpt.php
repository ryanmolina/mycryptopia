<?php
/**
 * The default template to display the content
 *
 * Used for index/archive/search.
 *
 * @package WordPress
 * @subpackage CRYPTON_BLOG
 * @since CRYPTON_BLOG 1.0
 */

$crypton_blog_post_format = get_post_format();
$crypton_blog_post_format = empty($crypton_blog_post_format) ? 'standard' : str_replace('post-format-', '', $crypton_blog_post_format);
$crypton_blog_animation = crypton_blog_get_theme_option('blog_animation');

?><article id="post-<?php the_ID(); ?>" 
	<?php post_class( 'post_item post_layout_excerpt post_format_'.esc_attr($crypton_blog_post_format) ); ?>
	<?php echo (!crypton_blog_is_off($crypton_blog_animation) ? ' data-animation="'.esc_attr(crypton_blog_get_animation_classes($crypton_blog_animation)).'"' : ''); ?>
	><?php

	// Sticky label
	if ( is_sticky() && !is_paged() ) {
		?><span class="post_label label_sticky"></span><?php
	}

	// Featured image
	crypton_blog_show_post_featured(array( 'thumb_size' => crypton_blog_get_thumb_size( is_sticky() && !is_paged() ? 'big' : 'extra' ),
		'post_info' => !in_array($crypton_blog_post_format, array('video')) && (is_sticky() && !is_paged()) ?
			'<div class="cat_in_image">'.crypton_blog_get_post_categories('').'</div>'
			: '',
	));
	?>
	<div class="go_wrap">
	<?php
	// Title and post meta
	if (get_the_title() != '') {
		?>
		<div class="post_header entry-header">
			<?php
			do_action('crypton_blog_action_before_post_title'); 

			// Post title
			the_title( sprintf( '<h2 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );

			do_action('crypton_blog_action_before_post_meta'); 

			// Post meta
			$crypton_blog_components = crypton_blog_is_inherit(crypton_blog_get_theme_option_from_meta('meta_parts'))
										|| !(!is_sticky() && !is_paged())
				? 'date,author,counters'
										: crypton_blog_array_get_keys_by_value(crypton_blog_get_theme_option('meta_parts'));
			$crypton_blog_counters = crypton_blog_is_inherit(crypton_blog_get_theme_option_from_meta('counters')) 
										? 'views,likes,comments'
										: crypton_blog_array_get_keys_by_value(crypton_blog_get_theme_option('counters'));

			if (!empty($crypton_blog_components))
				crypton_blog_show_post_meta(apply_filters('crypton_blog_filter_post_meta_args', array(
					'components' => $crypton_blog_components,
					'counters' => $crypton_blog_counters,
					'seo' => false
					), 'excerpt', 1)
				);
			?>
		</div><!-- .post_header --><?php
	}
	
	// Post content
	?><div class="post_content entry-content"><?php
		if (crypton_blog_get_theme_option('blog_content') == 'fullpost') {
			// Post content area
			?><div class="post_content_inner"><?php
				the_content( '' );
			?></div><?php
			// Inner pages
			wp_link_pages( array(
				'before'      => '<div class="page_links"><span class="page_links_title">' . esc_html__( 'Pages:', 'crypton-blog' ) . '</span>',
				'after'       => '</div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
				'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'crypton-blog' ) . ' </span>%',
				'separator'   => '<span class="screen-reader-text">, </span>',
			) );

		} else {

			$crypton_blog_show_learn_more = !in_array($crypton_blog_post_format, array('link', 'aside', 'status', 'quote'));
			$crypton_blog_show_learn_more = false;

			// Post content area
			?><div class="post_content_inner"><?php
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
			?></div><?php
			// More button
			if ( $crypton_blog_show_learn_more ) {
				?><p><a class="more-link" href="<?php echo esc_url(get_permalink()); ?>"><?php esc_html_e('Read more', 'crypton-blog'); ?></a></p><?php
			}

		}
	?></div><!-- .entry-content -->
	</div>
</article>