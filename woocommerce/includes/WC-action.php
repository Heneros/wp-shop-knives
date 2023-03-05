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




    // ///////Update Mini Cart.
    function update_mini_cart_action()
    {
        global $woocommerce;
        $miniCartItems = '';
        $items = $woocommerce->cart->get_cart();
        $customSubTotal = 0;
        $added_items = array(); // хранит уже добавленные в корзину товары
        foreach (WC()->cart->get_cart() as $cart_item_key => $values) {
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

            $product_name      = apply_filters('woocommerce_cart_item_name', $_product->get_name(), $values, $cart_item_key);
            $thumbnail = apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image(), $values, $cart_item_key);
            $product_price     = apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $values, $cart_item_key);
            $product_permalink = apply_filters('woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink($values) : '', $values, $cart_item_key);

            $variation_data = '';
            if ($values['variation']) {
                $variation_data = woocommerce_get_formatted_variation($values['variation'], true);
            }


            if (in_array($product_id, $added_items)) {
                continue; // продолжаем цикл, если товар уже добавлен
            }

            $miniCartItems .= '
            <div class="card-item">
                <div class="card-img">' . $thumbnail . '</div>
                <div class="card-info">
                    <a class="card-info__title" href="' .  $product_permalink . '">' . $product_name . ' ' . $variation_data . '</a>
                </div>
                <div class="card-price">' . $product_price . '</div>
                <div class="card-quantity js-quantity">
                    <button class="icon icon-minus quantity-minus">-</button>
                    <input class="card-input js-quantity-input" type="text" name="prod_quantity" value="' . $quantity  . '">
                    <button class="icon icon-plus quantity-plus">+</button>
                </div>
                ' . apply_filters(
                'woocommerce_cart_item_remove_link',
                sprintf(
                    '<a href="%s" aria-label="%s" data-product_id="%s" data-cart_item_key="%s" data-product_sku="%s">X</a>',
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


    // function update_mini_cart_action()
    // {
    //     global $woocommerce;
    //     $miniCartItems = '';
    //     $items = $woocommerce->cart->get_cart();
    //     $customSubTotal = 0;
    //     // foreach ($items as $item => $values) {
    //         global $woocommerce;
    //         $customSubTotal = 0;
    //         $is_on_sale = [];
    //         $items = $woocommerce->cart->get_cart();


    //             foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
    //         $_product = wc_get_product($cart_item['data']->get_id());
    //         $prodPrice = 0;
    //         $quantity = $cart_item['quantity'];
    //         if (!empty($_product->get_sale_price())) {
    //             $prodPrice = $_product->get_sale_price();
    //         } else {
    //             $prodPrice = $_product->get_price();
    //         }
    //         $lineSubTotal = $prodPrice * $quantity;
    //         $customSubTotal +=  $lineSubTotal;

    //         $_product   = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
    //         $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);


    //         $product_name      = apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key);
    //         $thumbnail         = apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key);
    //         $product_price     = apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key);
    //         $product_permalink = apply_filters('woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink($cart_item) : '', $cart_item, $cart_item_key);

    //         $miniCartItems .= '
    //         <div class="card-item">
    //                   <div class="card-img">
    //                 ' . $thumbnail . '
    //                 </div>
    //         <div class="card-info">
    //         <a class="card-info__title" href="' . $product_permalink . '">
    //                 ' . $product_name . '
    //                 </a>
    //         </div>
    //                 <div class="card-price">
    //                 ' .
    //             $product_price
    //             . '
    //                 </div>
    //         <div class="card-quantity js-quantity">
    //         <button class="icon icon-minus quantity-minus">-</button>
    //         <input class="card-input js-quantity-input" type="text" name="prod_quantity" value="' . $quantity  . '">
    //         <button class="icon icon-plus quantity-plus">+</button>
    //     </div>
    //     ' .  apply_filters(
    //                 'woocommerce_cart_item_remove_link',
    //                 sprintf(
    //                     '<a href="%s" aria-label="%s" data-product_id="%s" data-cart_item_key="%s" data-product_sku="%s">X</a>',
    //                     esc_url(wc_get_cart_remove_url($cart_item_key)),
    //                     esc_attr__("Remove this item", "woocommerce"),
    //                     esc_attr($product_id),
    //                     esc_attr($cart_item_key),
    //                     esc_attr($_product->get_sku())
    //                 ),
    //                 $cart_item_key
    //             )    . '

    //         ';
    //         $data = [
    //             'cart_contents' => $miniCartItems,
    //             'cart_total' =>  wc_price(WC()->cart->subtotal_ex_tax),
    //             'cart_items_count' => $woocommerce->cart->cart_contents_count,
    //         ];
    //         wp_send_json($data);
    //         die;
    //     }
    // }
    // add_action("wp_ajax_update_mini_cart_action", "update_mini_cart_action");
    // add_action("wp_ajax_nopriv_update_mini_cart_action", "update_mini_cart_action");


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
            $product = wc_get_product($product_id);
        }
        foreach (WC()->cart->get_cart() as $cart_item) {
            if ($cart_item['variation_id'] > 0 && in_array($cart_item['variation_id'], $product->get_children()))
                $variation_ids_in_cart[] = $cart_item['variation_id'];
        }
        if ($post_type != 'product') {
            if (!empty($variation_ids_in_cart)) {
                foreach ($variation_ids_in_cart as $item_var_prod_id) {
                    if ($item_var_prod_id == $product_id) {
                        $current_variation_prod = $item_var_prod_id;
                    }
                }
                $prod_unique_id = $woocommerce->cart_generate_cart_id($product_id);
                unset($woocommerce->cart->cart_contents[$prod_unique_id]);
                $woocommerce->cart->add_to_cart($product_id, $quantity, $current_variation_prod);
            }
        } else {
            $prod_unique_id = $woocommerce->cart->generate_cart_id($product_id);
            unset($woocommerce->cart->cart_contents[$prod_unique_id]);
            $woocommerce->cart->add_to_cart($product_id, $quantity);
        }

        // Get cart total and items count
        $cart_total = WC()->cart->get_cart_total();
        $cart_items_count = WC()->cart->get_cart_contents_count();

        // Return updated cart data in AJAX response
        $response = array(
            'cart_total' => $cart_total,
            'cart_items_count' => $cart_items_count,
        );
        wp_send_json_success($response);
    }

    add_action("wp_ajax_update_product_quantity", "update_product_quantity");
    add_action("wp_ajax_nopriv_update_product_quantity", "update_product_quantity");






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



    ///Product Variation
    // function create_product_variation($product_id, $variation_data)
    // {
    //     $product = wc_get_product($product_id);
    //     $variation_post = array(
    //         'post_title' => $product->get_title(),
    //         'post_name' => 'product-' . $product_id . '-variation',
    //         'post_status' => 'publish',
    //         'post_parent' => $product_id,
    //         'post_type' => 'product_variation',
    //         'guid' => $product->get_permalink()
    //     );
    //     $variation_id = wp_insert_post($variation_post);
    //     $variation = new WC_Product_Variation($variation_id);
    //     foreach ($variation_data['attributes'] as $attribute => $term_name) {
    //         $taxonomy = 'pa_' . $attribute;
    //         if (!taxonomy_exists($taxonomy)) {
    //             register_taxonomy(
    //                 $taxonomy,
    //                 'product_variation',
    //                 array(
    //                     'hierarchical' => true,
    //                     'label' => ucfirst($attribute),
    //                     'query_var' => true,
    //                     'rewrite' => array('slug' => sanitize_title($attribute))
    //                 )
    //             );
    //         }
    //         if (!term_exists($term_name, $taxonomy))
    //             wp_insert_term($term_name, $taxonomy);
    //         $term_slug = get_term_by('name', $term_name, $taxonomy)->slug;
    //         $post_term_names = wp_get_post_terms($product_id, $taxonomy, array('fields' => 'names'));
    //         if (!in_array($term_name, $post_term_names))
    //             wp_set_post_terms($product_id, $term_name, $taxonomy, true);
    //         update_post_meta($variation_id, 'attribute_', $taxonomy, $term_slug);
    //     }
    //     if (!empty($variation_data['sku']))
    //         $variation->set_sku($variation_data['sku']);
    //     if (empty($variation_data['sale_price'])) {
    //         $variation->set_price($variation_data['regular_price']);
    //     } else {
    //         $variation->set_price($variation_data['sale_price']);
    //         $variation->set_sale_price($variation_data['sale_price']);
    //     }
    //     $variation->set_regular_price($variation_data['regular_price']);
    //     if (!empty($variation_data['stock_qty'])) {
    //         $variation->set_stock_quantity($variation_data['stock_qty']);
    //         $variation->set_manage_stock(true);
    //         $variation->set_stock_status('');
    //     } else {
    //         $variation->set_manage_stock(false);
    //     }
    //     $variation->set_weight('');
    //     $variation->save('');
    // }



    ///Add class to variations select.
    // add_filter('woocommerce_dropdown_variation_attribute_options_args', static function ($args) {
    //     $args['class'] = 'filter-style select-item';
    //     return $args;
    // }, );



    ///Display on content-product single attribute
    add_action('woocommerce_single_product_summary', 'product_attribute_dimensions', 45);
    function product_attribute_dimensions()
    {
        global $product;

        $taxonomies = array('pa_size');
        foreach ($taxonomies as $taxonomy) {
            $value = $product->get_attribute($taxonomy);
            if ($value) {
                $label = get_taxonomy($taxonomy)->labels->singular_name;
                echo '<span class="bestsellers-products-item__size">' . $label . ': ' . $value . '</span>';
            }
        }
    }





    function get_variable_product_data_by_id()
    {
        $variation_id = (int)$_POST['var_id'];
        $variation = wc_get_product($variation_id);
        $variableProductImage = wp_get_attachment_image_src(get_post_thumbnail_id($variation_id), '');
        $v_product_data = [
            'p_image' => $variableProductImage[0],
            'p_sku' => $variation->get_sku(),
            'p_price' => $variation->get_price_html()
        ];
        wp_send_json($v_product_data);
        die;
    }


    add_action('wp_ajax_get_variable_product_data_by_id', 'get_variable_product_data_by_id');
    add_action('wp_ajax_nopriv_get_variable_product_data_by_id', 'get_variable_product_data_by_id');





    function wc_display_variation_product($product)
    {

        global $product;

        if ($product->is_type('variable')) {

            $attribute_keys = array_keys($product->get_attributes());
        ?>

            <form class="variations_form cart filter-style select-item" method="post" enctype='multipart/form-data' data-product_id="<?php echo absint($product->id); ?>" data-product_variations="<?php echo htmlspecialchars(json_encode($product->get_available_variations())) ?>">
                <?php do_action('woocommerce_before_variations_form'); ?>
                <?php if (empty($product->get_available_variations()) && false !== $product->get_available_variations()) : ?>
                    <span></span>
                <?php else : ?>
                    <table class="variations" cellspacing="0">
                        <tbody>
                            <?php foreach ($product->get_variation_attributes() as $attribute_name => $options) : ?>
                                <tr>
                                    <td class="value">
                                        <?php
                                        $selected = isset($_REQUEST['attribute_' . sanitize_title($attribute_name)]) ? wc_clean(urldecode($_REQUEST['attribute_' . sanitize_title($attribute_name)])) : $product->get_variation_default_attribute($attribute_name);
                                        wc_dropdown_variation_attribute_options(array('options' => $options, 'attribute' => $attribute_name, 'product' => $product, 'selected' => $selected));
                                        ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                    <?php do_action('woocommerce_before_add_to_cart_button'); ?>

                    <div class="single_variation_wrap" style="display:none;">
                        <?php
                        /**
                         * woocommerce_before_single_variation Hook.
                         */
                        do_action('woocommerce_before_single_variation');
                        do_action('woocommerce_single_variation');
                        do_action('woocommerce_after_single_variation');
                        ?>
                    </div>
                    <?php do_action('woocommerce_after_add_to_cart_button'); ?>
                <?php endif; ?>
                <?php do_action('woocommerce_after_variations_form'); ?>
            </form>
    <?php }
    }





    //////Vendor Code
    add_action('woocommerce_variation_options_pricing', 'add_vendor_code_to_variations', 10, 3);

    function add_vendor_code_to_variations($loop, $variation_data, $variation)
    {
        woocommerce_wp_text_input(array(
            'id' => 'vendor_code[' . $loop . ']',
            'class' => 'short',
            'label' => __('Custom Field Vendor Code', 'woocommerce'),
            'value' => get_post_meta($variation->ID, 'vendor_code', true)
        ));
    }


    add_action('woocommerce_save_product_variation', 'save_vendor_code_variations', 10, 2);

    function save_vendor_code_variations($variation_id, $i)
    {
        $vendor_code = $_POST['vendor_code'][$i];
        if (isset($vendor_code)) update_post_meta($variation_id, 'vendor_code', esc_attr($vendor_code));
    }


    add_filter('woocommerce_available_variation', 'add_vendor_code_variation_data');

    function add_vendor_code_variation_data($variations)
    {
        $variations['vendor_code'] = '<div class="woocommerce_vendor_code"><span>' . get_post_meta($variations['variation_id'], 'vendor_code', true) . '</span></div>';
        return $variations;
    }


    //////Trademark
    add_action('woocommerce_variation_options_pricing', 'add_trademark_to_variations', 10, 3);

    function add_trademark_to_variations($loop, $variation_data, $variation)
    {
        woocommerce_wp_text_input(array(
            'id' => 'trademark[' . $loop . ']',
            'class' => 'short',
            'label' => __('Custom Field Trademark', 'woocommerce'),
            'value' => get_post_meta($variation->ID, 'trademark', true)
        ));
    }


    add_action('woocommerce_save_product_variation', 'save_trademark_variations', 10, 2);

    function save_trademark_variations($variation_id, $i)
    {
        $trademark = $_POST['trademark'][$i];
        if (isset($trademark)) update_post_meta($variation_id, 'trademark', esc_attr($trademark));
    }


    add_filter('woocommerce_available_variation', 'add_trademark_variation_data');

    function add_trademark_variation_data($variations)
    {
        $variations['trademark'] = '<div class="woocommerce_trademark"><span>' . get_post_meta($variations['variation_id'], 'trademark', true) . '</span></div>';
        return $variations;
    }




    //////Seria
    add_action('woocommerce_variation_options_pricing', 'add_seria_to_variations', 10, 3);

    function add_seria_to_variations($loop, $variation_data, $variation)
    {
        woocommerce_wp_text_input(array(
            'id' => 'seria[' . $loop . ']',
            'class' => 'short',
            'label' => __('Custom Field Seria', 'woocommerce'),
            'value' => get_post_meta($variation->ID, 'seria', true)
        ));
    }


    add_action('woocommerce_save_product_variation', 'save_seria_variations', 10, 2);

    function save_seria_variations($variation_id, $i)
    {
        $seria = $_POST['seria'][$i];
        if (isset($seria)) update_post_meta($variation_id, 'seria', esc_attr($seria));
    }


    add_filter('woocommerce_available_variation', 'add_seria_variation_data');

    function add_seria_variation_data($variations)
    {
        $variations['seria'] = '<div class="woocommerce_seria"><span>' . get_post_meta($variations['variation_id'], 'seria', true) . '</span></div>';
        return $variations;
    }


    //////Bonus Points
    add_action('woocommerce_variation_options_pricing', 'add_bonus_points_to_variations', 10, 3);

    function add_bonus_points_to_variations($loop, $variation_data, $variation)
    {
        woocommerce_wp_text_input(array(
            'id' => 'bonus_points[' . $loop . ']',
            'class' => 'short',
            'label' => __('Custom Field bonus_points', 'woocommerce'),
            'value' => get_post_meta($variation->ID, 'bonus_points', true)
        ));
    }


    add_action('woocommerce_save_product_variation', 'save_bonus_points_variations', 10, 2);

    function save_bonus_points_variations($variation_id, $i)
    {
        $bonus_points = $_POST['bonus_points'][$i];
        if (isset($bonus_points)) update_post_meta($variation_id, 'bonus_points', esc_attr($bonus_points));
    }


    add_filter('woocommerce_available_variation', 'add_bonus_points_variation_data');

    function add_bonus_points_variation_data($variations)
    {
        $variations['bonus_points'] = '<div class="woocommerce_bonus_points"><span>' . get_post_meta($variations['variation_id'], 'bonus_points', true) . '</span></div>';
        return $variations;
    }



    remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);
    remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10);
    remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20);
    remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);
    remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);





    add_action('woocommerce_product_options_general_product_data', 'woocommerce_product_custom_fields');
    add_action('woocommerce_process_product_meta', 'woocommerce_product_custom_fields_save');

    function woocommerce_product_custom_fields()
    {
        global $woocommerce, $post;
        echo '<div class="product_custom_field">';
        woocommerce_wp_text_input(
            array(
                'id' => '_custom_product_vendor_code',
                'placeholder' => 'Custom Product Vendor',
                'label' => __('Custom Product  Vendor Code', 'woocommerce'),
                'desc_tip' => 'true'
            )
        );
        woocommerce_wp_text_input(
            array(
                'id' => '_custom_product_trademark_field',
                'placeholder' => 'Custom Product Trademark Field',
                'label' => __('Custom Product Trademark Field', 'woocommerce'),
            )
        );
        woocommerce_wp_text_input(
            array(
                'id' => '_custom_product_seria',
                'placeholder' => 'Custom Product Seria',
                'label' => __('Custom Product Seria', 'woocommerce'),
                'type' => 'number',
                'custom_attributes' => array(
                    'step' => 'any',
                    'min' => '0'
                )
            )
        );
        woocommerce_wp_text_input(
            array(
                'id' => '_custom_product_bonus_points',
                'placeholder' => 'Custom Product Bonus Points',
                'label' => __('Custom Product Bonus Points', 'woocommerce'),
                'type' => 'number',
                'custom_attributes' => array(
                    'step' => 'any',
                    'min' => '0'
                )
            )
        );
        echo '</div>';
    }



    function woocommerce_product_custom_fields_save($post_id)
    {
        $woocommerce_custom_product_vendor_code = $_POST['_custom_product_vendor_code'];
        if (!empty($woocommerce_custom_product_vendor_code))
            update_post_meta($post_id, '_custom_product_vendor_code', esc_attr($woocommerce_custom_product_vendor_code));

        $woocommerce_custom_product_trademark_field = $_POST['_custom_product_trademark_field'];
        if (!empty($woocommerce_custom_product_trademark_field))
            update_post_meta($post_id, '_custom_product_trademark_field', esc_attr($woocommerce_custom_product_trademark_field));

        $woocommerce_custom_product_textarea = $_POST['_custom_product_seria'];
        if (!empty($woocommerce_custom_product_textarea))
            update_post_meta($post_id, '_custom_product_seria', esc_html($woocommerce_custom_product_textarea));

        $woocommerce_custom_product_bonus_points = $_POST['_custom_product_bonus_points'];
        if (!empty($woocommerce_custom_product_bonus_points))
            update_post_meta($post_id, '_custom_product_bonus_points', esc_html($woocommerce_custom_product_bonus_points));
    }


    function woocommerce_add_to_cart_messsage($added_to_cart, $url = '')
    {
        if (!is_array($added_to_cart)) {
            return;
        }
        $messages = array();

        foreach ($added_to_cart as $product_id => $quantity) {
            $product = wc_get_product($product_id);

            if (!$product) {
                continue;
            }

            $name = $product->get_name();
            $quantity = (int) $quantity;

            if ($quantity <= 0) {
                $messages[] = sprintf('<a href="%s" class="button wc-forward">%s</a> %s', esc_url($product->get_permalink()), __('View product', 'woocommerce'), esc_html($name));
            } else {
                $messages[] = sprintf('<a href="%s" class="button wc-forward">%s</a> %s &times; %s', esc_url(wc_get_cart_url()), __('View cart', 'woocommerce'), esc_html($name), $quantity);
            }
        }

        if ($messages) {
            wc_add_notice(implode('<br>', $messages), 'success');
        }
    }



    function woocommerce_ajax_add_to_cart()
    {
        // Make sure that WooCommerce is loaded
        if (!function_exists('WC')) {
            return;
        }

        global $woocommerce;

        $product_id = apply_filters('woocommerce_add_to_cart_product_id', absint($_POST['product_id']));
        $quantity = empty($_POST['quantity']) ? 1 : apply_filters('woocommerce_stock_amount', $_POST['quantity']);
        $variation_id = absint($_POST['variation_id']);

        $passed_validation = apply_filters('woocommerce_add_to_cart_validation', true, $product_id, $quantity, $variation_id);

        if ($passed_validation && $woocommerce->cart->add_to_cart($product_id, $quantity, $variation_id)) {
            do_action('woocommerce_ajax_added_to_cart', $product_id);

            if (get_option('woocommerce_cart_redirect_after_add') == 'yes') {
                // Get the product name and quantity for the cart message
                $product_name = get_the_title($product_id);
                $cart_item_quantity = $woocommerce->cart->get_cart_item_quantity($product_id);
                $cart_message = sprintf('%s %s %s', __('Added', 'woocommerce'), $cart_item_quantity, __('to your cart', 'woocommerce'));
                wc_add_notice($cart_message, 'success');
            }

            WC_AJAX::get_refreshed_fragments();
        } else {
            header('Content-Type: application/json; charset=utf-8');
            $data = array(
                'error' => true,
                'product_url' => apply_filters('woocommerce_cart_redirect_after_error', get_permalink($product_id), $product_id)
            );
            echo json_encode($data);
        }
        wp_die();
    }
    add_action('wp_ajax_woocommerce_ajax_add_to_cart', 'woocommerce_ajax_add_to_cart');
    add_action('wp_ajax_nopriv_woocommerce_ajax_add_to_cart', 'woocommerce_ajax_add_to_cart');













    // // добавляем хук для добавления выбранной вариации в корзину
    // add_action('woocommerce_add_to_cart', 'add_variation_to_cart');
    // function add_variation_to_cart($cart_item_key, $product_id, $quantity, $variation_id, $variation, $cart_item_data)
    // {
    //     if ($variation_id > 0) {
    //         WC()->cart->add_to_cart($product_id, $quantity, $variation_id, $variation);
    //     }
    // }



    // function add_hidden_variation_field()
    // {
    //     if (is_product()) {
    //         global $product;

    //         if ($product->is_type('variable')) {
    //             $variation_data = array();
    //             $variation_id = $product->get_default_variation_id();

    //             if ($variation_id > 0) {
    //                 $variation_data = $product->get_variation_attributes($variation_id);
    //             }

    //             echo '<input type="hidden" name="variation_id" value="' . esc_attr($variation_id) . '">';

    //             foreach ($variation_data as $attribute_name => $attribute_value) {
    //                 echo '<input type="hidden" name="' . esc_attr('attribute_' . sanitize_title($attribute_name)) . '" value="' . esc_attr($attribute_value) . '">';
    //             }
    //         }
    //     }
    // }
