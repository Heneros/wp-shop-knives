<?php

/**
 * Loop Rating
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/rating.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

if (!defined('ABSPATH')) {
	exit;
}

global $product;

if (!wc_review_ratings_enabled()) {
	return;
}

$average      = $product->get_average_rating();
?>

<div class="bestsellers-products-item__line">
	<div class="stars stars_sm">
		<span style="width: <?php echo (($average / 5) * 100) ?>%"></span>
	</div>
	<div class="bestsellers-products-item__reviews">
		Reviews: <?php echo get_comments_number($product->ID); ?>
	</div>

</div>
<?php
// WordPress.XSS.EscapeOutput.OutputNotEscaped.
