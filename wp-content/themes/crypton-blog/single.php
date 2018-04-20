<?php
/**
 * The template to display single post
 *
 * @package WordPress
 * @subpackage CRYPTON_BLOG
 * @since CRYPTON_BLOG 1.0
 */

get_header();

while ( have_posts() ) { the_post();

	get_template_part( 'content', get_post_format() );

	if(false) {
		// Previous/next post navigation.
		?>
		<div class="nav-links-single"><?php
		the_post_navigation(array(
			'next_text' => '<span class="nav-arrow"></span>'
				. '<span class="screen-reader-text">' . esc_html__('Next post:', 'crypton-blog') . '</span> '
				. '<h6 class="post-title">%title</h6>'
				. '<span class="post_date">%date</span>',
			'prev_text' => '<span class="nav-arrow"></span>'
				. '<span class="screen-reader-text">' . esc_html__('Previous post:', 'crypton-blog') . '</span> '
				. '<h6 class="post-title">%title</h6>'
				. '<span class="post_date">%date</span>'
		));
		?></div><?php
	}
	// Related posts
	if ((int) crypton_blog_get_theme_option('show_related_posts') && ($crypton_blog_related_posts = (int) crypton_blog_get_theme_option('related_posts')) > 0) {
		crypton_blog_show_related_posts(array('orderby' => 'rand',
										'posts_per_page' => max(1, min(9, $crypton_blog_related_posts)),
										'columns' => max(1, min(4, crypton_blog_get_theme_option('related_columns')))
										),
									2
									);
	}

	// If comments are open or we have at least one comment, load up the comment template.
	if ( comments_open() || get_comments_number() ) {
		comments_template();
	}
}

get_footer();
?>