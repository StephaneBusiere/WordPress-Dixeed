<?php
//create post without backoffice
$check_page_exist = get_page_by_title('Aimez vous les ananas?', 'OBJECT', 'page');
// Check if the page already exists
if(empty($check_page_exist)) {
    $page_id = wp_insert_post(
        array(
        'comment_status' => 'close',
        'ping_status'    => 'close',
        'post_author'    => 1,
        'post_title'     => ucwords('Aimez vous les ananas?'),
        'post_name'      => sanitize_title('Aimez vous les ananas?'),
        'post_status'    => 'publish',
        'post_content'   => 'Content of the page',
        'post_type'      => 'page',
        'post_parent'    => 'id_of_the_parent_page_if_it_available',
        'page_template'  => 'ananas-page.php',
        )
    );
}
?>