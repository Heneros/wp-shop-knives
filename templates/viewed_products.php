<?php

/**
 * Template Name: Viewed Products
 */

get_header();



$prods = array();
if (isset($_COOKIE['watched_products'])) {
    $prods = json_decode(stripslashes($_COOKIE['watched_products']), true);
    if (!$prods) {
        $prods = array();
    }
}

$args = array(
    'posts_per_page' => -1,
    'post_type'      => 'product',
    'post__in' => (!empty($prods) ? array_keys($prods) : array(-1)),
    'orderby'        => 'post__in'
);

$query = new WP_Query($args);

if ($query->have_posts()) :
?>
    <section class="recently-viewed margin-top">
        <div class="container">
            <h1 class="title">Recently watched products</h1>
            <?php woocommerce_breadcrumb(); ?>
            <div class="shop-catalog__products">
                <?php while ($query->have_posts()) : $query->the_post(); ?>
                    <?php wc_get_template_part('content', 'product'); ?>
                <?php endwhile; ?>
            </div>
        </div>
    </section>
<?php else : ?>
    <p>No products found in cookie.</p>
<?php endif;
wp_reset_postdata();
get_footer();
?>