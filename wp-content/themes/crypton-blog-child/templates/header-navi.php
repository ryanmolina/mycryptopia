<?php
/**
 * The template to display the main menu
 *
 * @package WordPress
 * @subpackage CRYPTON_BLOG
 * @since CRYPTON_BLOG 1.0
 */
?>
<div class="top_panel_navi sc_layouts_row sc_layouts_row_type_compact sc_layouts_row_fixed sc_layouts_row_fixed_always<?php
if (false) {
	echo ' scheme_'. esc_attr(crypton_blog_is_inherit(crypton_blog_get_theme_option('menu_scheme')) 
	? (crypton_blog_is_inherit(crypton_blog_get_theme_option('header_scheme')) 
	? crypton_blog_get_theme_option('color_scheme') 
	: crypton_blog_get_theme_option('header_scheme')) 
	: crypton_blog_get_theme_option('menu_scheme'));
}
?>">
<div class="content_wrap img_menu">
	<div class="columns_wrap columns_fluid">
		<div class="sc_layouts_column sc_layouts_column_align_left sc_layouts_column_icons_position_left sc_layouts_column_fluid column-1_4">
			<?php
				// Logo
			?><div class="sc_layouts_item"><?php
			get_template_part( 'templates/header-logo' );
			?></div>
			</div><?php
			
			// Attention! Don't place any spaces between columns!
				?><div class="sc_layouts_column sc_layouts_column_align_right sc_layouts_column_icons_position_left sc_layouts_column_fluid column-7_12">
					<div class="sc_layouts_item">
						<?php
						// Main menu
						$crypton_blog_menu_main = crypton_blog_get_nav_menu(array(
							'location' => 'menu_main', 
							'class' => 'sc_layouts_menu sc_layouts_menu_default sc_layouts_hide_on_mobile'
						)
					);
						// Show any menu if no menu selected in the location 'menu_main'
						if (crypton_blog_get_theme_setting('autoselect_menu') && empty($crypton_blog_menu_main)) {
							$crypton_blog_menu_main = crypton_blog_get_nav_menu(array(
								'class' => 'sc_layouts_menu sc_layouts_menu_default sc_layouts_hide_on_mobile'
							)
						);
						}
						crypton_blog_show_layout($crypton_blog_menu_main);
						// Mobile menu button
						?>
						<div class="sc_layouts_iconed_text sc_layouts_menu_mobile_button">
							<a class="sc_layouts_item_link sc_layouts_iconed_text_link" href="#">
								<span class="sc_layouts_item_icon sc_layouts_iconed_text_icon trx_addons_icon-menu"></span>
							</a>
						</div>
					</div>
				</div>
				<!-- ->| NAV SEARCH HARDCODE -->
				<!-- NAV SEARCH CUSTOM STYLE  -->
				<style type="text/css">
					 #navi_search_wrap {
					    display: inline-block;
					    position: relative;
					    top: -3px;
					    margin-left: -10px;
					}
					#navi_search_wrap .search_style_expand.search_opened {
					    background-color: transparent !important;
					}
					#navi_search_wrap input {
					    width: 0px;
					    position: relative;
					    left: 25px;
					    padding: 3px 5px !important;
					    border-bottom: 2px solid #ff8a00 !important;
					    border-radius: 5px !important;
					    transition: width 0.3s;
					    font-family: Poppins, sans-serif !important;
					    font-size: 14px;
					    font-weight: 300;
					    padding-bottom: 0px !important;
					}

					#navi_search_wrap .search_submit {
					    font-weight: bolder;
					    background-color: #cccccc00;
					    font-size: 21px;
					}

					#navi_search_wrap .search_submit:hover {
					    transform: scale(1.2);
					}

					#navi_search_wrap .search_submit:before {
					    color: #ff8a00 !important;
					    font-weight: bolder;
					}

					#navi_search_wrap .search_submit:hover:before {
					    color: #ffa73f !important;
					}
				</style>

			<div id="navi_search_wrap" class="column-2_12 hide_on_mobile">
				<?php echo do_shortcode('[trx_sc_layouts_search style="expand" ajax="" hide_on_desktop="" hide_on_notebook="" hide_on_tablet="" hide_on_mobile="true"]') ?>
			</div>
			<!-- NAV SEARCH CUSTOM SCRIPT  -->
			<script type="text/javascript">
					let $j = jQuery.noConflict();
					$j('#navi_search_wrap .search_submit').click(function() {
						if ($j('#navi_search_wrap input').width() === 0) {
							$j('#navi_search_wrap input').css("width", "100%");
						} else {
							$j('#navi_search_wrap input').css({"width": "0"});
						}
					});
			</script>
			<!-- |-> NAV SEARCH HARDCODE -->
		</div><!-- /.columns_wrap
	</div><!-- /.content_wrap -->
</div><!-- /.top_panel_navi -->
