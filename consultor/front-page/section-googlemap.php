<div class="front_page_section front_page_section_googlemap<?php
			$consultor_scheme = consultor_get_theme_option('front_page_googlemap_scheme');
			if (!consultor_is_inherit($consultor_scheme)) echo ' scheme_'.esc_attr($consultor_scheme);
			echo ' front_page_section_paddings_'.esc_attr(consultor_get_theme_option('front_page_googlemap_paddings'));
		?>"<?php
		$consultor_css = '';
		$consultor_bg_image = consultor_get_theme_option('front_page_googlemap_bg_image');
		if (!empty($consultor_bg_image)) 
			$consultor_css .= 'background-image: url('.esc_url(consultor_get_attachment_url($consultor_bg_image)).');';
		if (!empty($consultor_css))
			echo ' style="' . esc_attr($consultor_css) . '"';
?>><?php
	// Add anchor
	$consultor_anchor_icon = consultor_get_theme_option('front_page_googlemap_anchor_icon');	
	$consultor_anchor_text = consultor_get_theme_option('front_page_googlemap_anchor_text');	
	if ((!empty($consultor_anchor_icon) || !empty($consultor_anchor_text)) && shortcode_exists('trx_sc_anchor')) {
		echo do_shortcode('[trx_sc_anchor id="front_page_section_googlemap"'
										. (!empty($consultor_anchor_icon) ? ' icon="'.esc_attr($consultor_anchor_icon).'"' : '')
										. (!empty($consultor_anchor_text) ? ' title="'.esc_attr($consultor_anchor_text).'"' : '')
										. ']');
	}
	?>
	<div class="front_page_section_inner front_page_section_googlemap_inner<?php
			if (consultor_get_theme_option('front_page_googlemap_fullheight'))
				echo ' consultor-full-height sc_layouts_flex sc_layouts_columns_middle';
			?>"<?php
			$consultor_css = '';
			$consultor_bg_mask = consultor_get_theme_option('front_page_googlemap_bg_mask');
			$consultor_bg_color = consultor_get_theme_option('front_page_googlemap_bg_color');
			if (!empty($consultor_bg_color) && $consultor_bg_mask > 0)
				$consultor_css .= 'background-color: '.esc_attr($consultor_bg_mask==1
																	? $consultor_bg_color
																	: consultor_hex2rgba($consultor_bg_color, $consultor_bg_mask)
																).';';
			if (!empty($consultor_css))
				echo ' style="' . esc_attr($consultor_css) . '"';
	?>>
		<div class="front_page_section_content_wrap front_page_section_googlemap_content_wrap<?php
			$consultor_layout = consultor_get_theme_option('front_page_googlemap_layout');
			if ($consultor_layout != 'fullwidth')
				echo ' content_wrap';
		?>">
			<?php
			// Content wrap with title and description
			$consultor_caption = consultor_get_theme_option('front_page_googlemap_caption');
			$consultor_description = consultor_get_theme_option('front_page_googlemap_description');
			if (!empty($consultor_caption) || !empty($consultor_description) || (current_user_can('edit_theme_options') && is_customize_preview())) {
				if ($consultor_layout == 'fullwidth') {
					?><div class="content_wrap"><?php
				}
					// Caption
					if (!empty($consultor_caption) || (current_user_can('edit_theme_options') && is_customize_preview())) {
						?><h2 class="front_page_section_caption front_page_section_googlemap_caption front_page_block_<?php echo !empty($consultor_caption) ? 'filled' : 'empty'; ?>"><?php
							echo wp_kses_post($consultor_caption);
						?></h2><?php
					}
				
					// Description (text)
					if (!empty($consultor_description) || (current_user_can('edit_theme_options') && is_customize_preview())) {
						?><div class="front_page_section_description front_page_section_googlemap_description front_page_block_<?php echo !empty($consultor_description) ? 'filled' : 'empty'; ?>"><?php
							echo wp_kses_post(wpautop($consultor_description));
						?></div><?php
					}
				if ($consultor_layout == 'fullwidth') {
					?></div><?php
				}
			}

			// Content (text)
			$consultor_content = consultor_get_theme_option('front_page_googlemap_content');
			if (!empty($consultor_content) || (current_user_can('edit_theme_options') && is_customize_preview())) {
				if ($consultor_layout == 'columns') {
					?><div class="front_page_section_columns front_page_section_googlemap_columns columns_wrap">
						<div class="column-1_3">
					<?php
				} else if ($consultor_layout == 'fullwidth') {
					?><div class="content_wrap"><?php
				}
	
				?><div class="front_page_section_content front_page_section_googlemap_content front_page_block_<?php echo !empty($consultor_content) ? 'filled' : 'empty'; ?>"><?php
					echo wp_kses_post($consultor_content);
				?></div><?php
	
				if ($consultor_layout == 'columns') {
					?></div><div class="column-2_3"><?php
				} else if ($consultor_layout == 'fullwidth') {
					?></div><?php
				}
			}
			
			// Widgets output
			?><div class="front_page_section_output front_page_section_googlemap_output"><?php 
				if (is_active_sidebar('front_page_googlemap_widgets')) {
					dynamic_sidebar( 'front_page_googlemap_widgets' );
				} else if (current_user_can( 'edit_theme_options' )) {
					if (!consultor_exists_trx_addons())
						consultor_customizer_need_trx_addons_message();
					else
						consultor_customizer_need_widgets_message('front_page_googlemap_caption', 'ThemeREX Addons - Google map');
				}
			?></div><?php

			if ($consultor_layout == 'columns' && (!empty($consultor_content) || (current_user_can('edit_theme_options') && is_customize_preview()))) {
				?></div></div><?php
			}
			?>			
		</div>
	</div>
</div>