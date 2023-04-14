<?php

/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.4.0
 */

defined('ABSPATH') || exit;

get_header('shop');

/**
 * Hook: woocommerce_before_main_content.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 * @hooked WC_Structured_Data::generate_website_data() - 30
 */
// do_action('woocommerce_before_main_content');

?>
<header class="woocommerce-products-header">


	<?php
	/**
	 * Hook: woocommerce_archive_description.
	 *
	 * @hooked woocommerce_taxonomy_archive_description - 10
	 * @hooked woocommerce_product_archive_description - 10
	 */
	do_action('woocommerce_archive_description');
	?>
</header>
<section class="shop-category ">
	<div class="container">
		<div class="shop-category__information">
			<h1 class="shop-category__title title"><?php echo woocommerce_page_title(); ?></h1>
			<div class="shop-category__second-row">
				<div class="shop-category__breadcrumbs">
					<a href="<?php echo site_url('/'); ?>" class="breadcrumbs-link breadcrumbs-homepage">Homepage</a>
					<span class="divide">></span>
					<a href="<?php echo site_url('/shop'); ?>" class="breadcrumbs-link"><?= woocommerce_page_title(); ?></a>
				</div>
				<button class="btn btn-shop" id="btn-filters">
					Filters
				</button>
				<div class="shop-category__sortby">
					<select class="filter-style select-item">
						<option value="">Popularity</option>
						<option value="">Newness</option>
						<option value="">Rating</option>
					</select>
				</div>
			</div>
		</div>
	</div>
</section>
<section class="shop-catalog">
	<div class="container grid">
		<div class="shop-catalog__left">
			<div class="blank"></div>
			<div class="shop-catalog__filters">
				<?php
				echo do_shortcode('[wpf-filters id=1]');
				?>
			</div>
		</div>
		<div class="shop-catalog__right">

			<?php
			if (woocommerce_product_loop()) {

				/**
				 * Hook: woocommerce_before_shop_loop.
				 *
				 * @hooked woocommerce_output_all_notices - 10
				 * @hooked woocommerce_result_count - 20
				 * @hooked woocommerce_catalog_ordering - 30
				 */
				// do_action('woocommerce_before_shop_loop');

				// woocommerce_product_loop_start();
			?>
				<div class="shop-catalog__products">
				<?php
				if (wc_get_loop_prop('total')) {
					while (have_posts()) {
						the_post();
						do_action('woocommerce_shop_loop');
						wc_get_template_part('content', 'product');
					}
				}

				woocommerce_product_loop_end();

				/**
				 * Hook: woocommerce_after_shop_loop.
				 *
				 * @hooked woocommerce_pagination - 10
				 */
				do_action('woocommerce_after_shop_loop');
			} else {
				/**
				 * Hook: woocommerce_no_products_found.
				 *
				 * @hooked wc_no_products_found - 10
				 */
				do_action('woocommerce_no_products_found');
			}

				?>
				</div>
				<?php
				/**
				 * Hook: woocommerce_after_main_content.
				 *
				 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
				 */
				do_action('woocommerce_after_main_content');

				/**
				 * Hook: woocommerce_sidebar.
				 *
				 * @hooked woocommerce_get_sidebar - 10
				 */
				?>

		</div>

	</div>
</section>
<?php
get_footer('shop');
