<?php

/**
 * The Template for displaying all single products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/prodact.php.
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
get_header();

$product_id = get_the_ID();
$product = wc_get_product($product_id);
?>
<section class="product-information">
	<div class="container">
		<div class="product-information__container">
			<div class="product-information__breadcrumbs">
				<a href="<?php echo site_url("/"); ?>" class="breadcrumbs-link breadcrumbs-homepage">Homepage</a>
				<span class="divide">></span>
				<a href="<?php echo site_url("/shop"); ?>" class="breadcrumbs-link">Shop</a>
				<span class="divide">></span>
				<a href="#!" class="breadcrumbs-link"><?php the_title(); ?></a>
			</div>
			<div class="product-information__top">
				<div class="product-information__left-side">
					<?php
					$attachment_ids = $product->get_gallery_image_ids();
					$image_url = wp_get_attachment_image_src(get_post_thumbnail_id($product_id), '');
					$productImage  = $image_url[0];
					?>
					<div class="product-information__slider">
						<div class="swiper mySwiperGallery2">
							<div class="swiper-wrapper">
								<?php
								foreach ($attachment_ids as $attachment_id) :
									$img_link = wp_get_attachment_url($attachment_id);
								?>
									<div class="swiper-slide">
										<img src="<?php echo $img_link; ?>" alt="img gallery">
									</div>
								<?php endforeach; ?>
							</div>
						</div>
						<div thumbsSlider="" class="swiper mySwiperGallery1">
							<div class="swiper-wrapper">
								<?php
								foreach ($attachment_ids as $attachment_id) :
									$img_link = wp_get_attachment_url($attachment_id);
								?>
									<div class="swiper-slide">
										<img src="<?php echo $img_link; ?>" alt="img gallery">
									</div>
								<?php endforeach; ?>

							</div>
						</div>
					</div>
				</div>
				<div class="product-information__right-side">
					<div class="product-information__right-wrapper">
						<div class="product-information__right-top-block">
							<div class="product-information__right-top">
								<div class="product-information__title-rating">
									<h2 class="title-rating">Knife Unique</h2>
									<div class="product-information__stars">
										<img src="img/star.svg" alt="icon star">
										<img src="img/star.svg" alt="icon star">
										<img src="img/star.svg" alt="icon star">
										<img src="img/star.svg" alt="icon star">
										<img src="img/star.svg" alt="icon star">
									</div>
								</div>
								<div class="product-information__icons">
									<span class="product-information__scales">
										<img src="<?php echo _assets_paths('img/sprite.svg#scales'); ?>" alt="icon scales">
									</span>
									<a href="#!" class="product-information__favorites">
										<!-- <img src="<?php echo _assets_paths('/img/sprite.svg#favorites-yellow'); ?>" alt="icon favorite"> -->
										<?php echo print_wish_icon($product->get_id()); ?>
									</a>
								</div>
							</div>
							<span class="available">In stock</span>
						</div>
						<div class="line"></div>
						<div class="product-information__right-middle">
							<ul class="list-reset product-information__right-list">
								<li class="product-information__right-item-left"> Vendor Code:</li>
								<li class="product-information__right-item-left"> Trademark:</li>
								<li class="product-information__right-item-left"> Seria:</li>
								<li class="product-information__right-item-left"> Bonus points:</li>
							</ul>
							<ul class="list-reset product-information__right-list">
								<li class="product-information__right-item-right"> 54654DFR546</li>
								<li class="product-information__right-item-right"> DFFFDF(Germany)</li>
								<li class="product-information__right-item-right"> Knifes seria(5d5d)</li>
								<li class="product-information__right-item-right"> 323</li>
							</ul>
						</div>
						<div class="line"></div>

						<div class="product-information__right-dropdowns">
							<?php
							if ($product->is_type('variable')) {
								woo_display_variation_dropdown_on_shop_page($product);
								do_action('woocommerce_single_product_summary');
							?>
								<style>
									.variations_form.hidden {
										display: none;
									}

									.single_variation_wrap {
										display: none !important;
									}

									.stock {
										display: none;
									}

									.product_title.entry-title {
										display: none !important;
									}

									.product_meta {
										display: none !important;
									}

									.product-information__right-dropdowns .price {
										display: none !important;
									}
									.product-information__right-dropdowns .bestsellers-products-item__size {
										display: none !important;
									}
									
								</style>
							<?php
							}
							?>
						</div>
					</div>
					<div class="line"></div>
					<div class="product-information__right-bottom">
						<div class="product-information__price-info">
							<?php if ($product->is_type('variable')) { ?>
								<span class="price" id="variable_product_price"><?php echo $product->get_price_html(); ?></span>
							<?php } else { ?>
								<span class="price"><?php echo $product->get_price_html(); ?></span>
							<?php	} ?>
							<div class="info-points">
								<p class="description">
									+ 15 points per purchase.
								</p>
								<div class="tooltip">
									<span class="tooltip-text">
										Lorem ipsum dolor sit amet consectetur adipisicing elit. Iste rerum numquam
										deserunt a quidem ipsam.
									</span>
									?
								</div>
							</div>
						</div>
						<div class="product-information__btns">
							<div class="product-information__quantity js-quantity">
								<button class="product-information__minus icon icon-minus js-quantity-minus">-</button>
								<input class="product-information__input h5 js-quantity-input" type="text" name="prod_quantity" min="1" value="1">
								<button class="product-information__plus icon icon-plus js-quantity-plus">+</button>
							</div>
							<div class="group-btns">
								<?php
								echo apply_filters(
									'woocommerce_loop_add_to_cart_link', // WPCS: XSS ok.
									sprintf(
										'<a href="%s" data-quantity="%s" class="%s btn btn-bottom btn-yellow js-open-cart" %s>%s</a>',
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
								<a href="<?php echo site_url('/cart/?add-to-cart=') . absint($product->get_id()); ?>" class="btn btn-bottom btn-yellow">
									Buy in 1 click
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	</div>
</section>
<?php
get_footer();
