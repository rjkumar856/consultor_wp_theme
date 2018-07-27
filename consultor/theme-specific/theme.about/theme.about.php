<?php
/**
 * Information about this theme
 *
 * @package WordPress
 * @subpackage CONSULTOR
 * @since CONSULTOR 1.0.30
 */


// Redirect to the 'About Theme' page after switch theme
if (!function_exists('consultor_about_after_switch_theme')) {
	add_action('after_switch_theme', 'consultor_about_after_switch_theme', 1000);
	function consultor_about_after_switch_theme() {
		update_option('consultor_about_page', 1);
	}
}
if ( !function_exists('consultor_about_after_setup_theme') ) {
	add_action( 'init', 'consultor_about_after_setup_theme', 1000 );
	function consultor_about_after_setup_theme() {
		if (get_option('consultor_about_page') == 1) {
			update_option('consultor_about_page', 0);
			wp_safe_redirect(admin_url().'themes.php?page=consultor_about');
			exit();
		}
	}
}


// Add 'About Theme' item in the Appearance menu
if (!function_exists('consultor_about_add_menu_items')) {
	add_action( 'admin_menu', 'consultor_about_add_menu_items' );
	function consultor_about_add_menu_items() {
		$theme = wp_get_theme();
		$theme_name = $theme->name . (CONSULTOR_THEME_FREE ? ' ' . esc_html__('Free', 'consultor') : '');
		add_theme_page(
			// Translators: Add theme name to the page title
			sprintf(esc_html__('About %s', 'consultor'), $theme_name),	//page_title
			// Translators: Add theme name to the menu title
			sprintf(esc_html__('About %s', 'consultor'), $theme_name),	//menu_title
			'manage_options',											//capability
			'consultor_about',											//menu_slug
			'consultor_about_page_builder',								//callback
			'dashicons-format-status',									//icon
			''															//menu position
		);
	}
}


// Load page-specific scripts and styles
if (!function_exists('consultor_about_enqueue_scripts')) {
	add_action( 'admin_enqueue_scripts', 'consultor_about_enqueue_scripts' );
	function consultor_about_enqueue_scripts() {
		$screen = function_exists('get_current_screen') ? get_current_screen() : false;
		if (is_object($screen) && $screen->id == 'appearance_page_consultor_about') {
			// Scripts
			wp_enqueue_script( 'jquery-ui-tabs', false, array('jquery', 'jquery-ui-core'), null, true );
			
			if (function_exists('consultor_plugins_installer_enqueue_scripts'))
				consultor_plugins_installer_enqueue_scripts();
			
			// Styles
			wp_enqueue_style( 'consultor-icons',  consultor_get_file_url('css/font-icons/css/fontello-embedded.css'), array(), null );
			if ( ($fdir = consultor_get_file_url('theme-specific/theme.about/theme.about.css')) != '' )
				wp_enqueue_style( 'consultor-about',  $fdir, array(), null );
		}
	}
}


// Build 'About Theme' page
if (!function_exists('consultor_about_page_builder')) {
	function consultor_about_page_builder() {
		$theme = wp_get_theme();
		?>
		<div class="consultor_about">
			<div class="consultor_about_header">
				<div class="consultor_about_logo"><?php
					$logo = consultor_get_file_url('theme-specific/theme.about/logo.jpg');
					if (empty($logo)) $logo = consultor_get_file_url('screenshot.jpg');
					if (!empty($logo)) {
						?><img src="<?php echo esc_url($logo); ?>"><?php
					}
				?></div>
				
				<?php if (CONSULTOR_THEME_FREE) { ?>
					<a href="<?php echo esc_url(consultor_storage_get('theme_download_url')); ?>"
										   target="_blank"
										   class="consultor_about_pro_link button button-primary"><?php
											esc_html_e('Get PRO version', 'consultor');
										?></a>
				<?php } ?>
				<h1 class="consultor_about_title"><?php
					// Translators: Add theme name and version to the 'Welcome' message
					echo esc_html(sprintf(__('Welcome to %1$s %2$s v.%3$s', 'consultor'),
								$theme->name,
								CONSULTOR_THEME_FREE ? __('Free', 'consultor') : '',
								$theme->version
								));
				?></h1>
				<div class="consultor_about_description">
					<?php
					if (CONSULTOR_THEME_FREE) {
						?><p><?php
							// Translators: Add the download url and the theme name to the message
							echo wp_kses_data(sprintf(__('Now you are using Free version of <a href="%1$s">%2$s Pro Theme</a>.', 'consultor'),
														esc_url(consultor_storage_get('theme_download_url')),
														$theme->name
														)
												);
							// Translators: Add the theme name and supported plugins list to the message
							echo '<br>' . wp_kses_data(sprintf(__('This version is SEO- and Retina-ready. It also has a built-in support for parallax and slider with swipe gestures. %1$s Free is compatible with many popular plugins, such as %2$s', 'consultor'),
														$theme->name,
														consultor_about_get_supported_plugins()
														)
												);
						?></p>
						<p><?php
							// Translators: Add the download url to the message
							echo wp_kses_data(sprintf(__('We hope you have a great acquaintance with our themes. If you are looking for a fully functional website, you can get the <a href="%s">Pro Version here</a>', 'consultor'),
														esc_url(consultor_storage_get('theme_download_url'))
														)
												);
						?></p><?php
					} else {
						?><p><?php
							// Translators: Add the theme name to the message
							echo wp_kses_data(sprintf(__('%s is a Premium WordPress theme. It has a built-in support for parallax, slider with swipe gestures, and is SEO- and Retina-ready', 'consultor'),
														$theme->name
														)
												);
						?></p>
						<p><?php
							// Translators: Add supported plugins list to the message
							echo wp_kses_data(sprintf(__('The Premium Theme is compatible with many popular plugins, such as %s', 'consultor'),
														consultor_about_get_supported_plugins()
														)
												);
						?></p><?php
					}
					?>
				</div>
			</div>
			<div id="consultor_about_tabs" class="consultor_tabs consultor_about_tabs">
				<ul>
					<li><a href="#consultor_about_section_start"><?php esc_html_e('Getting started', 'consultor'); ?></a></li>
					<li><a href="#consultor_about_section_actions"><?php esc_html_e('Recommended actions', 'consultor'); ?></a></li>
					<?php if (CONSULTOR_THEME_FREE) { ?>
						<li><a href="#consultor_about_section_pro"><?php esc_html_e('Free vs PRO', 'consultor'); ?></a></li>
					<?php } ?>
				</ul>
				<div id="consultor_about_section_start" class="consultor_tabs_section consultor_about_section"><?php
				
					// Install required plugins
					if (!CONSULTOR_THEME_FREE_WP && !consultor_exists_trx_addons()) {
						?><div class="consultor_about_block"><div class="consultor_about_block_inner">
							<h2 class="consultor_about_block_title">
								<i class="dashicons dashicons-admin-plugins"></i>
								<?php esc_html_e('ThemeREX Addons', 'consultor'); ?>
							</h2>
							<div class="consultor_about_block_description"><?php
								esc_html_e('It is highly recommended that you install the companion plugin "ThemeREX Addons" to have access to the layouts builder, awesome shortcodes, team and testimonials, services and slider, and many other features ...', 'consultor');
							?></div>
							<?php consultor_plugins_installer_get_button_html('trx_addons'); ?>
						</div></div><?php
					}
					
					// Install recommended plugins
					?><div class="consultor_about_block"><div class="consultor_about_block_inner">
						<h2 class="consultor_about_block_title">
							<i class="dashicons dashicons-admin-plugins"></i>
							<?php esc_html_e('Recommended plugins', 'consultor'); ?>
						</h2>
						<div class="consultor_about_block_description"><?php
							// Translators: Add the theme name to the message
							echo esc_html(sprintf(__('Theme %s is compatible with a large number of popular plugins. You can install only those that are going to use in the near future.', 'consultor'), $theme->name));
						?></div>
						<a href="<?php echo esc_url(admin_url().'themes.php?page=tgmpa-install-plugins'); ?>"
						   class="consultor_about_block_link button button-primary"><?php
							esc_html_e('Install plugins', 'consultor');
						?></a>
					</div></div><?php
					
					// Customizer or Theme Options
					?><div class="consultor_about_block"><div class="consultor_about_block_inner">
						<h2 class="consultor_about_block_title">
							<i class="dashicons dashicons-admin-appearance"></i>
							<?php esc_html_e('Setup Theme options', 'consultor'); ?>
						</h2>
						<div class="consultor_about_block_description"><?php
							esc_html_e('Using the WordPress Customizer you can easily customize every aspect of the theme. If you want to use the standard theme settings page - open Theme Options and follow the same steps there.', 'consultor');
						?></div>
						<a href="<?php echo esc_url(admin_url().'customize.php'); ?>"
						   class="consultor_about_block_link button button-primary"><?php
							esc_html_e('Customizer', 'consultor');
						?></a>
						<?php esc_html_e('or', 'consultor'); ?>
						<a href="<?php echo esc_url(admin_url().'themes.php?page=theme_options'); ?>"
						   class="consultor_about_block_link button"><?php
							esc_html_e('Theme Options', 'consultor');
						?></a>
					</div></div><?php
					
					// Documentation
					?><div class="consultor_about_block"><div class="consultor_about_block_inner">
						<h2 class="consultor_about_block_title">
							<i class="dashicons dashicons-book"></i>
							<?php esc_html_e('Read full documentation', 'consultor');	?>
						</h2>
						<div class="consultor_about_block_description"><?php
							// Translators: Add the theme name to the message
							echo esc_html(sprintf(__('Need more details? Please check our full online documentation for detailed information on how to use %s.', 'consultor'), $theme->name));
						?></div>
						<a href="<?php echo esc_url(consultor_storage_get('theme_doc_url')); ?>"
						   target="_blank"
						   class="consultor_about_block_link button button-primary"><?php
							esc_html_e('Documentation', 'consultor');
						?></a>
					</div></div><?php
					
					// Video tutorials
					?><div class="consultor_about_block"><div class="consultor_about_block_inner">
						<h2 class="consultor_about_block_title">
							<i class="dashicons dashicons-video-alt2"></i>
							<?php esc_html_e('Video tutorials', 'consultor');	?>
						</h2>
						<div class="consultor_about_block_description"><?php
							// Translators: Add the theme name to the message
							echo esc_html(sprintf(__('No time for reading documentation? Check out our video tutorials and learn how to customize %s in detail.', 'consultor'), $theme->name));
						?></div>
						<a href="<?php echo esc_url(consultor_storage_get('theme_video_url')); ?>"
						   target="_blank"
						   class="consultor_about_block_link button button-primary"><?php
							esc_html_e('Watch videos', 'consultor');
						?></a>
					</div></div><?php
					
					// Support
					if (!CONSULTOR_THEME_FREE) {
						?><div class="consultor_about_block"><div class="consultor_about_block_inner">
							<h2 class="consultor_about_block_title">
								<i class="dashicons dashicons-sos"></i>
								<?php esc_html_e('Support', 'consultor'); ?>
							</h2>
							<div class="consultor_about_block_description"><?php
								// Translators: Add the theme name to the message
								echo esc_html(sprintf(__('We want to make sure you have the best experience using %s and that is why we gathered here all the necessary informations for you.', 'consultor'), $theme->name));
							?></div>
							<a href="<?php echo esc_url(consultor_storage_get('theme_support_url')); ?>"
							   target="_blank"
							   class="consultor_about_block_link button button-primary"><?php
								esc_html_e('Support', 'consultor');
							?></a>
						</div></div><?php
					}
					
					// Online Demo
					?><div class="consultor_about_block"><div class="consultor_about_block_inner">
						<h2 class="consultor_about_block_title">
							<i class="dashicons dashicons-images-alt2"></i>
							<?php esc_html_e('On-line demo', 'consultor'); ?>
						</h2>
						<div class="consultor_about_block_description"><?php
							// Translators: Add the theme name to the message
							echo esc_html(sprintf(__('Visit the Demo Version of %s to check out all the features it has', 'consultor'), $theme->name));
						?></div>
						<a href="<?php echo esc_url(consultor_storage_get('theme_demo_url')); ?>"
						   target="_blank"
						   class="consultor_about_block_link button button-primary"><?php
							esc_html_e('View demo', 'consultor');
						?></a>
					</div></div>
					
				</div>



				<div id="consultor_about_section_actions" class="consultor_tabs_section consultor_about_section"><?php
				
					// Install required plugins
					if (!CONSULTOR_THEME_FREE_WP && !consultor_exists_trx_addons()) {
						?><div class="consultor_about_block"><div class="consultor_about_block_inner">
							<h2 class="consultor_about_block_title">
								<i class="dashicons dashicons-admin-plugins"></i>
								<?php esc_html_e('ThemeREX Addons', 'consultor'); ?>
							</h2>
							<div class="consultor_about_block_description"><?php
								esc_html_e('It is highly recommended that you install the companion plugin "ThemeREX Addons" to have access to the layouts builder, awesome shortcodes, team and testimonials, services and slider, and many other features ...', 'consultor');
							?></div>
							<?php consultor_plugins_installer_get_button_html('trx_addons'); ?>
						</div></div><?php
					}
					
					// Install recommended plugins
					?><div class="consultor_about_block"><div class="consultor_about_block_inner">
						<h2 class="consultor_about_block_title">
							<i class="dashicons dashicons-admin-plugins"></i>
							<?php esc_html_e('Recommended plugins', 'consultor'); ?>
						</h2>
						<div class="consultor_about_block_description"><?php
							// Translators: Add the theme name to the message
							echo esc_html(sprintf(__('Theme %s is compatible with a large number of popular plugins. You can install only those that are going to use in the near future.', 'consultor'), $theme->name));
						?></div>
						<a href="<?php echo esc_url(admin_url().'themes.php?page=tgmpa-install-plugins'); ?>"
						   class="consultor_about_block_link button button button-primary"><?php
							esc_html_e('Install plugins', 'consultor');
						?></a>
					</div></div><?php
					
					// Customizer or Theme Options
					?><div class="consultor_about_block"><div class="consultor_about_block_inner">
						<h2 class="consultor_about_block_title">
							<i class="dashicons dashicons-admin-appearance"></i>
							<?php esc_html_e('Setup Theme options', 'consultor'); ?>
						</h2>
						<div class="consultor_about_block_description"><?php
							esc_html_e('Using the WordPress Customizer you can easily customize every aspect of the theme. If you want to use the standard theme settings page - open Theme Options and follow the same steps there.', 'consultor');
						?></div>
						<a href="<?php echo esc_url(admin_url().'customize.php'); ?>"
						   target="_blank"
						   class="consultor_about_block_link button button-primary"><?php
							esc_html_e('Customizer', 'consultor');
						?></a>
						<?php esc_html_e('or', 'consultor'); ?>
						<a href="<?php echo esc_url(admin_url().'themes.php?page=theme_options'); ?>"
						   class="consultor_about_block_link button"><?php
							esc_html_e('Theme Options', 'consultor');
						?></a>
					</div></div>
					
				</div>



				<?php if (CONSULTOR_THEME_FREE) { ?>
					<div id="consultor_about_section_pro" class="consultor_tabs_section consultor_about_section">
						<table class="consultor_about_table" cellpadding="0" cellspacing="0" border="0">
							<thead>
								<tr>
									<td class="consultor_about_table_info">&nbsp;</td>
									<td class="consultor_about_table_check"><?php
										// Translators: Show theme name with suffix 'Free'
										echo esc_html(sprintf(__('%s Free', 'consultor'), $theme->name));
									?></td>
									<td class="consultor_about_table_check"><?php
										// Translators: Show theme name with suffix 'PRO'
										echo esc_html(sprintf(__('%s PRO', 'consultor'), $theme->name));
									?></td>
								</tr>
							</thead>
							<tbody>
	
	
								<?php
								// Responsive layouts
								?>
								<tr>
									<td class="consultor_about_table_info">
										<h2 class="consultor_about_table_info_title">
											<?php esc_html_e('Mobile friendly', 'consultor'); ?>
										</h2>
										<div class="consultor_about_table_info_description"><?php
											esc_html_e('Responsive layout. Looks great on any device.', 'consultor');
										?></div>
									</td>
									<td class="consultor_about_table_check"><i class="dashicons dashicons-yes"></i></td>
									<td class="consultor_about_table_check"><i class="dashicons dashicons-yes"></i></td>
								</tr>
	
								<?php
								// Built-in slider
								?>
								<tr>
									<td class="consultor_about_table_info">
										<h2 class="consultor_about_table_info_title">
											<?php esc_html_e('Built-in posts slider', 'consultor'); ?>
										</h2>
										<div class="consultor_about_table_info_description"><?php
											esc_html_e('Allows you to add beautiful slides using the built-in shortcode/widget "Slider" with swipe gestures support.', 'consultor');
										?></div>
									</td>
									<td class="consultor_about_table_check"><i class="dashicons dashicons-yes"></i></td>
									<td class="consultor_about_table_check"><i class="dashicons dashicons-yes"></i></td>
								</tr>
	
								<?php
								// Revolution slider
								if (consultor_storage_isset('required_plugins', 'revslider')) {
								?>
								<tr>
									<td class="consultor_about_table_info">
										<h2 class="consultor_about_table_info_title">
											<?php esc_html_e('Revolution Slider Compatibility', 'consultor'); ?>
										</h2>
										<div class="consultor_about_table_info_description"><?php
											esc_html_e('Our built-in shortcode/widget "Slider" is able to work not only with posts, but also with slides created  in "Revolution Slider".', 'consultor');
										?></div>
									</td>
									<td class="consultor_about_table_check"><i class="dashicons dashicons-yes"></i></td>
									<td class="consultor_about_table_check"><i class="dashicons dashicons-yes"></i></td>
								</tr>
								<?php } ?>
	
								<?php
								// SiteOrigin Panels
								if (consultor_storage_isset('required_plugins', 'siteorigin-panels')) {
								?>
								<tr>
									<td class="consultor_about_table_info">
										<h2 class="consultor_about_table_info_title">
											<?php esc_html_e('Free PageBuilder', 'consultor'); ?>
										</h2>
										<div class="consultor_about_table_info_description"><?php
											esc_html_e('Full integration with a nice free page builder "SiteOrigin Panels".', 'consultor');
										?></div>
									</td>
									<td class="consultor_about_table_check"><i class="dashicons dashicons-yes"></i></td>
									<td class="consultor_about_table_check"><i class="dashicons dashicons-yes"></i></td>
								</tr>
								<tr>
									<td class="consultor_about_table_info">
										<h2 class="consultor_about_table_info_title">
											<?php esc_html_e('Additional widgets pack', 'consultor'); ?>
										</h2>
										<div class="consultor_about_table_info_description"><?php
											esc_html_e('A number of useful widgets to create beautiful homepages and other sections of your website with SiteOrigin Panels.', 'consultor');
										?></div>
									</td>
									<td class="consultor_about_table_check"><i class="dashicons dashicons-no"></i></td>
									<td class="consultor_about_table_check"><i class="dashicons dashicons-yes"></i></td>
								</tr>
								<?php } ?>
	
								<?php
								// Visual Composer
								?>
								<tr>
									<td class="consultor_about_table_info">
										<h2 class="consultor_about_table_info_title">
											<?php esc_html_e('Visual Composer', 'consultor'); ?>
										</h2>
										<div class="consultor_about_table_info_description"><?php
											esc_html_e('Full integration with a very popular page builder "Visual Composer". A number of useful shortcodes and widgets to create beautiful homepages and other sections of your website.', 'consultor');
										?></div>
									</td>
									<td class="consultor_about_table_check"><i class="dashicons dashicons-no"></i></td>
									<td class="consultor_about_table_check"><i class="dashicons dashicons-yes"></i></td>
								</tr>
								<tr>
									<td class="consultor_about_table_info">
										<h2 class="consultor_about_table_info_title">
											<?php esc_html_e('Additional shortcodes pack', 'consultor'); ?>
										</h2>
										<div class="consultor_about_table_info_description"><?php
											esc_html_e('A number of useful shortcodes to create beautiful homepages and other sections of your website with Visual Composer.', 'consultor');
										?></div>
									</td>
									<td class="consultor_about_table_check"><i class="dashicons dashicons-no"></i></td>
									<td class="consultor_about_table_check"><i class="dashicons dashicons-yes"></i></td>
								</tr>
	
								<?php
								// Layouts builder
								?>
								<tr>
									<td class="consultor_about_table_info">
										<h2 class="consultor_about_table_info_title">
											<?php esc_html_e('Headers and Footers builder', 'consultor'); ?>
										</h2>
										<div class="consultor_about_table_info_description"><?php
											esc_html_e('Powerful visual builder of headers and footers! No manual code editing - use all the advantages of drag-and-drop technology.', 'consultor');
										?></div>
									</td>
									<td class="consultor_about_table_check"><i class="dashicons dashicons-no"></i></td>
									<td class="consultor_about_table_check"><i class="dashicons dashicons-yes"></i></td>
								</tr>
	
								<?php
								// WooCommerce
								if (consultor_storage_isset('required_plugins', 'woocommerce')) {
								?>
								<tr>
									<td class="consultor_about_table_info">
										<h2 class="consultor_about_table_info_title">
											<?php esc_html_e('WooCommerce Compatibility', 'consultor'); ?>
										</h2>
										<div class="consultor_about_table_info_description"><?php
											esc_html_e('Ready for e-commerce. You can build an online store with this theme.', 'consultor');
										?></div>
									</td>
									<td class="consultor_about_table_check"><i class="dashicons dashicons-yes"></i></td>
									<td class="consultor_about_table_check"><i class="dashicons dashicons-yes"></i></td>
								</tr>
								<?php } ?>
	
								<?php
								// Easy Digital Downloads
								if (consultor_storage_isset('required_plugins', 'easy-digital-downloads')) {
								?>
								<tr>
									<td class="consultor_about_table_info">
										<h2 class="consultor_about_table_info_title">
											<?php esc_html_e('Easy Digital Downloads Compatibility', 'consultor'); ?>
										</h2>
										<div class="consultor_about_table_info_description"><?php
											esc_html_e('Ready for digital e-commerce. You can build an online digital store with this theme.', 'consultor');
										?></div>
									</td>
									<td class="consultor_about_table_check"><i class="dashicons dashicons-no"></i></td>
									<td class="consultor_about_table_check"><i class="dashicons dashicons-yes"></i></td>
								</tr>
								<?php } ?>
	
								<?php
								// Other plugins
								?>
								<tr>
									<td class="consultor_about_table_info">
										<h2 class="consultor_about_table_info_title">
											<?php esc_html_e('Many other popular plugins compatibility', 'consultor'); ?>
										</h2>
										<div class="consultor_about_table_info_description"><?php
											esc_html_e('PRO version is compatible (was tested and has built-in support) with many popular plugins.', 'consultor');
										?></div>
									</td>
									<td class="consultor_about_table_check"><i class="dashicons dashicons-no"></i></td>
									<td class="consultor_about_table_check"><i class="dashicons dashicons-yes"></i></td>
								</tr>
	
								<?php
								// Support
								?>
								<tr>
									<td class="consultor_about_table_info">
										<h2 class="consultor_about_table_info_title">
											<?php esc_html_e('Support', 'consultor'); ?>
										</h2>
										<div class="consultor_about_table_info_description"><?php
											esc_html_e('Our premium support is going to take care of any problems, in case there will be any of course.', 'consultor');
										?></div>
									</td>
									<td class="consultor_about_table_check"><i class="dashicons dashicons-no"></i></td>
									<td class="consultor_about_table_check"><i class="dashicons dashicons-yes"></i></td>
								</tr>
	
								<?php
								// Get PRO version
								?>
								<tr>
									<td class="consultor_about_table_info">&nbsp;</td>
									<td class="consultor_about_table_check" colspan="2">
										<a href="<?php echo esc_url(consultor_storage_get('theme_download_url')); ?>"
										   target="_blank"
										   class="consultor_about_block_link consultor_about_pro_link button button-primary"><?php
											esc_html_e('Get PRO version', 'consultor');
										?></a>
									</td>
								</tr>
	
							</tbody>
						</table>
					</div>
				<?php } ?>
				
			</div>
		</div>
		<?php
	}
}


// Utils
//------------------------------------

// Return supported plugin's names
if (!function_exists('consultor_about_get_supported_plugins')) {
	function consultor_about_get_supported_plugins() {
		return '"' . join('", "', array_values(consultor_storage_get('required_plugins'))) . '"';
	}
}

require_once CONSULTOR_THEME_DIR . 'includes/plugins.installer/plugins.installer.php';
?>