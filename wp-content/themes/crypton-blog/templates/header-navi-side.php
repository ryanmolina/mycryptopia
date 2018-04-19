<?php
/**
 * The template to display the side menu
 *
 * @package WordPress
 * @subpackage CRYPTON_BLOG
 * @since CRYPTON_BLOG 1.0
 */
?>
<div class="menu_side_wrap scheme_<?php echo esc_attr(crypton_blog_is_inherit(crypton_blog_get_theme_option('menu_scheme')) 
																	? (crypton_blog_is_inherit(crypton_blog_get_theme_option('header_scheme')) 
																		? crypton_blog_get_theme_option('color_scheme') 
																		: crypton_blog_get_theme_option('header_scheme')) 
																	: crypton_blog_get_theme_option('menu_scheme'));
			echo " menu_side_".esc_attr(crypton_blog_get_theme_option('menu_side_icons') > 0 ? 'icons' : 'dots');
			?>">
	<span class="menu_side_button icon-menu-2"></span>

	<div class="menu_side_inner">
		<?php
		// Logo
		set_query_var('crypton_blog_logo_args', array('type' => 'side'));
		get_template_part( 'templates/header-logo' );
		set_query_var('crypton_blog_logo_args', array());
		// Main menu button
		?>
		<div class="toc_menu_item">
			<a href="#" class="toc_menu_description menu_mobile_description"><span class="toc_menu_description_title"><?php esc_html_e('Main menu', 'crypton-blog'); ?></span></a>
			<a class="menu_mobile_button toc_menu_icon icon-menu-2" href="#"></a>
		</div>		
	</div>
	
</div><!-- /.menu_side_wrap -->