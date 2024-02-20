<?php
function get_url_by_id($post_id)
{
    if ($post_id == get_option('page_on_front')) {
        return 'home';
    }

    $post = get_post($post_id);
    if (is_a($post, 'WP_Post')) {
        $permalink = get_permalink($post_id);
        return basename(parse_url($permalink, PHP_URL_PATH));
    } else {
        return null;
    }
}

function wpfh_insert_block_data($request)
{
    $payload = $request->get_json_params();
    $post_data = array(
        'post_title' => $payload['title'],
        'post_content' => $payload['content'],
        'post_status' => 'publish',
        'post_type' => 'wpfh_blocks',
    );
    $post_id = wp_insert_post($post_data);
    if (is_wp_error($post_id)) {
        return new WP_Error('insert_failed', 'Failed to insert post', array('status' => 500));
    }
    $post_slug = get_url_by_id($payload['use_in_id']) . '.' . $payload['use_in_id'];
    wp_set_object_terms($post_id, $post_slug, 'use_in');
    return new WP_REST_Response(array(
        'message' => 'Post created',
        'post_id' => $post_id,
        'url' => '/wp-admin/edit.php?post_type=wpfh_blocks&use_in=' . $post_slug
    ), 200);
}