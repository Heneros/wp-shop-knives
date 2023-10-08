<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="<?php echo _assets_paths('/img/favicon.ico'); ?>" type="image/x-icon">
    <!-- <title> <?php
                    // single_post_title();
                    ?></title> -->
    <title><?php wp_title('|', true, 'right'); ?></title>

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

    <div class="site-container">
        <!-- <div class="loader-screen">
            <div class="ball-rotate">
                <div></div>
            </div>
        </div> -->
        <div class="main-wrapperOverflow"></div>
        <!-- <header data-aos="fade-down" class="header page-header" id="myHeader"> -->
        <header class="header page-header" id="myHeader">

            <div class="header__first-line">
                <div class="header__container grid container grid-mobile">

                    <div class="header__left">
                        <?php
                        wp_nav_menu([
                            'theme_location' => 'menu-header-first',
                            'add_li_class' => 'nav__item',
                            'link_class' => 'nav__link',
                            'menu_class' => 'nav__list list-reset',
                            'container' => 'nav'
                        ]);
                        ?>
                    </div>
                    <div class="header__right">
                        <div class="header__profile">
                            <a href="<?php echo site_url('/my-account'); ?>" class="header__profile-name">My Profile</a>
                        </div>
                    </div>
                    <div class="header-mobile header__mobile-icons">
                        <a href="#!" class="header-mobile__call">
                            <div class="header-mobile__icon mobile-call">
                            </div>
                        </a>
                        <a href="<?= site_url('/my-account'); ?>" class="header-mobile__person">
                        </a>
                        <a href="<?php echo site_url('/wishlist'); ?>" class="header-mobile__favorites">
                            <div class="header-mobile__icon mobile-favorites">
                            </div>
                        </a>
                        <?php
                        global $woocommerce;
                        $cart = WC()->cart;
                        $items_count = WC()->cart->get_cart_contents_count();
                        ?>
                        <a href="#!" class="header__cart-link ">
                            <div class="header-mobile__icon header__cart-svg header-mobile__cart js-open-cart">
                                <div class="cart-num" id="mini-cart-count-mob">
                                    <?php
                                    echo $items_count ? $items_count : '0';
                                    ?>
                                </div>
                            </div>
                        </a>
                        <div class="header-mobile__burger" id="burger-menu">
                            <a href="<?= site_url('/'); ?>" class="header__logo-white">
                                <?php echo _assets_paths('img/sprite.svg#logo-white'); ?>
                            </a>
                            <button type="button" class="hamburger burger-icon">
                                <span class="hamburger-bar"></span>
                            </button>
                            <div class="menu-wrapper">
                                <div class="list-wrapper">
                                    <ul class="menu level-1">
                                        <li>
                                            <a href="#!" class="header-mobile-list-link nested">Personal Cabinet </a>
                                            <ul class="sub-menu level-2">
                                                <li>
                                                    <!-- <a href="#!" class="header-mobile-list-link nested">Categories knives </a> -->
                                                    <ul class="sub-menu level-3">
                                                        <li>
                                                            <a class="header-mobile-list-link" href="product-page.html">Product
                                                                Page</a>
                                                        </li>
                                                    </ul>
                                                </li>
                                                <?php
                                                wp_nav_menu([
                                                    'theme_location' => 'menu-footer-personal',
                                                    'container' => 'ul',
                                                    'add_li_class' => 'footer-item__li',
                                                    'menu_class' => 'footer-list list-reset'
                                                ]);
                                                ?>
                                            </ul>
                                        </li>
                                        <li>
                                            <a href="#!" class="header-mobile-list-link nested">Featured Products</a>

                                            <ul class="sub-menu level-2">
                                                <!-- <li>
                                                    <a class="header-mobile-list-link" href="product-page.html">Test Item 1</a>
                                                </li> -->
                                                <?php
                                                wp_nav_menu([
                                                    'theme_location' => 'featured-product',
                                                    'container' => 'ul',
                                                    'add_li_class' => 'footer-item__li',
                                                    'menu_class' => 'footer-list list-reset'
                                                ]);
                                                ?>
                                            </ul>
                                        </li>
                                        <li>
                                            <a class="header-mobile-list-link" href="<?= site_url('/shop'); ?>">Shop Page</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="list-wrapper">
                                    <button type="button" class="back-one-level">
                                        <span>Back</span>
                                    </button>
                                    <div class="sub-menu-wrapper"></div>
                                </div>
                                <div class="list-wrapper">
                                    <button type="button" class="back-one-level">
                                        <span>Back</span>
                                    </button>
                                    <div class="sub-menu-wrapper"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!---Burger Mobile -->
                </div>
            </div><!-- First Line -->

            <!-- Second Line -->
            <div class="header__second-line">
                <div class="header__container container grid grid-mobile">
                    <div class="header__left-second">
                        <a href="<?php echo home_url('/'); ?>" class="logo header__logo ">

                            <span> Logo</span>
                        </a>
                        <div class="header__search-field">
                            <?php echo do_shortcode('[fibosearch]'); ?>
                        </div>
                    </div>
                    <div class="header__right-second">
                        <div class="header__location">
                            <span class="icon icon-location">
                                <img src="<?php echo _assets_paths("img/sprite.svg#location"); ?>" alt="icon location">
                            </span>
                            <a href="#!" class="header__name-location location">
                                Kharkiv
                            </a>
                        </div>
                        <div class="header__order-call">
                            <a class="header__order-num" href="tel:123-543-66-552">123-543-66-552</a>
                            <p class="header__order-text">Request a call </p>
                        </div>
                        <div class="header__cart-block">
                            <a href="<?php echo site_url('/wishlist'); ?>" class="header__favorites">
                            </a>
                            <a href="#!" class="header__cart-link js-open-cart">
                                <div class="header__cart-svg">
                                    <div class="cart-num" id="mini-cart-count">
                                        <?php
                                        echo WC()->cart->get_cart_contents_count();

                                        ?>
                                    </div>
                                </div>
                            </a>
                            <p class="header__text-cart">
                                <span class="text-cart-price" id="checkout-total-price">
                                    <?php
                                    echo WC()->cart->get_total();
                                    ?>
                                </span>
                                <span class="text-cart-order">
                                    <a href="<?php echo site_url('/checkout'); ?>">
                                        Checkout
                                    </a>
                                </span>
                            </p>


                        </div>
                    </div>
                </div>
            </div>
            <!-- Second Line -->
            <!-- Thirds Line -->
            <div class="header__third-line">
                <div class="header__container container ">
                    <div class="header__menu-main select-header">
                        <?php
                        $terms = get_terms([
                            'taxonomy' => 'product_cat',
                        ]);
                        $i = 0;
                        $parent_categories = [];
                        $child_categories = [];

                        if (!empty($terms)) {
                            foreach ($terms as $term) {
                                if ($term->parent === 0) {
                                    $parent_categories[] = $term;
                                } else {
                                    $child_categories[] = $term;
                                }
                            }
                        }
                        if (!empty($parent_categories)) :
                            foreach ($parent_categories as $term) :
                                $i++;
                        ?>
                                <div class="header__menu-dropdown">
                                    <div class="menu-item js-select" data-path="data-<?= $i ?>"><?= $term->name; ?></div>
                                    <?php
                                    $args_child = [
                                        'taxonomy' => 'product_cat',
                                        'parent' => $term->term_id
                                    ];
                                    $children = get_categories($args_child);
                                    if (!empty($children)) :
                                    ?>
                                        <div class="select-header__main" data-target="data-<?= $i; ?>">
                                            <?php
                                            if (!empty($children)) :
                                                foreach ($children as $child) :
                                            ?> <div class="select-header__column">
                                                        <div class="select-header__column-title">
                                                            <?= $child->name; ?>
                                                        </div>
                                                        <div class="select-header__column-list">
                                                            <ul class="list-reset select-header__menu">
                                                                <?php
                                                                $args_products = [
                                                                    'post_type' => 'product',
                                                                    'posts_per_page' => -1,
                                                                    'product_cat' => $child->slug
                                                                ];
                                                                $products = new WP_Query($args_products);
                                                                if ($products->have_posts()) :
                                                                    while ($products->have_posts()) :
                                                                        $products->the_post();
                                                                ?>
                                                                        <li class="select-header__item">
                                                                            <a class="select-header__link" href="<?= get_the_permalink(); ?>">
                                                                                <?= get_the_title(); ?>
                                                                            </a>
                                                                        </li>
                                                                <?php
                                                                    endwhile;
                                                                    wp_reset_postdata();
                                                                endif;
                                                                ?>
                                                            </ul>
                                                        </div>
                                                    </div>
                                            <?php
                                                endforeach;
                                            endif;
                                            ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                        <?php
                            endforeach;
                        endif; ?>
                    </div>
                </div>
            </div>
            <!-- Thirds Line -->
            <div class="cart-products">
                <div class="cart-content" id="mini-cart-all-items">
                    <?php
                    woocommerce_mini_cart();
                    ?>
                </div>
                <div class="cart-header">
                    <a href="<?php echo site_url('/cart'); ?>">
                        Go To Cart
                    </a>
                </div>
                <div class="cart-price">
                    <div class="total-price-description">
                        Total Price
                    </div>
                    <span class="cart-subtotal" id="mini-cart-subtotal">
                        <?php
                        echo WC()->cart->get_total();
                        ?>
                    </span>
                    <br>

                </div>


            </div>
        </header>