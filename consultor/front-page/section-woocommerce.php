<div class="front_page_section front_page_section_woocommerce<?php
			$consultor_scheme = consultor_get_theme_option('front_page_woocommerce_scheme');
			if (!consultor_is_inherit($consultor_scheme)) echo ' scheme_'.esc_attr($consultor_scheme);
			echo ' front_page_section_paddings_'.esc_attr(consultor_get_theme_option('front_page_woocommerce_paddings'));
		?>"<?php
		$consultor_css = '';
		$consultor_bg_image = consultor_get_theme_option('front_page_woocommerce_bg_image');
		if (!empty($consultor_bg_image)) 
			$consultor_css .= 'background-image: url('.esc_url(consultor_get_attachment_url($consultor_bg_image)).');';
		if (!empty($consultor_css))
			echo ' style="' . esc_attr($consultor_css) . '"';
?>><?php
	// Add anchor
	$consultor_anchor_icon = consultor_get_theme_option('front_page_woocommerce_anchor_icon');	
	$consultor_anchor_text = consultor_get_theme_option('front_page_woocommerce_anchor_text');	
	if ((!empty($consultor_anchor_icon) || !empty($consultor_anchor_text)) && shortcode_exists('trx_sc_anchor')) {
		echo do_shortcode('[trx_sc_anchor id="front_page_section_woocommerce"'
										. (!empty($consultor_anchor_icon) ? ' icon="'.esc_attr($consultor_anchor_icon).'"' : '')
										. (!empty($consultor_anchor_text) ? ' title="'.esc_attr($consultor_anchor_text).'"' : '')
										. ']');
	}
	?>
	<div class="front_page_section_inner front_page_section_woocommerce_inner<?php
			if (consultor_get_theme_option('front_page_woocommerce_fullheight'))
				echo ' consultor-full-height sc_layouts_flex sc_layouts_columns_middle';
			?>"<?php
			$consultor_css = '';
			$consultor_bg_mask = consultor_get_theme_option('front_page_woocommerce_bg_mask');
			$consultor_bg_color = consultor_get_theme_option('front_page_woocommerce_bg_color');
			if (!empty($consultor_bg_color) && $consultor_bg_mask > 0)
				$consultor_css .= 'background-color: '.esc_attr($consultor_bg_mask==1
																	? $consultor_bg_color
																	: consultor_hex2rgba($consultor_bg_color, $consultor_bg_mask)
																).';';
			if (!empty($consultor_css))
				echo ' style="' . esc_attr($consultor_css) . '"';
	?>>
		<div class="front_page_section_content_wrap front_page_section_woocommerce_content_wrap content_wrap woocommerce">
			<?php
			// Content wrap with title and description
			$consultor_caption = consultor_get_theme_option('front_page_woocommerce_caption');
			$consultor_description = consultor_get_theme_option('front_page_woocommerce_description');
			if (!empty($consultor_caption) || !empty($consultor_description) || (current_user_can('edit_theme_options') && is_customize_preview())) {
				// Caption
				if (!empty($consultor_caption) || (current_user_can('edit_theme_options') && is_customize_preview())) {
					?><h2 class="front_page_section_caption front_page_section_woocommerce_caption front_page_block_<?php echo !empty($consultor_caption) ? 'filled' : 'empty'; ?>"><?php
						echo wp_kses_post($consultor_caption);
					?></h2><?php
				}
			
				// Description (text)
				if (!empty($consultor_description) || (current_user_can('edit_theme_options') && is_customize_preview())) {
					?><div class="front_page_section_description front_page_section_woocommerce_description front_page_block_<?php echo !empty($consultor_description) ? 'filled' : 'empty'; ?>"><?php
						echo wp_kses_post(wpautop($consultor_description));
					?></div><?php
				}
			}
		
			// Content (widgets)
			?><div class="front_page_section_output front_page_section_woocommerce_output list_products shop_mode_thumbs"><?php 
				$consultor_woocommerce_sc = consultor_get_theme_option('front_page_woocommerce_products');
				if ($consultor_woocommerce_sc == 'products') {
					$consultor_woocommerce_sc_ids = consultor_get_theme_option('front_page_woocommerce_products_per_page');
					$consultor_woocommerce_sc_per_page = count(explode(',', $consultor_woocommerce_sc_ids));
				} else {
					$consultor_woocommerce_sc_per_page = max(1, (int) consultor_get_theme_option('front_page_woocommerce_products_per_page'));
				}
				$consultor_woocommerce_sc_columns = max(1, min($consultor_woocommerce_sc_per_page, (int) consultor_get_theme_option('front_page_woocommerce_products_columns')));
				echo do_shortcode("[{$consultor_woocommerce_sc}"
									. ($consultor_woocommerce_sc == 'products' 
											? ' ids="'.esc_attr($consultor_woocommerce_sc_ids).'"' 
											: '')
									. ($consultor_woocommerce_sc == 'product_category' 
											? ' category="'.esc_attr(consultor_get_theme_option('front_page_woocommerce_products_categories')).'"' 
											: '')
									. ($consultor_woocommerce_sc != 'best_selling_products' 
											? ' orderby="'.esc_attr(consultor_get_theme_option('front_page_woocommerce_products_orderby')).'"'
											  . ' order="'.esc_attr(consultor_get_theme_option('front_page_woocommerce_products_order')).'"' 
											: '')
									. ' per_page="'.esc_attr($consultor_woocommerce_sc_per_page).'"' 
									. ' columns="'.esc_attr($consultor_woocommerce_sc_columns).'"' 
									. ']');
			?></div>
		</div>
	</div>
</div>