<?php


add_filter('woocommerce_checkout_fields', 'remove_checkout_field');

function remove_checkout_field($fields)
{
    unset($fields['billing']['billing_company']);
    unset($fields['billing']['billing_postcode']);

    return $fields;
}


///Remove second
add_filter('woocommerce_checkout_fields', 'custom_rename_wc_checkout_fields');
function  custom_rename_wc_checkout_fields($fields)
{

    unset($fields['billing']['billing_address_2']);
    return $fields;
}
