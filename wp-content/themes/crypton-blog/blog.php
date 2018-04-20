<?php
/**
 * The template to display blog archive
 *
 * @package WordPress
 * @subpackage CRYPTON_BLOG
 * @since CRYPTON_BLOG 1.0
 */

/*
Template Name: Blog archive
*/

/**
 * Make page with this template and put it into menu
 * to display posts as blog archive
 * You can setup output parameters (blog style, posts per page, parent category, etc.)
 * in the Theme Options section (under the page content)
 * You can build this page in the WordPress editor or any Page Builder to make custom page layout:
 * just insert %%CONTENT%% in the desired place of content
 */

// Get template page's content
$crypton_blog_content = '';
$crypton_blog_blog_archive_mask = '%%CONTENT%%';
$crypton_blog_blog_archive_subst = sprintf('<div class="blog_archive">%s</div>', $crypton_blog_blog_archive_mask);
if ( have_posts() ) {
	the_post();
	if (($crypton_blog_content = apply_filters('the_content', get_the_content())) != '') {
		if (($crypton_blog_pos = strpos($crypton_blog_content, $crypton_blog_blog_archive_mask)) !== false) {
			$crypton_blog_content = preg_replace('/(\<p\>\s*)?'.$crypton_blog_blog_archive_mask.'(\s*\<\/p\>)/i', $crypton_blog_blog_archive_subst, $crypton_blog_content);
		} else
			$crypton_blog_content .= $crypton_blog_blog_archive_subst;
		$crypton_blog_content = explode($crypton_blog_blog_archive_mask, $crypton_blog_content);
		// Add VC custom styles to the inline CSS
		$vc_custom_css = get_post_meta( get_the_ID(), '_wpb_shortcodes_custom_css', true );
		if ( !empty( $vc_custom_css ) ) crypton_blog_add_inline_css(strip_tags($vc_custom_css));
	}
}

// Prepare args for a new query
$crypton_blog_args = array(
	'post_status' => current_user_can('read_private_pages') && current_user_can('read_private_posts') ? array('publish', 'private') : 'publish'
);
$crypton_blog_args = crypton_blog_query_add_posts_and_cats($crypton_blog_args, '', crypton_blog_get_theme_option('post_type'), crypton_blog_get_theme_option('parent_cat'));
$crypton_blog_page_number = get_query_var('paged') ? get_query_var('paged') : (get_query_var('page') ? get_query_var('page') : 1);
if ($crypton_blog_page_number > 1) {
	$crypton_blog_args['paged'] = $crypton_blog_page_number;
	$crypton_blog_args['ignore_sticky_posts'] = true;
}
$crypton_blog_ppp = crypton_blog_get_theme_option('posts_per_page');
if ((int) $crypton_blog_ppp != 0)
	$crypton_blog_args['posts_per_page'] = (int) $crypton_blog_ppp;
// Make a new main query
$GLOBALS['wp_the_query']->query($crypton_blog_args);


// Add internal query vars in the new query!
if (is_array($crypton_blog_content) && count($crypton_blog_content) == 2) {
	set_query_var('blog_archive_start', $crypton_blog_content[0]);
	set_query_var('blog_archive_end', $crypton_blog_content[1]);
}

get_template_part('index');
?>