<?php

$args = [
    'post_type' => 'post',
    'posts_per_page' => 4
];
$query = new WP_Query($args);
?>
<section class="articles" data-aos="fade-up" data-aos-offset="-500">
    <div class="container">
        <h1 class="title">Our Articles</h1>
        <?php
        if ($query->have_posts()) :
        ?>
            <div class="articles-items">
                <?php
                while ($query->have_posts()) :
                    $query->the_post(); ?>
                    <div class="article-item">
                        <a href="<?php echo get_permalink(); ?>">
                            <div class="article-bg-img">
                                <!-- <img src="img/article-img.png" alt="article img">
                                 -->
                                <?php
                                the_post_thumbnail();
                                ?>
                            </div>
                            <div class="article-text">
                                <a href="<?php echo get_permalink(); ?>" class="article-title"><?php the_title(); ?></a>
                                <!-- <div class="article-date">14.06.2022</div> -->
                                <?php
                                $current_date = get_the_date('d-m-Y');
                                $newString = str_replace('-', '.', $current_date);
                                ?>
                                <div class="article-date"><?php echo $newString; ?></div>
                            </div>
                        </a>
                    </div>

                <?php
                endwhile;
                ?>
            </div>
        <?php
        endif;
        wp_reset_postdata();
        ?>
    </div>
</section>