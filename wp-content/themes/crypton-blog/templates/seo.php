<?php
/**
 * The template to display the Structured Data Snippets
 *
 * @package WordPress
 * @subpackage CRYPTON_BLOG
 * @since CRYPTON_BLOG 1.0.30
 */

// Structured data snippets
if (crypton_blog_is_on(crypton_blog_get_theme_option('seo_snippets'))) {
	?><div class="structured_data_snippets">
		<meta itemprop="headline" content="<?php echo esc_attr(get_the_title()); ?>">
		<meta itemprop="datePublished" content="<?php echo esc_attr(get_the_date('Y-m-d')); ?>">
		<meta itemprop="dateModified" content="<?php echo esc_attr(get_the_modified_date('Y-m-d')); ?>">
		<div itemscope itemprop="publisher" itemtype="https://schema.org/Organization">
			<meta itemprop="name" content="<?php echo esc_attr(get_bloginfo( 'name' )); ?>">
			<meta itemprop="telephone" content="">
			<meta itemprop="address" content="">
			<?php
			$crypton_blog_logo_image = ( crypton_blog_get_retina_multiplier() > 1 && crypton_blog_get_theme_option( 'logo_retina' ) != '')
								? crypton_blog_get_theme_option( 'logo_retina' )
								: crypton_blog_get_theme_option( 'logo' );
			if (!empty($crypton_blog_logo_image)) {
				?><meta itemprop="logo" itemtype="https://schema.org/ImageObject" content="<?php echo esc_url($crypton_blog_logo_image); ?>"><?php
			}
			?>
		</div>
		<?php
		if ( crypton_blog_get_theme_option('show_author_info')!=1 || !is_single() || is_attachment() || !get_the_author_meta('description') ) {	// || 	!is_multi_author()
			?><div itemscope itemprop="author" itemtype="https://schema.org/Person">
				<meta itemprop="name" content="<?php echo esc_attr(get_the_author()); ?>">
			</div><?php
		}
	?></div><?php
}
?>