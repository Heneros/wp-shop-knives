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
                                <!-- <div class="cart-num" id="mini-cart-count"> -->
                                <div class="cart-num" id="mini-cart-count-mob">
                                    <?php
                                    echo $items_count ? $items_count : '0';
                                    ?>
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
                                        // $cart_items = WC()->cart->get_cart();
                                        // $product_count = 0;
                                        // $added_items = array();
                                        // foreach ($cart_items as $cart_item_key => $cart_item) {
                                        //     $product_id = $cart_item['product_id'];
                                        //     if (in_array($product_id, $added_items)) {
                                        //         continue;
                                        //     }
                                        //     $product_count += $cart_item['quantity'];
                                        //     $added_items[] = $product_id;
                                        // }
                                        // echo esc_html($product_count);
                                        // echo count(WC()->cart->get_cart());
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
                                            <div class="select-header__column">
                                                <div class="select-header__column-title">
                                                    <?php
                                                    if (!empty($children)) {
                                                        foreach ($children as $child) {
                                                            echo $child->name;
                                                        }
                                                    }
                                                    ?>
                                                </div>
                                                <div class="select-header__column-list">
                                                    <ul class="list-reset select-header__menu">
                                                        <?php
                                                        foreach ($children as $child) {
                                                            $args_products = [
                                                                'post_type' => 'product',
                                                                'posts_per_page' => -1,
                                                                'product_cat' => $child->slug
                                                            ];
                                                            $products = new WP_Query($args_products);
                                                            if ($products->have_posts()) {
                                                                while ($products->have_posts()) {
                                                                    $products->the_post();
                                                                    echo '<li class="select-header__item"><a class="select-header__link" href="' . get_the_permalink() . '">' . get_the_title() . '</a></li>';
                                                                }
                                                                wp_reset_postdata();
                                                            }
                                                        }

                                                        ?>
                                                    </ul>
                                                </div>
                                            </div>
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
                    // $customSubTotal = 0;
                    // $is_on_sale = [];
                    // $items = $woocommerce->cart->get_cart();
                    // if (!empty($items)) {
                    //     foreach ($items as $item => $values) {
                    //         $_productMiniCart = wc_get_product($values['data']->get_id());
                    //         $product_id = $values['product_id'];
                    //         $image_url = wp_get_attachment_image_src(get_post_thumbnail_id($product_id), '');
                    //         $productImage = $image_url[0];
                    //         $check_type = $_productMiniCart->get_type();
                    //         $prodPrice = 0;
                    //         $quantity = $values['quantity'];
                    //         $thumbnail = apply_filters('woocommerce_cart_item_thumbnail', $_productMiniCart->get_image(), $values, $item);
                    //         if (!empty($_productMiniCart->get_sale_price())) {
                    //             $prodPrice = ceil($_productMiniCart->get_sale_price());
                    //         } else {
                    //             $prodPrice = ceil($_productMiniCart->get_regular_price());
                    //         }
                    //         $lineSubTotal = $prodPrice * $quantity;
                    //         $customSubTotal += $lineSubTotal;

                    //         if ($_productMiniCart->is_on_sale()) {
                    //             array_push($is_on_sale, 1);
                    //         }

                    // global $woocommerce;
                    // $miniCartItems = '';
                    // $items = $woocommerce->cart->get_cart();
                    // $customSubTotal = 0;
                    // $added_items = array();
                    // foreach (WC()->cart->get_cart() as $cart_item_key => $values) {
                    //     $_product = wc_get_product($values['data']->get_id());
                    //     $product_id = $values['product_id'];
                    //     $prodPrice = 0;
                    //     $quantity = $values['quantity'];
                    //     if (!empty($_product->get_sale_price())) {
                    //         $prodPrice = $_product->get_sale_price();
                    //     } else {
                    //         $prodPrice = $_product->get_price();
                    //     }
                    //     $lineSubTotal = $prodPrice * $quantity;
                    //     $customSubTotal += $lineSubTotal;

                    //     // $product_name      = apply_filters('woocommerce_cart_item_name', $_product->get_name(), $values, $cart_item_key);
                    //     $product_name = apply_filters('woocommerce_cart_item_name', $_product->get_name(), $values, $cart_item_key);


                    //     $thumbnail = apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image(), $values, $cart_item_key);
                    //     $product_price     = apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $values, $cart_item_key);
                    //     $product_permalink = apply_filters('woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink($values) : '', $values, $cart_item_key);

                    //     // $variation_data = '';
                    //     // if ($values['variation']) {
                    //     //     $variation_data = woocommerce_get_formatted_variation($values['variation'], true);
                    //     // }
                    //     // if (in_array($product_id, $added_items)) {
                    //     //     continue;
                    //     // }
                    //     $variation_data = '';
                    //     if ($values['variation']) {
                    //         $variation_data = woocommerce_get_formatted_variation($values['variation'], true);
                    //     }

                    //     if (in_array($product_id, $added_items)) {
                    //         continue;
                    //     }
                    ?>
                    <!-- <div class="card-item">
                            <div class="card-img"> <?php echo $thumbnail ?> </div>
                            <div class="card-info">
                                <a class="card-info__title" href="<?php get_the_permalink($product_id); ?>">
                                    <?php
                                    // echo $product_name;
                                    ?>
                                </a>
                            </div>
                            <div class="card-price"><?php echo $product_price ?> </div>
                            <div class="card-quantity js-quantity">
                                <input class="card-input js-quantity-input" type="text" name="prod_quantity" value="<?= $quantity  ?>">
                            </div>
                            <?php
                            // echo  apply_filters(
                            //     'woocommerce_cart_item_remove_link',
                            //     sprintf(
                            //         '<a href="%s" aria-label="%s" class="close-card" data-product_id="%s" data-cart_item_key="%s" data-product_sku="%s">X</a>',
                            //         esc_url(wc_get_cart_remove_url($cart_item_key)),
                            //         esc_attr__("Remove this item", "woocommerce"),
                            //         esc_attr($product_id),
                            //         esc_attr($cart_item_key),
                            //         esc_attr($_product->get_sku())
                            //     ),
                            //     $cart_item_key
                            // );
                            // $added_items[] = $product_id;
                            ?>
                        </div> -->
                    <?php
                    // }

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