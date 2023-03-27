<?php
if (!defined('ABSPATH')) exit;

/*
Plugin Name: GH Gist Color
Plugin URI: https://datogedon.com/wordpress/plugins/gist-theme-wp/
Description: Change the theme of your embedded gists.
Version: 1.0.0
Author: Baldomero Cho
Author URI: https://datogedon.com
License: GPLv2 or later
*/

$option_name = "current_gh_gist_color";
$options = array(
"chaos", "cobalt", "idle-fingers", "monokai", "obsidian", "one-dark",
"pastel-on-dark", "solarized-dark", "solarized-light", "terminal",
"tomorrow-night", "twilight"
);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_value = sanitize_text_field($_POST["newGistThemeWPSelected"]);
    if ($new_value) {
        update_option($option_name, $new_value);
    }
}

function gh_gist_color_enqueue_scripts()
{
global $option_name, $options;

$defaultTheme = "obsidian";
$currentTheme = get_option($option_name, $defaultTheme);

wp_register_style('ghgistcolor', plugins_url('stylesheets/' . $currentTheme . '.css', __FILE__));
wp_register_style('defaultvalues', plugins_url('stylesheets/defaultvalues.css', __FILE__));

    wp_enqueue_style('ghgistcolor');
    wp_enqueue_style('defaultvalues');
}

add_action('wp_enqueue_scripts', 'gh_gist_color_enqueue_scripts');
add_action('admin_menu', 'get_button_admin');

function get_button_admin()
{
    add_menu_page(
        'GH Gist Color',
        'GH Gist Color',
        'manage_options',
        'gh-gist-color-config',
        'gh_gist_color_config'
    );
}

function gh_gist_color_config()
{
    global $options, $option_name;
    $current_value = get_option($option_name);
    // Mueve la notificación de éxito aquí
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["newGistThemeWPSelected"])) {
        $new_value = sanitize_text_field($_POST["newGistThemeWPSelected"]);
        if ($new_value) {
            echo '<div class="notice notice-success">
                     <p><strong>' . strtoupper($new_value) . '</strong> selected and saved.</p>
                 </div>';
        }
    }
    $defaultTheme = "obsidian";
    echo '<div style="margin-top:50px">';
    echo '<h2>Tema actual: '.strtoupper($current_value==''?$defaultTheme:$current_value).'</h2>';
    $theme_image = ($current_value == "") ? $defaultTheme : $current_value;
    echo '<img id="gist-theme-image" src="' . plugin_dir_url(__FILE__) . 'themes-gist/' . $theme_image . '.jpeg">';
    echo '<form method="POST">';
    echo '<select name="newGistThemeWPSelected" id="newGistThemeWPSelected" onchange="updateImage();">';
    foreach ($options as $option) {
        $selected = ($current_value == $option) ? 'selected' : '';
        echo '<option value="' . $option . '" ' . $selected . '>' . $option . '</option>';
    }
    echo '</select>';
    echo '<input type="submit" value="Save">';
    echo '</form></div>';

    // Agrega la función de JavaScript
    echo '<script>
    function updateImage() {
        var selectElement = document.getElementById("newGistThemeWPSelected");
        var selectedOption = selectElement.options[selectElement.selectedIndex].value;
        var imagePath = "' . plugin_dir_url(__FILE__) . 'themes-gist/" + selectedOption + ".jpeg";
        document.getElementById("gist-theme-image").src = imagePath;
    }
    </script>';




}