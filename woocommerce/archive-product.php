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
<div class="margin-top">
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
					<button type="submit" class="btn btn-shop btn-reset" id="btn-filters">
						Filters
					</button>
					<div class="shop-category__sortby">
						<?php
						woocommerce_catalog_ordering(array(
							'orderby' => array(
								'default' => 'menu_order',
								'popularity' => 'popularity',
								'rating' => 'rating',
								'date' => 'date',
								'price' => 'price',
								'price-desc' => 'price-desc'
							),
							'order' => array(
								'default' => 'desc',
								'popularity' => 'desc',
								'rating' => 'desc',
								'date' => 'desc',
								'price' => 'asc',
								'price-desc' => 'desc'
							),
							'catalog_orderby_options' => array(
								'default' => __('Сортировка по умолчанию', 'woocommerce'),
								'popularity' => __('По популярности', 'woocommerce'),
								'rating' => __('По рейтингу', 'woocommerce'),
								'date' => __('По новизне', 'woocommerce'),
								'price' => __('По возрастанию цены', 'woocommerce'),
								'price-desc' => __('По убыванию цены', 'woocommerce')
							),



							'orderby_selected' => isset($_GET['orderby']) ? sanitize_text_field($_GET['orderby']) : 'default',
							'class' => 'filter-style select-item'
						));
						?>
						<button type="button" class="btn btn-reset" id="reset-btn">Reset </button>
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
					<div class="shop-catalog__products" id="products-container">
						<?php
						$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
						$postsPerPage = 6;
						$postOffset = ($paged - 1) * $postsPerPage;
						$args = array(
							'post_type' => 'product',
							'offset' => $postOffset,
							'posts_per_page' => $postsPerPage
						);
						$query = new WP_Query($args);
						if ($query->have_posts()) {
							while ($query->have_posts()) {
								$query->the_post();
								wc_get_template_part('content', 'product');
							}
						}

						woocommerce_product_loop_end();
						$next_page = $paged + 1;
						$max_pages = $query->max_num_pages;

						?>
					</div>
					<div class="shop-catalog__bottom">
						<?php if ($next_page <= $max_pages) : ?>

							<button class="btn btn-loadmore" data-nextpage="<?php echo $next_page; ?>" data-maxpages="<?php echo $max_pages; ?>" id="load-more">
								Load More
							</button>
						<?php else : ?>
							<style>
								.btn-loadmore {
									display: none !important;
								}
							</style>
						<?php endif;
						/**
						 * Hook: woocommerce_after_shop_loop.
						 *
						 * @hooked woocommerce_pagination - 10
						 */
						do_action('woocommerce_after_shop_loop');
						?>
					</div>
					<script>
						jQuery(document).ready(function($) {
							var page = 2;
							$('#load-more').on('click', function() {
								$.ajax({

									url: my_ajax_object.ajax_url,
									type: 'POST',
									data: {
										action: 'loadmore_shop',
										page: page,
										posts_per_page: <?php echo $postsPerPage; ?>
									},
									beforeSend: function() {
										$('#load-more').text('Loading...');
									},
									success: function(html) {
										$('#products-container').append(html);
										$('#load-more').text('Load more');
										page++;
										if (page > <?php echo $max_pages; ?>) {
											$('#load-more').hide();
										}
									}
								});
							});
						});
					</script>

				<?php
				} else {
					/**
					 * Hook: woocommerce_no_products_found.
					 *
					 * @hooked wc_no_products_found - 10
					 */
					do_action('woocommerce_no_products_found');
				}

				?>

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
</div>
<?php

get_template_part('template-parts/description-shop');

?>
<?php
get_footer('shop');
