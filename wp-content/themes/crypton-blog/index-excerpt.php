<?php
/**
 * The template for homepage posts with "Excerpt" style
 *
 * @package WordPress
 * @subpackage CRYPTON_BLOG
 * @since CRYPTON_BLOG 1.0
 */

crypton_blog_storage_set('blog_archive', true);

get_header(); 

if (have_posts()) {

	crypton_blog_show_layout(get_query_var('blog_archive_start'));

	?><div class="posts_container"><?php
	
	$crypton_blog_stickies = is_home() ? get_option( 'sticky_posts' ) : false;
	$crypton_blog_sticky_out = crypton_blog_get_theme_option('sticky_style')=='columns' 
							&& is_array($crypton_blog_stickies) && count($crypton_blog_stickies) > 0 && get_query_var( 'paged' ) < 1;
	if ($crypton_blog_sticky_out) {
		?><div class="sticky_wrap columns_wrap"><?php	
	}
	while ( have_posts() ) { the_post(); 
		if ($crypton_blog_sticky_out && !is_sticky()) {
			$crypton_blog_sticky_out = false;
			?></div><?php
		}
		get_template_part( 'content', $crypton_blog_sticky_out && is_sticky() ? 'sticky' : 'excerpt' );
	}
	if ($crypton_blog_sticky_out) {
		$crypton_blog_sticky_out = false;
		?></div><?php
	}
	
	?></div><?php

	crypton_blog_show_pagination();

	crypton_blog_show_layout(get_query_var('blog_archive_end'));

} else {

	if ( is_search() )
		get_template_part( 'content', 'none-search' );
	else
		get_template_part( 'content', 'none-archive' );

}

get_footer();
?>