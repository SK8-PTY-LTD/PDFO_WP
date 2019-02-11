<?php
add_action( 'wp_enqueue_scripts', 'g5plus_child_theme_enqueue_styles', 1000 );
function g5plus_child_theme_enqueue_styles() {
    wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css', array( 'g5plus_framework_style' ) );
}

add_action( 'after_setup_theme', 'g5plus_child_theme_setup');
function g5plus_child_theme_setup(){
    $language_path = get_stylesheet_directory() .'/languages';
    if(is_dir($language_path)){
        load_child_theme_textdomain('g5-beyot', $language_path );
    }
}
// if you want to add some custom function

/*
Fixes WP5.0 & WPBakery Page Builder loses Role Settings upon

You can set the post type for which the editor should be
available by adding the following code to functions.php:

Author: Jacktator
Plugin: WPBakery Page Builder 5.6
Reference: https://stackoverflow.com/questions/49316654/wp-bakery-page-builder-loses-settings-in-role-manager?rq=1
*/
// add_action('vc_before_init', 'Use_wpBakery');
// function Use_wpBakery() {
// 	$vc_list = array('page', 'post');
// 	vc_set_default_editor_post_types($vc_list);
// 	vc_editor_set_post_types($vc_list);
// }
