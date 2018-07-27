<?php
/**
 * The template to display the widgets area in the footer
 *
 * @package WordPress
 * @subpackage CONSULTOR
 * @since CONSULTOR 1.0.10
 */

// Footer sidebar
$consultor_footer_name = consultor_get_theme_option('footer_widgets');
$consultor_footer_present = !consultor_is_off($consultor_footer_name) && is_active_sidebar($consultor_footer_name);
if ($consultor_footer_present) { 
	consultor_storage_set('current_sidebar', 'footer');
	$consultor_footer_wide = consultor_get_theme_option('footer_wide');
	ob_start();
	if ( is_active_sidebar($consultor_footer_name) ) {
		dynamic_sidebar($consultor_footer_name);
	}
	$consultor_out = trim(ob_get_contents());
	ob_end_clean();
	if (!empty($consultor_out)) {
		$consultor_out = preg_replace("/<\\/aside>[\r\n\s]*<aside/", "</aside><aside", $consultor_out);
		$consultor_need_columns = true;	//or check: strpos($consultor_out, 'columns_wrap')===false;
		if ($consultor_need_columns) {
			$consultor_columns = max(0, (int) consultor_get_theme_option('footer_columns'));
			if ($consultor_columns == 0) $consultor_columns = min(4, max(1, substr_count($consultor_out, '<aside ')));
			if ($consultor_columns > 1)
				$consultor_out = preg_replace("/<aside([^>]*)class=\"widget/", "<aside$1class=\"column-1_".esc_attr($consultor_columns).' widget', $consultor_out);
			else
				$consultor_need_columns = false;
		}
		?>
		<div class="footer_widgets_wrap widget_area<?php echo !empty($consultor_footer_wide) ? ' footer_fullwidth' : ''; ?> sc_layouts_row  sc_layouts_row_type_normal">
			<div class="footer_widgets_inner widget_area_inner">
				<?php 
				if (!$consultor_footer_wide) { 
					?><div class="content_wrap"><?php
				}
				if ($consultor_need_columns) {
					?><div class="columns_wrap"><?php
				}
				do_action( 'consultor_action_before_sidebar' );
				consultor_show_layout($consultor_out);
				do_action( 'consultor_action_after_sidebar' );
				if ($consultor_need_columns) {
					?></div><!-- /.columns_wrap --><?php
				}
				if (!$consultor_footer_wide) {
					?></div><!-- /.content_wrap --><?php
				}
				?>
			</div><!-- /.footer_widgets_inner -->
		</div><!-- /.footer_widgets_wrap -->
		<?php
	}
}
?>