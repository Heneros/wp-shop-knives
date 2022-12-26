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
        foreach ($items as $item => $values) {
            $_product = wc_get_product($values['data']->get_id());
            $product_id = $values['product_id'];
            $prodPrice = 0;
            $quantity = $values['quantity'];
            if (!empty($_product->get_sale_price())) {
                $prodPrice = $_product->get_sale_price();
            } else {
                $prodPrice = $_product->get_price();
            }
            $lineSubTotal = $prodPrice * $quantity;
            $customSubTotal += $lineSubTotal;
            $thumbnail = apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image(), $values, $item);
            $miniCartItems .= '

            <div class="card-item">
              <div class="card-img">
            ' . $thumbnail . '
            </div>
            <div class="card-info">
                <a class="card-info__title" href="' .  get_the_permalink($product_id) . '">
                ' . $_product->get_title() . ' 
                </a>
            </div>
            <div class="card-price">
            ' .
                $_product->get_price_html()
                . '
            </div>
            <div class="card-quantity js-quantity">
                <button class="icon icon-minus js-quantity-minus">-</button>
                <input class="card-input js-quantity-input" type="text" name="prod_quantity" value="' . $quantity  . '">
                <button class="icon icon-plus js-quantity-plus">+</button>
            </div>
        </div>
            ';
        }

        if (WC()->cart->tax_display_cart == 'excl') {
            $cart_subtotal = WC()->cart->subtotal_ex_tax;
        } else {
            $cart_subtotal = WC()->cart->subtotal;
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


    add_action("wp_ajax_check_if_product_exist_in_cart", "check_if_product_exist_in_cart");
    add_action("wp_ajax_nopriv_check_if_product_exist_in_cart", "check_if_product_exist_in_cart");

    function check_if_product_exist_in_cart()
    {
        $product_id = (int)$_POST['product_id'];
        $in_cart = [];
        if (count(WC()->cart->get_cart()) !== 0) {
            foreach (WC()->cart->get_cart() as $cart_item) {
                $product_in_cart = $cart_item['product_id'];
                if ($product_in_cart === $product_id) {
                    $in_cart = [
                        'in_cart' => true
                    ];
                    wp_send_json($in_cart);
                } else {
                    $in_cart = [
                        'in_cart' => false
                    ];
                    wp_send_json($in_cart);
                }
            }
        } else {
            $in_cart = [
                'in_cart' => false
            ];
            wp_send_json($in_cart);
        }
        wp_die();
    }




    function check_if_product_in_stock()
    {
        $p_id = (int)$_POST['product_id'];
        $p = wc_get_product($p_id);
        if ($p->get_stock_status() == 'instock') {
            $s_status = true;
        } else {
            $s_status = false;
        }
        wp_send_json([
            'stock_status' => $s_status
        ]);
        wp_die();
    }
    add_action("wp_ajax_check_if_product_in_stock", "check_if_product_in_stock");
    add_action("wp_ajax_nopriv_check_if_product_in_stock", "check_if_product_in_stock");



    function update_product_quantity()
    {
        global $woocommerce;
        global $product;
        $variation_ids_in_cart = array();
        $current_variation_prod = 0;
        $product_id = (int)$_POST['prod_id'];
        $quantity = (int)$_POST['quantity'];
        $post_type = get_post_type($product_id);
        if (!is_object($product)) {
        }
    }
