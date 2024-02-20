<?php
function delete_posts_by_taxonomy($term)
{
    $post_type = 'wpfh_blocks';
    $taxonomy = 'use_in';
    $args = array(
        'post_type' => $post_type,
        'posts_per_page' => -1,
        'fields' => 'ids',
        'tax_query' => array(
            array(
                'taxonomy' => $taxonomy,
                'field' => 'slug',
                'terms' => $term,
            ),
        ),
    );
    $query = new WP_Query($args);
    $count_delete = 0;
    if ($query->have_posts()) {
        foreach ($query->posts as $post_id) {
            $count_delete++;
            wp_delete_post($post_id, true);
        }
    }
    return $count_delete;
}

function wpfh_delete_use_in($request)
{
    $payload = $request->get_json_params();
    $use_in = $payload['use_in'];
    $count_delete = delete_posts_by_taxonomy($use_in);
    return ['count_delete' => $count_delete];
}