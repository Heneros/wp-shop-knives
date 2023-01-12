<section class="banners">
    <div class="container">
        <?php
   
     
 
        $banner_items =  get_field('banner_items');
 
        if (have_rows('banner_items')) :
        ?>
            <div class="banners-items">
                <?php
                while (have_rows('banner_items')) :
                    the_row();
                    $link = get_sub_field('link');
                    $bgImg = get_sub_field('bg-image');
                    $description = get_sub_field('description');
                    $title = get_sub_field('title');
                ?>
                    <div class="banner-item" data-aos="fade-up">
                        <div class="banner-item__adaptive">
                            <a href="<?php echo $link; ?>" class="btn adaptive-read-more">
                                Read More
                            </a>
                        </div>
                        <div class="banner-bg-img" style="background: url('<?php echo esc_url($bgImg['url']); ?>') no-repeat;"></div>
                        <div class="banner-bg-adaptive">
                            <img src="<?php echo esc_url($bgImg['url']); ?>" alt="<?php echo esc_attr($bgImg['alt']); ?>">
                        </div>
                        <div class="banner-text">
                            <h2>
                                <a href="<?php echo $link; ?>" class="banner-title">
                                <?php echo $title; ?>
                                </a>
                            </h2>
                            <div class="banner-description">
                            <?php echo $description; ?>
                            </div>
                            <a href="<?php echo $link; ?>" class="read-more btn">
                                Read More
                            </a>
                        </div>
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