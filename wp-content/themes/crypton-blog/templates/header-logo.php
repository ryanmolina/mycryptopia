<?php
/**
 * The template to display the logo or the site name and the slogan in the Header
 *
 * @package WordPress
 * @subpackage CRYPTON_BLOG
 * @since CRYPTON_BLOG 1.0
 */

$crypton_blog_args = get_query_var('crypton_blog_logo_args');

// Site logo
$crypton_blog_logo_type   = isset($crypton_blog_args['type']) ? $crypton_blog_args['type'] : '';
$crypton_blog_logo_image  = crypton_blog_get_logo_image($crypton_blog_logo_type);
$crypton_blog_logo_text   = crypton_blog_is_on(crypton_blog_get_theme_option('logo_text')) ? get_bloginfo( 'name' ) : '';
$crypton_blog_logo_slogan = get_bloginfo( 'description', 'display' );
if (!empty($crypton_blog_logo_image) || !empty($crypton_blog_logo_text)) {
	?><a class="sc_layouts_logo" href="<?php echo is_front_page() ? '#' : esc_url(home_url('/')); ?>"><?php
		if (!empty($crypton_blog_logo_image)) {
			if (empty($crypton_blog_logo_type) && function_exists('the_custom_logo') && (int) $crypton_blog_logo_image > 0) {
				the_custom_logo();
			} else {
				$crypton_blog_attr = crypton_blog_getimagesize($crypton_blog_logo_image);
				echo '<img src="'.esc_url($crypton_blog_logo_image).'" alt=""'.(!empty($crypton_blog_attr[3]) ? ' '.wp_kses_data($crypton_blog_attr[3]) : '').'>';
			}
		} else {
			crypton_blog_show_layout(crypton_blog_prepare_macros($crypton_blog_logo_text), '<span class="logo_text">', '</span>');
			crypton_blog_show_layout(crypton_blog_prepare_macros($crypton_blog_logo_slogan), '<span class="logo_slogan">', '</span>');
		}
	?></a><?php
}
?>