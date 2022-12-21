<?php

session_start();

add_action('woocommerce_shop_loop_item_title', 'change_loop_ratings_location', 2);
function change_loop_ratings_location()
{
    remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);
    add_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_rating', 15);
}


// remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10);

remove_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10);
add_action('woocommerce_shop_loop_item_title', 'custom_loop_product_title', 10);
function custom_loop_product_title()
{
    global $product;

    // $attributesProduct = $product->get_default_attributes();
    if (!$product->attributes) { ?>
        <h2 class="sub-title">
            <a href="<?php echo $product->get_permalink(); ?>">
                <?php echo $product->get_name() ?>
            </a>
        </h2>

    <?php  } else { ?>
        <h2 class="sub-title">
            <a href="<?php echo $product->get_permalink(); ?>">
                <?php
                echo $product->get_name();
                ?>
            </a>
        </h2>
        <div class="bestsellers-products-item__line">
            <?php
            wc_display_product_attributes($product);
            ?>
            <span class="bestsellers-products-item__structure">
                <?php
                $tags_product = get_the_terms($product->ID, 'product_tag');
                foreach ($tags_product as $tag_product) {
                    echo ' ' . $tag_product->name;
                }
                ?>
            </span>
        <?php
    }
        ?>
        </div>
    <?php
}



function print_wish_icon($prod_id)
{
    $class = '';
    if (isset($_SESSION['wishlist']) && in_array($prod_id, $_SESSION['wishlist'])) {
        $class = 'in_list';
    }
    ?>
        <?php
        if (is_singular('product')) { ?>
            <a href="#!" class="bestsellers-products-item__favorites add_favorite <?php echo $class; ?>" data-prodid="<?php echo $prod_id; ?>">
                <img src="<?php echo _assets_paths('img/sprite.svg#favorites-yellow'); ?>" alt="icon favorite">
            </a>
        <?php } else {   ?>
            <a href="#!" class="bestsellers-products-item__favorites add_favorite <?php echo $class; ?>" data-prodid="<?php echo $prod_id; ?>">
                <img src="<?php echo _assets_paths('img/sprite.svg#favorites-yellow'); ?>" alt="icon favorite">
            </a>
    <?php
        }
        return;
    }

    add_action("wp_ajax_add_to_wishlist", "add_to_wishlist");
    add_action("wp_ajax_nopriv_add_to_wishlist", "add_to_wishlist");

    function add_to_wishlist()
    {
        if (isset($_POST['prod_id']) && !empty($_POST['prod_id']) && !in_array($_POST['prod_id'], $_SESSION['wishlist'])) {
            $_SESSION['wishlist'][] = $_POST['prod_id'];
            echo json_encode(['response' => 'success']);
        }
        die;
    }

    add_action("wp_ajax_remove_from_wishlist", "remove_from_wishlist");
    add_action("wp_ajax_nopriv_remove_from_wishlist", "remove_from_wishlist");


    function remove_from_wishlist()
    {
        if (isset($_POST['prod_id']) && !empty($_POST['prod_id'])) {
            foreach ($_SESSION['wishlist'] as $k => $item) {
                if ($item == $_POST['prod_id']) {
                    unset($_SESSION['wishlist'][$k]);
                }
            }
            $prods = [];
            if (isset($_SESSION['wishlist'])) {
                $prods = $_SESSION['wishlist'];
            }
            $args = [
                'post_type' => 'product',
                'post__in' => ((!isset($prods) || empty($prods)) ? array(-1) : $prods)
            ];
            $wishlist_prods = new WP_Query($args);
            ob_start();
            get_template_part("elements/filtered-products", '', ['objects' => $wishlist_prods]);
            $content = ob_get_clean();
            echo json_encode(['response' => 'success', 'products' => ($content) ? $content : '<p>No products been found.</p>', 'found_posts' =>  $wishlist_prods->found_posts]);
        }
        die;
    }




    ///////Update Mini Cart.
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
