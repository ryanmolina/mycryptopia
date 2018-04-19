<?php
/**
 * The Footer: widgets area, logo, footer menu and socials
 *
 * @package WordPress
 * @subpackage CRYPTON_BLOG
 * @since CRYPTON_BLOG 1.0
 */

						// Widgets area inside page content
						crypton_blog_create_widgets_area('widgets_below_content');
						?>				
					</div><!-- </.content> -->

					<?php
					// Show main sidebar
					get_sidebar();

					// Widgets area below page content
					crypton_blog_create_widgets_area('widgets_below_page');

					$crypton_blog_body_style = crypton_blog_get_theme_option('body_style');
					if ($crypton_blog_body_style != 'fullscreen') {
						?></div><!-- </.content_wrap> --><?php
					}
					?>
			</div><!-- </.page_content_wrap> -->

			<?php
			// Footer
			$crypton_blog_footer_type = crypton_blog_get_theme_option("footer_type");
			if ($crypton_blog_footer_type == 'custom' && !crypton_blog_is_layouts_available())
				$crypton_blog_footer_type = 'default';
			get_template_part( "templates/footer-{$crypton_blog_footer_type}");
			?>

		</div><!-- /.page_wrap -->

	</div><!-- /.body_wrap -->

	<?php if (crypton_blog_is_on(crypton_blog_get_theme_option('debug_mode')) && crypton_blog_get_file_dir('images/makeup.jpg')!='') { ?>
		<img src="<?php echo esc_url(crypton_blog_get_file_url('images/makeup.jpg')); ?>" id="makeup">
	<?php } ?>

	<?php wp_footer(); ?>

</body>
</html>