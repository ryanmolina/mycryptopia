<?php
/**
 * The template to display the page title and breadcrumbs
 *
 * @package WordPress
 * @subpackage CRYPTON_BLOG
 * @since CRYPTON_BLOG 1.0
 */

// Page (category, tag, archive, author) title

if ( crypton_blog_need_page_title() ) {
	crypton_blog_sc_layouts_showed('title', true);
	crypton_blog_sc_layouts_showed('postmeta', false);
	?>
	<div class="top_panel_title sc_layouts_row sc_layouts_row_type_normal" id="header-img" >
		<div class="content_wrap">
			<div class="sc_layouts_column sc_layouts_column_align_center">
				<div class="sc_layouts_item">
					<div class="sc_layouts_title sc_align_center">
						
						<?php
						// Post meta on the single post
						if ( is_single() && false)  {

							?><div class="sc_layouts_title_meta"><?php
								crypton_blog_show_post_meta(apply_filters('crypton_blog_filter_post_meta_args', array(
									'components' => 'categories,date,counters,edit',
									'counters' => 'views,comments,likes',
									'seo' => true
									), 'header', 1)
								);
							?></div><?php
						}


						// Blog/Post title
						?><div class="sc_layouts_title_title"><?php
							$crypton_blog_blog_title = crypton_blog_get_blog_title();
							$crypton_blog_blog_title_text = $crypton_blog_blog_title_class = $crypton_blog_blog_title_link = $crypton_blog_blog_title_link_text = '';
							if (is_array($crypton_blog_blog_title)) {
								$crypton_blog_blog_title_text = $crypton_blog_blog_title['text'];
								$crypton_blog_blog_title_class = !empty($crypton_blog_blog_title['class']) ? ' '.$crypton_blog_blog_title['class'] : '';
								$crypton_blog_blog_title_link = !empty($crypton_blog_blog_title['link']) ? $crypton_blog_blog_title['link'] : '';
								$crypton_blog_blog_title_link_text = !empty($crypton_blog_blog_title['link_text']) ? $crypton_blog_blog_title['link_text'] : '';
							} else
								$crypton_blog_blog_title_text = $crypton_blog_blog_title;
							?>
							<h1 itemprop="headline" class="sc_layouts_title_caption<?php echo esc_attr($crypton_blog_blog_title_class); ?>"><?php
								$crypton_blog_top_icon = crypton_blog_get_category_icon();
								if (!empty($crypton_blog_top_icon)) {
									$crypton_blog_attr = crypton_blog_getimagesize($crypton_blog_top_icon);
									?><img src="<?php echo esc_url($crypton_blog_top_icon); ?>" alt="" <?php if (!empty($crypton_blog_attr[3])) crypton_blog_show_layout($crypton_blog_attr[3]);?>><?php
								}
								echo wp_kses_data($crypton_blog_blog_title_text);
							?></h1>
							<?php
							if (!empty($crypton_blog_blog_title_link) && !empty($crypton_blog_blog_title_link_text)) {
								?><a href="<?php echo esc_url($crypton_blog_blog_title_link); ?>" class="theme_button theme_button_small sc_layouts_title_link"><?php echo esc_html($crypton_blog_blog_title_link_text); ?></a><?php
							}
							
							// Category/Tag description
							if ( is_category() || is_tag() || is_tax() )
								the_archive_description( '<div class="sc_layouts_title_description">', '</div>' );
		
						?></div><?php
	
						// Breadcrumbs
						?>
						<!-- <div class="sc_layouts_title_breadcrumbs"><?php
							// do_action( 'crypton_blog_action_breadcrumbs');
						?></div> -->
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
}
?>