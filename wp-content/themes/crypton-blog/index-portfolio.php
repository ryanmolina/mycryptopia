<?php
/**
 * The template for homepage posts with "Portfolio" style
 *
 * @package WordPress
 * @subpackage CRYPTON_BLOG
 * @since CRYPTON_BLOG 1.0
 */

crypton_blog_storage_set('blog_archive', true);

get_header(); 

if (have_posts()) {

	crypton_blog_show_layout(get_query_var('blog_archive_start'));

	$crypton_blog_stickies = is_home() ? get_option( 'sticky_posts' ) : false;
	$crypton_blog_sticky_out = crypton_blog_get_theme_option('sticky_style')=='columns' 
							&& is_array($crypton_blog_stickies) && count($crypton_blog_stickies) > 0 && get_query_var( 'paged' ) < 1;
	
	// Show filters
	$crypton_blog_cat = crypton_blog_get_theme_option('parent_cat');
	$crypton_blog_post_type = crypton_blog_get_theme_option('post_type');
	$crypton_blog_taxonomy = crypton_blog_get_post_type_taxonomy($crypton_blog_post_type);
	$crypton_blog_show_filters = crypton_blog_get_theme_option('show_filters');
	$crypton_blog_tabs = array();
	if (!crypton_blog_is_off($crypton_blog_show_filters)) {
		$crypton_blog_args = array(
			'type'			=> $crypton_blog_post_type,
			'child_of'		=> $crypton_blog_cat,
			'orderby'		=> 'name',
			'order'			=> 'ASC',
			'hide_empty'	=> 1,
			'hierarchical'	=> 0,
			'exclude'		=> '',
			'number'		=> '',
			'taxonomy'		=> $crypton_blog_taxonomy,
			'pad_counts'	=> false
		);
		$crypton_blog_portfolio_list = get_terms($crypton_blog_args);
		if (is_array($crypton_blog_portfolio_list) && count($crypton_blog_portfolio_list) > 0) {
			$crypton_blog_tabs[$crypton_blog_cat] = esc_html__('All', 'crypton-blog');
			foreach ($crypton_blog_portfolio_list as $crypton_blog_term) {
				if (isset($crypton_blog_term->term_id)) $crypton_blog_tabs[$crypton_blog_term->term_id] = $crypton_blog_term->name;
			}
		}
	}
	if (count($crypton_blog_tabs) > 0) {
		$crypton_blog_portfolio_filters_ajax = true;
		$crypton_blog_portfolio_filters_active = $crypton_blog_cat;
		$crypton_blog_portfolio_filters_id = 'portfolio_filters';
		?>
		<div class="portfolio_filters crypton_blog_tabs crypton_blog_tabs_ajax">
			<ul class="portfolio_titles crypton_blog_tabs_titles">
				<?php
				foreach ($crypton_blog_tabs as $crypton_blog_id=>$crypton_blog_title) {
					?><li><a href="<?php echo esc_url(crypton_blog_get_hash_link(sprintf('#%s_%s_content', $crypton_blog_portfolio_filters_id, $crypton_blog_id))); ?>" data-tab="<?php echo esc_attr($crypton_blog_id); ?>"><?php echo esc_html($crypton_blog_title); ?></a></li><?php
				}
				?>
			</ul>
			<?php
			$crypton_blog_ppp = crypton_blog_get_theme_option('posts_per_page');
			if (crypton_blog_is_inherit($crypton_blog_ppp)) $crypton_blog_ppp = '';
			foreach ($crypton_blog_tabs as $crypton_blog_id=>$crypton_blog_title) {
				$crypton_blog_portfolio_need_content = $crypton_blog_id==$crypton_blog_portfolio_filters_active || !$crypton_blog_portfolio_filters_ajax;
				?>
				<div id="<?php echo esc_attr(sprintf('%s_%s_content', $crypton_blog_portfolio_filters_id, $crypton_blog_id)); ?>"
					class="portfolio_content crypton_blog_tabs_content"
					data-blog-template="<?php echo esc_attr(crypton_blog_storage_get('blog_template')); ?>"
					data-blog-style="<?php echo esc_attr(crypton_blog_get_theme_option('blog_style')); ?>"
					data-posts-per-page="<?php echo esc_attr($crypton_blog_ppp); ?>"
					data-post-type="<?php echo esc_attr($crypton_blog_post_type); ?>"
					data-taxonomy="<?php echo esc_attr($crypton_blog_taxonomy); ?>"
					data-cat="<?php echo esc_attr($crypton_blog_id); ?>"
					data-parent-cat="<?php echo esc_attr($crypton_blog_cat); ?>"
					data-need-content="<?php echo (false===$crypton_blog_portfolio_need_content ? 'true' : 'false'); ?>"
				>
					<?php
					if ($crypton_blog_portfolio_need_content) 
						crypton_blog_show_portfolio_posts(array(
							'cat' => $crypton_blog_id,
							'parent_cat' => $crypton_blog_cat,
							'taxonomy' => $crypton_blog_taxonomy,
							'post_type' => $crypton_blog_post_type,
							'page' => 1,
							'sticky' => $crypton_blog_sticky_out
							)
						);
					?>
				</div>
				<?php
			}
			?>
		</div>
		<?php
	} else {
		crypton_blog_show_portfolio_posts(array(
			'cat' => $crypton_blog_cat,
			'parent_cat' => $crypton_blog_cat,
			'taxonomy' => $crypton_blog_taxonomy,
			'post_type' => $crypton_blog_post_type,
			'page' => 1,
			'sticky' => $crypton_blog_sticky_out
			)
		);
	}

	crypton_blog_show_layout(get_query_var('blog_archive_end'));

} else {

	if ( is_search() )
		get_template_part( 'content', 'none-search' );
	else
		get_template_part( 'content', 'none-archive' );

}

get_footer();
?>