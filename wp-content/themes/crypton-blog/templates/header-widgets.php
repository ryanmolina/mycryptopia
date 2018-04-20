<?php
/**
 * The template to display the widgets area in the header
 *
 * @package WordPress
 * @subpackage CRYPTON_BLOG
 * @since CRYPTON_BLOG 1.0
 */

// Header sidebar
$crypton_blog_header_name = crypton_blog_get_theme_option('header_widgets');
$crypton_blog_header_present = !crypton_blog_is_off($crypton_blog_header_name) && is_active_sidebar($crypton_blog_header_name);
if ($crypton_blog_header_present) { 
	crypton_blog_storage_set('current_sidebar', 'header');
	$crypton_blog_header_wide = crypton_blog_get_theme_option('header_wide');
	ob_start();
	if ( is_active_sidebar($crypton_blog_header_name) ) {
		dynamic_sidebar($crypton_blog_header_name);
	}
	$crypton_blog_widgets_output = ob_get_contents();
	ob_end_clean();
	if (!empty($crypton_blog_widgets_output)) {
		$crypton_blog_widgets_output = preg_replace("/<\/aside>[\r\n\s]*<aside/", "</aside><aside", $crypton_blog_widgets_output);
		$crypton_blog_need_columns = strpos($crypton_blog_widgets_output, 'columns_wrap')===false;
		if ($crypton_blog_need_columns) {
			$crypton_blog_columns = max(0, (int) crypton_blog_get_theme_option('header_columns'));
			if ($crypton_blog_columns == 0) $crypton_blog_columns = min(6, max(1, substr_count($crypton_blog_widgets_output, '<aside ')));
			if ($crypton_blog_columns > 1)
				$crypton_blog_widgets_output = preg_replace("/<aside([^>]*)class=\"widget/", "<aside$1class=\"column-1_".esc_attr($crypton_blog_columns).' widget', $crypton_blog_widgets_output);
			else
				$crypton_blog_need_columns = false;
		}
		?>
		<div class="header_widgets_wrap widget_area<?php echo !empty($crypton_blog_header_wide) ? ' header_fullwidth' : ' header_boxed'; ?>">
			<div class="header_widgets_inner widget_area_inner">
				<?php 
				if (!$crypton_blog_header_wide) { 
					?><div class="content_wrap"><?php
				}
				if ($crypton_blog_need_columns) {
					?><div class="columns_wrap"><?php
				}
				do_action( 'crypton_blog_action_before_sidebar' );
				crypton_blog_show_layout($crypton_blog_widgets_output);
				do_action( 'crypton_blog_action_after_sidebar' );
				if ($crypton_blog_need_columns) {
					?></div>	<!-- /.columns_wrap --><?php
				}
				if (!$crypton_blog_header_wide) {
					?></div>	<!-- /.content_wrap --><?php
				}
				?>
			</div>	<!-- /.header_widgets_inner -->
		</div>	<!-- /.header_widgets_wrap -->
		<?php
	}
}
?>