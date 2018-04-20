<?php
/**
 * The template to display the service's single page
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.4
 */

get_header();

while ( have_posts() ) { the_post();
	?>
	<article id="post-<?php the_ID(); ?>" <?php post_class( 'currency_single itemscope' ); trx_addons_seo_snippets('', 'Article'); ?>>

		<?php do_action('trx_addons_action_before_article', 'currency.single'); ?>
		
		<section class="currency_page_header">

			<?php
			// Get post meta: price, icon, etc.
			$meta = get_post_meta(get_the_ID(), 'trx_addons_options', true);

			?>
			<div class="left">
			<?php

			if (!empty($meta['info_title'])) {
				?><div class="info_title">
				<h3><?php echo $meta['info_title']; ?></h3>
				</div><?php
			}

			if (!empty($meta['price'])) {
				?><div class="currency_price">
				<?php echo do_shortcode($meta['price']); ?>
				</div><?php
			}

			if (!empty($meta['info_text'])) {
				?><div class="info_text">
				<?php echo do_shortcode($meta['info_text']); ?>
				</div><?php
			}
			?>
			</div><div class="right">
			<?php

			// Image
			if ( !trx_addons_sc_layouts_showed('featured') && has_post_thumbnail() ) {
				?><div class="currency_page_featured"><?php
					the_post_thumbnail( trx_addons_get_thumb_size('huge'), trx_addons_seo_image_params(array(
								'alt' => get_the_title()
								))
							);
				?></div><?php
			}
			?>
			</div>
			<?php

			// Title
			if ( !trx_addons_sc_layouts_showed('title') ) {
				?><h2 class="currency_page_title"><?php the_title(); ?></h2><?php
			}
			?>

		</section>
		<?php

		// Post content
		?><section class="currency_page_content entry-content"<?php trx_addons_seo_snippets('articleBody'); ?>><?php
			the_content( );
		?></section><!-- .entry-content --><?php

		// Link to the product
		if (!empty($meta['product']) && (int) $meta['product'] > 0) {
			?><div class="currency_page_buttons">
				<a href="<?php echo esc_url(get_permalink($meta['product'])); ?>" class="sc_button theme_button"><?php esc_html_e('Order now', 'trx_addons'); ?></a>
			</div><?php
		}

		do_action('trx_addons_action_after_article', 'currency.single');

	?></article><?php

	// Related items (select dishes with same category)
	$taxonomies = array();
	$terms = get_the_terms(get_the_ID(), TRX_ADDONS_CPT_CURRENCY_TAXONOMY);
	if ( !empty( $terms ) ) {
		$taxonomies[TRX_ADDONS_CPT_CURRENCY_TAXONOMY] = array();
		foreach( $terms as $term )
			$taxonomies[TRX_ADDONS_CPT_CURRENCY_TAXONOMY][] = $term->term_id;
	}

	$trx_addons_related_style   = explode('_', trx_addons_get_option('currency_style'));
	$trx_addons_related_type    = $trx_addons_related_style[0];
	$trx_addons_related_columns = empty($trx_addons_related_style[1]) ? 1 : max(1, $trx_addons_related_style[1]);
	
	trx_addons_get_template_part('templates/tpl.posts-related.php',
										'trx_addons_args_related',
										apply_filters('trx_addons_filter_args_related', array(
															'class' => 'currency_page_related sc_currency sc_currency_'.esc_attr($trx_addons_related_type),
															'posts_per_page' => $trx_addons_related_columns,
															'columns' => $trx_addons_related_columns,
															'template' => TRX_ADDONS_PLUGIN_CPT . 'currency/tpl.'.trim($trx_addons_related_type).'-item.php',
															'template_args_name' => 'trx_addons_args_sc_currency',
															'post_type' => TRX_ADDONS_CPT_CURRENCY_PT,
															'taxonomies' => $taxonomies
															)
													)
									);

	// If comments are open or we have at least one comment, load up the comment template.
	if ( comments_open() || get_comments_number() ) {
		comments_template();
	}
}

get_footer();
?>