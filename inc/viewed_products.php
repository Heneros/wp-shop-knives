<?php
// function rv_products_viewed()
// {
//     $rv_posts = array();

//     if (is_singular('product')) {
//         if (isset($_COOKIE['watched_products']) && $_COOKIE['watched_products'] != '') {
//             $rv_posts = unserialize($_COOKIE['watched_products']);

//             if (!is_array($rv_posts)) {
//                 $rv_posts = array(get_the_ID());
//             } else {
//                 $rv_posts = array_diff($rv_posts, array(get_the_ID()));
//                 array_unshift($rv_posts, get_the_ID());
//             }
//         } else {
//             $rv_posts = array(get_the_ID());
//         }

//         setcookie('watched_products', serialize($rv_posts), time() + DAY_IN_SECONDS * 30, '/');
//     }
// }

// add_action('template_redirect', 'rv_products_viewed');