<section class="slider-homepage">
    <div class="container">
        <div class="slider-homepage__block">
            <?php
            if (have_rows('homepage_slider_items')) :
            ?>
                <div class="slider-homepage__swiper swiper">
                    <div class="swiper-wrapper">
                        <?php
                        while (have_rows('homepage_slider_items')) :
                            the_row();
                            $title = get_sub_field('title');
                            $description = get_sub_field('description');
                            $link = get_sub_field('link');
                        ?>
                            <div class="swiper-slide">
                                <div class="slider-homepage__text-content">
                                    <h1 data-aos="fade-down" class="slider-homepage__title">
                                        <?php echo $title; ?>
                                    </h1>
                                    <p data-aos="fade-down" class="slider-homepage__descr">
                                        <?php echo $description; ?>
                                    </p>
                                    <a href="<?php echo $link; ?>" data-aos="fade-down" class="slider-homepage__btn btn">Подробнее</a>
                                </div>
                            </div>
                        <?php
                        endwhile;
                        ?>
                    </div>
                    <div class="slider-homepage__navigation">
                        <div class="slider-homepage__pagination swiper-pagination"></div>
                        <div class="slider-homepage__scrollbar swiper-scrollbar"></div>
                    </div>
                </div>
            <?php
            endif;
            $homepage_main_image = get_field('homepage_main_image');
            ?>
            <div class="slider-homepage__product-image">
                <div class="slider-homepage__product-block">
                    <div class="slider-homepage__plus-one"></div>
                    <div class="slider-homepage__plus-two"></div>
                    <div class="slider-homepage__plus-three"></div>
                    <img src="<?php echo esc_url($homepage_main_image['url']); ?>" alt="<?php echo esc_attr($homepage_main_image['alt']); ?>">
                </div>
            </div>

        </div>
        <?php
        if (have_rows('icons_homepage')) :
        ?>
            <div data-aos="fade-up" class="slider-homepage__icons">
                <?php
                while (have_rows('icons_homepage')) :
                    the_row();
                    $icon = get_sub_field('icon');
                    $title = get_sub_field('title');
                ?>
                    <div class="slider-homepage__icon">
                        <div class="slider-homepage__icon-block">
                            <img src="<?php echo esc_url($icon['url']); ?>" alt="<?php echo esc_attr($icon['alt']); ?>">
                        </div>
                        <span><?php
                                echo $title;
                                ?></span>
                    </div>
                <?php
                endwhile;
                ?>
            </div>
        <?php
        endif;
        ?>
    </div>
</section>