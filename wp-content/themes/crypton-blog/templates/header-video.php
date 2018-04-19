<?php
/**
 * The template to display the background video in the header
 *
 * @package WordPress
 * @subpackage CRYPTON_BLOG
 * @since CRYPTON_BLOG 1.0.14
 */
$crypton_blog_header_video = crypton_blog_get_header_video();
$crypton_blog_embed_video = '';
if (!empty($crypton_blog_header_video) && !crypton_blog_is_from_uploads($crypton_blog_header_video)) {
	if (crypton_blog_is_youtube_url($crypton_blog_header_video) && preg_match('/[=\/]([^=\/]*)$/', $crypton_blog_header_video, $matches) && !empty($matches[1])) {
		?><div id="background_video" data-youtube-code="<?php echo esc_attr($matches[1]); ?>"></div><?php
	} else {
		global $wp_embed;
		if (false && is_object($wp_embed)) {
			$crypton_blog_embed_video = do_shortcode($wp_embed->run_shortcode( '[embed]' . trim($crypton_blog_header_video) . '[/embed]' ));
			$crypton_blog_embed_video = crypton_blog_make_video_autoplay($crypton_blog_embed_video);
		} else {
			$crypton_blog_header_video = str_replace('/watch?v=', '/embed/', $crypton_blog_header_video);
			$crypton_blog_header_video = crypton_blog_add_to_url($crypton_blog_header_video, array(
				'feature' => 'oembed',
				'controls' => 0,
				'autoplay' => 1,
				'showinfo' => 0,
				'modestbranding' => 1,
				'wmode' => 'transparent',
				'enablejsapi' => 1,
				'origin' => home_url(),
				'widgetid' => 1
			));
			$crypton_blog_embed_video = '<iframe src="' . esc_url($crypton_blog_header_video) . '" width="1170" height="658" allowfullscreen="0" frameborder="0"></iframe>';
		}
		?><div id="background_video"><?php crypton_blog_show_layout($crypton_blog_embed_video); ?></div><?php
	}
}
?>