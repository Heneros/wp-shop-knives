<?php

session_start();




add_filter('woocommerce_breadcrumb_defaults', function () {
    return array(
        'delimiter' => '<span class="divide">&gt;</span>',
        'wrap_before' => '<div class="product-information__breadcrumbs">',
        'wrap_after'  => '</div>',
        'before'      => '',
        'after'       => '',
        'home'        => __('Home', ''),
    );
});
