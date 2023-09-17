<?php

/**
 * Loop Add to Cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/add-to-cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.3.0
 */

if (!defined('ABSPATH')) {
	exit;
}

global $product;
global $product;
$variation_id_default = 0; // Инициализируем переменную

if ($product->is_type('variable')) {
	$default_attributes = $product->get_default_attributes();
	foreach ($product->get_available_variations() as $variation_values) {
		foreach ($variation_values['attributes'] as $key => $attribute_value) {
			$attribute_name = str_replace('attribute_', '', $key);
			$default_value = $product->get_variation_default_attribute($attribute_name);
			if ($default_value == $attribute_value) {
				$is_default_variation = true;
			} else {
				$is_default_variation = false;
				break; // Stop this loop to start next main loop
			}
		}
		if ($is_default_variation) {
			$variation_id = $variation_values['variation_id'];
			break; // Stop the main loop
		}
	}

	// Now we get the default variation data
	if ($is_default_variation) {
		// Raw output of available "default" variation details data
		$variation_id_default = $variation_id;
	}
}

if ($product->is_type('variable')) {

	echo apply_filters(
		'woocommerce_loop_add_to_cart_link', // WPCS: XSS ok.
		sprintf(
			'<a href="%s" class="%s bestsellers-products-item__btn btn-yellow" target="_blank">%s</a>',
			esc_url(get_permalink($product->get_id())),
			'',
			esc_html('Read More')
		),
		$product,
		$args
	);
} else {
	echo apply_filters(
		'woocommerce_loop_add_to_cart_link', // WPCS: XSS ok.
		sprintf(
			'<a href="%s" data-quantity="%s" class="%s bestsellers-products-item__btn btn-yellow js-open-cart " %s>%s</a>',
			esc_url($product->add_to_cart_url()),
			esc_attr(isset($args['quantity']) ? $args['quantity'] : 1),
			esc_attr('add-to-cart-btn'),
			isset($args['attributes']) ? wc_implode_html_attributes($args['attributes']) : '',
			esc_html($product->add_to_cart_text())
		),
		$product,
		$args
	);
?>
	<input type="hidden" value="<?php echo $variation_id_default ?>" name="variation_id">
	<input type="hidden" value="<?php echo $product->get_id() ?>" name="product_id">
	<input type="hidden" value="1" name="prod_quantity">
<?php
}
