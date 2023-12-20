<?php




require get_template_directory() . '/woocommerce/includes/WC-action.php';

require get_template_directory() . '/inc/viewed_products.php';
require get_template_directory() . '/inc/filter.php';
require get_template_directory() . '/inc/functions/custom_pagination.php';
require get_template_directory() . '/inc/shop-loadmore.php';
require get_template_directory() . '/inc/compare_products.php';
require get_template_directory() . '/inc/request_call.php';

///woocommerce
require get_template_directory() . '/inc/woocommerce/shop.php';
require get_template_directory() . '/inc/woocommerce/single-product.php';
require get_template_directory() . '/inc/woocommerce/wishlist.php';
require get_template_directory() . '/inc/woocommerce/cart.php';
require get_template_directory() . '/inc/woocommerce/checkout.php';


add_action('wp_ajax_nopriv_accept_cookie', 'accept_cookie');
add_action('wp_ajax_accept_cookie', 'accept_cookie');

function accept_cookie()
{
    if (isset($_POST['accept_cookie'])) {
        $_SESSION['id'] = session_id();
        setcookie('cookie_consent', $_SESSION['id'], time() + 60 * 60 * 24 * 365, '/');
        echo 'success';
    } elseif (isset($_POST['decline_cookie'])) {
        setcookie('cookie_consent', 'declined', time() + 60 * 60 * 24 * 365, '/');
        echo 'error';
    }
}



add_action('wp_ajax_nopriv_remove_product_from_cookie', 'remove_product_from_cookie');
add_action('wp_ajax_remove_product_from_cookie', 'remove_product_from_cookie');

function remove_product_from_cookie()
{
    $product_id = $_POST['productId'];
    $watched_products = json_decode(stripslashes($_COOKIE['watched_products']), true);
    unset($watched_products[$product_id]);
    setcookie('watched_products', json_encode($watched_products), time() + 60 * 60 * 24 * 30, '/');
    echo json_encode($watched_products);
    wp_die();
}


///Contact form 7.Remove styles.
add_filter('wpcf7_autop_or_not', '__return_false');
function rjs_lwp_contactform_css_js()
{
    global $post;
    if (is_a($post, 'WP_Post') && has_shortcode($post->post_content, 'contact-form-7')) {
        wp_enqueue_script('contact-form-7');
        wp_enqueue_style('contact-form-7');
    } else {
        wp_dequeue_script('contact-form-7');
        wp_dequeue_style('contact-form-7');
    }
}

add_action('wp_enqueue_scripts', 'rjs_lwp_contactform_css_js');




if (function_exists('acf_add_options_page')) {
    acf_add_options_page(array(
        'page_title' => 'Theme General Settings',
        'menu_title' => 'Theme Settings',
        'menu_slug' => 'theme-general-settings',
        'capability' => 'edit_posts',
        'redirect' => false
    ));
}




function add_additional_class_on_li($classes, $item, $args)
{
    if (isset($args->add_li_class)) {
        $classes[] = $args->add_li_class;
    }
    return $classes;
}
add_filter('nav_menu_css_class', 'add_additional_class_on_li', 1, 3);

function add_menu_link_class($atts, $item, $args)
{
    if (property_exists($args, 'link_class')) {
        $atts['class'] = $args->link_class;
    }
    return $atts;
}
add_filter('nav_menu_link_attributes', 'add_menu_link_class', 1, 3);




function _assets_paths($path)
{
    return get_template_directory_uri() . '/assets/' . $path;
}

add_action('wp_enqueue_scripts', 'theme_enqueue_styles', 99);
function theme_enqueue_styles()
{
    // wp_enqueue_style("css-custom", _assets_paths("/css/custom.css"), [], "1.0", 'all');
    // wp_enqueue_style("css-formstyler", _assets_paths("/css/jquery.formstyler.theme.css"), [], "1.1", 'all');
    // wp_enqueue_style("css-vendor", _assets_paths("/css/vendor.css"), [], "1.1", 'all');
    wp_enqueue_style("css-main-custom", _assets_paths("/css/custom.css"), [], "1.0", 'all');
    wp_enqueue_style("css-main", _assets_paths("/css/main.css"), [], "1.0", 'all');
    // wp-content/themes/shop-knives/assets/css/jquery.formstyler.theme.css

}





function shop_scripts()
{

    // wp_localize_script("ajax-script", 'my_ajax_object', array('ajax_url' =>  admin_url('admin-ajax.php')));
    wp_enqueue_script("ajax-script", get_template_directory_uri() . '/assets/js/custom.js', array("jquery"));

    wp_localize_script("ajax-script", 'my_ajax_object', array(
        'ajax_url' =>  admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('my-ajax-nonce')
    ));

    wp_enqueue_script('js-vendor-swiper', _assets_paths('/js/vendor/swiper.min.js'), ['jquery'], true);
    wp_enqueue_script('js-vendor-aos', _assets_paths('/js/vendor/aos.js'),  ['jquery'], true);
    wp_enqueue_script('js-vendor-rangeSlider', _assets_paths('/js/vendor/ion.rangeSlider.min.js'),  ['jquery'], true);
    wp_enqueue_script('js-vendor-formstyler', _assets_paths('/js/vendor/jquery.formstyler.min.js'), ['jquery'], true);
    wp_enqueue_script('js-vendor-rateyo', _assets_paths('/js/vendor/jquery.rateyo.min.js'), ['jquery'], true);
    wp_enqueue_script('js-vendor-nouislider', _assets_paths('/js/vendor/nouislider.min.js'),  ['jquery'], true);
    wp_enqueue_script("js-scripts", get_template_directory_uri() . '/assets/js/script.js', array("jquery"));

    // wp_enqueue_script('js-custom', _assets_paths('/js/custom.js'), ['jquery'], true);
    // wp_enqueue_script('js-main', _assets_paths('/js/script.js'),  ['jquery'], true);

    // wp_enqueue_style("css-custom", _assets_paths("/css/custom.css"), [], "1.0", 'all');
    // wp_enqueue_style("css-formstyler", _assets_paths("/css/jquery.formstyler.theme.css"), [], "1.1", 'all');
    // wp_enqueue_style("css-vendor", _assets_paths("/css/vendor.css"), [], "1.1", 'all');
}

add_action("wp_enqueue_scripts", "shop_scripts");





add_action("after_setup_theme", "shop_setup");

function shop_setup()
{
    register_nav_menu("menu-header-first", "Menu Header First");
    register_nav_menu("menu-footer-information", "Menu Footer Information");
    register_nav_menu("menu-footer-support", "Menu Footer Support");
    register_nav_menu("menu-footer-additional", "Menu Footer Additional");
    register_nav_menu("menu-footer-personal", "Menu Footer Personal");
    register_nav_menu("featured-product", "Menu Featured Products");


    add_theme_support('title-tag');

    add_theme_support('custom-logo');
    add_theme_support('post-thumbnails');
    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
    add_theme_support('automatic-feed-links');

    add_theme_support(
        'html5',
        array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
            'style',
            'script',
        )
    );
}
