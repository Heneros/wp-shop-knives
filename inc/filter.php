<?php

add_action('init', 'projects_post_type', 0);

function projects_post_type()
{
    register_post_type('projects', [
        'labels' => [
            'name' => __('Projects'),
            'singular_name' => __('Projects'),
            'menu_name' => __('Projects'),
            'view_item ' => 'View Projects',
            'edit_item' => 'Edit Projects',
            'update_item' => 'Update Projects',
            'add_new_item' => 'Add New Projects',
            'new_item_name' => 'Add New Projects',
        ],
        'rewrite' => [
            'slug' => 'projects'
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
        'taxonomies' => array('project_areas'),
        'menu_position'       => 3,
        'show_in_nav_menus'   => true,
    ]);

    register_taxonomy('project_areas', ['projects'], [
        'labels' => [
            'name' => __('Project Areas'),
            'singular_name' => __('Project Areas'),
            'menu_name'     => __('Project Areas '),
            'search_items'      => __('Serch Project Areas'),
            'parent_item'  => __('Parent Project Areas:'),
            'parent_item_colon' => __('Parent Project Areas:'),
            'all_items'         => __('All Project Areas'),
            'update_item'       => __('Update Project Area'),
            'add_new_item'     => __('Add new Project Area'),
            'edit_item'         => __('Edit Project Area'),
            'new_item_name'     => __('New name Project Area'),
        ],
        'public' => true,
        'show_in_rest' => true,
        'hierarchical'          => true,
        'update_count_callback' => '_update_post_term_count',
        'rewrite' => ['slug' => 'projects_areas'],
        'meta_box_cb' => 'post_categories_meta_box',
        'show_admin_column' => true
    ]);

    register_taxonomy('project_areas', ['projects'], [
        'labels' => [
            'name' => __('Project Areas'),
            'singular_name' => __('Project Areas'),
            'menu_name'     => __('Project Areas '),
            'search_items'      => __('Serch Project Areas'),
            'parent_item'  => __('Parent Project Areas:'),
            'parent_item_colon' => __('Parent Project Areas:'),
            'all_items'         => __('All Project Areas'),
            'update_item'       => __('Update Project Area'),
            'add_new_item'     => __('Add new Project Area'),
            'edit_item'         => __('Edit Project Area'),
            'new_item_name'     => __('New name Project Area'),
        ],
        'public' => true,
        'show_in_rest' => true,
        'hierarchical'          => true,
        'update_count_callback' => '_update_post_term_count',
        'rewrite' => ['slug' => 'projects_areas'],
        'meta_box_cb' => 'post_categories_meta_box',
        'show_admin_column' => true
    ]);
    register_taxonomy('field_activities', ['projects'], [
        'labels' => [
            'name' => __('Field Activity'),
            'singular_name' => __('Field Activity'),
            'menu_name'     => __('Field Activity'),
            'search_items'      => __('Serch Field Activities'),
            'parent_item'  => __('Parent Field Activity'),
            'parent_item_colon' => __('Parent Field Activity'),
            'all_items'         => __('All Field Activity'),
            'update_item'       => __('Update Field Activity '),
            'add_new_item'     => __('Add new Field Activity '),
            'edit_item'         => __('Edit Field Activity '),
            'new_item_name'     => __('New name Field Activity '),
        ],
        'public' => true,
        'show_in_rest' => true,
        'hierarchical'          => true,
        'update_count_callback' => '_update_post_term_count',
        'rewrite' => ['slug' => 'field_activities'],
        'meta_box_cb' => 'post_categories_meta_box',
        'show_admin_column' => true
    ]);
}




add_action('filters_tax_projects', 'functions_tax_projects');


function functions_tax_projects()
{
    echo get_projects_filter_form(array('project_areas', 'field_activities'));
}


function get_projects_filter_form($taxonomies = array())
{
    $form = '<form method="get" action="' . esc_url(get_permalink()) . '">';

    foreach ($taxonomies as $taxonomy) {
        $current_terms = isset($_GET[$taxonomy]) ? (array) $_GET[$taxonomy] : array();
        $args = array(
            'taxonomy' => $taxonomy,
            'hide_empty' => false,
        );
        $terms = get_terms($args);
        if (!empty($terms) && !is_wp_error($terms)) {
            $form .= '<div>';
            $form .= '<span>' . esc_html(get_taxonomy($taxonomy)->labels->singular_name) . '</span>';
            foreach ($terms as $term) {
                $checked = '';
                if (in_array($term->slug, $current_terms)) {
                    $checked = 'checked';
                }
                $form .= '<div>';
                $form .= '<label for="' . esc_attr($taxonomy . '_' . $term->slug) . '">';
                $form .= '<input type="checkbox" name="' . esc_attr($taxonomy) . '[]" id="' . esc_attr($taxonomy . '_' . $term->slug) . '" value="' . esc_attr($term->slug) . '" ' . esc_attr($checked) . ' onchange="this.form.submit();">';
                $form .= esc_html($term->name);
                $form .= '</label>';
                $form .= '</div>';
            }
            $form .= '</div>';
        }
    }

    $form .= '<input type="hidden" name="page_id" value="' . esc_attr(get_the_ID()) . '">';

    $form .= '</form>';

    return $form;
}
