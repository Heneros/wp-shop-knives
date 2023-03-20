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


<script>
	var productId = <?php echo json_encode(get_the_ID()); ?>;
	var watchedProducts = getCookie("watched_products");
	watchedProducts = watchedProducts ? JSON.parse(watchedProducts) : {};

	watchedProducts[productId] = true; // создает ассоциативный массив.
	setCookie('watched_products', JSON.stringify(watchedProducts), 30);

	function getCookie(name) {
		var value = "; " + document.cookie;
		var parts = value.split("; " + name + "=");
		if (parts.length == 2) {
			return parts.pop().split(";").shift();;
		}
	}

	function setCookie(name, value, days) {
		var expires = "";
		if (days) {
			var date = new Date();
			date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
			expires = "; expires=" + date.toUTCString();
		}
		document.cookie = name + "=" + value + expires + "; path=/";
	}
</script>

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
						</div>
						<?php if ($product->is_in_stock()) : ?>
							<span class="available">
								In stock
							</span>
						<?php else : ?>
							<span class="out_stock">
								Out of stock
							</span>
						<?php endif; ?>
						<div class="line"></div>
						<div class="product-information__right-dropdowns">
							<?php
							if ($product->is_type('variable')) {
								do_action('woocommerce_single_product_summary');
							?>
								<style>
									.bestsellers-products-item__size {
										display: none !important;
									}

									/* .product_meta {
										display: none !important;
									}

									.product-information__right-dropdowns .price {
										display: none !important;
									}

									.woocommerce-variation-availability {
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
									} */
								</style>


							<?php
							} else {

							?>
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
								<div class="line"></div>
								<style>
									.bestsellers-products-item__size {
										display: none !important;
									}

									.stock.out-of-stock {
										display: none !important;
									}
								</style>
								<?php wc_get_template('single-product/price.php'); ?>
								<div class="product-information__right-bottom">


									<?php
									do_action('woocommerce_single_product_summary');
									?>

								</div>
							<?php
							}

							?>

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
				</div>
				<div data-tab="delivery" class="delivery js-tabs-body-item ">
					<?php
					if (have_rows('your_country')) :
					?>
						<div class="delivery-location">
							<div class="delivery-title">
								Your country
							</div>
							<div class="info-dropdown">
								<select class="filter-style select-item">
									<?php
									while (have_rows('your_country')) :
										the_row();
										$country = get_sub_field('country'); ?>
										<option value="<?= $country; ?>"><?= $country; ?></option>
									<?php
									endwhile;
									?>
								</select>
							</div>
						</div>
					<?php
					endif;
					if (have_rows('your_city')) :
					?>
						<div class="delivery-location">
							<div class="delivery-title">
								Your City
							</div>
							<div class="info-dropdown">
								<select class="filter-style select-item">
									<?php
									while (have_rows('your_city')) :
										the_row();
										$city = get_sub_field('city'); ?>
										<option value="<?= $city; ?>"><?= $city; ?></option>
									<?php
									endwhile;
									?>
								</select>
							</div>
						</div>
					<?php
					endif;
					?>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- Related Products -->
<section class="similiar-products">
	<div class="container">
		<div class="text-above">
			<h1 class="title">Similiar Products</h1>
		</div>
		<div class="bestsellers-products bestsellers-products-swiper swiper">
			<div class="swiper-wrapper">
				<?php
				$args = array(
					'posts_per_page' => 7,
					'orderby' => 'rand'
				);
				woocommerce_related_products(apply_filters('woocommerce_output_related_products_args', $args));
				?>
			</div>
		</div>
		<div class="bestsellers-products__pagination swiper-pagination"></div>
	</div>
	<div class="text-above-adaptive">
		<a href="<?php echo site_url('/shop'); ?>" class="catalog">
			Go to catalog
		</a>
	</div>
	</div>
</section>
<section class="products-recommedation">
	<div class="container">
		<div class="text-above">
			<h1 class="title">Recommedation </h1>
		</div>
		<?php
		wp_reset_postdata();
		$recommended_products = get_field('recommended_products');
		$args = [
			'post__in' => $recommended_products,
			'post_type' => 'product'
		];
		$query = new WP_Query($args);
		if ($query->have_posts()) :
		?>
			<div class="bestsellers-products bestsellers-products-swiper swiper">
				<div class="swiper-wrapper">
					<?php while ($query->have_posts()) :
						$query->the_post();
					?>
						<div class="swiper-slide">
							<?php wc_get_template_part('content', 'product'); ?>
						</div>
					<?php endwhile; ?>
				</div>
			</div>
		<?php endif; ?>
		<div class="bestsellers-products__pagination swiper-pagination"></div>
	</div>
	<div class="text-above-adaptive">
		<a href="<?php echo site_url('/shop'); ?>" class="catalog">
			Go to catalog
		</a>
	</div>
	</div>
</section>
<?php
get_footer();
