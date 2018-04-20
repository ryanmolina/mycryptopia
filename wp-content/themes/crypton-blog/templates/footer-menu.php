<?php
/**
 * The template to display menu in the footer
 *
 * @package WordPress
 * @subpackage CRYPTON_BLOG
 * @since CRYPTON_BLOG 1.0.10
 */

// Footer menu
$crypton_blog_menu_footer = crypton_blog_get_nav_menu(array(
											'location' => 'menu_footer',
											'class' => 'sc_layouts_menu sc_layouts_menu_default'
											));
if (!empty($crypton_blog_menu_footer)) {
	?>
	<div class="footer_menu_wrap">
		<div class="footer_menu_inner">
			<?php crypton_blog_show_layout($crypton_blog_menu_footer); ?>
		</div>
	</div>
	<?php
}
?>