<?php
// ///////Update Mini Cart.
function update_mini_cart_action()
{
    global $woocommerce;
    $miniCartItems = '';
    $items = $woocommerce->cart->get_cart();
    $customSubTotal = 0;
    $added_items = array();
    foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
        $_product   = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
        $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);

        if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocoomerce_widget_cart_item_visible', true, $cart_item, $cart_item_key)) {
            $product_name      = apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key);
            $thumbnail         = apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key);
            $product_price     = apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key);
            $product_permalink = apply_filters('woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink($cart_item) : '', $cart_item, $cart_item_key);


            $miniCartItems .= '
            <div class="card-item">
                <div class="card-img">' . $thumbnail . '</div>
                <div class="card-info">
                    <a class="card-info__title" href="' .  $product_permalink . '">' . $product_name . '</a>
                </div>
                <div class="card-price">' . $product_price . '</div>
                <div class="card-quantity js-quantity">
                    <input class="card-input js-quantity-input" type="text" name="prod_quantity" value="' . apply_filters('woocommerce_widget_cart_item_quantity', '' . sprintf('%s', $cart_item['quantity'], '') . '', $cart_item, $cart_item_key) . '">
                </div>
                ' . apply_filters(
                'woocommerce_cart_item_remove_link',
                sprintf(
                    '<a href="%s" aria-label="%s" class="close-card" data-product_id="%s" data-cart_item_key="%s" data-product_sku="%s">X</a>',
                    esc_url(wc_get_cart_remove_url($cart_item_key)),
                    esc_attr__("Remove this item", "woocommerce"),
                    esc_attr($product_id),
                    esc_attr($cart_item_key),
                    esc_attr($_product->get_sku())
                ),
                $cart_item_key
            ) . '
            </div>
            ';
            $added_items[] = $product_id;
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


function add_to_cart_variable_product()
{
    global $woocommerce;
    $quantity = (int)$_POST['prod_obj']['quantity'];
    $variation_id = (int)$_POST['prod_obj']['variation_id'];
    $product_id = (int)$_POST['prod_obj']['productID'];

    $p = wc_get_product($variation_id);
    if ($p->get_stock_status() == 'instock') {
        $s_status = true;
        $woocommerce->cart->add_to_cart($variation_id, $quantity);
    } else {
        $s_status = false;
    }
    wp_send_json([
        'stock_status' => $s_status
    ]);
}
add_action("wp_ajax_add_to_cart_variable_product", "add_to_cart_variable_product");
add_action("wp_ajax_nopriv_add_to_cart_variable_product", "add_to_cart_variable_product");







add_action('wp_ajax_add_to_cart', 'add_to_cart');
add_action('wp_ajax_nopriv_add_to_cart', 'add_to_cart');
function add_to_cart()
{

    $error = '';
    $product_id = isset($_POST['product_id']) ? $_POST['product_id'] : '';
    $attributes = isset($_POST['attributes']) ? $_POST['attributes'] : [];
    $quantity = isset($_POST['quantity']) ? $_POST['quantity'] : 1;

    if (empty($product_id)) {
        $error = 'Product was not send';
    }

    if (empty($error)) {
        $variation_id = (new \WC_Product_Data_Store_CPT())->find_matching_product_variation(
            new \WC_Product($product_id),
            $attributes
        );

        WC()->cart->add_to_cart($product_id, $quantity, $variation_id);

        wp_send_json_success([
            'message' => 'Product was added'
        ]);
    } else {
        wp_send_json_error([
            'message' => $error
        ]);
    }
}



add_filter('woocommerce_cart_item_name', 'remove_variation_attribute_name', 10, 3);


function remove_variation_attribute_name($product_name, $cart_item, $cart_item_key)
{

    $_product = $cart_item['data'];
    if ($_product && $_product->is_type('variation')) {
        $product_name = $_product->get_title();
    }

    return $product_name;
}