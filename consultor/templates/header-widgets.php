<?php
/**
 * The template to display the widgets area in the header
 *
 * @package WordPress
 * @subpackage CONSULTOR
 * @since CONSULTOR 1.0
 */

// Header sidebar
$consultor_header_name = consultor_get_theme_option('header_widgets');
$consultor_header_present = !consultor_is_off($consultor_header_name) && is_active_sidebar($consultor_header_name);
if ($consultor_header_present) { 
	consultor_storage_set('current_sidebar', 'header');
	$consultor_header_wide = consultor_get_theme_option('header_wide');
	ob_start();
	if ( is_active_sidebar($consultor_header_name) ) {
		dynamic_sidebar($consultor_header_name);
	}
	$consultor_widgets_output = ob_get_contents();
	ob_end_clean();
	if (!empty($consultor_widgets_output)) {
		$consultor_widgets_output = preg_replace("/<\/aside>[\r\n\s]*<aside/", "</aside><aside", $consultor_widgets_output);
		$consultor_need_columns = strpos($consultor_widgets_output, 'columns_wrap')===false;
		if ($consultor_need_columns) {
			$consultor_columns = max(0, (int) consultor_get_theme_option('header_columns'));
			if ($consultor_columns == 0) $consultor_columns = min(6, max(1, substr_count($consultor_widgets_output, '<aside ')));
			if ($consultor_columns > 1)
				$consultor_widgets_output = preg_replace("/<aside([^>]*)class=\"widget/", "<aside$1class=\"column-1_".esc_attr($consultor_columns).' widget', $consultor_widgets_output);
			else
				$consultor_need_columns = false;
		}
		?>
		<div class="header_widgets_wrap widget_area<?php echo !empty($consultor_header_wide) ? ' header_fullwidth' : ' header_boxed'; ?>">
			<div class="header_widgets_inner widget_area_inner">
				<?php 
				if (!$consultor_header_wide) { 
					?><div class="content_wrap"><?php
				}
				if ($consultor_need_columns) {
					?><div class="columns_wrap"><?php
				}
				do_action( 'consultor_action_before_sidebar' );
				consultor_show_layout($consultor_widgets_output);
				do_action( 'consultor_action_after_sidebar' );
				if ($consultor_need_columns) {
					?></div>	<!-- /.columns_wrap --><?php
				}
				if (!$consultor_header_wide) {
					?></div>	<!-- /.content_wrap --><?php
				}
				?>
			</div>	<!-- /.header_widgets_inner -->
		</div>	<!-- /.header_widgets_wrap -->
		<?php
	}
}
?>