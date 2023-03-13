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
        'taxonomies' => array('project_areas', 'field_activities'),
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
            $form .= '<div class="js-select">';
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


add_action('wp_ajax_nopriv_loadmore', 'loadmore_ajax_handler');
add_action('wp_ajax_loadmore', 'loadmore_ajax_handler');

// function loadmore_ajax_handler()
// {
//     $next_page = $_POST['next_page'];
//     $posts_per_page = $_POST['posts_per_page'];
//     $offset = $_POST['offset'];

//     $args = array(
//         'post_type'      => 'projects',
//         'offset'         => $offset,
//         'posts_per_page' => $posts_per_page,
//     );
function loadmore_ajax_handler()
{
    $next_page = $_POST['next_page'];
    $posts_per_page = $_POST['posts_per_page'];
    $offset = $_POST['offset'];
    $post_type = $_POST['post_type'];

    $args = array(
        'post_type'      => $post_type,
        'offset'         => $offset,
        'posts_per_page' => $posts_per_page,
    );
    $query = new WP_Query($args);

    if ($query->have_posts()) :
        while ($query->have_posts()) :
            $query->the_post();
            global $post;
            $featured_img = wp_get_attachment_url(get_post_thumbnail_id());
            $link = get_permalink();

            $field_activities_tax = get_the_term_list($post->ID, 'field_activities', '', ', ');
            $field_activities = '';

            if ($field_activities_tax) {
                $field_activities = explode(',', $field_activities_tax);
                foreach ($field_activities as &$area) {
                    $area = '<span class="tax">' . trim(strip_tags($area)) . '</span>';
                }
            }
            $project_areas_tax = get_the_term_list($post->ID, 'project_areas', '', ', ');
            $project_areas =   strip_tags($project_areas_tax);
            $project_areas = '<span>' . $project_areas . '</span>';
?>
            <div class="cardd-item">
                <div class="card-img" style="background-image: url(<?php echo $featured_img  ?>); ">
                    <div class="taxs">
                        <?php
                        echo implode(' ', $field_activities);
                        ?>
                    </div>
                </div>
                <div class="card-content">
                    <h1>
                        <a href="<?= $link ?>">
                            <?php the_title(); ?>
                        </a>
                    </h1>
                    <?php if ($project_areas_tax) : ?>
                        <div class="card-location">
                            <?php
                            echo $project_areas;
                            ?>
                        </div>
                    <?php
                    endif;
                    ?>
                </div>
            </div>
<?php
        endwhile;
    endif;

    wp_reset_postdata();

    die();
}
