<?php

/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined('ABSPATH') || exit;

global $product;

// Ensure visibility.
if (empty($product) || !$product->is_visible()) {
	return;
}

?>
<div <?php wc_product_class('bestsellers-products-item', $product); ?>>
	<?php
	/**
	 * Hook: woocommerce_before_shop_loop_item.
	 *
	 * @hooked woocommerce_template_loop_product_link_open - 10
	 */
	?>
	<div class="bestsellers-products-item__img">
		<?php
		do_action('woocommerce_before_shop_loop_item');

		/**
		 * Hook: woocommerce_before_shop_loop_item_title.
		 *
		 * @hooked woocommerce_show_product_loop_sale_flash - 10
		 * @hooked woocommerce_template_loop_product_thumbnail - 10
		 */

		do_action('woocommerce_before_shop_loop_item_title');
		?>
	</div>

	<div class="bestsellers-products-item__text">
		<?php
		/**
		 * Hook: woocommerce_shop_loop_item_title.
		 *
		 * @hooked woocommerce_template_loop_product_title - 10
		 */
		?>

		<div class="bestsellers-products-item__top">
			<?php
			do_action('woocommerce_shop_loop_item_title');
			?>

		</div>

		<div class="bestsellers-products-item__bottom">
			<?php

			/**
			 * Hook: woocommerce_after_shop_loop_item_title.
			 *
			 *
			 * @hooked woocommerce_template_loop_price - 10
			 */

			do_action('woocommerce_after_shop_loop_item_title');
			echo print_wish_icon($product->get_id()); ?>

			<?php
			/**
			 * 
			 * Hook: woocommerce_after_shop_loop_item.
			 *
			 * @hooked woocommerce_template_loop_product_link_close - 5
			 * @hooked woocommerce_template_loop_add_to_cart - 10
			 */
			?>
		</div>
		<?php
		do_action('woocommerce_after_shop_loop_item');

		?>
	</div>



	<?php


	if (is_page('viewed-products')) : ?>
		<button class="remove-product btn" data-product-id="<?php echo get_the_ID(); ?>">Remove product from list</button>
		<script>
			(function() {
				const removeBtns = document.querySelectorAll(".remove-product");

				removeBtns.forEach(btn => {
					btn.addEventListener('click', () => {
						const productId = btn.getAttribute("data-product-id");
						let watchedProducts = JSON.parse(getCookie('watched_products'));
						if (watchedProducts) {
							delete watchedProducts[productId];
							setCookie('watched_products', JSON.stringify(watchedProducts), 30);
						}
						btn.parentNode.remove();
					});
				});

				function getCookie(name) {
					const value = `; ${document.cookie}`;
					const parts = value.split(`; ${name}=`);
					if (parts.length === 2) return parts.pop().split().shift();
				}

				function setCookie(name, value, days) {
					let expires = '';
					if (days) {
						const date = new Date();
						date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
						expires = `; expires=${date.toUTCString()}`;
					}
					document.cookie = `${name}=${value}${expires}; path=/`;
				}

			})();
		</script>
	<?php
	endif;
	?>

</div>