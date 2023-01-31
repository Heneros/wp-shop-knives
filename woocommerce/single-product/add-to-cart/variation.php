<?php

/**
 * Single variation display
 *
 * This is a javascript-based template for single variations (see https://codex.wordpress.org/Javascript_Reference/wp.template).
 * The values will be dynamically replaced after selecting attributes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 2.5.0
 */

defined('ABSPATH') || exit;

?>
<script type="text/template" id="tmpl-variation-template">
	<!-- <div class="woocommerce-variation-description">{{{ data.variation.variation_description }}}</div>
	<div class="woocommerce-variation-availability">{{{ data.variation.availability_html }}}</div>
	<div class="woocommerce-variation-custom_field">
{{{ data.variation.custom_field}}}
</div>
	<div class="product-information__right-bottom">

	</div> -->

	<div class="woocommerce-variation-price">{{{ data.variation.price_html }}}</div>

	<div class="product-information__right-middle" bis_skin_checked="1">
		<ul class="list-reset product-information__right-list">
			<li class="product-information__right-item-left"> Vendor Code:</li>
			<li class="product-information__right-item-left"> Trademark:</li>
			<li class="product-information__right-item-left"> Seria:</li>
			<li class="product-information__right-item-left"> Bonus points:</li>
		</ul>
		<ul class="list-reset product-information__right-list">
			<li class="product-information__right-item-right" id="p_sku"> </li>
			<li class="product-information__right-item-right"> DFFFDF(Germany)</li>
			<li class="product-information__right-item-right"> Knifes seria(5d5d)</li>
			<li class="product-information__right-item-right"> 323</li>
		</ul>
	</div>
</script>
<script type="text/template" id="tmpl-unavailable-variation-template">
	<p><?php esc_html_e('Sorry, this product is unavailable. Please choose a different combination.', 'woocommerce'); ?></p>
</script>