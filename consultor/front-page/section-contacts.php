<div class="front_page_section front_page_section_contacts<?php
			$consultor_scheme = consultor_get_theme_option('front_page_contacts_scheme');
			if (!consultor_is_inherit($consultor_scheme)) echo ' scheme_'.esc_attr($consultor_scheme);
			echo ' front_page_section_paddings_'.esc_attr(consultor_get_theme_option('front_page_contacts_paddings'));
		?>"<?php
		$consultor_css = '';
		$consultor_bg_image = consultor_get_theme_option('front_page_contacts_bg_image');
		if (!empty($consultor_bg_image)) 
			$consultor_css .= 'background-image: url('.esc_url(consultor_get_attachment_url($consultor_bg_image)).');';
		if (!empty($consultor_css))
			echo ' style="' . esc_attr($consultor_css) . '"';
?>><?php
	// Add anchor
	$consultor_anchor_icon = consultor_get_theme_option('front_page_contacts_anchor_icon');	
	$consultor_anchor_text = consultor_get_theme_option('front_page_contacts_anchor_text');	
	if ((!empty($consultor_anchor_icon) || !empty($consultor_anchor_text)) && shortcode_exists('trx_sc_anchor')) {
		echo do_shortcode('[trx_sc_anchor id="front_page_section_contacts"'
										. (!empty($consultor_anchor_icon) ? ' icon="'.esc_attr($consultor_anchor_icon).'"' : '')
										. (!empty($consultor_anchor_text) ? ' title="'.esc_attr($consultor_anchor_text).'"' : '')
										. ']');
	}
	?>
	<div class="front_page_section_inner front_page_section_contacts_inner<?php
			if (consultor_get_theme_option('front_page_contacts_fullheight'))
				echo ' consultor-full-height sc_layouts_flex sc_layouts_columns_middle';
			?>"<?php
			$consultor_css = '';
			$consultor_bg_mask = consultor_get_theme_option('front_page_contacts_bg_mask');
			$consultor_bg_color = consultor_get_theme_option('front_page_contacts_bg_color');
			if (!empty($consultor_bg_color) && $consultor_bg_mask > 0)
				$consultor_css .= 'background-color: '.esc_attr($consultor_bg_mask==1
																	? $consultor_bg_color
																	: consultor_hex2rgba($consultor_bg_color, $consultor_bg_mask)
																).';';
			if (!empty($consultor_css))
				echo ' style="' . esc_attr($consultor_css) . '"';
	?>>
		<div class="front_page_section_content_wrap front_page_section_contacts_content_wrap content_wrap">
			<?php

			// Title and description
			$consultor_caption = consultor_get_theme_option('front_page_contacts_caption');
			$consultor_description = consultor_get_theme_option('front_page_contacts_description');
			if (!empty($consultor_caption) || !empty($consultor_description) || (current_user_can('edit_theme_options') && is_customize_preview())) {
				// Caption
				if (!empty($consultor_caption) || (current_user_can('edit_theme_options') && is_customize_preview())) {
					?><h2 class="front_page_section_caption front_page_section_contacts_caption front_page_block_<?php echo !empty($consultor_caption) ? 'filled' : 'empty'; ?>"><?php
						echo wp_kses_post($consultor_caption);
					?></h2><?php
				}
			
				// Description
				if (!empty($consultor_description) || (current_user_can('edit_theme_options') && is_customize_preview())) {
					?><div class="front_page_section_description front_page_section_contacts_description front_page_block_<?php echo !empty($consultor_description) ? 'filled' : 'empty'; ?>"><?php
						echo wp_kses_post(wpautop($consultor_description));
					?></div><?php
				}
			}

			// Content (text)
			$consultor_content = consultor_get_theme_option('front_page_contacts_content');
			$consultor_layout = consultor_get_theme_option('front_page_contacts_layout');
			if ($consultor_layout == 'columns' && (!empty($consultor_content) || (current_user_can('edit_theme_options') && is_customize_preview()))) {
				?><div class="front_page_section_columns front_page_section_contacts_columns columns_wrap">
					<div class="column-1_3">
				<?php
			}

			if ((!empty($consultor_content) || (current_user_can('edit_theme_options') && is_customize_preview()))) {
				?><div class="front_page_section_content front_page_section_contacts_content front_page_block_<?php echo !empty($consultor_content) ? 'filled' : 'empty'; ?>"><?php
					echo wp_kses_post($consultor_content);
				?></div><?php
			}

			if ($consultor_layout == 'columns' && (!empty($consultor_content) || (current_user_can('edit_theme_options') && is_customize_preview()))) {
				?></div><div class="column-2_3"><?php
			}
		
			// Shortcode output
			$consultor_sc = consultor_get_theme_option('front_page_contacts_shortcode');
			if (!empty($consultor_sc) || (current_user_can('edit_theme_options') && is_customize_preview())) {
				?><div class="front_page_section_output front_page_section_contacts_output front_page_block_<?php echo !empty($consultor_sc) ? 'filled' : 'empty'; ?>"><?php
					consultor_show_layout(do_shortcode($consultor_sc));
				?></div><?php
			}

			if ($consultor_layout == 'columns' && (!empty($consultor_content) || (current_user_can('edit_theme_options') && is_customize_preview()))) {
				?></div></div><?php
			}
			?>			
		</div>
	</div>
</div>