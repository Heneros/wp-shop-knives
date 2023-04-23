<?php

add_action('wp_ajax_nopriv_loadmore_shop', 'loadmore_shop');
add_action('wp_ajax_loadmore_shop', 'loadmore_shop');



function loadmore_shop()
{
    $posts_per_page = $_POST['posts_per_page'];
    $offset = $_POST['offset'];
    $post_type = $_POST['post_type'];

    $args = array(
        'post_type' => $post_type,
        'offset' => $offset,
        'posts_per_page' => $posts_per_page,
    );
    $query = new WP_Query($args);

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            wc_get_template_part('content', 'product');
        }
    }
}
