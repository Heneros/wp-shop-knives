<?php


add_action('init', 'request_calls_post_type', 0);

function request_calls_post_type()
{
    register_post_type('request_calls', [
        'labels' => [
            'name' => __('Request Calls'),
            'singular_name' => __('Request Calls'),
            'menu_name' => __('Request Calls'),
            'view_item ' => 'View Request Calls',
            'edit_item' => 'Edit Request Calls',
            'update_item' => 'Update Request Calls',
            'add_new_item' => 'Add New Request Calls',
            'new_item_name' => 'Add New Request Calls',
        ],
        'rewrite' => [
            'slug' => 'request_calls'
        ],
        'description'         => '',
        'public'              => true,
        'show_ui'             => true,
        'capability_type'     => 'post',
        'map_meta_cap'        => true,
        'publicly_queryable'  => true,
        'exclude_from_search' => false,
        'hierarchical'        => false,
        'query_var'           => true,
        'show_in_rest' => true,
        'supports'            => ['title'],
        'has_archive' => false,
        'menu_position'       => 3,
        'show_in_nav_menus'   => true,
    ]);
}

add_action('add_meta_boxes', 'shop_meta_boxes');
function shop_meta_boxes()
{
    $fields = [
        'shop_order_date' => 'Date request: ',
        'shop_order_name' => 'Name client: ',
        'shop_order_phone' => 'Phone client: ',
        'shop_order_message' => 'Message client: ',
        'shop_order_choice' => 'Type form: ',
    ];
    foreach ($fields as $slug => $text) {
        add_meta_box(
            $slug,
            $text,
            'shop_review_fields_cb',
            'request_calls',
            'advanced',
            'default',
            $slug
        );
    }
}
function shop_review_fields_cb($post_obj, $slug)
{
    $slug = $slug['args'];
    switch ($slug) {
        case 'shop_order_date':
            $data = $post_obj->post_date;
            break;
        case 'shop_review_choice':
            $id = get_post_meta($post_obj->ID, $slug, true);
            $title = get_the_title($id);
            $type = get_post_type_object(get_post_type($id))->labels->singular_name;
            $data = 'Request call<strong>:' . $title . '</strong>. <br> From section: <strong>' . $type . '</strong>';
            break;
        default:
            $data = get_post_meta($post_obj->ID, $slug, true);
            $data = $data ? $data : 'No data';
    }
    echo '<p>' .  $data . '</p>';
}


// add_action("admin_post_shop-modal-form", "shop_modal_form_handler");
// add_action("admin_post_nopriv_shop-modal-form", "shop_modal_form_handler");

// add_action("admin_post_shop-modal-form", "shop_modal_form_handler");
// add_action("admin_post_nopriv_shop-modal-form", "shop_modal_form_handler");

// function shop_modal_form_handler()
// {
//     $name = $_POST['name'] ?  $_POST['name'] : 'Anonym';
//     $phone = $_POST['phone'] ?  $_POST['phone'] : false;
//     $message =  $_POST['message'] ?  $_POST['message'] : 'empty';
//     $choice =   $_POST['form-post-id'] ?  $_POST['form-post-id'] : 'empty';

//     if ($phone) {
//         $name = wp_strip_all_tags($name);
//         $phone = wp_strip_all_tags($phone);
//         $message = wp_strip_all_tags($message);
//         $choice = wp_strip_all_tags($choice);
//         $id = wp_insert_post(wp_slash([
//             'post_title' => 'Request call № ',
//             'post_type' => 'request_calls',
//             'post_status' => 'publish',
//             'meta_input' => [
//                 'shop_order_name' => $name,
//                 'shop_order_message' => $message,
//                 'shop_order_choice' => $choice
//             ]
//         ]));
//         if ($id  !== 0) {
//             wp_update_post([
//                 'ID' => $id,
//                 'post_title' => 'Request call №' . $id,
//             ]);
//             // update_field('status_order', 'new', $id);
//         }
//     }
//     header("Location: " . home_url());
// }

// add_action("admin_post_shop-modal-form", "shop_modal_form_handler");
// add_action("admin_post_nopriv_shop-modal-form", "shop_modal_form_handler");



add_action("admin_post_shop-modal-form", "shop_modal_form_handler");
add_action("admin_post_nopriv_shop-modal-form", "shop_modal_form_handler");

function shop_modal_form_handler()
{
    check_ajax_referer('shop-modal-form-nonce', 'shop-modal-form-nonce');

    $name = isset($_POST['name']) ? sanitize_text_field($_POST['name']) : 'Anonym';
    $phone = isset($_POST['phone']) ? sanitize_text_field($_POST['phone']) : false;
    $message = isset($_POST['message']) ? sanitize_text_field($_POST['message']) : 'empty';


    if ($phone) {
        $name = wp_strip_all_tags($name);
        $phone = wp_strip_all_tags($phone);
        $message = wp_strip_all_tags($message);
        $id = wp_insert_post(wp_slash([
            'post_title' => 'Request call № ',
            'post_type' => 'request_calls',
            'post_status' => 'publish',
            'meta_input' => [
                'shop_order_name' => $name,
                'shop_order_message' => $message,
            ]
        ]));
        if ($id  !== 0) {
            wp_update_post([
                'ID' => $id,
                'post_title' => 'Request call №' . $id,
            ]);
        }
        // wp_send_json([
        //     'status' => 'success'
        // ]);
    } else {
        // wp_send_json([
        //     'status' => 'error'
        // ]);
    }
    header("Location: " . home_url() . '#model-success');
}
