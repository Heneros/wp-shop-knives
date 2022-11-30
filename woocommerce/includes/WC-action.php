<?php

if (!function_exists('woocommerce_template_loop_product_link_open')) {
    function woocommerce_template_loop_product_link_open()
    {
        global $product;
        $link = apply_filters('woocommerce_loop_product_link', get_the_permalink(), $product);
        echo '<a href="' . esc_url($link) . '" class="bestsellers-products-item__img">';
    }
}



remove_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10);
add_action('woocommerce_shop_loop_item_title', 'custom_loop_product_title', 10);
function custom_loop_product_title()
{
    global $product;

    $attributesProduct = $product->get_default_attributes();
    if (!$product->attributes) { ?>
        <a href="<?php echo $product->get_permalink(); ?>" class="sub-title"><?php echo $product->get_name() ?></a>
    <?php  } else { ?>
        <a href="<?php echo $product->get_permalink(); ?>" class="sub-title">
            <?php
            echo $product->get_name();
            foreach ($attributesProduct as $attributeProduct) {
                echo ' ' .  $attributeProduct;
            }  ?></a>
    <?php }

    ?>

<?php
}
