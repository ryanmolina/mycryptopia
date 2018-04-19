<?php
/**
 * The template to display the site logo in the footer
 *
 * @package WordPress
 * @subpackage CRYPTON_BLOG
 * @since CRYPTON_BLOG 1.0.10
 */

// Logo
if (crypton_blog_is_on(crypton_blog_get_theme_option('logo_in_footer'))) {
	$crypton_blog_logo_image = '';
	if (crypton_blog_is_on(crypton_blog_get_theme_option('logo_retina_enabled')) && crypton_blog_get_retina_multiplier() > 1)
		$crypton_blog_logo_image = crypton_blog_get_theme_option( 'logo_footer_retina' );
	if (empty($crypton_blog_logo_image)) 
		$crypton_blog_logo_image = crypton_blog_get_theme_option( 'logo_footer' );
	$crypton_blog_logo_text   = get_bloginfo( 'name' );
	if (!empty($crypton_blog_logo_image) || !empty($crypton_blog_logo_text)) {
		?>
		<div class="footer_logo_wrap">
			<div class="footer_logo_inner">
				<?php
				if (!empty($crypton_blog_logo_image)) {
					$crypton_blog_attr = crypton_blog_getimagesize($crypton_blog_logo_image);
					echo '<a href="'.esc_url(home_url('/')).'"><img src="'.esc_url($crypton_blog_logo_image).'" class="logo_footer_image" alt=""'.(!empty($crypton_blog_attr[3]) ? ' ' . wp_kses_data($crypton_blog_attr[3]) : '').'></a>' ;
				} else if (!empty($crypton_blog_logo_text)) {
					echo '<h1 class="logo_footer_text"><a href="'.esc_url(home_url('/')).'">' . esc_html($crypton_blog_logo_text) . '</a></h1>';
				}
				?>
			</div>
		</div>
		<?php
	}
}
?>