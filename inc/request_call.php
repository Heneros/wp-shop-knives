<?php


add_action('init', 'request_calls_post_type', 0);






function request_calls_post_type()
{
    register_post_type('request_calls', [
        'labels' => [
            'name' => __('Request Calls'),
            'singular_name' => __('Request Calls'),
            'menu_name' => __('Request Calls'),
            'view_item ' => 'View Request Calls',
            'edit_item' => 'Edit Request Calls',
            'update_item' => 'Update Request Calls',
            'add_new_item' => 'Add New Request Calls',
            'new_item_name' => 'Add New Request Calls',
        ],
        'rewrite' => [
            'slug' => 'request_calls'
        ],
        'description'         => '',
        'public'              => true,
        'show_ui'             => true,
        'capability_type'     => 'post',
        'map_meta_cap'        => true,
        'publicly_queryable'  => true,
        'exclude_from_search' => false,
        'hierarchical'        => false,
        'query_var'           => true,
        'show_in_rest' => true,
        'supports'            => ['title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments'],
        'has_archive' => true,
        'menu_position'       => 3,
        'show_in_nav_menus'   => true,
    ]);
}
