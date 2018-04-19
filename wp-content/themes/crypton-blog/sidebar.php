<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package WordPress
 * @subpackage CRYPTON_BLOG
 * @since CRYPTON_BLOG 1.0
 */

if (crypton_blog_sidebar_present()) {
	ob_start();
	$crypton_blog_sidebar_name = crypton_blog_get_theme_option('sidebar_widgets');
	crypton_blog_storage_set('current_sidebar', 'sidebar');
	if ( is_active_sidebar($crypton_blog_sidebar_name) ) {
		dynamic_sidebar($crypton_blog_sidebar_name);
	}
	$crypton_blog_out = trim(ob_get_contents());
	ob_end_clean();
	if (!empty($crypton_blog_out)) {
		$crypton_blog_sidebar_position = crypton_blog_get_theme_option('sidebar_position');
		?>
		<div class="sidebar <?php echo esc_attr($crypton_blog_sidebar_position); ?> widget_area<?php if (!crypton_blog_is_inherit(crypton_blog_get_theme_option('sidebar_scheme'))) echo ' scheme_'.esc_attr(crypton_blog_get_theme_option('sidebar_scheme')); ?>" role="complementary">
			<div class="sidebar_inner">
				<?php
				do_action( 'crypton_blog_action_before_sidebar' );
				crypton_blog_show_layout(preg_replace("/<\/aside>[\r\n\s]*<aside/", "</aside><aside", $crypton_blog_out));
				do_action( 'crypton_blog_action_after_sidebar' );
				?>
			</div><!-- /.sidebar_inner -->
		</div><!-- /.sidebar -->
		<?php
	}
}
?>