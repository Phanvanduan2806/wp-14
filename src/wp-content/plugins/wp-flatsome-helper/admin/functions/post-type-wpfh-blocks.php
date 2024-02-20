<?php
/**
 * Registers a custom post type 'wpfh_blocks'.
 *
 * @since 1.0.0
 *
 * @return void
 */
function wpfh_blocks_post_type() : void {
    $labels = [
        'name' => _x( 'wpfh Blocks', 'Post Type General Name', 'wp-flatsome-helper' ),
        'singular_name' => _x( 'wpfh Block', 'Post Type Singular Name', 'wp-flatsome-helper' ),
        'menu_name' => __( 'wpfh Blocks', 'wp-flatsome-helper' ),
        'name_admin_bar' => __( 'wpfh Blocks', 'wp-flatsome-helper' ),
        'archives' => __( 'wpfh Blocks Archives', 'wp-flatsome-helper' ),
        'attributes' => __( 'wpfh Blocks Attributes', 'wp-flatsome-helper' ),
        'parent_item_colon' => __( 'Parent wpfh Block:', 'wp-flatsome-helper' ),
        'all_items' => __( 'All wpfh Blocks', 'wp-flatsome-helper' ),
        'add_new_item' => __( 'Add New wpfh Block', 'wp-flatsome-helper' ),
        'add_new' => __( 'Add New', 'wp-flatsome-helper' ),
        'new_item' => __( 'New wpfh Block', 'wp-flatsome-helper' ),
        'edit_item' => __( 'Edit wpfh Block', 'wp-flatsome-helper' ),
        'update_item' => __( 'Update wpfh Block', 'wp-flatsome-helper' ),
        'view_item' => __( 'View wpfh Block', 'wp-flatsome-helper' ),
        'view_items' => __( 'View wpfh Blocks', 'wp-flatsome-helper' ),
        'search_items' => __( 'Search wpfh Blocks', 'wp-flatsome-helper' ),
        'not_found' => __( 'wpfh Block Not Found', 'wp-flatsome-helper' ),
        'not_found_in_trash' => __( 'wpfh Block Not Found in Trash', 'wp-flatsome-helper' ),
        'featured_image' => __( 'Featured Image', 'wp-flatsome-helper' ),
        'set_featured_image' => __( 'Set Featured Image', 'wp-flatsome-helper' ),
        'remove_featured_image' => __( 'Remove Featured Image', 'wp-flatsome-helper' ),
        'use_featured_image' => __( 'Use as Featured Image', 'wp-flatsome-helper' ),
        'insert_into_item' => __( 'Insert into wpfh Block', 'wp-flatsome-helper' ),
        'uploaded_to_this_item' => __( 'Uploaded to this wpfh Block', 'wp-flatsome-helper' ),
        'items_list' => __( 'wpfh Blocks List', 'wp-flatsome-helper' ),
        'items_list_navigation' => __( 'wpfh Blocks List Navigation', 'wp-flatsome-helper' ),
        'filter_items_list' => __( 'Filter wpfh Blocks List', 'wp-flatsome-helper' ),
    ];
    $labels = apply_filters( 'wpfh_blocks-labels', $labels );

    $args = [
        'label' => __( 'wpfh Block', 'wp-flatsome-helper' ),
        'description' => __( 'wpfh Block Description', 'wp-flatsome-helper' ),
        'labels' => $labels,
        'supports' => [
            'title',
            'editor',
        ],
        'hierarchical' => false,
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 25,
        'menu_icon' => 'dashicons-tagcloud',
        'show_in_admin_bar' => true,
        'show_in_nav_menus' => true,
        'exclude_from_search' => false,
        'has_archive' => false,
        'can_export' => false,
        'capability_type' => 'page',
        'show_in_rest' => true,
    ];
    $args = apply_filters( 'wpfh_blocks-args', $args );
    register_post_type( 'wpfh_blocks', $args );
}
