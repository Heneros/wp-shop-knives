<?php

/**
 * 
 * Template Name: Wishlist
 * 
 */
$prods = [];

if (isset($_SESSION['wishlist'])) {
    $prods = $_SESSION['wishlist'];
}

$args = [
    'posts_per_page' => -1,
    'post_type' => 'product',
    'post__in' => ((!isset($prods) || empty($prods)) ? array(-1) : $prods)
];
$recent_prods = new WP_Query($args);
get_header();

?>

<div class="products-wishlist">

    <?php
    echo session_id(); 
    if ($recent_prods->have_posts()) :

        while ($recent_prods->have_posts()) :
            $recent_prods->the_post();
            wc_get_template_part('content', 'product');
            wp_reset_postdata();
        endwhile;
    endif; ?>
</div>

<?php

get_footer();

?>