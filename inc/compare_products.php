<?php

add_action("wp_ajax_compare_products", "compare_products");
add_action("wp_ajax_nopriv_compare_products", "compare_products");
function compare_products()
{

    if (!session_id()) {
        session_start();
    }

    if (isset($_POST['prod_id']) && !empty($_POST['prod_id'])) {
        if (!isset($_SESSION['products_compare'])) {
            $_SESSION['products_compare'] = array();
        }

        if (!in_array($_POST['prod_id'], $_SESSION['products_compare'])) {
            $_SESSION['products_compare'][] = $_POST['prod_id'];
            $response = array('response' => 'success');
        } else {
            $response = array('response' => 'error', 'message' => 'Product already added to compare page ');
        }
        echo json_encode($response);
    } else {
        $response = array('response' => 'error', 'message' => 'Error happened in compare page');
        echo json_encode($response);
    }
    wp_die();
}



add_action("wp_ajax_remove_compare_products", "remove_compare_products");
add_action("wp_ajax_nopriv_remove_compare_products", "remove_compare_products");
function remove_compare_products()
{
    if (!session_id()) {
        session_start();
    }

    if (isset($_POST['prod_id']) && !empty($_POST['prod_id'])) {
        foreach ($_SESSION['products_compare'] as $k => $item) {
            if ($item == $_POST['prod_id']) {
                unset($_SESSION['products_compare'][$k]);
            }
        }
        $prods = [];
        if (isset($_SESSION['products_compare'])) {
            $prods = $_SESSION['products_compare'];
        }
        $args = [
            'post_type' => 'product',
            'post__in' => ((!isset($prods) || empty($prods)) ? array(-1) : $prods)
        ];
        $compare_prods = new WP_Query($args);
        ob_start();
        get_template_part("elements/compare-products", '', ['objects' => $compare_prods]);
        $content = ob_get_clean();
        echo json_encode(['response' => 'success', 'products' => ($content) ? $content : '<p>No product been found.</p>', 'found_posts' => $compare_prods->found_posts]);
    }
    wp_die();
}
