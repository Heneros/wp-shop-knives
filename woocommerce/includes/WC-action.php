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
        <div class="bestsellers-products-item__line">


        <?php
              wc_display_product_attributes($product);
              
         echo wc_get_product_tag_list( $product->get_id(), ' ', '<span class="bestsellers-products-item__structure">' . ' ', '</span>' );
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
                <!-- svg -->
                <!-- <svg width="34" height="29" viewBox="0 0 34 29" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M2.176 5.267h0C1.04 7.104.688 9.192 1.143 11.204h0c.59 2.593 2.765 5.443 5.792 8.057 0 0 0 0 0 0l9.47 8.565c.166.15.383.225.599.225a.892.892 0 00.6-.225l9.468-8.565s0 0 0 0c2.614-2.27 4.999-5.016 5.747-7.864h0c.957-4.055-1.166-7.578-4.445-9.308C25.104.364 20.68.42 17.004 3.502 12.438-.44 5.362.245 2.176 5.267zm6.753 13.614h0l-.34-.303c-1.117-.992-2.715-2.412-3.974-4.102-1.394-1.87-2.365-4.058-1.816-6.352h0c.717-3.217 3.734-5.61 7.458-5.62 1.957-.002 3.826.712 5.41 1.986h0l.002.002c.149.109.286.235.426.364l.007.006c.141.131.285.264.443.378h0l.004.002c.33.197.805.144 1.071-.121 1.343-1.298 3.126-2.303 5.075-2.549h0c3.442-.442 6.836 1.3 8.148 4.405.764 1.807.664 3.774-.227 5.518-.936 1.779-1.805 2.889-3.712 4.713-1.03.986-2.36 2.179-4.165 3.797-1.534 1.375-3.41 3.057-5.735 5.18l-.034-.03-.192-.174-.7-.634-2.274-2.056-4.875-4.41zM23.622 3.859h0-.006c-.518.088-.772.497-.713.878.029.19.136.37.322.496.184.126.445.195.78.172 1.821.1 3.345 1.192 3.929 2.81.097.272.162.544.196.828 0 .24.061.466.202.637.142.172.36.282.662.292H29c.377-.023.616-.17.74-.397.123-.223.13-.512.067-.809a5.487 5.487 0 00-1.155-2.637c-1.13-1.435-3.05-2.336-5.029-2.27z"></path>
            </svg> -->
                <img src="<?php echo _assets_paths('img/sprite.svg#favorites-yellow'); ?>" alt="icon favorite">

            </a>
        <?php } else {   ?>
            <a href="#!" class="bestsellers-products-item__favorites add_favorite <?php echo $class; ?>" data-prodid="<?php echo $prod_id; ?>">
                <img src="<?php echo _assets_paths('img/sprite.svg#favorites-yellow'); ?>" alt="icon favorite">

                <!-- <svg width="34" height="29" viewBox="0 0 34 29" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M2.176 5.267h0C1.04 7.104.688 9.192 1.143 11.204h0c.59 2.593 2.765 5.443 5.792 8.057 0 0 0 0 0 0l9.47 8.565c.166.15.383.225.599.225a.892.892 0 00.6-.225l9.468-8.565s0 0 0 0c2.614-2.27 4.999-5.016 5.747-7.864h0c.957-4.055-1.166-7.578-4.445-9.308C25.104.364 20.68.42 17.004 3.502 12.438-.44 5.362.245 2.176 5.267zm6.753 13.614h0l-.34-.303c-1.117-.992-2.715-2.412-3.974-4.102-1.394-1.87-2.365-4.058-1.816-6.352h0c.717-3.217 3.734-5.61 7.458-5.62 1.957-.002 3.826.712 5.41 1.986h0l.002.002c.149.109.286.235.426.364l.007.006c.141.131.285.264.443.378h0l.004.002c.33.197.805.144 1.071-.121 1.343-1.298 3.126-2.303 5.075-2.549h0c3.442-.442 6.836 1.3 8.148 4.405.764 1.807.664 3.774-.227 5.518-.936 1.779-1.805 2.889-3.712 4.713-1.03.986-2.36 2.179-4.165 3.797-1.534 1.375-3.41 3.057-5.735 5.18l-.034-.03-.192-.174-.7-.634-2.274-2.056-4.875-4.41zM23.622 3.859h0-.006c-.518.088-.772.497-.713.878.029.19.136.37.322.496.184.126.445.195.78.172 1.821.1 3.345 1.192 3.929 2.81.097.272.162.544.196.828 0 .24.061.466.202.637.142.172.36.282.662.292H29c.377-.023.616-.17.74-.397.123-.223.13-.512.067-.809a5.487 5.487 0 00-1.155-2.637c-1.13-1.435-3.05-2.336-5.029-2.27z"></path>
            </svg> -->
                <!-- svg -->
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
