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
$crypton_blog_columns = empty($crypton_blog_blog_style[1]) ? 1 : max(1, $crypton_blog_blog_style[1]);
$crypton_blog_expanded = !crypton_blog_sidebar_present() && crypton_blog_is_on(crypton_blog_get_theme_option('expand_content'));
$crypton_blog_post_format = get_post_format();
$crypton_blog_post_format = empty($crypton_blog_post_format) ? 'standard' : str_replace('post-format-', '', $crypton_blog_post_format);
$crypton_blog_animation = crypton_blog_get_theme_option('blog_animation');

?><article id="post-<?php the_ID(); ?>" 
	<?php post_class( 'post_item post_layout_chess post_layout_chess_'.esc_attr($crypton_blog_columns).' post_format_'.esc_attr($crypton_blog_post_format) ); ?>
	<?php echo (!crypton_blog_is_off($crypton_blog_animation) ? ' data-animation="'.esc_attr(crypton_blog_get_animation_classes($crypton_blog_animation)).'"' : ''); ?>>

	<?php
	// Add anchor
	if ($crypton_blog_columns == 1 && shortcode_exists('trx_sc_anchor')) {
		echo do_shortcode('[trx_sc_anchor id="post_'.esc_attr(get_the_ID()).'" title="'.esc_attr(get_the_title()).'"]');
	}

	// Sticky label
	if ( is_sticky() && !is_paged() ) {
		?><span class="post_label label_sticky"></span><?php
	}

	// Featured image
	crypton_blog_show_post_featured( array(
											'class' => $crypton_blog_columns == 1 ? 'crypton_blog-full-height' : '',
											'show_no_image' => true,
											'thumb_bg' => true,
											'thumb_size' => crypton_blog_get_thumb_size(
																	strpos(crypton_blog_get_theme_option('body_style'), 'full')!==false
																		? ( $crypton_blog_columns > 1 ? 'huge' : 'original' )
																		: (	$crypton_blog_columns > 2 ? 'big' : 'huge')
																	)
											) 
										);

	?><div class="post_inner"><div class="post_inner_content"><?php 

		?><div class="post_header entry-header"><?php 
			do_action('crypton_blog_action_before_post_title'); 

			// Post title
			the_title( sprintf( '<h3 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' );
			
			do_action('crypton_blog_action_before_post_meta'); 

			// Post meta
			$crypton_blog_components = crypton_blog_is_inherit(crypton_blog_get_theme_option_from_meta('meta_parts')) 
										? 'categories,date'.($crypton_blog_columns < 3 ? ',counters' : '').($crypton_blog_columns == 1 ? ',edit' : '')
										: crypton_blog_array_get_keys_by_value(crypton_blog_get_theme_option('meta_parts'));
			$crypton_blog_counters = crypton_blog_is_inherit(crypton_blog_get_theme_option_from_meta('counters')) 
										? 'comments'
										: crypton_blog_array_get_keys_by_value(crypton_blog_get_theme_option('counters'));
			$crypton_blog_post_meta = empty($crypton_blog_components) 
										? '' 
										: crypton_blog_show_post_meta(apply_filters('crypton_blog_filter_post_meta_args', array(
												'components' => $crypton_blog_components,
												'counters' => $crypton_blog_counters,
												'seo' => false,
												'echo' => false
												), $crypton_blog_blog_style[0], $crypton_blog_columns)
											);
			crypton_blog_show_layout($crypton_blog_post_meta);
		?></div><!-- .entry-header -->
		
		<div class="post_content entry-content">
			<div class="post_content_inner">
				<?php
				$crypton_blog_show_learn_more = !in_array($crypton_blog_post_format, array('link', 'aside', 'status', 'quote'));
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
				crypton_blog_show_layout($crypton_blog_post_meta);
			}
			// More button
			if ( $crypton_blog_show_learn_more ) {
				?><p><a class="more-link" href="<?php echo esc_url(get_permalink()); ?>"><?php esc_html_e('Read more', 'crypton-blog'); ?></a></p><?php
			}
			?>
		</div><!-- .entry-content -->

	</div></div><!-- .post_inner -->

</article>