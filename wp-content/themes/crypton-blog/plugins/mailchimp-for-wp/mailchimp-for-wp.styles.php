<?php
// Add plugin-specific colors and fonts to the custom CSS
if (!function_exists('crypton_blog_mailchimp_get_css')) {
	add_filter('crypton_blog_filter_get_css', 'crypton_blog_mailchimp_get_css', 10, 4);
	function crypton_blog_mailchimp_get_css($css, $colors, $fonts, $scheme='') {
		
		if (isset($css['fonts']) && $fonts) {
			$css['fonts'] .= <<<CSS
form.mc4wp-form .mc4wp-form-fields input[type="email"] {
	{$fonts['input_font-family']}
	{$fonts['input_font-size']}
	{$fonts['input_font-weight']}
	{$fonts['input_font-style']}
	{$fonts['input_line-height']}
	{$fonts['input_text-decoration']}
	{$fonts['input_text-transform']}
	{$fonts['input_letter-spacing']}
}
CSS;
		
			
			$rad = crypton_blog_get_border_radius();
			$css['fonts'] .= <<<CSS

form.mc4wp-form .mc4wp-form-fields input[type="email"],
form.mc4wp-form .mc4wp-form-fields input[type="submit"] {

}

CSS;
		}

		
		if (isset($css['colors']) && $colors) {
			$css['colors'] .= <<<CSS


form.mc4wp-form .mc4wp-alert {
	background-color: {$colors['text_link']};
	border-color: {$colors['text_hover']};
	color: {$colors['inverse_text']};
}
.wrap_for_icon:before {
	color: {$colors['inverse_link']};
}


.sc_popup form.mc4wp-form .mc4wp-form-fields input[type="submit"] {
	background-color: {$colors['text_link']};
}
.sc_popup form.mc4wp-form .mc4wp-form-fields input[type="submit"]:hover {
	background-color: {$colors['text_hover']};
}

CSS;
		}

		return $css;
	}
}
?>