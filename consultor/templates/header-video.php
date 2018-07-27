<?php
/**
 * The template to display the background video in the header
 *
 * @package WordPress
 * @subpackage CONSULTOR
 * @since CONSULTOR 1.0.14
 */
$consultor_header_video = consultor_get_header_video();
$consultor_embed_video = '';
if (!empty($consultor_header_video) && !consultor_is_from_uploads($consultor_header_video)) {
	if (consultor_is_youtube_url($consultor_header_video) && preg_match('/[=\/]([^=\/]*)$/', $consultor_header_video, $matches) && !empty($matches[1])) {
		?><div id="background_video" data-youtube-code="<?php echo esc_attr($matches[1]); ?>"></div><?php
	} else {
		global $wp_embed;
		if (false && is_object($wp_embed)) {
			$consultor_embed_video = do_shortcode($wp_embed->run_shortcode( '[embed]' . trim($consultor_header_video) . '[/embed]' ));
			$consultor_embed_video = consultor_make_video_autoplay($consultor_embed_video);
		} else {
			$consultor_header_video = str_replace('/watch?v=', '/embed/', $consultor_header_video);
			$consultor_header_video = consultor_add_to_url($consultor_header_video, array(
				'feature' => 'oembed',
				'controls' => 0,
				'autoplay' => 1,
				'showinfo' => 0,
				'modestbranding' => 1,
				'wmode' => 'transparent',
				'enablejsapi' => 1,
				'origin' => home_url(),
				'widgetid' => 1
			));
			$consultor_embed_video = '<iframe src="' . esc_url($consultor_header_video) . '" width="1170" height="658" allowfullscreen="0" frameborder="0"></iframe>';
		}
		?><div id="background_video"><?php consultor_show_layout($consultor_embed_video); ?></div><?php
	}
}
?>