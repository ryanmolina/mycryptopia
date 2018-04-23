<!-- MOBILE MENU SEARCH IMPLEMENTATION -->
<style type="text/css">
#mobile_menu_search_wrap {
    display: inline-block;
    position: relative;
    width: 100%;
    margin: 30px auto;
}

/* SEARCH INPUT FIELD */
#mobile_menu_search_wrap .search_field {
    font-size: 18px;
    padding: 5px !important;
    line-height: normal !important;
    width: 60%;
    border: 1px solid #5f5f5f;
    background-color: #16161b;
}

/* SEARCH BUTTON */
#mobile_menu_search_wrap .search_submit {
    padding: 5px;
    line-height: normal !important;
    text-align: center;
    display: inline-block;
    position: relative;
    background-color: #161d2c;
    border: 1px solid #2e2d33 !important;
    height: 33px;
    width: 50px;
    top: 3px;
    left: -4px;
}

/* SEARCH BUTTON ICON */
#mobile_menu_search_wrap .search_submit:before {
    font-size: 18px;
    color: #ff8a00;
    font-weight: bolder;
}

<?php
/**
 * The template to show mobile header and menu
 *
 * @package WordPress
 * @subpackage CRYPTON_BLOG
 * @since CRYPTON_BLOG 1.0
 */

// Mobile header
if (crypton_blog_get_theme_option('header_mobile_enabled')) {
	$crypton_blog_header_css = $crypton_blog_header_image = '';
	$crypton_blog_header_image = get_header_image();
	if (crypton_blog_trx_addons_featured_image_override()) $crypton_blog_header_image = crypton_blog_get_current_mode_image($crypton_blog_header_image);
	?>
	<div class="top_panel_mobile<?php
						echo !empty($crypton_blog_header_image) ? ' with_bg_image' : ' without_bg_image';
						if ($crypton_blog_header_image!='') echo ' '.esc_attr(crypton_blog_add_inline_css_class('background-image: url('.esc_url($crypton_blog_header_image).');'));
						?> scheme_<?php echo esc_attr(crypton_blog_is_inherit(crypton_blog_get_theme_option('header_scheme')) 
														? crypton_blog_get_theme_option('color_scheme') 
														: crypton_blog_get_theme_option('header_scheme'));
						?>"><?php
		
		do_action('crypton_blog_action_before_header_mobile_info');

		// Additional info
		if (crypton_blog_is_off(crypton_blog_get_theme_option('header_mobile_hide_info')) && ($crypton_blog_info=crypton_blog_get_theme_option('header_mobile_additional_info'))!='') {
			?><div class="top_panel_mobile_info sc_layouts_row sc_layouts_row_type_compact sc_layouts_row_delimiter">
				<div class="content_wrap">
					<div class="columns_wrap">
						<div class="sc_layouts_column sc_layouts_column_align_center sc_layouts_column_icons_position_left column-1_1"><?php
							?><div class="sc_layouts_item"><?php
								crypton_blog_show_layout($crypton_blog_info);
							?></div><!-- /.sc_layouts_item -->
						</div><!-- /.sc_layouts_column -->
					</div><!-- /.columns_wrap -->
				</div><!-- /.content_wrap -->
			</div><!-- /.sc_layouts_row --><?php
		}

		do_action('crypton_blog_action_before_header_mobile_before_navi');

		?><div class="top_panel_mobile_navi sc_layouts_row sc_layouts_row_type_compact sc_layouts_row_delimiter sc_layouts_row_fixed sc_layouts_row_fixed_always">
			<div class="content_wrap">
				<div class="columns_wrap columns_fluid">
					<div class="sc_layouts_column sc_layouts_column_align_left sc_layouts_column_icons_position_left sc_layouts_column_fluid column-1_3"><?php
						do_action('crypton_blog_action_before_header_mobile_before_logo');
						// Logo
						if (crypton_blog_is_off(crypton_blog_get_theme_option('header_mobile_hide_logo'))) {
							?><div class="sc_layouts_item"><?php
								set_query_var('crypton_blog_logo_args', array('type' => 'mobile_header'));
								get_template_part( 'templates/header-logo' );
								set_query_var('crypton_blog_logo_args', array());
							?></div><?php
						}
						do_action('crypton_blog_action_before_header_mobile_after_logo');
					?></div><?php
					
					// Attention! Don't place any spaces between columns!
					?><div class="sc_layouts_column sc_layouts_column_align_right sc_layouts_column_icons_position_left sc_layouts_column_fluid  column-2_3"><?php
						if (crypton_blog_exists_trx_addons()) {
							do_action('crypton_blog_action_before_header_mobile_before_login');
							// Display login/logout
							if (crypton_blog_is_off(crypton_blog_get_theme_option('header_mobile_hide_login'))) {
								ob_start();
								do_action('crypton_blog_action_login', array('text_login' => false, 'text_logout' => false));
								$crypton_blog_action_output = ob_get_contents();
								ob_end_clean();
								if (!empty($crypton_blog_action_output)) {
									?><div class="sc_layouts_item sc_layouts_menu sc_layouts_menu_default"><?php
										crypton_blog_show_layout($crypton_blog_action_output);
									?></div><?php
								}
							}
							do_action('crypton_blog_action_before_header_mobile_before_cart');
							// Display cart button
							if (crypton_blog_is_off(crypton_blog_get_theme_option('header_mobile_hide_cart'))) {
								ob_start();
								do_action('crypton_blog_action_cart');
								$crypton_blog_action_output = ob_get_contents();
								ob_end_clean();
								if (!empty($crypton_blog_action_output)) {
									?><div class="sc_layouts_item"><?php
										crypton_blog_show_layout($crypton_blog_action_output);
									?></div><?php
								}
							}
							do_action('crypton_blog_action_before_header_mobile_before_search');
							// Display search field
							if (crypton_blog_is_off(crypton_blog_get_theme_option('header_mobile_hide_search'))) {
								ob_start();
								do_action('crypton_blog_action_search', 'fullscreen', 'header_mobile_search', false);
								$crypton_blog_action_output = ob_get_contents();
								ob_end_clean();
								if (!empty($crypton_blog_action_output)) {
									?><div class="sc_layouts_item"><?php
										crypton_blog_show_layout($crypton_blog_action_output);
									?></div><?php
								}
							}
						}

						do_action('crypton_blog_action_before_header_mobile_before_menu_button');
						
						// Mobile menu button
						?><div class="sc_layouts_item">
							<div class="sc_layouts_iconed_text sc_layouts_menu_mobile_button">
								<a class="sc_layouts_item_link sc_layouts_iconed_text_link" href="#">
									<span class="sc_layouts_item_icon sc_layouts_iconed_text_icon trx_addons_icon-menu"></span>
								</a>
							</div>
						</div><?php

						do_action('crypton_blog_action_before_header_mobile_after_menu_button');

					?></div><!-- /.sc_layouts_column -->
				</div><!-- /.columns_wrap -->
			</div><!-- /.content_wrap -->
		</div><!-- /.sc_layouts_row --><?php

		do_action('crypton_blog_action_before_header_mobile_after_navi');
		
	?></div><!-- /.top_panel_mobile --><?php
}

// Mobile menu
?>
<div class="menu_mobile_overlay"></div>
<div class="menu_mobile menu_mobile_<?php echo esc_attr(crypton_blog_get_theme_option('menu_mobile_fullscreen') > 0 ? 'fullscreen' : 'narrow'); ?> scheme_dark">
	<div class="menu_mobile_inner">
		<a class="menu_mobile_close icon-cancel"></a><?php

		// Logo
		set_query_var('crypton_blog_logo_args', array('type' => 'mobile'));
		get_template_part( 'templates/header-logo' );
		set_query_var('crypton_blog_logo_args', array());

		// Mobile menu
		$crypton_blog_menu_mobile = crypton_blog_get_nav_menu('menu_mobile');
		if (empty($crypton_blog_menu_mobile)) {
			$crypton_blog_menu_mobile = apply_filters('crypton_blog_filter_get_mobile_menu', '');
			if (empty($crypton_blog_menu_mobile)) $crypton_blog_menu_mobile = crypton_blog_get_nav_menu('menu_main');
			if (empty($crypton_blog_menu_mobile)) $crypton_blog_menu_mobile = crypton_blog_get_nav_menu();
		}
		if (!empty($crypton_blog_menu_mobile)) {
			if (!empty($crypton_blog_menu_mobile))
				$crypton_blog_menu_mobile = str_replace(
					array('menu_main', 'id="menu-', 'sc_layouts_menu_nav', 'sc_layouts_hide_on_mobile', 'hide_on_mobile'),
					array('menu_mobile', 'id="menu_mobile-', '', '', ''),
					$crypton_blog_menu_mobile
					);
			if (strpos($crypton_blog_menu_mobile, '<nav ')===false)
				$crypton_blog_menu_mobile = sprintf('<nav class="menu_mobile_nav_area">%s</nav>', $crypton_blog_menu_mobile);
			crypton_blog_show_layout(apply_filters('crypton_blog_filter_menu_mobile_layout', $crypton_blog_menu_mobile));
		}
		// MOBILE MENU SEARCH
		echo "<div id='mobile_menu_search_wrap'>";
		echo do_shortcode('[trx_sc_layouts_search style="normal" ajax="" hide_on_desktop="" hide_on_notebook="" hide_on_tablet="" hide_on_mobile=""]');
		echo "</div id='mobile_menu_search_wrap'>";

		// Social icons
		crypton_blog_show_layout(crypton_blog_get_socials_links(), '<div class="socials_mobile">', '</div>');
		?>
	</div>
</div>
