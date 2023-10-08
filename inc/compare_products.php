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
