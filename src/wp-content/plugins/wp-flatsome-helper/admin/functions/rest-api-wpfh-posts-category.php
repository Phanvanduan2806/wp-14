<?php
function wpfh_create_category($category_name)
{
    $category = get_term_by('name', $category_name, 'category');
    if ($category) {
        return $category->term_id;
    }
    $new_category = wp_insert_term($category_name, 'category');
    if (is_wp_error($new_category)) {
        error_log('Error creating category: ' . $new_category->get_error_message());
        return null;
    }
    return $new_category['term_id'];
}

function wpfh_create_posts($category_id, $post, $media_id)
{
    global $wpdb;
    $escaped_title = $wpdb->esc_like($post['title']);
    $checkPost = $wpdb->get_row(
        $wpdb->prepare("
            SELECT ID
            FROM $wpdb->posts
            INNER JOIN $wpdb->term_relationships ON ($wpdb->posts.ID = $wpdb->term_relationships.object_id)
            INNER JOIN $wpdb->term_taxonomy ON ($wpdb->term_relationships.term_taxonomy_id = $wpdb->term_taxonomy.term_taxonomy_id)
            WHERE $wpdb->posts.post_title = %s
            AND $wpdb->term_taxonomy.term_id = %d",
            $escaped_title,
            $category_id
        )
    );
    if ($checkPost) return $checkPost->ID;

    $post_id = wp_insert_post(array(
        'post_title' => $post['title'],
        'post_content' => $post['content'],
        'post_category' => array($category_id),
        'post_status' => 'publish'
    ));

    if (!is_wp_error($post_id)) {
        set_post_thumbnail($post_id, $media_id);
    }
    return $post_id;
}


function wpfh_download_media($posts)
{
    require_once(ABSPATH . "wp-admin" . '/includes/image.php');
    require_once(ABSPATH . "wp-admin" . '/includes/file.php');
    require_once(ABSPATH . "wp-admin" . '/includes/media.php');

    $arr_img = [];
    foreach ($posts as $item) {
        $arr_img[$item['thumbnail']] = $item['thumbnail'];
    }
    foreach ($arr_img as $thumbnail_url) {
        $tmp = download_url($thumbnail_url);
        $file_array = array(
            'name' => basename($thumbnail_url),
            'tmp_name' => $tmp
        );
        if (is_wp_error($tmp)) {
            continue;
        }
        $media_id = media_handle_sideload($file_array, 0);
        if (is_wp_error($media_id)) {
            continue;
        }
        $arr_img[$thumbnail_url] = $media_id;
    }
    return $arr_img;
}

function wpfh_posts_category($request)
{
    $payload = $request->get_json_params();
    $posts = $payload['posts_in'];
    $name_cat = $payload['name_cat'];
    $arr_img = wpfh_download_media($posts);
    $id_cat_3 = wpfh_create_category($name_cat);
    $postsId = [];
    foreach ($posts as $post) {
        $media_id = $arr_img[$post['thumbnail']];
        $postId = wpfh_create_posts($id_cat_3, $post, $media_id);
        $postsId[] = $postId;
    }
    return ['data' => ['category_id' => $id_cat_3, 'posts_id' => $postsId]];
}