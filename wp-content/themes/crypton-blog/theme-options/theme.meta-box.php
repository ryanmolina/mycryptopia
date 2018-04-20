<?php
/**
 * Theme Options and meta-boxes support
 *
 * @package WordPress
 * @subpackage CRYPTON_BLOG
 * @since CRYPTON_BLOG 1.0.29
 */


// -----------------------------------------------------------------
// -- Meta-boxes
// -----------------------------------------------------------------

if ( !function_exists('crypton_blog_init_meta_box') ) {
	add_action( 'after_setup_theme', 'crypton_blog_init_meta_box' );
	function crypton_blog_init_meta_box() {
		if ( is_admin() ) {
			add_action('admin_enqueue_scripts',	'crypton_blog_add_meta_box_scripts');
			add_action('save_post',				'crypton_blog_save_meta_box');
			add_action('add_meta_boxes',		'crypton_blog_add_meta_box');
		}
	}
}
	
// Load required styles and scripts for admin mode
if ( !function_exists( 'crypton_blog_add_meta_box_scripts' ) ) {
	//Handler of the add_action("admin_enqueue_scripts", 'crypton_blog_add_meta_box_scripts');
	function crypton_blog_add_meta_box_scripts() {
		// If current screen is 'Edit Page' - load font icons
		$screen = function_exists('get_current_screen') ? get_current_screen() : false;
		if (is_object($screen) && crypton_blog_allow_meta_box(!empty($screen->post_type) ? $screen->post_type : $screen->id)) {
			wp_enqueue_style( 'crypton_blog-icons',  crypton_blog_get_file_url('css/font-icons/css/fontello-embedded.css'), array(), null );
			wp_enqueue_script( 'jquery-ui-tabs', false, array('jquery', 'jquery-ui-core'), null, true );
			wp_enqueue_script( 'jquery-ui-accordion', false, array('jquery', 'jquery-ui-core'), null, true );
			wp_enqueue_script( 'crypton_blog-options', crypton_blog_get_file_url('theme-options/theme.options.js'), array('jquery'), null, true );
			wp_localize_script( 'crypton_blog-options', 'crypton_blog_dependencies', crypton_blog_get_theme_dependencies() );
		}
	}
}


// Check if meta box is allow
if (!function_exists('crypton_blog_allow_meta_box')) {
	function crypton_blog_allow_meta_box($post_type) {
		return apply_filters('crypton_blog_filter_allow_meta_box', in_array($post_type, array('page', 'post')), $post_type);
	}
}

// Add meta box
if (!function_exists('crypton_blog_add_meta_box')) {
	//Handler of the add_action('add_meta_boxes', 'crypton_blog_add_meta_box');
	function crypton_blog_add_meta_box() {
		global $post_type;
		if (crypton_blog_allow_meta_box($post_type)) {
			add_meta_box(sprintf('crypton_blog_meta_box_%s', $post_type), 
						esc_html__('Theme Options', 'crypton-blog'),
						'crypton_blog_show_meta_box',
						$post_type,
						$post_type=='post' ? 'side' : 'advanced',
						'default');
		}
	}
}

// Callback function to show fields in meta box
if (!function_exists('crypton_blog_show_meta_box')) {
	function crypton_blog_show_meta_box() {
		global $post, $post_type;
		if (crypton_blog_allow_meta_box($post_type)) {
			// Load saved options 
			$meta = get_post_meta($post->ID, 'crypton_blog_options', true);
			$tabs_titles = $tabs_content = array();
			global $CRYPTON_BLOG_STORAGE;
			// Refresh linked data if this field is controller for the another (linked) field
			// Do this before show fields to refresh data in the $CRYPTON_BLOG_STORAGE
			foreach ($CRYPTON_BLOG_STORAGE['options'] as $k=>$v) {
				if (!isset($v['override']) || strpos($v['override']['mode'], $post_type)===false) continue;
				if (!empty($v['linked'])) {
					$v['val'] = isset($meta[$k]) ? $meta[$k] : 'inherit';
					if (!empty($v['val']) && !crypton_blog_is_inherit($v['val']))
						crypton_blog_refresh_linked_data($v['val'], $v['linked']);
				}
			}
			// Show fields
			foreach ($CRYPTON_BLOG_STORAGE['options'] as $k=>$v) {
				if (!isset($v['override']) || strpos($v['override']['mode'], $post_type)===false) continue;
				if (empty($v['override']['section']))
					$v['override']['section'] = esc_html__('General', 'crypton-blog');
				if (!isset($tabs_titles[$v['override']['section']])) {
					$tabs_titles[$v['override']['section']] = $v['override']['section'];
					$tabs_content[$v['override']['section']] = '';
				}
				$v['val'] = isset($meta[$k]) ? $meta[$k] : 'inherit';
				$tabs_content[$v['override']['section']] .= crypton_blog_options_show_field($k, $v, $post_type);
			}
			if (count($tabs_titles) > 0) {
				?>
				<div class="crypton_blog_options crypton_blog_meta_box">
					<input type="hidden" name="meta_box_post_nonce" value="<?php echo esc_attr(wp_create_nonce(admin_url())); ?>" />
					<input type="hidden" name="meta_box_post_type" value="<?php echo esc_attr($post_type); ?>" />
					<div id="crypton_blog_options_tabs" class="crypton_blog_tabs">
						<ul><?php
							$cnt = 0;
							foreach ($tabs_titles as $k=>$v) {
								$cnt++;
								?><li><a href="#crypton_blog_options_<?php echo esc_attr($cnt); ?>"><?php echo esc_html($v); ?></a></li><?php
							}
						?></ul>
						<?php
							$cnt = 0;
							foreach ($tabs_content as $k=>$v) {
								$cnt++;
								?>
								<div id="crypton_blog_options_<?php echo esc_attr($cnt); ?>" class="crypton_blog_tabs_section crypton_blog_options_section">
									<?php crypton_blog_show_layout($v); ?>
								</div>
								<?php
							}
						?>
					</div>
				</div>
				<?php		
			}
		}
	}
}


// Save data from meta box
if (!function_exists('crypton_blog_save_meta_box')) {
	//Handler of the add_action('save_post', 'crypton_blog_save_meta_box');
	function crypton_blog_save_meta_box($post_id) {

		// verify nonce
		if ( !wp_verify_nonce( crypton_blog_get_value_gp('meta_box_post_nonce'), admin_url() ) )
			return $post_id;

		// check autosave
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
			return $post_id;
		}

		$post_type = wp_kses_data(wp_unslash(isset($_POST['meta_box_post_type']) ? $_POST['meta_box_post_type'] : $_POST['post_type']));

		// check permissions
		$capability = 'page';
		$post_types = get_post_types( array( 'name' => $post_type), 'objects' );
		if (!empty($post_types) && is_array($post_types)) {
			foreach ($post_types  as $type) {
				$capability = $type->capability_type;
				break;
			}
		}
		if (!current_user_can('edit_'.($capability), $post_id)) {
			return $post_id;
		}

		// Save meta
		$meta = array();
		$options = crypton_blog_storage_get('options');
		foreach ($options as $k=>$v) {
			// Skip not overriden options
			if (!isset($v['override']) || strpos($v['override']['mode'], $post_type)===false) continue;
			// Skip inherited options
			if (!empty($_POST['crypton_blog_options_inherit_' . $k])) continue;
			// Get option value from POST
			$meta[$k] = isset($_POST['crypton_blog_options_field_' . $k])
							? crypton_blog_get_value_gp('crypton_blog_options_field_' . $k)
							: ($v['type']=='checkbox' ? 0 : '');
		}
		update_post_meta($post_id, 'crypton_blog_options', $meta);
		
		// Save separate meta options to search template pages
		if ($post_type=='page' && !empty($_POST['page_template']) && $_POST['page_template']=='blog.php') {
			update_post_meta($post_id, 'crypton_blog_options_post_type', isset($meta['post_type']) ? $meta['post_type'] : 'post');
			update_post_meta($post_id, 'crypton_blog_options_parent_cat', isset($meta['parent_cat']) ? $meta['parent_cat'] : 0);
		}
	}
}
?>