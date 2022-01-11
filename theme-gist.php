<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/*
Plugin Name: Theme Gist Embed
Plugin URI: https://datogedon.com/wordpress/plugins/gist-theme-wp/
Description: Change the theme of your embedded gists.
Version: 1.0.0
Author: Baldomero Cho
Author URI: https://datogedon.com
License: GPLv2 or later
*/

$option_name = "current_theme_gist_embed";
$defaultTheme = "obsidian";

if (get_option($option_name)) {
    $currentTheme = get_option($option_name);
} else {
    add_option($option_name, $defaultTheme);
}

add_action('admin_menu', 'theme_gist_embed_setup_menu');

function theme_gist_embed_setup_menu()
{
    add_menu_page('Theme Gist Embed Config', 'Theme Gist', 'manage_options', 'theme-gist-embed', 'theme_gist_embed','dashicons-media-code',);
}


wp_register_style('gistthemecode', plugins_url('stylesheets/' . $currentTheme . '.css', __FILE__));
wp_register_style('defaultvalues', plugins_url('stylesheets/defaultvalues.css', __FILE__));
wp_enqueue_script('vuejs251', plugins_url('js/vue.min.js',__FILE__));

wp_enqueue_style('gistthemecode');
wp_enqueue_style('defaultvalues');

function theme_gist_embed()
{
    include "includes/make.php";
}

