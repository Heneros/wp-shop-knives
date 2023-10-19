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
 <script>

 </script>
 <section class="wishlist  margin-top">
     <div class="container ">
         <h1 class="title"><?php the_title(); ?></h1>
         <?php woocommerce_breadcrumb(); ?>
         <span>Found in wishlist: <b class="count_wishlist"> <?php echo $recent_prods->found_posts ?></b></span>
         <br>
         <?php if ($recent_prods->found_posts > 0) : ?>
             <a class="clear_wishlist" href="javascript: void(0)">Remove All Product from list</a>
         <?php endif; ?>
         <div class="shop-catalog__products wishlist_products">
             <?php
                if ($recent_prods->have_posts()) :
                    while ($recent_prods->have_posts()) :
                        $recent_prods->the_post();
                        wc_get_template_part('content', 'product');
                    endwhile;
                endif;
                wp_reset_postdata();
                ?>
         </div>
     </div>
 </section>
 <?php

    get_footer();

    ?>