<?php
// Add plugin-specific colors and fonts to the custom CSS
if ( !function_exists( 'crypton_blog_vc_get_css' ) ) {
	add_filter( 'crypton_blog_filter_get_css', 'crypton_blog_vc_get_css', 10, 4 );
	function crypton_blog_vc_get_css($css, $colors, $fonts, $scheme='') {
		if (isset($css['fonts']) && $fonts) {
			$css['fonts'] .= <<<CSS
.vc_tta.vc_tta-accordion .vc_tta-panel-title .vc_tta-title-text {
	{$fonts['p_font-family']}
}
.vc_progress_bar.vc_progress_bar_narrow .vc_single_bar .vc_label .vc_label_units {
	{$fonts['info_font-family']}
}
.vc_general.vc_tta.vc_tta-tabs.vc_tta-style-outline .vc_tta-panels-container .vc_tta-panel-title a span.vc_tta-title-text,
.vc_general.vc_tta.vc_tta-tabs.vc_tta-style-outline .vc_tta-tabs-container .vc_tta-tab a span.vc_tta-title-text {
	{$fonts['h1_font-family']}
}

CSS;
		}

		if (isset($css['colors']) && $colors) {
			$css['colors'] .= <<<CSS

/* Row and columns */
.scheme_self.vc_section,
.scheme_self.wpb_row,
.scheme_self.wpb_column > .vc_column-inner > .wpb_wrapper,
.scheme_self.wpb_text_column {
	color: {$colors['text']};
}
/* Background color for blocks with specified scheme (removed, use bg_color instead)
.scheme_self.vc_section[data-vc-full-width="true"],
.scheme_self.wpb_row[data-vc-full-width="true"],
.scheme_self.wpb_column:not([class*="sc_extra_bg_"]) > .vc_column-inner > .wpb_wrapper,
.scheme_self.wpb_text_column {
	background-color: {$colors['bg_color']};
}
*/
/* Mask for parallax background (removed, use bg_color + bg_mask instead)
.scheme_self.vc_row.vc_parallax[class*="scheme_"] .vc_parallax-inner:before {
	background-color: {$colors['bg_color_08']};
}
*/

/* Accordion */
.vc_tta.vc_tta-accordion .vc_tta-panel-heading .vc_tta-controls-icon {
	color: {$colors['inverse_link']};
	background-color: {$colors['text_dark']};
}
.vc_tta.vc_tta-accordion .vc_tta-panel-heading .vc_tta-controls-icon:before,
.vc_tta.vc_tta-accordion .vc_tta-panel-heading .vc_tta-controls-icon:after {
	border-color: {$colors['inverse_link']};
}
.vc_tta-color-grey.vc_tta-style-classic .vc_tta-panel .vc_tta-panel-title > a {
	color: {$colors['text_dark']};
}
.vc_tta-color-grey.vc_tta-style-classic .vc_tta-panel.vc_active .vc_tta-panel-title > a,
.vc_tta-color-grey.vc_tta-style-classic .vc_tta-panel .vc_tta-panel-title > a:hover {
	color: {$colors['text_link']};
}
.vc_tta-color-grey.vc_tta-style-classic .vc_tta-panel.vc_active .vc_tta-panel-title > a .vc_tta-controls-icon,
.vc_tta-color-grey.vc_tta-style-classic .vc_tta-panel .vc_tta-panel-title > a:hover .vc_tta-controls-icon {
	color: {$colors['inverse_link']};
	background-color: {$colors['text_link']};
}
.vc_tta-color-grey.vc_tta-style-classic .vc_tta-panel.vc_active .vc_tta-panel-title > a .vc_tta-controls-icon:before,
.vc_tta-color-grey.vc_tta-style-classic .vc_tta-panel.vc_active .vc_tta-panel-title > a .vc_tta-controls-icon:after {
	border-color: {$colors['inverse_link']};
}

/* Tabs */
.vc_tta-color-grey.vc_tta-style-classic .vc_tta-tabs-list .vc_tta-tab > a {
	color: {$colors['inverse_link']};
	background-color: {$colors['text_dark']};
}
.vc_tta-color-grey.vc_tta-style-classic .vc_tta-tabs-list .vc_tta-tab > a:hover,
.vc_tta-color-grey.vc_tta-style-classic .vc_tta-tabs-list .vc_tta-tab.vc_active > a {
	color: {$colors['inverse_hover']};
	background-color: {$colors['text_link']};
}

/* Separator */
.vc_separator.vc_sep_color_grey .vc_sep_line {
	border-color: {$colors['bd_color']};
}

/* Progress bar */
.vc_progress_bar.vc_progress_bar_narrow .vc_single_bar {
	background-color: {$colors['alter_bg_color']};
}
.vc_progress_bar.vc_progress_bar_narrow.vc_progress-bar-color-bar_red .vc_single_bar .vc_bar {
	background-color: {$colors['alter_link']};
}
.vc_progress_bar.vc_progress_bar_narrow .vc_single_bar .vc_label {
	color: {$colors['text_dark']};
}
.vc_progress_bar.vc_progress_bar_narrow .vc_single_bar .vc_label .vc_label_units {
	color: {$colors['text_dark']};
}

/*------------------------------------------------------------------------------------------------*/
.vc_general.vc_tta.vc_tta-tabs.vc_tta-style-outline .vc_tta-panels-container .vc_tta-panel-title a span.vc_tta-title-text,
.vc_general.vc_tta.vc_tta-tabs.vc_tta-style-outline .vc_tta-tabs-container .vc_tta-tab a{
	color: {$colors['text_dark']};
	background-color: transparent;
}
.vc_general.vc_tta.vc_tta-tabs.vc_tta-style-outline .vc_tta-panels-container .vc_tta-panel.vc_active .vc_tta-panel-title a span.vc_tta-title-text,
.vc_general.vc_tta.vc_tta-tabs.vc_tta-style-outline .vc_tta-panels-container .vc_tta-panel:hover .vc_tta-panel-title a span.vc_tta-title-text,
.vc_general.vc_tta.vc_tta-tabs.vc_tta-style-outline .vc_tta-tabs-container .vc_tta-tab:hover a,
.vc_general.vc_tta.vc_tta-tabs.vc_tta-style-outline .vc_tta-tabs-container .vc_tta-tab.vc_active a{
	color: {$colors['text_link']};
}
.vc_general.vc_tta.vc_tta-tabs.vc_tta-style-outline .vc_tta-tabs-container .vc_tta-tab a span.vc_tta-title-text {
	border-color: transparent;
}
.vc_general.vc_tta.vc_tta-tabs.vc_tta-style-outline .vc_tta-panels-container .vc_tta-panel.vc_active .vc_tta-panel-heading,
.vc_general.vc_tta.vc_tta-tabs.vc_tta-style-outline .vc_tta-panels-container .vc_tta-panel:hover .vc_tta-panel-heading,
.vc_general.vc_tta.vc_tta-tabs.vc_tta-style-outline .vc_tta-tabs-container .vc_tta-tab:hover a span.vc_tta-title-text,
.vc_general.vc_tta.vc_tta-tabs.vc_tta-style-outline .vc_tta-tabs-container .vc_tta-tab.vc_active a span.vc_tta-title-text {
	border-color: {$colors['text_link']};
	background-color: transparent;
}
.vc_general.vc_tta.vc_tta-tabs.vc_tta-style-outline .vc_tta-panels-container .woocommerce .products li{
	border-right-color: {$colors['bd_color']};
}
.vc_general.vc_tta.vc_tta-tabs.vc_tta-style-outline .vc_tta-panels-container .woocommerce .products li:nth-child(2n+0):hover,
.vc_general.vc_tta-tabs.vc_tta-style-outline .vc_tta-panels-container .woocommerce .products li:hover,
.vc_general.vc_tta-tabs.vc_tta-style-outline .vc_tta-panels-container .woocommerce .products li:last-child:hover{
	border-color: {$colors['bd_color']} !important;
}

.vc_general.vc_tta.vc_tta-tabs.vc_tta-style-outline .vc_tta-panels-container .woocommerce .products li .post_item .price > span,
.vc_general.vc_tta.vc_tta-tabs.vc_tta-style-outline .vc_tta-panels-container .woocommerce .products li .post_item .price ins span{
	color: {$colors['text_link']};
}



CSS;
		}
		
		return $css;
	}
}
?>