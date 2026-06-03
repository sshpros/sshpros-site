<?php
if ( ! defined( 'ABSPATH' ) )
	exit;


add_action('wp_ajax_ihs_backlink', 'xyz_ihs_ajax_backlink');
function xyz_ihs_ajax_backlink() {
	check_ajax_referer('xyz-ihs-blink','security');
    if(current_user_can('administrator')){
        global $wpdb;
        if(isset($_POST)){
            if(intval($_POST['enable'])==1){
                update_option('xyz_credit_link','ihs');
                echo 1;
            }
            if(intval($_POST['enable'])==-1){
                update_option('xyz_ihs_credit_dismiss','dis');
                echo -1;
            }
        }
    }die;
}
add_action('wp_ajax_xyz_ihs_sync_usage', function() {
    global $wpdb;

    $offset = isset($_POST['offset']) ? intval($_POST['offset']) : 0;
    $batch_size = 1; // adjust as needed
    $table_name = $wpdb->prefix . 'xyz_ihs_usage';
    // Get posts starting from $offset
    $posts = $wpdb->get_results($wpdb->prepare(
        "SELECT ID, post_content, post_type FROM {$wpdb->posts} 
         WHERE post_status = 'publish' 
         ORDER BY ID ASC 
         LIMIT %d, %d", 
         $offset, $batch_size
    ));
    if (empty($posts)) {
        // Finished
        update_option('xyz_ihs_sync_needed', 0); // reset
        wp_send_json_success(['status' => 'complete']);
    }
    foreach ($posts as $post) {
        // Run your usage update logic
        xyz_ihs_update_usage_for_post($post->ID, $post->post_content, $post->post_type);
    }
    $new_offset = $offset + count($posts);
    // Store the new offset
    update_option('xyz_ihs_sync_needed', $new_offset);
    wp_send_json_success([
        'status' => 'processing',
        'new_offset' => $new_offset
    ]);
});
?>
