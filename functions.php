<?php

require get_template_directory() . '/woocommerce/includes/WC-action.php';




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
    wp_enqueue_style("css-main", _assets_paths("/css/main.css"), [], "1.0", 'all');
}





function shop_scripts()
{
    wp_enqueue_script("ajax-script", get_template_directory_uri() . '/assets/js/custom.js', array("jquery"));

    wp_localize_script("ajax-script", 'my_ajax_object', array('ajax_url' =>  site_url() . '/wp-admin/admin-ajax.php'));

    wp_enqueue_script('js-vendor-swiper', _assets_paths('/js/vendor/swiper.min.js'), ['jquery'], true);
    wp_enqueue_script('js-vendor-aos', _assets_paths('/js/vendor/aos.js'),  ['jquery'], true);
    wp_enqueue_script('js-vendor-rangeSlider', _assets_paths('/js/vendor/ion.rangeSlider.min.js'),  ['jquery'], true);
    wp_enqueue_script('js-vendor-formstyler', _assets_paths('/js/vendor/jquery.formstyler.min.js'), ['jquery'], true);
    wp_enqueue_script('js-vendor-rateyo', _assets_paths('/js/vendor/jquery.rateyo.min.js'), ['jquery'], true);
    wp_enqueue_script('js-vendor-nouislider', _assets_paths('/js/vendor/nouislider.min.js'),  ['jquery'], true);
    // wp_enqueue_script('js-custom', _assets_paths('/js/custom.js'), ['jquery'], true);
    wp_enqueue_script('js-main', _assets_paths('/js/script.js'),  ['jquery'], true);

    wp_enqueue_style("css-custom", _assets_paths("/css/custom.css"), [], "1.0", 'all');
    wp_enqueue_style("css-vendor", _assets_paths("/css/vendor.css"), [], "1.0", 'all');
}

add_action("wp_enqueue_scripts", "shop_scripts");





add_action("after_setup_theme", "shop_setup");

function shop_setup()
{
    register_nav_menu("menu-header-first", "Menu Header First");

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
