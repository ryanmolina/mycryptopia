<?php
/**
 * The Front Page template file.
 *
 * @package WordPress
 * @subpackage CRYPTON_BLOG
 * @since CRYPTON_BLOG 1.0.31
 */

get_header();

// If front-page is a static page
if (get_option('show_on_front') == 'page') {

	// If Front Page Builder is enabled - display sections
	if (crypton_blog_is_on(crypton_blog_get_theme_option('front_page_enabled'))) {

		if ( have_posts() ) the_post();

		$crypton_blog_sections = crypton_blog_array_get_keys_by_value(crypton_blog_get_theme_option('front_page_sections'), 1, false);
		if (is_array($crypton_blog_sections)) {
			foreach ($crypton_blog_sections as $crypton_blog_section) {
				get_template_part("front-page/section", $crypton_blog_section);
			}
		}
	
	// Else if this page is blog archive
	} else if (is_page_template('blog.php')) {
		get_template_part('blog');

	// Else - display native page content
	} else {
		get_template_part('page');
	}

// Else get index template to show posts
} else {
	get_template_part('index');
}

get_footer();
?>