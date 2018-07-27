<?php
/**
 * The template to display the copyright info in the footer
 *
 * @package WordPress
 * @subpackage CONSULTOR
 * @since CONSULTOR 1.0.10
 */

// Copyright area
$consultor_footer_scheme =  consultor_is_inherit(consultor_get_theme_option('footer_scheme')) ? consultor_get_theme_option('color_scheme') : consultor_get_theme_option('footer_scheme');
$consultor_copyright_scheme = consultor_is_inherit(consultor_get_theme_option('copyright_scheme')) ? $consultor_footer_scheme : consultor_get_theme_option('copyright_scheme');
?> 
<div class="footer_copyright_wrap scheme_<?php echo esc_attr($consultor_copyright_scheme); ?>">
	<div class="footer_copyright_inner">
		<div class="content_wrap">
			<div class="copyright_text"><?php
				// Replace {{...}} and ((...)) on the <i>...</i> and <b>...</b>
				$consultor_copyright = consultor_prepare_macros(consultor_get_theme_option('copyright'));
				if (!empty($consultor_copyright)) {
					// Replace {date_format} on the current date in the specified format
					if (preg_match("/(\\{[\\w\\d\\\\\\-\\:]*\\})/", $consultor_copyright, $consultor_matches)) {
						$consultor_copyright = str_replace($consultor_matches[1], date_i18n(str_replace(array('{', '}'), '', $consultor_matches[1])), $consultor_copyright);
					}
					// Display copyright
					echo wp_kses_data(nl2br($consultor_copyright));
				}
			?></div>
		</div>
	</div>
</div>
