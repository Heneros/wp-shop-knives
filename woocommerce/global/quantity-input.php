<?php

/**
 * Product quantity inputs
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/global/quantity-input.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 4.0.0
 */

defined('ABSPATH') || exit;
global $product;
if ($max_value && $min_value === $max_value) {
?>
	<div class="quantity hidden">
		<input type="hidden" id="<?php echo esc_attr($input_id); ?>" class="qty" name="<?php echo esc_attr($input_name); ?>" value="<?php echo esc_attr($min_value); ?>" />
	</div>
<?php
} else {
	/* translators: %s: Quantity. */
	$label = !empty($args['product_name']) ? sprintf(esc_html__('%s quantity', 'woocommerce'), wp_strip_all_tags($args['product_name'])) : esc_html__('Quantity', 'woocommerce');
?>

	<div class="quantity">
		<?php do_action('woocommerce_before_quantity_input_field'); ?>
		<input type="text" name="prod_quantity" class="<?php echo esc_attr(join(' ', (array) $classes)); ?> product-information__input h5 js-quantity-input input_qty" min="<?php echo apply_filters('woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product); ?>" max="<?php echo apply_filters('woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product); ?>" value="<?php echo isset($_POST['quantity']) ? wc_stock_amount(wp_unslash($_POST['quantity'])) : $product->get_min_purchase_quantity(); ?>" />
		<?php do_action('woocommerce_after_quantity_input_field'); ?>
	</div>
<?php
}
