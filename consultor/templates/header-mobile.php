<?php
/**
 * The template to show mobile header and menu
 *
 * @package WordPress
 * @subpackage CONSULTOR
 * @since CONSULTOR 1.0
 */

// Mobile header
if (consultor_get_theme_option('header_mobile_enabled')) {
	$consultor_header_css = $consultor_header_image = '';
	$consultor_header_image = get_header_image();
	if (consultor_trx_addons_featured_image_override()) $consultor_header_image = consultor_get_current_mode_image($consultor_header_image);
	?>
	<div class="top_panel_mobile<?php
						echo !empty($consultor_header_image) ? ' with_bg_image' : ' without_bg_image';
						if ($consultor_header_image!='') echo ' '.esc_attr(consultor_add_inline_css_class('background-image: url('.esc_url($consultor_header_image).');'));
						?> scheme_<?php echo esc_attr(consultor_is_inherit(consultor_get_theme_option('header_scheme')) 
														? consultor_get_theme_option('color_scheme') 
														: consultor_get_theme_option('header_scheme'));
						?>"><?php
		
		do_action('consultor_action_before_header_mobile_info');

		// Additional info
		if (consultor_is_off(consultor_get_theme_option('header_mobile_hide_info')) && ($consultor_info=consultor_get_theme_option('header_mobile_additional_info'))!='') {
			?><div class="top_panel_mobile_info sc_layouts_row sc_layouts_row_type_compact sc_layouts_row_delimiter">
				<div class="content_wrap">
					<div class="columns_wrap">
						<div class="sc_layouts_column sc_layouts_column_align_center sc_layouts_column_icons_position_left column-1_1"><?php
							?><div class="sc_layouts_item"><?php
								consultor_show_layout($consultor_info);
							?></div><!-- /.sc_layouts_item -->
						</div><!-- /.sc_layouts_column -->
					</div><!-- /.columns_wrap -->
				</div><!-- /.content_wrap -->
			</div><!-- /.sc_layouts_row --><?php
		}

		do_action('consultor_action_before_header_mobile_before_navi');

		?><div class="top_panel_mobile_navi sc_layouts_row sc_layouts_row_type_compact sc_layouts_row_delimiter sc_layouts_row_fixed sc_layouts_row_fixed_always">
			<div class="content_wrap">
				<div class="columns_wrap columns_fluid">
					<div class="sc_layouts_column sc_layouts_column_align_left sc_layouts_column_icons_position_left sc_layouts_column_fluid column-1_3"><?php
						do_action('consultor_action_before_header_mobile_before_logo');
						// Logo
						if (consultor_is_off(consultor_get_theme_option('header_mobile_hide_logo'))) {
							?><div class="sc_layouts_item"><?php
								set_query_var('consultor_logo_args', array('type' => 'mobile_header'));
								get_template_part( 'templates/header-logo' );
								set_query_var('consultor_logo_args', array());
							?></div><?php
						}
						do_action('consultor_action_before_header_mobile_after_logo');
					?></div><?php
					
					// Attention! Don't place any spaces between columns!
					?><div class="sc_layouts_column sc_layouts_column_align_right sc_layouts_column_icons_position_left sc_layouts_column_fluid  column-2_3"><?php
						if (consultor_exists_trx_addons()) {
							do_action('consultor_action_before_header_mobile_before_login');
							// Display login/logout
							if (consultor_is_off(consultor_get_theme_option('header_mobile_hide_login'))) {
								ob_start();
								do_action('consultor_action_login', array('text_login' => false, 'text_logout' => false));
								$consultor_action_output = ob_get_contents();
								ob_end_clean();
								if (!empty($consultor_action_output)) {
									?><div class="sc_layouts_item sc_layouts_menu sc_layouts_menu_default"><?php
										consultor_show_layout($consultor_action_output);
									?></div><?php
								}
							}
							do_action('consultor_action_before_header_mobile_before_cart');
							// Display cart button
							if (consultor_is_off(consultor_get_theme_option('header_mobile_hide_cart'))) {
								ob_start();
								do_action('consultor_action_cart');
								$consultor_action_output = ob_get_contents();
								ob_end_clean();
								if (!empty($consultor_action_output)) {
									?><div class="sc_layouts_item"><?php
										consultor_show_layout($consultor_action_output);
									?></div><?php
								}
							}
							do_action('consultor_action_before_header_mobile_before_search');
							// Display search field
							if (consultor_is_off(consultor_get_theme_option('header_mobile_hide_search'))) {
								ob_start();
								do_action('consultor_action_search', 'fullscreen', 'header_mobile_search', false);
								$consultor_action_output = ob_get_contents();
								ob_end_clean();
								if (!empty($consultor_action_output)) {
									?><div class="sc_layouts_item"><?php
										consultor_show_layout($consultor_action_output);
									?></div><?php
								}
							}
						}

						do_action('consultor_action_before_header_mobile_before_menu_button');
						
						// Mobile menu button
						?><div class="sc_layouts_item">
							<div class="sc_layouts_iconed_text sc_layouts_menu_mobile_button">
								<a class="sc_layouts_item_link sc_layouts_iconed_text_link" href="#">
									<span class="sc_layouts_item_icon sc_layouts_iconed_text_icon trx_addons_icon-menu"></span>
								</a>
							</div>
						</div><?php

						do_action('consultor_action_before_header_mobile_after_menu_button');

					?></div><!-- /.sc_layouts_column -->
				</div><!-- /.columns_wrap -->
			</div><!-- /.content_wrap -->
		</div><!-- /.sc_layouts_row --><?php

		do_action('consultor_action_before_header_mobile_after_navi');
		
	?></div><!-- /.top_panel_mobile --><?php
}

// Mobile menu
?>
<div class="menu_mobile_overlay"></div>
<div class="menu_mobile menu_mobile_<?php echo esc_attr(consultor_get_theme_option('menu_mobile_fullscreen') > 0 ? 'fullscreen' : 'narrow'); ?> scheme_dark">
	<div class="menu_mobile_inner">
		<a class="menu_mobile_close icon-cancel"></a><?php

		// Logo
		set_query_var('consultor_logo_args', array('type' => 'mobile'));
		get_template_part( 'templates/header-logo' );
		set_query_var('consultor_logo_args', array());

		// Mobile menu
		$consultor_menu_mobile = consultor_get_nav_menu('menu_mobile');
		if (empty($consultor_menu_mobile)) {
			$consultor_menu_mobile = apply_filters('consultor_filter_get_mobile_menu', '');
			if (empty($consultor_menu_mobile)) $consultor_menu_mobile = consultor_get_nav_menu('menu_main');
			if (empty($consultor_menu_mobile)) $consultor_menu_mobile = consultor_get_nav_menu();
		}
		if (!empty($consultor_menu_mobile)) {
			if (!empty($consultor_menu_mobile))
				$consultor_menu_mobile = str_replace(
					array('menu_main', 'id="menu-', 'sc_layouts_menu_nav', 'sc_layouts_hide_on_mobile', 'hide_on_mobile'),
					array('menu_mobile', 'id="menu_mobile-', '', '', ''),
					$consultor_menu_mobile
					);
			if (strpos($consultor_menu_mobile, '<nav ')===false)
				$consultor_menu_mobile = sprintf('<nav class="menu_mobile_nav_area">%s</nav>', $consultor_menu_mobile);
			consultor_show_layout(apply_filters('consultor_filter_menu_mobile_layout', $consultor_menu_mobile));
		}

		// Search field
		do_action('consultor_action_search', 'normal', 'search_mobile', false);
		
		// Social icons
		consultor_show_layout(consultor_get_socials_links(), '<div class="socials_mobile">', '</div>');
		?>
	</div>
</div>
