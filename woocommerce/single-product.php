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
$product_sku = $product->get_sku();
$image_url = wp_get_attachment_image_src(get_post_thumbnail_id($product->get_id()), '');
$product_image = $image_url[0];
$average_rating      = $product->get_average_rating();

$product_short_desc = $product->get_short_description();
$product_description = $product->get_description();
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
								<div class="swiper-slide">
									<img src="<?php echo $product_image; ?>" alt="img gallery">
								</div>
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
									<h2 class="title-rating"><?php the_title(); ?></h2>
									<div class="bestsellers-products-item__line">
										<div class="stars stars_sm">
											<span style="width: <?php echo (($average_rating / 5) * 100) ?>%"></span>
										</div>
									</div>
								</div>
								<div class="product-information__icons">
									<span class="product-information__scales">
										<img src="<?php echo _assets_paths('img/sprite.svg#scales'); ?>" alt="icon scales">
									</span>
									<a href="#!" class="product-information__favorites">
										<?php
										echo print_wish_icon($product->get_id());
										?>
									</a>
								</div>
							</div>
							<span class="available">In stock</span>
						</div>
						<div class="line"></div>
						<div class="product-information__right-dropdowns">
							<?php
							if ($product->is_type('variable')) {
								do_action('woocommerce_single_product_summary');
							?>
								<style>
									.product_meta {
										display: none !important;
									}

									.product-information__right-dropdowns .price {
										display: none !important;
									}

									.woocommerce-variation-availability {
										display: none !important;
									}

									.bestsellers-products-item__size {
										display: none !important;
									}

									.product-information__right-dropdowns .product_title .entry-title {
										display: none !important;
									}

									.quantity.hidden {
										display: none !important;
									}

									.hidden-btn {
										display: none !important;
									}
								</style>


							<?php
							} else { ?>
								<div class="product-information__right-middle">
									<ul class="list-reset product-information__right-list">
										<li class="product-information__right-item-left"> Vendor Code:</li>
										<li class="product-information__right-item-left"> Trademark:</li>
										<li class="product-information__right-item-left"> Seria:</li>
										<li class="product-information__right-item-left"> Bonus points:</li>
									</ul>
									<ul class="list-reset product-information__right-list">
										<li class="product-information__right-item-right"> <?php
																							echo get_post_meta($post->ID, '_custom_product_vendor_code', true);
																							?></li>
										<li class="product-information__right-item-right"> <?php
																							echo get_post_meta($post->ID, '_custom_product_trademark_field', true);
																							?></li>
										<li class="product-information__right-item-right"> <?php
																							echo get_post_meta($post->ID, '_custom_product_seria', true);
																							?></li>
										<li class="product-information__right-item-right"> <?php
																							echo get_post_meta($post->ID, '_custom_product_bonus_points', true);
																							?></li>
									</ul>
								</div>
							<?php
							}
							?>
						</div>
					</div>
					<div class="line"></div>
					<div class="product-information__right-bottom">
						<div class="product-information__price-info custom_price">
							<?php if ($product->is_type('variable')) { ?>
								<span class="price" id="variable_product_price"><?php echo $product->get_price_html(); ?></span>
							<?php } else { ?>
								<span class="price"><?php echo $product->get_price_html(); ?></span>
							<?php	}	?>
							<div class="info-points">
								<p class="description">
									+ 15 points per purchase.
								</p>
								<div class="tooltip">
									<span class="tooltip-text">
										Lorem ipsum dolor sit amet consectetur adipisicing elit. Iste rerum numquam
										deserunt a quidem ipsam.
									</span>

								</div>
							</div>
						</div>
						<div class="product-information__btns">
							<?php
							do_action('woocommerce_before_add_to_cart_quantity');
							?>
							<div class="product-information__quantity js-quantity">
								<button class="product-information__minus icon icon-minus js-quantity-minus">-</button>
								<input class="product-information__input h5 js-quantity-input" type="number" name="prod_quantity" min="<?php echo apply_filters('woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product); ?>" max="<?php echo apply_filters('woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product); ?>" value="<?php echo isset($_POST['quantity']) ? wc_stock_amount(wp_unslash($_POST['quantity'])) : $product->get_min_purchase_quantity(); ?>">
								<button class="product-information__plus icon icon-plus js-quantity-plus">+</button>
							</div>


							<div class="group-btns">
								<?php
								do_action('woocommerce_after_add_to_cart_quantity');
								if ($product->is_type('variable')) { ?>
									<a href="<?php echo site_url('/cart/?add-to-cart=') . absint($product->get_id()); ?>" class="btn btn-bottom btn-yellow  add-to-cart-with-quantity-variable_product-btn  ">
										Add to cart
									</a>
									<a href="<?php echo site_url('/cart/?add-to-cart=') . absint($product->get_id()); ?>" class="btn btn-bottom btn-yellow">
										Buy in 1 click
									</a>
									<!-- Simple product -->
								<?php } else { ?>
									<a href="<?php echo site_url('/cart/?add-to-cart=') . absint($product->get_id()); ?>" class="btn btn-bottom btn-yellow add-to-cart-with-quantity-btn ">
										Add to cart
									</a>
									<a href="<?php echo site_url('/cart/?add-to-cart=') . absint($product->get_id()); ?>" class="btn btn-bottom btn-yellow">
										Buy in 1 click
									</a>
								<?php	}


								?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	</div>
</section>
<section class="product-tabs">
	<div class="container">
		<div class="product-tabs__container">
			<ul class="tabs-items js-tabs list-reset">
				<li><a href="#!" class="item-tab js-tabs-head-item description-tab  ">
						Description
					</a></li>`
				<li><a href="#!" class="item-tab js-tabs-head-item characteristic-tab  ">
						Characteristic
					</a></li>
				<li><a href="#!" class="item-tab js-tabs-head-item feedback-tab active ">
						Feedback
					</a></li>
				<li><a href="#!" class="item-tab js-tabs-head-item delivery-tab ">
						Delivery
					</a></li>
			</ul>
			<div class="line"></div>
			<div class="js-tabs-body">
				<div data-tab="description-product" class="description-product js-tabs-body-item">
					<p>
						<?php
						echo $product_short_desc;
						?>
					</p>
				</div>
				<div data-tab="characteristic" class="characteristic js-tabs-body-item ">
					<?php
					if (have_rows('product_characteristics')) :
						while (have_rows('product_characteristics')) :
							the_row();
							$name = get_sub_field('name'); ?>
							<div class="item">
								<h3 class="sub-title"><?= $name; ?></h3>
								<?php
								if (have_rows('list_characteristic')) :
									while (have_rows('list_characteristic')) :
										the_row();
										$name = get_sub_field('name');
										$value = get_sub_field('value');
								?>
										<div class="container-lists">
											<ul class="list-reset">
												<li><?= $name; ?></li>
											</ul>
											<ul class="list-reset">
												<li><?= $value; ?></li>
											</ul>
										</div>
								<?php
									endwhile;
								endif; ?>
							</div>
					<?php
						endwhile;
					endif; ?>
				</div>
				<div data-tab="feedback" class="feedback js-tabs-body-item active ">
					<!-- Not available -->
					<!-- <p class="description">Current product not available
                        <button class="btn write-review">Write review</button>
                    </p> -->
					<!-- Not available -->
					<?php
					echo comments_template();
					?>

					<!-- 
					<div class="feedback-item">
						<div class="feedback-item__head">
							<img src="img/feedback-user-2.png" class="avatar" alt="feedback-user">
							<div class="feedback-item__heading">
								<div class="name-star">
									<span class="name">
										Second Title
									</span>
									<div class="stars">
										<img src="img/star.svg" alt="icon star">
										<img src="img/star.svg" alt="icon star">
										<img src="img/star.svg" alt="icon star">
										<img src="img/star.svg" alt="icon star">
										<img src="img/star.svg" alt="icon star">
									</div>
								</div>
							</div>
							<div class="date">
								5.12.2022
							</div>
						</div>
						<div class="item-body">
							Lorem ipsum, dolor sit amet consectetur adipisicing elit. Inventore maiores doloremque in
							id, labore harum eligendi temporibus. Ipsum accusantium itaque facere eveniet. Aspernatur
							magnam provident debitis eveniet nihil inventore, saepe nisi ea amet nostrum pariatur
							impedit nobis quasi sed beatae harum asperiores possimus quaerat ut excepturi. Unde,
							voluptatum eius vitae doloremque laudantium rem non quidem?
							<div class="item-bottom">
								<span class="reply">Reply</span>
								<div class="favorites">
									<img src="img/sprite.svg#favorites-yellow" alt="icon favorite">
								</div>
							</div>
						</div>
					</div> -->

				</div>
			</div>
		</div>
	</div>
</section>
<?php
get_footer();
