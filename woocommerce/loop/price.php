<?php

/**
 * Loop Price
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/price.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     1.6.4
 */

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

global $product;
?>

<?php if ($price_html = $product->get_price_html()) : ?>
	<span class="bestsellers-products-item__price"><?php echo $price_html; ?></span>
<?php endif; ?>

<div class="bestsellers-products-item__icons" bis_skin_checked="1">
	<span class="bestsellers-products-item__scales">
		<img src="<?php echo _assets_paths('img/sprite.svg#scales'); ?>" alt="icon scales">
	</span>
	<a href="#!" class="bestsellers-products-item__favorites">
		<!-- <img src="<?php echo _assets_paths('img/sprite.svg#favorites-yellow'); ?>" alt="icon favorite"> -->
	</a>
</div>