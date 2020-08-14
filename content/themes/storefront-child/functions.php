<?php
require 'checkoutCustomField.php';


/* enqueue script for parent theme stylesheeet */        
function childtheme_parent_styles() {
 
 // enqueue style
 wp_enqueue_style( 'parent', get_template_directory_uri().'/style.css' );                       
}
add_action( 'wp_enqueue_scripts', 'childtheme_parent_styles');



$check_page_exist = get_page_by_title('Ananas', 'OBJECT', 'page');
// Check if the page already exists
if(empty($check_page_exist)) {
    $page_id = wp_insert_post(
        array(
        'comment_status' => 'close',
        'ping_status'    => 'close',
        'post_author'    => 1,
        'post_title'     => ucwords('ananas'),
        'post_name'      => sanitize_title('Ananas'),
        'post_status'    => 'publish',
        'post_content'   => 'Content of the page',
        'post_type'      => 'page',
        'post_parent'    => 'id_of_the_parent_page_if_it_available',
        'page_template'  => 'content-new-page.php',
        )
    );
}
?>

