<div class="front_page_section front_page_section_contacts<?php
			$crypton_blog_scheme = crypton_blog_get_theme_option('front_page_contacts_scheme');
			if (!crypton_blog_is_inherit($crypton_blog_scheme)) echo ' scheme_'.esc_attr($crypton_blog_scheme);
			echo ' front_page_section_paddings_'.esc_attr(crypton_blog_get_theme_option('front_page_contacts_paddings'));
		?>"<?php
		$crypton_blog_css = '';
		$crypton_blog_bg_image = crypton_blog_get_theme_option('front_page_contacts_bg_image');
		if (!empty($crypton_blog_bg_image)) 
			$crypton_blog_css .= 'background-image: url('.esc_url(crypton_blog_get_attachment_url($crypton_blog_bg_image)).');';
		if (!empty($crypton_blog_css))
			echo ' style="' . esc_attr($crypton_blog_css) . '"';
?>><?php
	// Add anchor
	$crypton_blog_anchor_icon = crypton_blog_get_theme_option('front_page_contacts_anchor_icon');	
	$crypton_blog_anchor_text = crypton_blog_get_theme_option('front_page_contacts_anchor_text');	
	if ((!empty($crypton_blog_anchor_icon) || !empty($crypton_blog_anchor_text)) && shortcode_exists('trx_sc_anchor')) {
		echo do_shortcode('[trx_sc_anchor id="front_page_section_contacts"'
										. (!empty($crypton_blog_anchor_icon) ? ' icon="'.esc_attr($crypton_blog_anchor_icon).'"' : '')
										. (!empty($crypton_blog_anchor_text) ? ' title="'.esc_attr($crypton_blog_anchor_text).'"' : '')
										. ']');
	}
	?>
	<div class="front_page_section_inner front_page_section_contacts_inner<?php
			if (crypton_blog_get_theme_option('front_page_contacts_fullheight'))
				echo ' crypton_blog-full-height sc_layouts_flex sc_layouts_columns_middle';
			?>"<?php
			$crypton_blog_css = '';
			$crypton_blog_bg_mask = crypton_blog_get_theme_option('front_page_contacts_bg_mask');
			$crypton_blog_bg_color = crypton_blog_get_theme_option('front_page_contacts_bg_color');
			if (!empty($crypton_blog_bg_color) && $crypton_blog_bg_mask > 0)
				$crypton_blog_css .= 'background-color: '.esc_attr($crypton_blog_bg_mask==1
																	? $crypton_blog_bg_color
																	: crypton_blog_hex2rgba($crypton_blog_bg_color, $crypton_blog_bg_mask)
																).';';
			if (!empty($crypton_blog_css))
				echo ' style="' . esc_attr($crypton_blog_css) . '"';
	?>>
		<div class="front_page_section_content_wrap front_page_section_contacts_content_wrap content_wrap">
			<?php

			// Title and description
			$crypton_blog_caption = crypton_blog_get_theme_option('front_page_contacts_caption');
			$crypton_blog_description = crypton_blog_get_theme_option('front_page_contacts_description');
			if (!empty($crypton_blog_caption) || !empty($crypton_blog_description) || (current_user_can('edit_theme_options') && is_customize_preview())) {
				// Caption
				if (!empty($crypton_blog_caption) || (current_user_can('edit_theme_options') && is_customize_preview())) {
					?><h2 class="front_page_section_caption front_page_section_contacts_caption front_page_block_<?php echo !empty($crypton_blog_caption) ? 'filled' : 'empty'; ?>"><?php
						echo wp_kses_post($crypton_blog_caption);
					?></h2><?php
				}
			
				// Description
				if (!empty($crypton_blog_description) || (current_user_can('edit_theme_options') && is_customize_preview())) {
					?><div class="front_page_section_description front_page_section_contacts_description front_page_block_<?php echo !empty($crypton_blog_description) ? 'filled' : 'empty'; ?>"><?php
						echo wp_kses_post(wpautop($crypton_blog_description));
					?></div><?php
				}
			}

			// Content (text)
			$crypton_blog_content = crypton_blog_get_theme_option('front_page_contacts_content');
			$crypton_blog_layout = crypton_blog_get_theme_option('front_page_contacts_layout');
			if ($crypton_blog_layout == 'columns' && (!empty($crypton_blog_content) || (current_user_can('edit_theme_options') && is_customize_preview()))) {
				?><div class="front_page_section_columns front_page_section_contacts_columns columns_wrap">
					<div class="column-1_3">
				<?php
			}

			if ((!empty($crypton_blog_content) || (current_user_can('edit_theme_options') && is_customize_preview()))) {
				?><div class="front_page_section_content front_page_section_contacts_content front_page_block_<?php echo !empty($crypton_blog_content) ? 'filled' : 'empty'; ?>"><?php
					echo wp_kses_post($crypton_blog_content);
				?></div><?php
			}

			if ($crypton_blog_layout == 'columns' && (!empty($crypton_blog_content) || (current_user_can('edit_theme_options') && is_customize_preview()))) {
				?></div><div class="column-2_3"><?php
			}
		
			// Shortcode output
			$crypton_blog_sc = crypton_blog_get_theme_option('front_page_contacts_shortcode');
			if (!empty($crypton_blog_sc) || (current_user_can('edit_theme_options') && is_customize_preview())) {
				?><div class="front_page_section_output front_page_section_contacts_output front_page_block_<?php echo !empty($crypton_blog_sc) ? 'filled' : 'empty'; ?>"><?php
					crypton_blog_show_layout(do_shortcode($crypton_blog_sc));
				?></div><?php
			}

			if ($crypton_blog_layout == 'columns' && (!empty($crypton_blog_content) || (current_user_can('edit_theme_options') && is_customize_preview()))) {
				?></div></div><?php
			}
			?>			
		</div>
	</div>
</div>