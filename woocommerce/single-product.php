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
						<div class="swiper mySwiperGallery1 mySwiperGallery2">
							<div class="swiper-wrapper">
								<div class="swiper-slide">
									<img src="<?php echo $productImage ?>" alt="img gallery">
								</div>
							</div>
						</div>
						<div class="swiper mySwiperGallery1">
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

				</div>
			</div>
		</div>
	</div>
</section>
<?php
get_footer();
