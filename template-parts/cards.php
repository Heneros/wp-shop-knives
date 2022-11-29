<section class="cards">
    <div class="container">
        <?php if (have_rows('cards_items')) : ?>
            <div class="cards-items">
                <?php while (have_rows('cards_items')) :
                    the_row();
                    $link = get_sub_field('link');
                    $title = get_sub_field('title');
                    $image = get_sub_field('image');
                ?>
                    <a data-aos="fade-down" href="<?php echo $link; ?>" class="cards-item card-item">
                        <div class="cards-item__text">
                            <h4 class="cards-item__title"><?php echo $title; ?></h4>
                            <?php if (have_rows('lists_inside_cards')) : ?>
                                <ul class="cards-item__list list-reset">
                                    <?php while (have_rows('lists_inside_cards')) :
                                        the_row();
                                        $item_list = get_sub_field('item_list');
                                    ?>
                                        <li class="cards-item__li"><?php echo $item_list; ?></li>
                                    <?php endwhile; ?>
                                </ul>
                            <?php endif; ?>
                        </div>
                        <div class="cards-item__img">
                            <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>">
                        </div>
                    </a>
                <?php endwhile; ?>
            </div>
        <?php endif; ?>
    </div>
</section>