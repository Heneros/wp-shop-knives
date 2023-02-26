<?php
wp_footer();

?>

<footer class="footer">
    <div class="container">
        <div class="footer-items">
            <div class="footer-item">
                <span class="footer-item__title">
                    Information:
                </span>
                <?php
                wp_nav_menu([
                    'theme_location' => 'menu-footer-information',
                    'container' => 'ul',
                    'add_li_class' => 'footer-item__li',
                    'menu_class' => 'footer-list list-reset'
                ]);
                ?>
            </div>
            <div class="footer-item">
                <span class="footer-item__title">
                    Support Team:
                </span>
                <?php
                wp_nav_menu([
                    'theme_location' => 'menu-footer-support',
                    'container' => 'ul',
                    'add_li_class' => 'footer-item__li',
                    'menu_class' => 'footer-list list-reset'
                ]);
                ?>
            </div>
            <div class="footer-item">
                <span class="footer-item__title">
                    Additional:
                </span>
                <?php
                wp_nav_menu([
                    'theme_location' => 'menu-footer-additional',
                    'container' => 'ul',
                    'add_li_class' => 'footer-item__li',
                    'menu_class' => 'footer-list list-reset'
                ]);
                ?>
            </div>
            <div class="footer-item">
                <span class="footer-item__title">
                    Personal Cabinet:
                </span>
                <?php
                wp_nav_menu([
                    'theme_location' => 'menu-footer-personal',
                    'container' => 'ul',
                    'add_li_class' => 'footer-item__li',
                    'menu_class' => 'footer-list list-reset'
                ]);
                ?>
            </div>
        </div>
        <!---Second row items-->
        <div class="footer-items footer-second-row">
            <div class="footer-item">
                <span class="footer-item__title">
                    Contacts:
                </span>
                <?php
                $phone_num = get_field('contact_phone_footer', 'option');
                $contact_time_working_footer = get_field('contact_time_working_footer', 'option');
                $contact_city_footer = get_field('contact_city_footer', 'option');
                $contact_email_footer = get_field('contact_email_footer', 'option');

                $phone_num_new  = str_replace('-', '', $phone_num);
                ?>
                <ul class="footer-list list-reset footer-list-contact">
                    <li class="footer-item__li call"><a href="tel:<?php echo $phone_num_new; ?>"><?php echo $phone_num; ?></a></li>
                    <li class="footer-item__li time"><?php echo $contact_time_working_footer; ?></li>
                    <li class="footer-item__li location"><?php echo $contact_city_footer; ?></li>
                    <li class="footer-item__li mail"><a href="mailto:<?php echo $contact_email_footer; ?>"><?php echo $contact_email_footer; ?></a></li>
                </ul>
                <?php if (have_rows('social_links', 'option')) : ?>
                    <ul class="footer-item__icons list-reset">
                        <?php while (have_rows('social_links', 'option')) :
                            the_row();
                            $icon = get_sub_field('icon');
                            $link = get_sub_field('link');
                        ?>
                            <li><a href="<?php echo $link; ?>">
                                    <img src="<?php echo esc_url($icon['url']);  ?>" alt="<?php echo esc_attr($icon['alt']);  ?>">
                                </a></li>
                        <?php endwhile; ?>
                    </ul>
                <?php endif; ?>
            </div>
            <div class="footer-item">
                <span class="footer-item__title">
                    Useful Links:
                </span>
                <ul class="footer-list list-reset">
                    <li class="footer-item__li"><a href="#!">Payment and delivery methods</a></li>
                </ul>
            </div>
            <div class="footer-item">
                <span class="footer-item__title">
                    Our Guarantee:
                </span>
                <?php
                echo get_field('our_guarantee_text', 'option');
                ?>
            </div>
            <div class="footer-item">
                <span class="footer-item__title">
                    NEWSLETTER:
                </span>
                <p>Lorem, ipsum dolor.</p>
                <?php
                echo do_shortcode('[contact-form-7 id="159" title="Subscribe email form"]');
                ?>
            </div>
        </div>
        <div class="author-code">
            <span> Write code:</span>
            <a href="https://github.com/heneros" target="_blank">
                Heneros
            </a>
        </div>
    </div>
</footer>