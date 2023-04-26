<?php

add_action('wp_ajax_nopriv_loadmore_shop', 'loadmore_shop');
add_action('wp_ajax_loadmore_shop', 'loadmore_shop');



function loadmore_shop()
{
    // $posts_per_page = $_POST['posts_per_page'];
    // $offset = $_POST['offset'];
    // $post_type = $_POST['post_type'];
    // $current_page = $_POST['current_page'];

    // $args = array(
    //     'post_type' => $post_type,
    //     'offset' => $offset,
    //     'posts_per_page' => $posts_per_page,
    // );
    // $query = new WP_Query($args);

    // if ($query->have_posts()) {
    //     foreach ($query->posts as $post) {
    //         setup_postdata($post);
    //         wc_get_template_part('content', 'product');
    //     }
    //     wp_reset_postdata();
    // }
    $paged = $_POST['paged'];
    $posts_per_page = $_POST['posts_per_page'];
    $offset = ($paged - 1) * $posts_per_page;
    $args = array(
        'post_type' => 'product',
        'posts_per_page' => $posts_per_page,
        'offset' => $offset,
        'paged' => $paged
    );
    $query = new WP_Query($args);
    if ($query->have_posts()) :
        while ($query->have_posts()) : $query->the_post();
            wc_get_template_part('content', 'product');
        endwhile;
    endif;
    wp_die();
}
