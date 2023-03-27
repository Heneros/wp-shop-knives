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
     (function($) {
         $(document).on('click', '.clear_wishlist', function(e) {
             e.preventDefault();

             $.ajax({
                 url: woocommerce_params.ajax_url,
                 method: 'POST',
                 data: {
                     clear_wishlist: true,
                     action: 'clear_wishlist'
                 },
                 beforeSend: function() {},
                 success: function(data) {
                     var res = JSON.parse(data);

                     $('.clear_wishlist').hide();
                 }
             })
         });
     })(jQuery);
 </script>
 <div class="container ">
     <h1 class="title"><?php the_title(); ?></h1>
     <span>Found in wishlist: <?php echo $recent_prods->found_posts ?></span>
     <br>
     <?php if ($recent_prods->found_posts > 0) : ?>

         <a class="clear_wishlist" href="javascript: void(0)">Remove All Product from list</a>
     <?php endif; ?>
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