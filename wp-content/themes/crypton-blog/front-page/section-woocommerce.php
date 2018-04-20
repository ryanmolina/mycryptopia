<div class="front_page_section front_page_section_woocommerce<?php
			$crypton_blog_scheme = crypton_blog_get_theme_option('front_page_woocommerce_scheme');
			if (!crypton_blog_is_inherit($crypton_blog_scheme)) echo ' scheme_'.esc_attr($crypton_blog_scheme);
			echo ' front_page_section_paddings_'.esc_attr(crypton_blog_get_theme_option('front_page_woocommerce_paddings'));
		?>"<?php
		$crypton_blog_css = '';
		$crypton_blog_bg_image = crypton_blog_get_theme_option('front_page_woocommerce_bg_image');
		if (!empty($crypton_blog_bg_image)) 
			$crypton_blog_css .= 'background-image: url('.esc_url(crypton_blog_get_attachment_url($crypton_blog_bg_image)).');';
		if (!empty($crypton_blog_css))
			echo ' style="' . esc_attr($crypton_blog_css) . '"';
?>><?php
	// Add anchor
	$crypton_blog_anchor_icon = crypton_blog_get_theme_option('front_page_woocommerce_anchor_icon');	
	$crypton_blog_anchor_text = crypton_blog_get_theme_option('front_page_woocommerce_anchor_text');	
	if ((!empty($crypton_blog_anchor_icon) || !empty($crypton_blog_anchor_text)) && shortcode_exists('trx_sc_anchor')) {
		echo do_shortcode('[trx_sc_anchor id="front_page_section_woocommerce"'
										. (!empty($crypton_blog_anchor_icon) ? ' icon="'.esc_attr($crypton_blog_anchor_icon).'"' : '')
										. (!empty($crypton_blog_anchor_text) ? ' title="'.esc_attr($crypton_blog_anchor_text).'"' : '')
										. ']');
	}
	?>
	<div class="front_page_section_inner front_page_section_woocommerce_inner<?php
			if (crypton_blog_get_theme_option('front_page_woocommerce_fullheight'))
				echo ' crypton_blog-full-height sc_layouts_flex sc_layouts_columns_middle';
			?>"<?php
			$crypton_blog_css = '';
			$crypton_blog_bg_mask = crypton_blog_get_theme_option('front_page_woocommerce_bg_mask');
			$crypton_blog_bg_color = crypton_blog_get_theme_option('front_page_woocommerce_bg_color');
			if (!empty($crypton_blog_bg_color) && $crypton_blog_bg_mask > 0)
				$crypton_blog_css .= 'background-color: '.esc_attr($crypton_blog_bg_mask==1
																	? $crypton_blog_bg_color
																	: crypton_blog_hex2rgba($crypton_blog_bg_color, $crypton_blog_bg_mask)
																).';';
			if (!empty($crypton_blog_css))
				echo ' style="' . esc_attr($crypton_blog_css) . '"';
	?>>
		<div class="front_page_section_content_wrap front_page_section_woocommerce_content_wrap content_wrap woocommerce">
			<?php
			// Content wrap with title and description
			$crypton_blog_caption = crypton_blog_get_theme_option('front_page_woocommerce_caption');
			$crypton_blog_description = crypton_blog_get_theme_option('front_page_woocommerce_description');
			if (!empty($crypton_blog_caption) || !empty($crypton_blog_description) || (current_user_can('edit_theme_options') && is_customize_preview())) {
				// Caption
				if (!empty($crypton_blog_caption) || (current_user_can('edit_theme_options') && is_customize_preview())) {
					?><h2 class="front_page_section_caption front_page_section_woocommerce_caption front_page_block_<?php echo !empty($crypton_blog_caption) ? 'filled' : 'empty'; ?>"><?php
						echo wp_kses_post($crypton_blog_caption);
					?></h2><?php
				}
			
				// Description (text)
				if (!empty($crypton_blog_description) || (current_user_can('edit_theme_options') && is_customize_preview())) {
					?><div class="front_page_section_description front_page_section_woocommerce_description front_page_block_<?php echo !empty($crypton_blog_description) ? 'filled' : 'empty'; ?>"><?php
						echo wp_kses_post(wpautop($crypton_blog_description));
					?></div><?php
				}
			}
		
			// Content (widgets)
			?><div class="front_page_section_output front_page_section_woocommerce_output list_products shop_mode_thumbs"><?php 
				$crypton_blog_woocommerce_sc = crypton_blog_get_theme_option('front_page_woocommerce_products');
				if ($crypton_blog_woocommerce_sc == 'products') {
					$crypton_blog_woocommerce_sc_ids = crypton_blog_get_theme_option('front_page_woocommerce_products_per_page');
					$crypton_blog_woocommerce_sc_per_page = count(explode(',', $crypton_blog_woocommerce_sc_ids));
				} else {
					$crypton_blog_woocommerce_sc_per_page = max(1, (int) crypton_blog_get_theme_option('front_page_woocommerce_products_per_page'));
				}
				$crypton_blog_woocommerce_sc_columns = max(1, min($crypton_blog_woocommerce_sc_per_page, (int) crypton_blog_get_theme_option('front_page_woocommerce_products_columns')));
				echo do_shortcode("[{$crypton_blog_woocommerce_sc}"
									. ($crypton_blog_woocommerce_sc == 'products' 
											? ' ids="'.esc_attr($crypton_blog_woocommerce_sc_ids).'"' 
											: '')
									. ($crypton_blog_woocommerce_sc == 'product_category' 
											? ' category="'.esc_attr(crypton_blog_get_theme_option('front_page_woocommerce_products_categories')).'"' 
											: '')
									. ($crypton_blog_woocommerce_sc != 'best_selling_products' 
											? ' orderby="'.esc_attr(crypton_blog_get_theme_option('front_page_woocommerce_products_orderby')).'"'
											  . ' order="'.esc_attr(crypton_blog_get_theme_option('front_page_woocommerce_products_order')).'"' 
											: '')
									. ' per_page="'.esc_attr($crypton_blog_woocommerce_sc_per_page).'"' 
									. ' columns="'.esc_attr($crypton_blog_woocommerce_sc_columns).'"' 
									. ']');
			?></div>
		</div>
	</div>
</div>