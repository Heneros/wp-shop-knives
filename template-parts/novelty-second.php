<section class="novelty">
    <div class="container">
        <div class="novelty-blocks">
            <div class="novelty-text" data-aos="fade-up" data-aos-offset="-500">
                <h1 class="novelty-title title"><?php echo get_field('title_novelty_homepage', $page_id); ?></h1>
                <p class="novelty-description">
                    <?php echo get_field('description_novelty_homepage', $page_id); ?>
                </p>
                <div class="novelty-link">
                    <a href="<?php echo site_url('/shop'); ?>" class="novelty-watch-more">
                        Watch more
                    </a>
                </div>
            </div>
            <?php
            $args = [
                'post_type' => 'product',
                'posts_per_page' => 12,
                'orderby' => 'rand'
            ];
            $loop = new WP_Query($args);
            if ($loop->have_posts()) :

            ?>
                <div class="novelty-slider swiper" data-aos="fade-up" data-aos-offset="-500">
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
                    <div class="swiper-pagination novelty__pagination"></div>
                </div>
            <?php
            endif;
            ?>
        </div>
    </div>
</section>