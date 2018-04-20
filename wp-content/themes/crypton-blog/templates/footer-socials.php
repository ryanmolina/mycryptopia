<?php
/**
 * The template to display the socials in the footer
 *
 * @package WordPress
 * @subpackage CRYPTON_BLOG
 * @since CRYPTON_BLOG 1.0.10
 */


// Socials
if ( crypton_blog_is_on(crypton_blog_get_theme_option('socials_in_footer')) && ($crypton_blog_output = crypton_blog_get_socials_links()) != '') {
	?>
	<div class="footer_socials_wrap socials_wrap">
		<div class="footer_socials_inner">
			<?php crypton_blog_show_layout($crypton_blog_output); ?>
		</div>
	</div>
	<?php
}
?>