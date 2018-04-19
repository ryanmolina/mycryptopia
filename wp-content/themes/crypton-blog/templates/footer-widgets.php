<?php
/**
 * The template to display the widgets area in the footer
 *
 * @package WordPress
 * @subpackage CRYPTON_BLOG
 * @since CRYPTON_BLOG 1.0.10
 */

// Footer sidebar
$crypton_blog_footer_name = crypton_blog_get_theme_option('footer_widgets');
$crypton_blog_footer_present = !crypton_blog_is_off($crypton_blog_footer_name) && is_active_sidebar($crypton_blog_footer_name);
if ($crypton_blog_footer_present) { 
	crypton_blog_storage_set('current_sidebar', 'footer');
	$crypton_blog_footer_wide = crypton_blog_get_theme_option('footer_wide');
	ob_start();
	if ( is_active_sidebar($crypton_blog_footer_name) ) {
		dynamic_sidebar($crypton_blog_footer_name);
	}
	$crypton_blog_out = trim(ob_get_contents());
	ob_end_clean();
	if (!empty($crypton_blog_out)) {
		$crypton_blog_out = preg_replace("/<\\/aside>[\r\n\s]*<aside/", "</aside><aside", $crypton_blog_out);
		$crypton_blog_need_columns = true;	//or check: strpos($crypton_blog_out, 'columns_wrap')===false;
		if ($crypton_blog_need_columns) {
			$crypton_blog_columns = max(0, (int) crypton_blog_get_theme_option('footer_columns'));
			if ($crypton_blog_columns == 0) $crypton_blog_columns = min(4, max(1, substr_count($crypton_blog_out, '<aside ')));
			if ($crypton_blog_columns > 1)
				$crypton_blog_out = preg_replace("/<aside([^>]*)class=\"widget/", "<aside$1class=\"column-1_".esc_attr($crypton_blog_columns).' widget', $crypton_blog_out);
			else
				$crypton_blog_need_columns = false;
		}
		?>
		<div class="footer_widgets_wrap widget_area<?php echo !empty($crypton_blog_footer_wide) ? ' footer_fullwidth' : ''; ?> sc_layouts_row  sc_layouts_row_type_normal">
			<div class="footer_widgets_inner widget_area_inner">
				<?php 
				if (!$crypton_blog_footer_wide) { 
					?><div class="content_wrap"><?php
				}
				if ($crypton_blog_need_columns) {
					?><div class="columns_wrap"><?php
				}
				do_action( 'crypton_blog_action_before_sidebar' );
				crypton_blog_show_layout($crypton_blog_out);
				do_action( 'crypton_blog_action_after_sidebar' );
				if ($crypton_blog_need_columns) {
					?></div><!-- /.columns_wrap --><?php
				}
				if (!$crypton_blog_footer_wide) {
					?></div><!-- /.content_wrap --><?php
				}
				?>
			</div><!-- /.footer_widgets_inner -->
		</div><!-- /.footer_widgets_wrap -->
		<?php
	}
}
?>