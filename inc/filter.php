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




add_shortcode('shortcode_posts', 'my_project_shortcode');


function my_project_shortcode($atts)
{
    $atts = shortcode_atts(array(
        'posts_per_page' => '6',
        'post_type' => 'projects',
    ), $atts);





    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    $postsPerPage = 6;
    $postOffset = ($paged - 1) * $postsPerPage;
    $args = array(
        'post_type' => 'projects',
        'offset'            => $postOffset,
        'posts_per_page'    => $postsPerPage,
    );
?>
    <div class="container">
        <div class="filters-project">
            <?php
            do_action('filters_tax_projects');
            ?>
        </div>
        <?php
        if (!empty($_GET['project_areas']) || !empty($_GET['field_activities'])) {
            $tax_query = array('relation' => 'AND');

            if (!empty($_GET['project_areas'])) {
                $selected_terms = is_array($_GET['project_areas']) ? $_GET['project_areas'] : array($_GET['project_areas']);
                $tax_query[] = array(
                    'taxonomy' => 'project_areas',
                    'field' => 'slug',
                    'terms' => $selected_terms,
                );
            }

            if (!empty($_GET['field_activities'])) {
                $selected_terms = is_array($_GET['field_activities']) ? $_GET['field_activities'] : array($_GET['field_activities']);
                $tax_query[] = array(
                    'taxonomy' => 'field_activities',
                    'field' => 'slug',
                    'terms' => $selected_terms,
                );
            }
            $args['tax_query'] = $tax_query;
        }
        ?>
        <div class="items-project">
            <?php
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
            ?>
        </div>
        <?php
        $next_page = $paged + 1;
        $max_pages = $query->max_num_pages;


        $count_posts = wp_count_posts('projects');
        $total_posts = $count_posts->publish;


        if ($next_page <= $max_pages) { ?>
            <div class="loadmore">
                <a id="loadmore-btn" class="load_more" data-nextpage="<?php echo $next_page; ?>" data-maxpages="<?php echo $max_pages; ?>">
                    <span> הצג עוד 6 מתוך <?= $total_posts ?></span>
                </a>
            </div>
        <?php  } else { ?>
            <style>
                .loadmore {
                    display: none !important;
                }
            </style>
        <?php  }   ?>
        <script>
            var offset = 0;
            var posts_per_page = 6;
            var next_page = 2;
            var post_type = 'projects';
            jQuery(function($) {
                $('#loadmore-btn').click(function() {
                    var button = $(this);
                    var next_page = button.data('nextpage');
                    var max_pages = button.data('maxpages');
                    $.ajax({
                        url: my_ajax_object.ajax_url,
                        type: 'POST',
                        data: {
                            action: 'loadmore',
                            offset: offset + posts_per_page,
                            posts_per_page: posts_per_page,
                            next_page: next_page,
                            post_type: post_type
                        },
                        beforeSend: function() {
                            $('#loadmore-btn').text('Loading...');
                        },
                        success: function(data) {
                            $('#loadmore-btn').text('Load More');
                            $('.items-project').append(data);
                            offset += posts_per_page;
                            next_page++;
                            if (next_page + 1 > max_pages) {
                                button.hide();
                            }
                        }
                    });
                });
            });
        </script>
    </div>
    <?php
    return $atts;
}













add_action('filters_tax_projects', 'functions_tax_projects');

function functions_tax_projects()
{
    echo get_projects_filter_form(array('project_areas', 'field_activities'));
}

function get_projects_filter_form($taxonomies = array())
{ 
    
    $form = '
    <button class="filter-toggle">פילטר</button>
    <div class="filter-search">
    <input type="search" placeholder="חיפוש" class="input-search">
    </div>
    <div class="filter-form"><form method="get" action="' . esc_url(get_permalink()) . '">
    <span class="filter-close"></span>
    <span class="form-title">סינון תוצאות לפי:</span>';

    foreach ($taxonomies as $taxonomy) {

        $current_terms = isset($_GET[$taxonomy]) ? (array) $_GET[$taxonomy] : array();
        $args = array(
            'taxonomy' => $taxonomy,
            'hide_empty' => false,
        );
        $terms = get_terms($args);
        if (!empty($terms) && !is_wp_error($terms)) {
            $form .= '<div class="select-wrapper">';
            $form .= '<div class="select-header-list rotate-down">';
            $form .= '<div class="select-title">' . esc_html(get_taxonomy($taxonomy)->labels->singular_name) . '</div>';
            $form .= '<div class="select-icon"></div>';
            $form .= '</div>';
            $form .= '<div class="select-droppdown open" >';
            $form .= '<ul>';
            foreach ($terms as $term) {
                $checked = '';
                $option_is_set = false;
                if (in_array($term->slug, $current_terms)) {
                    $checked = 'checked';
                    $option_is_set = true;
                }
                $form .= '<li class="' . ($option_is_set ? 'active' : '') . '">';

                $form .= '<label for="' . esc_attr($taxonomy . '_' . $term->slug) . '">';

                $form .= '<input type="checkbox" class="checkbox" name="' . esc_attr($taxonomy) . '[]" id="' . esc_attr($taxonomy . '_' . $term->slug) . '" value="' . esc_attr($term->slug) . '" ' . esc_attr($checked) . ' onchange="this.form.submit();">';
                $form .= '<span class="checkbox-label">' . esc_html($term->name) . '</span>';
                $form .= '</label>';
                $form .= '</li>';
            }
            $form .= '</ul>';
            $form .= '</div>';
            $form .= '</div>';
        }
    }

    $form .= '<input type="hidden" name="page_id" value="' . esc_attr(get_the_ID()) . '">';

    $form .= '</form></div>';

    return $form;
}



add_action('wp_ajax_nopriv_loadmore', 'loadmore_ajax_handler');
add_action('wp_ajax_loadmore', 'loadmore_ajax_handler');


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
