<?php
/**
 * The Header: Logo and main menu
 *
 * @package WordPress
 * @subpackage CONSULTOR
 * @since CONSULTOR 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js scheme_<?php
										 // Class scheme_xxx need in the <html> as context for the <body>!
										 echo esc_attr(consultor_get_theme_option('color_scheme'));
										 ?>">
<head>
	<?php wp_head(); ?>
</head>

<body <?php	body_class(); ?>>

	<?php do_action( 'consultor_action_before_body' ); ?>

	<div class="body_wrap">
		<?php

			$show_socials_side = consultor_is_on(consultor_get_theme_option('show_socials_side') && ($consultor_output = consultor_get_socials_links()) != '') ;
			if (!empty($show_socials_side)) {
				?>
				<div class="side_socials"><?php
				consultor_show_layout($consultor_output);
				?></div><?php
			}

		?>

		<div class="page_wrap"><?php
			
			// Desktop header
			$consultor_header_type = consultor_get_theme_option("header_type");
			if ($consultor_header_type == 'custom' && !consultor_is_layouts_available())
				$consultor_header_type = 'default';
			get_template_part( "templates/header-{$consultor_header_type}");

			// Side menu
			if (in_array(consultor_get_theme_option('menu_style'), array('left', 'right'))) {
				get_template_part( 'templates/header-navi-side' );
			}

			// Mobile header
			get_template_part( 'templates/header-mobile');
			?>

			<div class="page_content_wrap">

				<?php if (consultor_get_theme_option('body_style') != 'fullscreen') { ?>
				<div class="content_wrap">
				<?php } ?>

					<?php
					// Widgets area above page content
					consultor_create_widgets_area('widgets_above_page');
					?>				

					<div class="content">
						<?php
						// Widgets area inside page content
						consultor_create_widgets_area('widgets_above_content');
						?>				
