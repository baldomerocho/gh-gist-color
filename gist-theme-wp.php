<?php

/*
Plugin Name: Gist Theme Wp
Plugin URI: https://datogedon.com/wordpress/plugins/gist-theme-wp/
Description: Change the theme of your embedded gists.
Version: 1.0.0
Author: Baldomero Cho
Author URI: https://datogedon.com
License: GPLv2 or later
*/

$option_name = "current_gist_theme_wp";
$defaultTheme = "obsidian";

if(get_option($option_name)){
    $currentTheme = get_option($option_name);
}
else {
    add_option($option_name, $defaultTheme);
}

add_action('admin_menu', 'gist_theme_wp_setup_menu');

function gist_theme_wp_setup_menu(){
    add_menu_page( 'Gist Theme Config', 'Gist Theme', 'manage_options', 'gist-theme-wp', 'gist_theme_wp' );
}


wp_register_style('gistthemecode', plugins_url('stylesheets/'.$currentTheme.'.css',__FILE__ ));
wp_register_style('defaultvalues', plugins_url('stylesheets/defaultvalues.css',__FILE__ ));

wp_enqueue_style( 'gistthemecode' );
wp_enqueue_style( 'defaultvalues' );

function gist_theme_wp(){
    echo "<h1>Gist Theme Config</h1>";
    include "make.php";
}