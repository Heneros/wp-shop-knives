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

<div class="container ">
    <h1 class="title"><?php the_title(); ?></h1> 
    <a href="#!">Remove All Product from list</a>
    <div class="shop-catalog__products">
        <?php
        if ($recent_prods->have_posts()) :
            while ($recent_prods->have_posts()) :
                $recent_prods->the_post();
                wc_get_template_part('content', 'product');
                wp_reset_postdata();
            endwhile;
        endif; ?>
    </div>
</div>
<?php

get_footer();

?>