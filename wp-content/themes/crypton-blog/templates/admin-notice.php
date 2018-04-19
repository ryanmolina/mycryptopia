<?php
/**
 * The template to display Admin notices
 *
 * @package WordPress
 * @subpackage CRYPTON_BLOG
 * @since CRYPTON_BLOG 1.0.1
 */
 
$crypton_blog_theme_obj = wp_get_theme();
?>
<div class="update-nag" id="crypton_blog_admin_notice">
	<h3 class="crypton_blog_notice_title"><?php
		// Translators: Add theme name and version to the 'Welcome' message
		echo esc_html(sprintf(__('Welcome to %1$s v.%2$s', 'crypton-blog'),
				$crypton_blog_theme_obj->name . (CRYPTON_BLOG_THEME_FREE ? ' ' . __('Free', 'crypton-blog') : ''),
				$crypton_blog_theme_obj->version
				));
	?></h3>
	<?php
	if (!crypton_blog_exists_trx_addons()) {
		?><p><?php echo wp_kses_data(__('<b>Attention!</b> Plugin "ThemeREX Addons is required! Please, install and activate it!', 'crypton-blog')); ?></p><?php
	}
	?><p>
		<a href="<?php echo esc_url(admin_url().'themes.php?page=crypton_blog_about'); ?>" class="button button-primary"><i class="dashicons dashicons-nametag"></i> <?php
			// Translators: Add theme name
			echo esc_html(sprintf(__('About %s', 'crypton-blog'), $crypton_blog_theme_obj->name));
		?></a>
		<?php
		if (crypton_blog_get_value_gp('page')!='tgmpa-install-plugins') {
			?>
			<a href="<?php echo esc_url(admin_url().'themes.php?page=tgmpa-install-plugins'); ?>" class="button button-primary"><i class="dashicons dashicons-admin-plugins"></i> <?php esc_html_e('Install plugins', 'crypton-blog'); ?></a>
			<?php
		}
		if (function_exists('crypton_blog_exists_trx_addons') && crypton_blog_exists_trx_addons() && class_exists('trx_addons_demo_data_importer')) {
			?>
			<a href="<?php echo esc_url(admin_url().'themes.php?page=trx_importer'); ?>" class="button button-primary"><i class="dashicons dashicons-download"></i> <?php esc_html_e('One Click Demo Data', 'crypton-blog'); ?></a>
			<?php
		}
		?>
        <a href="<?php echo esc_url(admin_url().'customize.php'); ?>" class="button button-primary"><i class="dashicons dashicons-admin-appearance"></i> <?php esc_html_e('Theme Customizer', 'crypton-blog'); ?></a>
		<span> <?php esc_html_e('or', 'crypton-blog'); ?> </span>
        <a href="<?php echo esc_url(admin_url().'themes.php?page=theme_options'); ?>" class="button button-primary"><i class="dashicons dashicons-admin-appearance"></i> <?php esc_html_e('Theme Options', 'crypton-blog'); ?></a>
        <a href="#" class="button crypton_blog_hide_notice"><i class="dashicons dashicons-dismiss"></i> <?php esc_html_e('Hide Notice', 'crypton-blog'); ?></a>
	</p>
</div>