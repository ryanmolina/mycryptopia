<?php
/**
 * The template to display default site footer
 *
 * @package WordPress
 * @subpackage CRYPTON_BLOG
 * @since CRYPTON_BLOG 1.0.10
 */

$crypton_blog_footer_scheme =  crypton_blog_is_inherit(crypton_blog_get_theme_option('footer_scheme')) ? crypton_blog_get_theme_option('color_scheme') : crypton_blog_get_theme_option('footer_scheme');
$crypton_blog_footer_id = str_replace('footer-custom-', '', crypton_blog_get_theme_option("footer_style"));
if ((int) $crypton_blog_footer_id == 0) {
	$crypton_blog_footer_id = crypton_blog_get_post_id(array(
												'name' => $crypton_blog_footer_id,
												'post_type' => defined('TRX_ADDONS_CPT_LAYOUTS_PT') ? TRX_ADDONS_CPT_LAYOUTS_PT : 'cpt_layouts'
												)
											);
} else {
	$crypton_blog_footer_id = apply_filters('crypton_blog_filter_get_translated_layout', $crypton_blog_footer_id);
}
$crypton_blog_footer_meta = get_post_meta($crypton_blog_footer_id, 'trx_addons_options', true);
?>
<footer class="footer_wrap footer_custom footer_custom_<?php echo esc_attr($crypton_blog_footer_id); 
						?> footer_custom_<?php echo esc_attr(sanitize_title(get_the_title($crypton_blog_footer_id))); 
						if (!empty($crypton_blog_footer_meta['margin']) != '') 
							echo ' '.esc_attr(crypton_blog_add_inline_css_class('margin-top: '.crypton_blog_prepare_css_value($crypton_blog_footer_meta['margin']).';'));
						?> scheme_<?php echo esc_attr($crypton_blog_footer_scheme); 
						?>">
	<?php
    // Custom footer's layout
    do_action('crypton_blog_action_show_layout', $crypton_blog_footer_id);
	?>
</footer><!-- /.footer_wrap -->
