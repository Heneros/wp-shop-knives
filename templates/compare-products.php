<?php

/**
 * 
 * Template Name: Compare Products
 * 
 */
get_header();
$products_compare = [];

if (isset($_SESSION['products_compare'])) {
    $products_compare = $_SESSION['products_compare'];
}
$args = [
    'posts_per_page' => -1,
    'post_type' => 'product',
    'post__in' => ((!isset($products_compare) || empty($products_compare)) ? array(-1) : $products_compare),
];
$recent_prods = new WP_Query($args);
?>
<section class="compare-products margin-top">
    <div class="container">
        <?php woocommerce_breadcrumb(); ?>
        <?php if ($recent_prods->found_posts) : ?>
            <a href="#!" class="clear_compare">Clear Table</a>
            <table class="compare-products__table">
                <?php
                if ($recent_prods->have_posts()) :
                ?>
                    <thead>
                        <tr>
                            <th>
                            </th>
                            <th>
                                Name:
                            </th>
                            <th>
                                Price:
                            </th>
                            <th>
                                Rating:
                            </th>
                            <th>
                                Bonus Points:
                            </th>
                            <th>
                                Trademark:
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($recent_prods->have_posts()) :
                            $recent_prods->the_post();
                            $product = wc_get_product(get_the_ID());

                            $product_id = $product->get_id();
                            $product_title = $product->get_name();
                            $product_description = $product->get_description();
                            $product_sku = $product->get_sku();
                            $product_price = $product->get_price_html();
                            $image_url = wp_get_attachment_image_src(get_post_thumbnail_id($product->get_id()), '');
                            $product_image = $image_url[0];
                            $avg_rating = $product->get_average_rating();
                            $product_link = $product->get_permalink();

                            $vendor_code = get_post_meta($product->get_id(), '_custom_product_vendor_code', true);
                            $trademark = get_post_meta($product->get_id(), '_custom_product_trademark_field', true);
                            $product_seria = get_post_meta($product->get_id(), '_custom_product_seria', true);
                            $bonus_points = get_post_meta($product->get_id(), '_custom_product_bonus_points', true);

                            $vendor_code = get_post_meta($product_id, '_custom_product_vendor_code', true);
                        ?>

                            <tr>
                                <td data-label="">
                                    <a href=" <?= $product_link; ?>">
                                        <img src="<?= $product_image; ?>" alt="">
                                    </a>
                                </td>
                                <td data-label="Name">
                                    <a href="<?= $product_link; ?>">
                                        <?php
                                        echo  $product_title;
                                        ?>
                                    </a>
                                </td>
                                <td data-label="Price">
                                    <?php
                                    echo  $product_price;
                                    ?>
                                </td>
                                <?php if (!empty($avg_rating)) : ?>
                                    <td data-label="Rating">
                                        <?php
                                        echo  $avg_rating;
                                        ?>
                                    </td>
                                <?php else : ?>
                                    <td>
                                    </td>
                                <?php endif;   ?>
                                <?php
                                if (!empty($bonus_points)) : ?>
                                    <td data-label="Bonus Points">
                                        <?php
                                        echo  $bonus_points;
                                        ?>
                                    </td>
                                <?php else : ?>
                                    <td>
                                    </td>
                                <?php endif;
                                if (!empty($trademark)) :
                                ?>
                                    <td data-label="Trademark">
                                        <?php
                                        echo  $trademark;
                                        ?>
                                    </td>
                                <?php else : ?>
                                    <td>
                                    </td>
                                <?php endif; ?>
                                <td>
                                    <span data-prodId="<?= $product_id; ?>" class="remove_compare">
                                        Remove product from table
                                    </span>
                                </td>
                            </tr>
                        <?php
                        endwhile;
                        ?>
                    </tbody>
                <?php
                endif;
                wp_reset_postdata();
                ?>
            </table>
        <?php
        else :
        ?>
        <p>No products added.</p>
        <?php
        endif; ?>
    </div>
</section>
<?php
get_footer()

?>