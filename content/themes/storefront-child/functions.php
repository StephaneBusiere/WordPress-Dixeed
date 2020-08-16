<?php

require 'inc/checkoutCustomField.php';
require 'inc/create-post.php';
require 'inc/create-list-table.php';


function custom_enqueue_script()
{
    wp_enqueue_script(
        'script',
        get_bloginfo('stylesheet_directory') . '/js/script.js',
        array( 'jquery' ),
        '',
        true
    );
    wp_localize_script('script', 'ajaxurl', admin_url('admin-ajax.php'));
}
add_action('wp_enqueue_scripts', 'custom_enqueue_script');

/* enqueue script for parent theme stylesheeet */
function childtheme_parent_styles()
{
 
 // enqueue style
    wp_enqueue_style('parent', get_template_directory_uri().'/style.css');
}
add_action('wp_enqueue_scripts', 'childtheme_parent_styles');

?>

