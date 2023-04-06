<?php
do_action('woocommerce_before_mini_cart');

if (!WC()->cart->is_empty()) :

	do_action('woocommerce_before_mini_cart_contents');

	foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
		$_product   = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
		$product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);

		if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocoomerce_widget_cart_item_visible', true, $cart_item, $cart_item_key)) {
			$product_name      = apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key);
			$thumbnail         = apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key);
			$product_price     = apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key);
			$product_permalink = apply_filters('woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink($cart_item) : '', $cart_item, $cart_item_key);
?>
			<div class="card-item">
				<div class="card-img">
					<?php echo $thumbnail; ?>
				</div>
				<div class="card-info">
					<a class="card-info__title" href="	<?php echo $product_permalink; ?>">
						<?php echo $product_name; ?>
					</a>
				</div>
				<div class="card-price">
					<?php echo $product_price; ?>
				</div>
				<div class="card-quantity js-quantity">
					<!-- <button class="icon icon-minus quantity-minus" data-product_id="<?php echo $product_id; ?>" data-cart_item_key="<?php echo $cart_item_key; ?>">-</button> -->
			
					<!-- <button class="icon icon-plus quantity-plus" data-product_id="<?php echo $product_id; ?>" data-cart_item_key="<?php echo $cart_item_key; ?>">+</button> -->
					<?php echo apply_filters('woocommerce_widget_cart_item_quantity', '<span class="quantity">' . sprintf('%s &times; %s', $cart_item['quantity'], '') . '</span>', $cart_item, $cart_item_key); ?>

				</div>
				<?php
				echo apply_filters(
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
				)
				?>
			</div>
	<?php
		}
		do_action('woocommerce_mini_cart_contents');
	}
else : ?>
	<a href="<?= site_url('/shop'); ?>">
		Empty cart
	</a>
<?php

endif;
