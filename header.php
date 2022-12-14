<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
    <title> <?php
            single_post_title();
            ?></title>
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
                            <a href="#!" class="header__profile-name">My Profile</a>
                        </div>
                    </div>
                    <div class="header-mobile header__mobile-icons">
                        <a href="#!" class="header-mobile__call">
                            <div class="header-mobile__icon mobile-call">
                            </div>
                        </a>
                        <a href="#!" class="header-mobile__person">
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
                                <div class="cart-num" id="">
                                    <?php echo $items_count ? $items_count : '0'; ?>
                                </div>
                            </div>

                        </a>
                        <div class="header-mobile__burger" id="burger-menu">
                            <a href="#!" class="header__logo-white">
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
                                                    <a href="#!" class="header-mobile-list-link nested">Categories knives </a>
                                                    <ul class="sub-menu level-3">
                                                        <li>
                                                            <a class="header-mobile-list-link" href="product-page.html">Product
                                                                Page</a>
                                                        </li>
                                                        <li>
                                                            <a class="header-mobile-list-link" href="product-page.html">Product
                                                                Page</a>
                                                        </li>
                                                        <li>
                                                            <a class="header-mobile-list-link" href="product-page.html">Product
                                                                Page</a>
                                                        </li>
                                                        <li>
                                                            <a class="header-mobile-list-link" href="product-page.html">Product
                                                                Page</a>
                                                        </li>
                                                        <li>
                                                            <a class="header-mobile-list-link" href="product-page.html">Product
                                                                Page</a>
                                                        </li>
                                                    </ul>
                                                </li>
                                                <li>
                                                    <a class="header-mobile-list-link" href="#!">Test Item 1</a>
                                                </li>
                                                <li>
                                                    <a class="header-mobile-list-link" href="#!">Test Item 2</a>
                                                </li>
                                                <li>
                                                    <a class="header-mobile-list-link" href="#!">Test Item 3</a>
                                                </li>
                                                <li>
                                                    <a class="header-mobile-list-link" href="#!">Test Item 4 </a>
                                                </li>
                                                <li>
                                                    <a class="header-mobile-list-link" href="#!">Test Item 5</a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li>
                                            <a href="#!" class="header-mobile-list-link nested">Featured Products</a>
                                            <ul class="sub-menu level-2">
                                                <li>
                                                    <a class="header-mobile-list-link" href="product-page.html">Test Item 1</a>
                                                </li>
                                                <li>
                                                    <a class="header-mobile-list-link" href="product-page.html">Test Item 2</a>
                                                </li>
                                                <li>
                                                    <a class="header-mobile-list-link" href="product-page.html">Test Item 3</a>
                                                </li>
                                                <li>
                                                    <a class="header-mobile-list-link" href="product-page.html">Test Item 4</a>
                                                </li>
                                                <li>
                                                    <a class="header-mobile-list-link" href="product-page.html">Test Item 5</a>
                                                </li>
                                                <li>
                                                    <a class="header-mobile-list-link" href="product-page.html">Test Item 6</a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li>
                                            <a href="#!" class="header-mobile-list-link nested">Company</a>
                                            <ul class="sub-menu level-2">
                                                <li>
                                                    <a class="header-mobile-list-link" href="shop.html">Shop</a>
                                                </li>
                                                <li>
                                                    <a class="header-mobile-list-link" href="shop.html">Shop</a>
                                                </li>
                                                <li>
                                                    <a href="#!" class="header-mobile-list-link nested">Information</a>
                                                    <ul class="sub-menu level-3">
                                                        <li>
                                                            <a class="header-mobile-list-link" href="shop.html">Shop Page</a>
                                                        </li>
                                                        <li>
                                                            <a class="header-mobile-list-link" href="shop.html">Shop Page</a>
                                                        </li>
                                                        <li>
                                                            <a class="header-mobile-list-link" href="shop.html">Shop Page</a>
                                                        </li>
                                                        <li>
                                                            <a class="header-mobile-list-link" href="shop.html">Shop Page</a>
                                                        </li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </li>
                                        <li>
                                            <a class="header-mobile-list-link" href="shop.html">Shop Page</a>
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
                            <!-- <img src="<?php echo _assets_paths('img/sprite.svg#logo'); ?>" alt="logo site"> -->
                            <?php the_custom_logo(); ?>
                        </a>
                        <div class="header__search-field">
                            <!-- <input type="text" name="search" class="input header__input" id="search" placeholder="Search..."> -->
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
                                        global $woocommerce;
                                        $cart = WC()->cart;
                                        echo $woocommerce->cart->cart_contents_count; ?>
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
                                    Checkout
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
                        <div class="header__menu-dropdown">
                            <div class="menu-item js-select" data-path="one">
                                Catalog Knifes
                            </div>

                            <div class="select-header__main " data-target="one">
                                <div class="select-header__column">
                                    <div class="select-header__column-title">
                                        Categories Knifes
                                    </div>
                                    <div class="select-header__column-list">
                                        <ul class="list-reset select-header__menu">
                                            <li class="select-header__item"><a class="select-header__link" href="#!">Cutting
                                                    knives</a></li>
                                            <li class="select-header__item"><a class="select-header__link" href="#!">Tourist
                                                    knives</a></li>
                                            <li class="select-header__item"><a class="select-header__link" href="#!">knives
                                                    hunting</a></li>
                                            <li class="select-header__item"><a class="select-header__link" href="#!">Best
                                                    knives</a></li>
                                            <li class="select-header__item"><a class="select-header__link" href="#!">knives from
                                                    Norway</a></li>
                                            <li class="select-header__item"><a class="select-header__link" href="#!">tactical
                                                    purpose</a>
                                            </li>
                                            <li class="select-header__item"><a class="select-header__link" href="#!">Throwing
                                                    knives</a></li>
                                            <li class="select-header__item"><a class="select-header__link" href="#!">Machetes
                                                </a></li>
                                            <li class="select-header__item"><a class="select-header__link" href="#!">knives
                                                    kitchen</a></li>
                                        </ul>
                                    </div>
                                    <div class="select-header__box">
                                        <a class="select-header__watch-all-link" href="shop.html">
                                            See all
                                        </a>
                                    </div>
                                </div>
                                <div class="select-header__column">
                                    <div class="select-header__column-title">
                                        Production knives
                                    </div>
                                    <div class="select-header__column-list">
                                        <ul class="list-reset select-header__menu">
                                            <li class="select-header__item"><a class="select-header__link" href="#!">knives
                                                    ASD</a></li>
                                            <li class="select-header__item"><a class="select-header__link" href="#!">knives
                                                    ADS</a></li>
                                            <li class="select-header__item"><a class="select-header__link" href="#!">knives
                                                    ASC</a></li>
                                            <li class="select-header__item"><a class="select-header__link" href="#!">knives
                                                    ??????</a></li>
                                            <li class="select-header__item"><a class="select-header__link" href="#!">knives from
                                                    DAS</a></li>
                                            <li class="select-header__item"><a class="select-header__link" href="#!">knives
                                                    ASASAC</a></li>
                                            <li class="select-header__item"><a class="select-header__link" href="#!">Bulat
                                                    Lorem</a></li>
                                            <li class="select-header__item"><a class="select-header__link" href="#!">Bulat
                                                    Lorem ipsum </a></li>
                                            <li class="select-header__item"><a class="select-header__link" href="#!">knives
                                                    DSWRFV</a></li>
                                            <li class="select-header__item"><a class="select-header__link" href="#!">knives
                                                    Style-??</a></li>
                                            <li class="select-header__item"><a class="select-header__link" href="#!">Lorem,
                                                    ipsum.</a></li>
                                        </ul>
                                    </div>
                                    <div class="select-header__box">
                                        <a class="select-header__watch-all-link" href="shop.html">
                                            See all
                                        </a>
                                    </div>
                                </div>
                                <div class="select-header__column">
                                    <div class="select-header__column-title">
                                        knives by brand steel
                                    </div>
                                    <div class="select-header__column-list">
                                        <ul class="list-reset select-header__menu">
                                            <li class="select-header__item"><a class="select-header__link" href="#!">knives from
                                                    steel 4??10</a></li>
                                            <li class="select-header__item"><a class="select-header__link" href="#!">knives from
                                                    steel 5??8</a></li>
                                            <li class="select-header__item"><a class="select-header__link" href="#!">knives from
                                                    steel 1X1</a></li>
                                            <li class="select-header__item"><a class="select-header__link" href="#!">knives from
                                                    steel 1??17723</a></li>
                                            <li class="select-header__item"><a class="select-header__link" href="#!">knives from
                                                    steel DZX-88 </a></li>
                                            <li class="select-header__item"><a class="select-header__link" href="#!">knives from
                                                    steel 777??42</a></li>
                                            <li class="select-header__item"><a class="select-header__link" href="#!">knives from
                                                    steel ASD4-542</a></li>
                                            <li class="select-header__item"><a class="select-header__link" href="#!">knives from
                                                    steel 3s3ws40 </a></li>
                                            <li class="select-header__item"><a class="select-header__link" href="#!">knives
                                                    d-DFA</a></li>
                                            <li class="select-header__item"><a class="select-header__link" href="#!">knives from
                                                    steel 45E3</a></li>
                                        </ul>
                                    </div>
                                    <div class="select-header__box">
                                        <a class="select-header__watch-all-link" href="shop.html">
                                            See all
                                        </a>
                                    </div>
                                </div>
                                <div class="select-header__column">
                                    <div class="select-header__column-title">
                                        Sharpening and polishing knives
                                    </div>
                                    <div class="select-header__column-list">
                                        <ul class="list-reset select-header__menu">
                                            <li class="select-header__item"><a class="select-header__link" href="#!">Paste
                                                    DD</a></li>
                                            <li class="select-header__item"><a class="select-header__link" href="#!">Diamond
                                                    metal</a></li>
                                            <li class="select-header__item"><a class="select-header__link" href="#!">Lorem,
                                                    ipsum dolor.</a></li>
                                            <li class="select-header__item"><a class="select-header__link" href="#!">Sharpening
                                                    systems</a></li>
                                        </ul>
                                    </div>
                                    <div class="select-header__box">
                                        <a class="select-header__watch-all-link" href="shop.html">
                                            See all
                                        </a>
                                    </div>
                                </div>
                                <div class="select-header__column">
                                    <div class="select-header__column-title">
                                        Knife workshop
                                    </div>
                                    <div class="select-header__column-list">
                                        <ul class="list-reset select-header__menu">
                                            <li class="select-header__item"><a class="select-header__link" href="#!">Knife
                                                    selected</a></li>
                                            <li class="select-header__item"><a class="select-header__link" href="#!">Blanks
                                                    for knives</a>
                                            </li>
                                            <li class="select-header__item"><a class="select-header__link" href="#!">Casting
                                                    for knives</a></li>
                                            <li class="select-header__item"><a class="select-header__link" href="#!">Materials
                                                    for handles</a>
                                            </li>
                                            <li class="select-header__item"><a class="select-header__link" href="#!">Care
                                                    handles </a></li>
                                        </ul>
                                    </div>
                                    <div class="select-header__box">
                                        <a class="select-header__watch-all-link" href="shop.html">
                                            See all
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="header__menu-dropdown">
                            <div class="menu-item js-select" data-path="two">
                                Blade Weapon
                            </div>
                            <div class="select-header__main" data-target="two">
                                <div class="select-header__column">
                                    <div class="select-header__column-title">
                                        Category knives
                                    </div>
                                    <div class="select-header__column-list">
                                        <ul class="list-reset select-header__menu">
                                            <li class="select-header__item"><a class="select-header__link" href="#!">Cutting
                                                    knives</a></li>
                                            <li class="select-header__item"><a class="select-header__link" href="#!">Tourist
                                                    knives</a></li>
                                            <li class="select-header__item"><a class="select-header__link" href="#!">knives
                                                    hunting</a></li>
                                            <li class="select-header__item"><a class="select-header__link" href="#!">Damask
                                                    knives</a></li>
                                            <li class="select-header__item"><a class="select-header__link" href="#!">knives from
                                                    Norway</a></li>
                                            <li class="select-header__item"><a class="select-header__link" href="#!">tactical
                                                    purpose</a>
                                            </li>
                                            <li class="select-header__item"><a class="select-header__link" href="#!">Throwing
                                                    knives</a></li>
                                            <li class="select-header__item"><a class="select-header__link" href="#!">Machete
                                                    and kukri</a></li>
                                            <li class="select-header__item"><a class="select-header__link" href="#!">knives
                                                    kitchen</a></li>
                                        </ul>
                                    </div>
                                    <div class="select-header__box">
                                        <a class="select-header__watch-all-link" href="shop.html">
                                            See all
                                        </a>
                                    </div>
                                </div>


                            </div>
                        </div>


                        <div class="menu-item js-select">Souvenirs</div>
                        <div class="menu-item js-select">Flashlights DS3DS</div>
                        <div class="menu-item js-select">Related products</div>
                    </div>


                </div>
            </div>
            <!-- Thirds Line -->


            <div class="cart-products">
                <div class="cart-content" id="mini-cart-all-items">
                    <?php
                    global $woocommerce;
                    $customSubTotal = 0;
                    $is_on_sale = [];
                    $items = $woocommerce->cart->get_cart();
                    if (!empty($items)) {
                        foreach ($items as $item => $values) {
                            $_productMiniCart = wc_get_product($values['data']->get_id());
                            $product_id = $values['product_id'];
                            $image_url = wp_get_attachment_image_src(get_post_thumbnail_id($product_id), '');
                            $productImage = $image_url[0];
                            $check_type =  $_productMiniCart->get_type();
                            $prodPrice = 0;
                            $quantity = $values['quantity'];
                            $thumbnail = apply_filters('woocommerce_cart_item_thumbnail', $_productMiniCart->get_image(), $values, $item);
                            if (!empty($_productMiniCart->get_sale_price())) {
                                $prodPrice = ceil($_productMiniCart->get_sale_price());
                            } else {
                                $prodPrice = ceil($_productMiniCart->get_regular_price());
                            }
                            $lineSubtotal = $prodPrice * $quantity;
                            $customSubTotal += $lineSubtotal;

                            if ($_productMiniCart->is_on_sale()) {
                                array_push($is_on_sale, 1);
                            }
                    ?>
                            <div class="card-item">
                                <div class="card-img">
                                    <?php echo $thumbnail; ?>
                                </div>
                                <div class="card-info">
                                    <a class="card-info__title" href="<?php echo the_permalink($product_id); ?>">
                                        <?php
                                        echo $_productMiniCart->get_title();
                                        ?>
                                    </a>
                                </div>
                                <div class="card-price">
                                    <?php
                                    echo $_productMiniCart->get_price_html();
                                    ?>
                                </div>

                                <div class="card-quantity js-quantity">
                                    <button class="icon icon-minus js-quantity-minus">-</button>
                                    <input class="card-input js-quantity-input" type="text" value="<?php echo $quantity; ?>">
                                    <button class="icon icon-plus js-quantity-plus">+</button>
                                </div>
                                <?php
                                echo apply_filters('woocommerce_cart_item_remove_link', sprintf(
                                    '<a href="%s" aria-label="%s" data-product_id="%s" data-cart_item_key="%s" data-product_sku="%s">X</a>',
                                    esc_url(wc_get_cart_remove_url($item)),
                                    esc_attr__('Remove this item', 'woocommerce'),
                                    esc_attr($product_id),
                                    esc_attr($item),
                                    esc_attr($_productMiniCart->get_sku()),
                                ), $item);
                                ?>
                            </div>
                        <?php
                        }
                        ?>

                    <?php
                    } else {
                    ?>
                        <h2 class="cart-title"> Empty Cart</h2>
                        <p class="cart-message">
                            You dont have any products
                        </p>
                    <?php
                    }
                    ?>
                </div>
                <?php
                if (!empty($items)) {
                ?>
                    <div class="cart-price">
                        <div class="total-price-description">
                            Total Price
                        </div>
                        <span class="cart-subtotal" id="mini-cart-subtotal">
                            <?php
                            echo wc_price(WC()->cart->subtotal_ex_tax)
                            ?>
                        </span>
                    </div>
                <?php
                }
                ?>

            </div>
        </header>