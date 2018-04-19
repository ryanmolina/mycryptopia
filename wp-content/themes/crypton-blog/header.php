<?php
/**
 * The Header: Logo and main menu
 *
 * @package WordPress
 * @subpackage CRYPTON_BLOG
 * @since CRYPTON_BLOG 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js scheme_<?php
										 // Class scheme_xxx need in the <html> as context for the <body>!
										 echo esc_attr(crypton_blog_get_theme_option('color_scheme'));
										 ?>">
<head>
	<?php wp_head(); ?>
</head>

<body <?php	body_class(); ?>>

	<?php do_action( 'crypton_blog_action_before_body' ); ?>

	<div class="body_wrap">


        <canvas class="start" id="canvas"></canvas>


		<div class="page_wrap"><?php
			
			// Desktop header
			$crypton_blog_header_type = crypton_blog_get_theme_option("header_type");
			if ($crypton_blog_header_type == 'custom' && !crypton_blog_is_layouts_available())
				$crypton_blog_header_type = 'default';
			get_template_part( "templates/header-{$crypton_blog_header_type}");

			// Side menu
			if (in_array(crypton_blog_get_theme_option('menu_style'), array('left', 'right'))) {
				get_template_part( 'templates/header-navi-side' );
			}

			// Mobile header
			get_template_part( 'templates/header-mobile');
			?>

			<div class="page_content_wrap">

				<?php if (crypton_blog_get_theme_option('body_style') != 'fullscreen') { ?>
				<div class="content_wrap">
				<?php } ?>

					<?php
					// Widgets area above page content
					crypton_blog_create_widgets_area('widgets_above_page');
					?>				

					<div class="content">
						<?php
						// Widgets area inside page content
						crypton_blog_create_widgets_area('widgets_above_content');
						?>				
