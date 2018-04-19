<?php
/**
 * The template to display the copyright info in the footer
 *
 * @package WordPress
 * @subpackage CRYPTON_BLOG
 * @since CRYPTON_BLOG 1.0.10
 */

// Copyright area
$crypton_blog_footer_scheme =  crypton_blog_is_inherit(crypton_blog_get_theme_option('footer_scheme')) ? crypton_blog_get_theme_option('color_scheme') : crypton_blog_get_theme_option('footer_scheme');
$crypton_blog_copyright_scheme = crypton_blog_is_inherit(crypton_blog_get_theme_option('copyright_scheme')) ? $crypton_blog_footer_scheme : crypton_blog_get_theme_option('copyright_scheme');
?> 
<div class="footer_copyright_wrap scheme_<?php echo esc_attr($crypton_blog_copyright_scheme); ?>">
	<div class="footer_copyright_inner">
		<div class="content_wrap">
			<div class="copyright_text"><?php
				// Replace {{...}} and ((...)) on the <i>...</i> and <b>...</b>
				$crypton_blog_copyright = crypton_blog_prepare_macros(crypton_blog_get_theme_option('copyright'));
				if (!empty($crypton_blog_copyright)) {
					// Replace {date_format} on the current date in the specified format
					if (preg_match("/(\\{[\\w\\d\\\\\\-\\:]*\\})/", $crypton_blog_copyright, $crypton_blog_matches)) {
						$crypton_blog_copyright = str_replace($crypton_blog_matches[1], date_i18n(str_replace(array('{', '}'), '', $crypton_blog_matches[1])), $crypton_blog_copyright);
					}
					// Display copyright
					echo wp_kses_data(nl2br($crypton_blog_copyright));
				}
			?></div>
		</div>
	</div>
</div>
