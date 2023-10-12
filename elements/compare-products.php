<?php

// print_r($args);

while ($args['objects']->have_posts()) {
    $args['objects']->the_post();
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
}
?>