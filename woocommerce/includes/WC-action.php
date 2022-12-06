<?php




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
                // foreach ($attributesProduct as $attributeProduct) {
                //     echo ' ' .  $attributeProduct;
                // } 
                ?>
            </a>
        </h2>

    <?php

        wc_display_product_attributes($product);
    }

    ?>

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
        <a href="#" class="bestsellers-products-item__favorites echo <?php echo $class; ?>" data-prodid="<?php echo $prod_id; ?>">
            <!-- svg -->
        </a>
    <?php } else {
    ?>
        <a href="#" class="bestsellers-products-item__favorites echo <?php echo $class; ?>" data-prodid="<?php echo $prod_id; ?>">
            <!-- svg -->
        </a>
<?php
    }
    return;
}

add_action("wp_ajax_add_to_wishlist", "add_to_wishlist");
add_action("wp_ajax_nopriv_add_to_wishlist", "add_to_wishlist");

function add_to_wishlist(){
    
}
