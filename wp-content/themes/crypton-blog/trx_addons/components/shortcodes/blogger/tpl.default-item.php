<?php
/**
 * The style "default" of the Blogger
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.2
 */

$args = get_query_var('trx_addons_args_sc_blogger');

if ($args['slider']) {
	?><div class="slider-slide swiper-slide"><?php
} else if ($args['columns'] > 1) {
	?><div class="<?php echo esc_attr(trx_addons_get_column_class(1, $args['columns'])); ?>"><?php
}

$post_format = get_post_format();
$post_format = empty($post_format) ? 'standard' : str_replace('post-format-', '', $post_format);
$post_link = get_permalink();
$post_title = get_the_title();

if (get_post_type()=='product') {
	global $product;
	$cats = crypton_blog_get_post_terms(', ', get_the_ID(), 'product_cat');
	if ( $price_html = $product->get_price_html() ) {
		$price_info = trim($price_html);
	}
	if ( $rating_html = $product->get_average_rating() ) {
		$rating_info = trim($rating_html);
	}
	if ( $sell_html = $product->is_on_sale() ) {
		$sell_info = trim($sell_html);
	}
}


?><div <?php post_class( 'sc_blogger_item post_format_'.esc_attr($post_format) ); ?>><?php
	
	// Featured image
	trx_addons_get_template_part('templates/tpl.featured.php',
									'trx_addons_args_featured',
									apply_filters('trx_addons_filter_args_featured', array(
														'class' => 'sc_blogger_item_featured',
														'hover' => 'zoomin',
														'post_info' => ((get_post_type()=='product') 
																			? (!empty($sell_info) ? '<span class="onsale">'.esc_html__( 'On Sale', 'crypton-blog' ).'</span>' : '')
																				.'<div class="icons"><a rel="nofollow" href="'.esc_url( get_permalink()).'" class="shop_cart icon-cart-2 button add_to_cart_button product_type_variable"></a></div>'
																			: ''
														),
														'thumb_size' => ((get_post_type()=='product') 
																			? apply_filters('trx_addons_filter_thumb_size', trx_addons_get_thumb_size($args['columns'] > 2 ? 'masonry' : 'masonry-big'), 'blogger-default')
																			: apply_filters('trx_addons_filter_thumb_size', trx_addons_get_thumb_size($args['columns'] > 2 ? 'medium' : 'big'), 'blogger-default')
														)), 'blogger-default')
								);

				
	// Post content
	?><div class="sc_blogger_item_content entry-content"><?php

		// Post title
		?><div class="sc_blogger_item_header entry-header"><?php 
			if ((get_post_type()=='product') && !empty($rating_info)) {
			?>
			<div class="sc_blogger_product_rating"><div class="woocommerce">
			<?php
				echo wc_get_rating_html( $product->get_average_rating() ); 
			?>
			</div></div><?php
			}
			?><?php
			if ((get_post_type()=='product') && !empty($cats)) {
			?>
				<div class="sc_blogger_product_category"><?php trx_addons_show_layout($cats); ?></div>
			<?php
			}
		?><?php 
			// Post title
			the_title( sprintf( '<h5 class="sc_blogger_item_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h5>' );
		?><?php
			if ((get_post_type()=='product') && !empty($price_info)) {
			?>
				<div class="sc_blogger_product_price"><?php trx_addons_show_layout($price_info); ?></div>
			<?php
			}

		?></div><!-- .entry-header --><?php

	?></div><!-- .entry-content --><?php
	
?></div><!-- .sc_blogger_item --><?php

if ($args['slider'] || $args['columns'] > 1) {
	?></div><?php
}
?>