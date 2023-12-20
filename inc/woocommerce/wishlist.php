<?php

function print_wish_icon($prod_id)
{
    $class = '';
    if (isset($_SESSION['wishlist']) && in_array($prod_id, $_SESSION['wishlist'])) {
        $class = 'in_list';
    }
    if (is_singular('product')) { ?>
        <a href="#!" class="bestsellers-products-item__favorites add_favorite <?php echo $class; ?>" data-prodId="<?php echo $prod_id; ?>">
            <img src="<?php echo _assets_paths('img/sprite.svg#favorites-yellow'); ?>" alt="icon favorite">
        </a>
    <?php } else {   ?>
        <a href="#!" class="bestsellers-products-item__favorites add_favorite <?php echo $class; ?>" data-prodId="<?php echo $prod_id; ?>">
            <img src="<?php echo _assets_paths('img/sprite.svg#favorites-yellow'); ?>" alt="icon favorite">
        </a>
<?php
    }
    return;
}

add_action("wp_ajax_add_to_wishlist", "add_to_wishlist");
add_action("wp_ajax_nopriv_add_to_wishlist", "add_to_wishlist");

function add_to_wishlist()
{

    if (!session_id()) {
        session_start();
    }

    if (isset($_POST['prod_id']) && !empty($_POST['prod_id'])) {
        if (!isset($_SESSION['wishlist'])) {
            $_SESSION['wishlist'] = array();
        }

        if (!in_array($_POST['prod_id'], $_SESSION['wishlist'])) {
            $_SESSION['wishlist'][] = $_POST['prod_id'];
            $response = array('response' => 'success');
            echo json_encode($response);
        } else {
            $response = array('response' => 'error', 'message' => 'Товар уже добавлен в список желаний.');
            echo json_encode($response);
        }
    } else {
        $response = array('response' => 'error', 'message' => 'Недостаточно данных для выполнения запроса.');
        echo json_encode($response);
    }

    wp_die();
}




add_action("wp_ajax_remove_from_wishlist", "remove_from_wishlist");
add_action("wp_ajax_nopriv_remove_from_wishlist", "remove_from_wishlist");


function remove_from_wishlist()
{
    if (!session_id()) {
        session_start();
    }

    if (isset($_POST['prod_id']) && !empty($_POST['prod_id'])) {
        foreach ($_SESSION['wishlist'] as $k => $item) {
            if ($item == $_POST['prod_id']) {
                unset($_SESSION['wishlist'][$k]);
            }
        }
        $prods = [];
        if (isset($_SESSION['wishlist'])) {
            $prods = $_SESSION['wishlist'];
        }
        $args = [
            'post_type' => 'product',
            'post__in' => ((!isset($prods) || empty($prods)) ? array(-1) : $prods)
        ];
        $wishlist_prods = new WP_Query($args);
        ob_start();
        get_template_part("elements/filtered-products", '', ['objects' => $wishlist_prods]);
        $content = ob_get_clean();
        echo json_encode(['response' => 'success', 'products' => ($content) ? $content : '<p>No products been found.</p>', 'found_posts' =>  $wishlist_prods->found_posts]);
    }

    wp_die();
}






add_action('wp_ajax_clear_wishlist', 'clear_wishlist');
add_action('wp_ajax_nopriv_clear_wishlist', 'clear_wishlist');
function clear_wishlist()
{
    if (isset($_POST['clear_wishlist'])) {
        echo json_encode(['foundd_posts' => 0, 'response' => 'success', 'wishlist_reset' => '<p>No products in wishlist</p>']);
        unset($_SESSION['wishlist']);
    }
    die;
}
