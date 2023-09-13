<?php

/**
 * Single variation cart button
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.0.1
 */

defined('ABSPATH') || exit;

global $product;
?>

<div class="woocommerce-variation-add-to-cart variations_button product-information__right-bottom">
	<?php wc_get_template('single-product/price.php'); ?>



	<div class="product-information__btns">
		<?php do_action('woocommerce_before_add_to_cart_button'); ?>
		<div class="product-information__quantity parent-quantity ">
			<button class="product-information__minus  icon-minus  quantity-minus" type="button">-</button>
			<?php
			do_action('woocommerce_before_add_to_cart_quantity');
			?>
			<input type="text" name="prod_quantity" class="product-information__input h5 js-quantity-input input_qty" min="<?php echo apply_filters('woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product); ?>" max="<?php echo apply_filters('woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product); ?>" value="<?php echo isset($_POST['quantity']) ? wc_stock_amount(wp_unslash($_POST['quantity'])) : $product->get_min_purchase_quantity(); ?>" />
			<?php
			do_action('woocommerce_after_add_to_cart_quantity');
			?>
			<button class="product-information__plus icon-plus   quantity-plus" type="button">+</button>
		</div>

		<div class="group-btns ">
			<button type="submit" class="btn btn-bottom btn-yellow  single_add_to_cart_button add-to-cart-with-quantity-variable_product-btn button hidden-btn">
				<?php echo esc_html($product->single_add_to_cart_text()); ?>
			</button>
			<!-- <button class="btn btn-bottom btn-yellow">
				Buy in 1 click
			</button> -->

			<?php do_action('woocommerce_after_add_to_cart_button'); ?>

			<input type="hidden" name="add-to-cart" value="<?php echo absint($product->get_id()); ?>" />
			<input type="hidden" name="product_id" value="<?php echo absint($product->get_id()); ?>" />
			<input type="hidden" name="variation_id" class="variation_id" value="0" />
		</div>

	</div>

</div>