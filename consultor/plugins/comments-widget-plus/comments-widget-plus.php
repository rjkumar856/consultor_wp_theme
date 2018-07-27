<?php
/* Comments Widget Plus support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if (!function_exists('consultor_comments_theme_setup9')) {
    add_action( 'after_setup_theme', 'consultor_comments_theme_setup9', 9 );
    function consultor_comments_theme_setup9() {
        if (consultor_exists_comments()) {
            add_action( 'wp_enqueue_scripts', 							'consultor_comments_frontend_scripts', 1100 );
            add_filter( 'consultor_filter_merge_styles',					'consultor_comments_merge_styles' );
        }
        if (is_admin()) {
            add_filter( 'consultor_filter_tgmpa_required_plugins',		'consultor_comments_tgmpa_required_plugins' );
        }
    }
}



// Filter to add in the required plugins list
if ( !function_exists( 'consultor_comments_tgmpa_required_plugins' ) ) {
    //Handler of the add_filter('consultor_filter_tgmpa_required_plugins',	'consultor_comments_tgmpa_required_plugins');
    function consultor_comments_tgmpa_required_plugins($list=array()) {
        if (consultor_storage_isset('required_plugins', 'comments-widget-plus')) {
            $path = consultor_get_file_dir('plugins/comments-widget-plus/comments-widget-plus.zip');
            if (!empty($path) || consultor_get_theme_setting('tgmpa_upload')) {
                $list[] = array(
                    'name' 		=> consultor_storage_get_array('required_plugins', 'comments-widget-plus'),
                    'slug' 		=> 'comments-widget-plus',
                    'source'	=> !empty($path) ? $path : 'upload://comments-widget-plus.zip',
                    'required' 	=> false
                );
            }
        }
        return $list;
    }
}

// Check if plugin installed and activated
if ( !function_exists( 'consultor_exists_comments' ) ) {
    function consultor_exists_comments() {
        return class_exists('comments_plugin');
    }
}

?>