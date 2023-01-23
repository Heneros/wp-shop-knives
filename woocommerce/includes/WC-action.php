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
            '
                . apply_filters(
                    'woocommerce_cart_item_remove_link',
                    sprintf(
                        '<a href="%s" aria-label="%s" data-product_id="%s" data-cart_item_key="%s" data-product_sku="%s">X</a>',
                        esc_url(wc_get_cart_remove_url($item)),
                        esc_attr__("Remove this item", "woocommerce"),
                        esc_attr($product_id),
                        esc_attr($item),
                        esc_attr($_product->get_sku())
                    )
                ) .
                '
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
    }

    add_action("wp_ajax_update_product_quantity", "update_product_quantity");
    add_action("wp_ajax_nopriv_update_product_quantity", "update_product_quantity");


    ///Product Variation
    function create_product_variation($product_id, $variation_data)
    {
        $product = wc_get_product($product_id);
        $variation_post = array(
            'post_title' => $product->get_title(),
            'post_name' => 'product-' . $product_id . '-variation',
            'post_status' => 'publish',
            'post_parent' => $product_id,
            'post_type' => 'product_variation',
            'guid' => $product->get_permalink()
        );
        $variation_id = wp_insert_post($variation_post);
        $variation = new WC_Product_Variation($variation_id);
        foreach ($variation_data['attributes'] as $attribute => $term_name) {
            $taxonomy = 'pa_' . $attribute;
            if (!taxonomy_exists($taxonomy)) {
                register_taxonomy(
                    $taxonomy,
                    'product_variation',
                    array(
                        'hierarchical' => true,
                        'label' => ucfirst($attribute),
                        'query_var' => true,
                        'rewrite' => array('slug' => sanitize_title($attribute))
                    )
                );
            }
            if (!term_exists($term_name, $taxonomy))
                wp_insert_term($term_name, $taxonomy);
            $term_slug = get_term_by('name', $term_name, $taxonomy)->slug;
            $post_term_names = wp_get_post_terms($product_id, $taxonomy, array('fields' => 'names'));
            if (!in_array($term_name, $post_term_names))
                wp_set_post_terms($product_id, $term_name, $taxonomy, true);
            update_post_meta($variation_id, 'attribute_', $taxonomy, $term_slug);
        }
        if (!empty($variation_data['sku']))
            $variation->set_sku($variation_data['sku']);
        if (empty($variation_data['sale_price'])) {
            $variation->set_price($variation_data['regular_price']);
        } else {
            $variation->set_price($variation_data['sale_price']);
            $variation->set_sale_price($variation_data['sale_price']);
        }
        $variation->set_regular_price($variation_data['regular_price']);
        if (!empty($variation_data['stock_qty'])) {
            $variation->set_stock_quantity($variation_data['stock_qty']);
            $variation->set_manage_stock(true);
            $variation->set_stock_status('');
        } else {
            $variation->set_manage_stock(false);
        }
        $variation->set_weight('');
        $variation->save('');
    }


    function wc_display_variation_dropdown_on_product($product)
    {
        // echo 'test';
        global $product;
        if ($product->is_type('variable')) {
            $attribute_keys = array_keys($product->get_attributes());
        ?>
            <form class="variations_form cart" method="post" enctype="multipart/form-data" data-product_id="<?php echo absint($product->id); ?>" data-product_variations="<?php echo htmlspecialchars(json_encode($product->get_available_variations())) ?>">
                <?php do_action('woocommerce_before_variations_form'); ?>
                <?php if (empty($product->get_available_variations()) && false !== $product->get_available_variations()) : ?>
                    <span></span>
                <?php else : ?>

                    <?php
                    foreach ($product->get_variation_attributes() as $attribute_name => $options) :
                    ?>
                        <div class="product-information__right-block">
                            <?php
                            $result = preg_replace("(pa_)", '', $attribute_name);
                            echo '<div class="product-information__right-item-left">' . $result . '</div>';
                            echo '<div class="info-dropdown">';
                            $selected = isset($_REQUEST['attribute_' . sanitize_title($attribute_name)]) ? wc_clean(urlencode($_REQUEST['attribute_' . sanitize_title($attribute_name)])) : $product->get_variation_default_attribute($attribute_name);
                            wc_dropdown_variation_attribute_options(array('options' => $options, 'attribute' => $attribute_name, 'product' => $product, 'selected' => $selected));

                            echo '</div>';
                            ?>
                        </div>
                    <?php
                    endforeach;
                    ?>

                <?php endif; ?>
            </form>
    <?php
        }
    }


    ///Add class to variations select.
    // add_filter('woocommerce_dropdown_variation_attribute_options_args', static function ($args) {
    //     $args['class'] = 'filter-style select-item';
    //     return $args;
    // }, 2);



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
        global $woocommerce;
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
