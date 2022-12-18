<?php

require get_template_directory() . '/woocommerce/includes/WC-action.php';





function _assets_paths($path)
{
    return get_template_directory_uri() . '/assets/' . $path;
}

add_action('wp_enqueue_scripts', 'theme_enqueue_styles', 99);
function theme_enqueue_styles()
{
    wp_enqueue_style("css-main", _assets_paths("/css/main.css"), [], "1.0", 'all');
}

function shop_scripts()
{
    wp_enqueue_script("ajax-script", get_template_directory_uri() . '/js/admin-ajax.js', array("jquery"));
    wp_localize_script("ajax-script", 'my_ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));

    wp_enqueue_script('js-vendor-swiper', _assets_paths('/js/vendor/swiper.min.js'), ['jquery'], true);
    wp_enqueue_script('js-vendor-aos', _assets_paths('/js/vendor/aos.js'),  ['jquery'], true);
    wp_enqueue_script('js-vendor-rangeSlider', _assets_paths('/js/vendor/ion.rangeSlider.min.js'),  ['jquery'], true);
    wp_enqueue_script('js-vendor-formstyler', _assets_paths('/js/vendor/jquery.formstyler.min.js'), ['jquery'], true);
    wp_enqueue_script('js-vendor-rateyo', _assets_paths('/js/vendor/jquery.rateyo.min.js'), ['jquery'], true);
    wp_enqueue_script('js-vendor-nouislider', _assets_paths('/js/vendor/nouislider.min.js'),  ['jquery'], true);
    wp_enqueue_script('js-custom', _assets_paths('/js/custom.js'), ['jquery'], true);
    wp_enqueue_script('js-main', _assets_paths('/js/script.js'),  ['jquery'], true);

    wp_enqueue_style("css-custom", _assets_paths("/css/custom.css"), [], "1.0", 'all');
    wp_enqueue_style("css-vendor", _assets_paths("/css/vendor.css"), [], "1.0", 'all');
}

add_action("wp_enqueue_scripts", "shop_scripts");


add_action("after_setup_theme", "shop_setup");

function shop_setup()
{
    add_theme_support('title-tag');

    add_theme_support('custom-logo');
    add_theme_support('post-thumbnails');
    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
    add_theme_support('automatic-feed-links');
    add_theme_support(
        'html5',
        array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
            'style',
            'script',
        )
    );
}



function update_mini_cart_action()
{
    global $woocommerce;

    $miniCartItems = '';
    $items = $woocommerce->cart->get_cart();
    $customSubTotal = 0;
    $is_on_sale = [];
    if (!empty($items)) {
        foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
            $_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
            $product_id = $cart_item['product_id'];
            $image_url = wp_get_attachment_image_src(get_post_thumbnail_id($product_id), '');
            $prodPrice = 0;
            $quantity = $cart_item['quantity'];
            $thumbnail = apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key);
            if (!empty($_product->get_sale_price())) {
                $prodPrice = ceil($_product->get_sale_price());
            } else {
                $prodPrice = ceil($_product->get_regular_price());
            }
            $lineSubTotal = $prodPrice * $quantity;
            $customSubTotal += $lineSubTotal;
            if ($_product->is_on_sale()) {
                array_push($is_on_sale, 1);
            }
            $miniCartItems .= '
            <div class="card-item">
            <div class="card-img">
            ' . $thumbnail . '
            </div>
            <div class="card-info">
                <a class="card-info__title" href="' .  get_the_permalink($product_id) . '">
                ' .
                wp_kses_post(apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key) . '&nbsp;')
                . '
                </a>
            </div>
            <div class="card-price">
            ' . apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key) . '
            </div>
            <div class="card-quantity js-quantity">
                <button class="icon icon-minus js-quantity-minus">-</button>
                <input class="card-input js-quantity-input" type="text" name="prod_quantity" value="' . $quantity  . '">
                <button class="icon icon-plus js-quantity-plus">+</button>
            </div>
        </div>
    <?php
            ';
        }
    }
    $data = [
        'cart_contents' => $miniCartItems,
        'cart_total' => wc_price(WC()->cart->subtotal_ex_tax),
        'cart_items_count' => $woocommerce->cart->cart_contents_count
    ];
    wp_send_json($data);
    die;
}

add_action("wp_ajax_update_mini_cart_action", "update_mini_cart_action");
add_action("wp_ajax_nopriv_update_mini_cart_action", "update_mini_cart_action");


