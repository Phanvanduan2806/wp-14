<?php
function wpfh_use_in_taxonomy() {
    $labels = array(
        'name'                       => 'Uses In',
        'singular_name'              => 'Use In',
        'menu_name'                  => 'Use In',
        'all_items'                  => 'All Uses In',
        'parent_item'                => 'Parent Use In',
        'parent_item_colon'          => 'Parent Use In:',
        'new_item_name'              => 'New Use In Name',
        'add_new_item'               => 'Add New Use In',
        'edit_item'                  => 'Edit Use In',
        'update_item'                => 'Update Use In',
        'view_item'                  => 'View Use In',
        'separate_items_with_commas' => 'Separate uses in with commas',
        'add_or_remove_items'        => 'Add or remove uses in',
        'choose_from_most_used'      => 'Choose from the most used',
        'popular_items'              => 'Popular Uses In',
        'search_items'               => 'Search Uses In',
        'not_found'                  => 'Not Found',
        'no_terms'                   => 'No uses in',
        'items_list'                 => 'Uses in list',
        'items_list_navigation'      => 'Uses in list navigation',
    );
    $args = array(
        'labels'                     => $labels,
        'hierarchical'               => false, // Set to true if you want it to be hierarchical (like categories)
        'public'                     => false,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => false,
        'show_tagcloud'              => true,
    );
    register_taxonomy('use_in', array('wpfh_blocks'), $args);
}
