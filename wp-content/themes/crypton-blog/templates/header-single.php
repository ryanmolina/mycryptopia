<?php
/**
 * The template to display the featured image in the single post
 *
 * @package WordPress
 * @subpackage CRYPTON_BLOG
 * @since CRYPTON_BLOG 1.0
 */

if ( get_query_var('crypton_blog_header_image')=='' && is_singular() && has_post_thumbnail() && in_array(get_post_type(), array('post', 'page')) )  {
	$crypton_blog_src = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' );
	if (!empty($crypton_blog_src[0])) {
		crypton_blog_sc_layouts_showed('featured', true);
		?><div class="sc_layouts_featured with_image <?php echo esc_attr(crypton_blog_add_inline_css_class('background-image:url('.esc_url($crypton_blog_src[0]).');')); ?>"></div><?php
	}
}
?>