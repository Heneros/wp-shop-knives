<section class="bestsellers" data-aos="fade-up" data-aos-offset="-500">
    <div class="container">
        <div class="text-above">
            <h1 class="title">Promotions</h1>
            <a href="shop.html" class="catalog">
                Go to catalog
            </a>
        </div>
        <?php
        $args = [
            'post_type' => 'product',
            'posts_per_page' => 12,
            'order'=> 'DESC'
        ];
        $loop = new WP_Query($args);
        if ($loop->have_posts()) :
        ?>
            <div class="bestsellers-products bestsellers-products-swiper swiper">
                <div class="swiper-wrapper">
                    <?php
                    while ($loop->have_posts()) :
                        $loop->the_post();
                    ?>
                        <div class="swiper-slide">
                            <?php
                            wc_get_template_part('content', 'product');
                            ?>
                        </div>
                    <?php
                    endwhile;
                    ?>
                </div>
                <div class="bestsellers-products__pagination swiper-pagination"></div>
            </div>
        <?php endif;
                     wp_reset_postdata();
        ?>
        <div class="text-above-adaptive">
            <a href="shop.html" class="catalog">
                Go to catalog
            </a>
        </div>
    </div>
</section>