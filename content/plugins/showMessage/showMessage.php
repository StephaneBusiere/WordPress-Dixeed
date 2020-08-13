<?php
/**
 * Plugin Name: showMessage
 * Description: Un plugin qui active/désactive l'affichage d'un message sur le dashboard client
 * Version: 1.0
 * Author: Stéphane Busiere
 */
// Register Custom Post Type



function my_meta_init()
{
$post_id = $_GET['post'] ? $_GET['post'] : $_POST['post_ID'] ;
// checks for post/page ID
if ($post_id == '9')
{
    $screens = ['page'];
    foreach ($screens as $screen) {
        add_meta_box(
            'wporg_box_id',           // Unique ID
            'Ajouter un text',  // Box title
            'wporg_custom_box_html',  // Content callback, must be of type callable
            $screen                   // Post type
        );
}
}
}
add_action('add_meta_boxes', 'my_meta_init');

function wporg_custom_box_html($post)
{
    $val = get_post_meta($post->ID,'_ma_valeur',true);
    
    
    echo'<label for="wporg_field">Entrez votre message</label>';
    echo '<input class="inputMetabox" id="mon_champ" type="text" name="mon_champ" value="'.$val.'"/>';
    
    
}
add_action('save_post','save_metaboxes');
function save_metaboxes($post_ID){
    if(isset($_POST['mon_champ'])){
        update_post_meta($post_ID,'_ma_valeur', esc_html($_POST['mon_champ']));
      }
}
?>
