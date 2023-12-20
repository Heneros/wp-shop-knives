<?php

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
        'p_price' => $variation->get_price_html(),
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

            <?php else : ?>

                <?php
                do_action('woocommerce_before_add_to_cart_button');
                ?>

                <div class="single_variation_wrap" style="display:none;">

                    <?php
                    do_action('woocommerce_before_single_variation');
                    do_action('woocommerce_single_variation');
                    do_action('woocommerce_after_single_variation');
                    ?>
                    <div class="variations">

                        <?php foreach ($product->get_variation_attributes() as $attribute_name => $options) : ?>
                            <div class="value">
                                <?php
                                $selected = isset($_REQUEST['attribute_' . sanitize_title($attribute_name)]) ? wc_clean(urldecode($_REQUEST['attribute_' . sanitize_title($attribute_name)])) : $product->get_variation_default_attribute($attribute_name);

                                echo '<label class="product-information__right-item-left" for="attribute_' . sanitize_title($attribute_name) . '">' . wc_attribute_label($attribute_name) . '</label>';
                                wc_dropdown_variation_attribute_options(array(
                                    'options' => $options,
                                    'attribute' => $attribute_name,
                                    'product' => $product,
                                    'selected' => $selected,
                                    'name' => 'attribute_' . sanitize_title($attribute_name),
                                    'show_option_none' => __('Choose an option 5555 ', 'woocommerce'),
                                ));
                                ?>
                            </div>
                        <?php endforeach; ?>
                        <div class="line"></div>



                    </div>

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

function update_product_quantity()
{
    global $woocommerce;
    $variation_ids_in_cart = array();
    global $product;
    $current_variation_prod = 0;
    $product_id = (int)$_POST['prod_id'];
    $quantity = (int)$_POST['quantity'];
    $post_type = get_post_type($product_id);
    if (!is_object($product))
        $product = wc_get_product($product_id);
    // Loop through cart items
    foreach (WC()->cart->get_cart() as $cart_item) {
        // Collecting product variation IDs if they are in cart for this variable product
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
            // Get it's unique ID within the Cart
            $prod_unique_id = $woocommerce->cart->generate_cart_id($product_id);
            // Remove it from the cart by un-setting it
            unset($woocommerce->cart->cart_contents[$prod_unique_id]);
            $woocommerce->cart->add_to_cart($product_id, $quantity, $current_variation_prod);
        }
    } else {
        // Get it's unique ID within the Cart
        $prod_unique_id = $woocommerce->cart->generate_cart_id($product_id);
        // Remove it from the cart by un-setting it
        unset($woocommerce->cart->cart_contents[$prod_unique_id]);
        $woocommerce->cart->add_to_cart($product_id, $quantity);
    }
}

add_action('wp_ajax_update_product_quantity', 'update_product_quantity');
add_action('wp_ajax_nopriv_update_product_quantity', 'update_product_quantity');
