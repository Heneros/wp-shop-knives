jQuery(document).ready(function ($) {










    /////////Add to favorites
    $(document.body).on("click", ".add_favorite", function (e) {
        e.preventDefault();
        var prod_id = $(this).attr('data-prodid');
        var that = $(this);
        var action = '';
        if ($(that).hasClass('in_list')) {
            action = 'remove_from_wishlist';
        } else {
            action = 'add_to_wishlist';
        }
        $.ajax({
            url: woocommerce_params.ajax_url,
            method: 'POST',
            data: {
                action: action,
                prod_id: prod_id
            },
            beforeSend: function () { },
            success: function (data) {
                var res = JSON.parse(data);
                if (res.response == 'success' && action == 'add_to_wishlist') {
                    $(that).addClass('in_list');
                } else if (res.response == 'success' && action == 'remove_from_wishlist') {
                    $(that).removeClass('in_list');
                    if ($('.product-wishlist').length) {
                        $('.found_recent b').html(res.found_POSTs);
                        if (res.found_POSTs == 0) {
                            $(".clear_wishlist").hide();
                        }
                        $('.products-wishlist').html(res.products);
                    }
                }
            }
        })
    });




    ////////Mini Cart Update
    function miniCartAjaxUpdate() {

        $.ajax({
            method: "POST",
            url: my_ajax_object.ajax_url,
            cache: false,
            data: {
                action: 'update_mini_cart_action'
            },
            success: function (response) {
                let miniCartCount = document.getElementById('mini-cart-count');
                let miniCartItemsContainer = document.getElementById('mini-cart-all-items');
                let miniCartSubtotal = document.getElementById('mini-cart-subtotal');
                let checkoutTotalPrice = document.getElementById('checkout-total-price');


                miniCartItemsContainer.innerHTML = '';
                if (miniCartSubtotal) {
                    miniCartSubtotal.innerHTML = '';
                }


                checkoutTotalPrice.innerHTML = response.cart_total;

                $("#mini-cart-subtotal").append(response.cart_total);
                $("#mini-cart-all-items").append(response.cart_contents);
                $("#mini-cart-count").text(response.cart_items_count);



                // miniCartCount.innerText = response.cart_items_count;
            }
        })
    }
    ////////////Add To cart
    // function addToCart(url) {

    //     $.ajax({
    //         url: url,
    //         method: "POST",
    //         error: function (response) {
    //             console.log(response);
    //         },
    //         success: function (response) {
    //             miniCartAjaxUpdate();
    //             let miniCartCount = document.getElementById("mini-cart-count");
    //             let currentCount = parseInt(miniCartCount.innerText) + 1;
    //             miniCartCount.innerText = currentCount;
    //         }
    //     });

    // }








    $('.add-to-cart-btn').on('click', function (e) {
        e.preventDefault();
    
        var form = $(this).closest('form');
        var product_id = form.find('input[name="product_id"]').val();
        var variation_id = 0;
    
 
        if (form.find('.variation-attributes').length > 0) {
            var attributes = {};
            form.find('.variation-attributes select').each(function () {
                var attribute_name = $(this).attr('name').replace('attribute_', '');
                attributes[attribute_name] = $(this).val();
            });
            variation_id = getVariationId(attributes);
        }
    
        var data = {
            action: 'woocommerce_ajax_add_to_cart',
            product_id: product_id,
            variation_id: variation_id,
            quantity: form.find('input[name="quantity"]').val(),
        };
    
        $.ajax({
            type: 'POST',
            url: woocommerce_params.ajax_url,
            data: data,
            dataType: 'json',
            success: function (response) {
                if (!response) {
                    return;
                }
    
                if (response.error && response.product_url) {
                    window.location.href = response.product_url;
                    return;
                }
                miniCartAjaxUpdate();
    
                var fragments = response.fragments;
                var cart_hash = response.cart_hash;
    
                if (fragments) {
                    $.each(fragments, function (key, value) {
                        $(key).replaceWith(value);
                    });
    
                    $('body').trigger('wc_fragments_loaded');
                }
    
                if (response && response.error && response.error.message) {
                    alert(response.error.message);
                } else {
                    $('body').trigger('added_to_cart', [fragments, cart_hash]);
                }
            },
            error: function (errorThrown) {
                console.log(errorThrown);
            }
        });
    });
    



    function getVariationId(attributes) {
        var variations_data = window.variationsData;
        if (!variations_data) {
            return 0;
        }
        var variations = variations_data.variations;

        for (var i = 0; i < variations.length; i++) {
            var variation = variations[i];
            var matching_attributes = 0;

            for (var attribute_name in attributes) {
                if (variation.attributes.hasOwnProperty(attribute_name) && variation.attributes[attribute_name] == attributes[attribute_name]) {
                    matching_attributes++;
                }
            }

            if (matching_attributes == Object.keys(attributes).length) {
                return variation.variation_id;
            }
        }

        return 0;
    }

 


    
    $(document.body).on("click", ".card-item .quantity-plus", function (e) {
        e.preventDefault();

        let quantity_inp_elem = this.parentElement.nextElementSibling;
        console.log(quantity_inp_elem);
        let quantity_inp = this.previousElementSibling;
        let prod_id = quantity_inp_elem.getAttribute("data-product_id");
        quantity_inp.value = parseInt(quantity_inp.value) + 1;

        $.ajax({
            method: "POST",
            url: my_ajax_object.ajax_url,
            cache: false,
            data: {
                prod_id: prod_id,
                quantity: quantity_inp.value,
                action: "update_product_quantity"
            },
            success: function (response) {
                miniCartAjaxUpdate();
            }
        })
    });

    $(document.body).on("click", ".card-item .quantity-minus", function (e) {
        e.preventDefault();
        let quantity_inp_elem = this.parentElement.nextElementSibling;
        let quantity_inp = this.nextElementSibling;
        let prod_id = quantity_inp_elem.getAttribute("data-product_id");

        if (parseInt(quantity_inp.value) != 1) {
            quantity_inp.value = parseInt(quantity_inp.value) - 1;
            $.ajax({
                method: "POST",
                url: my_ajax_object.ajax_url,
                cache: false,
                data: {
                    prod_id: prod_id,
                    quantity: quantity_inp.value,
                    action: 'update_product_quantity'
                },
                success: function (response) {
                    miniCartAjaxUpdate();
                }
            });
        }
    });


    // $(".btn-footer").html('');


    $(".btn-footer").prop("value", "");



    //////Change select.
    $('input.variation_id').change(function () {
        if ('' != $("input.variation_id").val()) {
            var var_id = $("input.variation_id").val();
            $.ajax({
                url: woocommerce_params.ajax_url,
                method: "POST",
                data: {
                    var_id: var_id,
                    action: 'get_variable_product_data_by_id'
                },
                success: function (response) {
                    console.log(response);
                    let big_img_container = document.getElementsByClassName('swiper-slide-active')[0];
                    let big_image_href_img_src = big_img_container.getElementsByTagName('img')[0];


                    // let product_p_sku = document.getElementById('p_sku');
                    let variable_product_price = document.getElementById('variable_product_price');
                    if (response.p_image) {
                        big_image_href_img_src.src = response.p_image;
                    }

                    // product_p_sku.innerHTML = response.p_sku;
                    if (variable_product_price) {
                        variable_product_price.innerHTML = response.p_price;
                    }

                }
            });
        }
    });

    function addToCartWithQuantityVariableProduct(prod_obj) {
        $.ajax({
            method: 'POST',
            url: woocommerce_params.ajax_url,
            data: {
                prod_obj: prod_obj,
                action: 'add_to_cart_variable_product'
            },
            error: function (response) {
                console.log(response);
            },
            success: function (response) {
                if (response.stock_status == true) {
                    miniCartAjaxUpdate();
                    // alert("Added");
                }
            }
        });
    }

    ///Add variable product in cart
    $(document.body).on("click", ".add-to-cart-with-quantity-variable_product-btn", function (e) {
        e.preventDefault();

        let quantity = $("input[name=prod_quantity]").val();
        let variation_id = $("input[name=variation_id]").val();
        let productID = $("input[name=product_id]").val();
        if (variation_id) {
            let variable_product_obj = {
                quantity: quantity,
                variation_id: variation_id,
                productID: productID
            };
            // console.log(variable_product_obj);
            if (parseInt(quantity) == 0) {
                alert('add-to-cart-with-quantity-variable dont added to cart');
            } else {
                $.ajax({
                    method: 'POST',
                    url: woocommerce_params.ajax_url,
                    cache: false,
                    data: {
                        product_id: productID,
                        action: 'check_if_product_exist_in_cart'
                    },
                    success: function (response) {
                        $.ajax({
                            method: 'POST',
                            url: woocommerce_params.ajax_url,
                            cache: false,
                            data: {
                                product_id: productID,
                                action: 'check_if_product_in_stock'
                            },
                            success: function (response_s) {
                                if (response_s.stock_status == true) {
                                    addToCartWithQuantityVariableProduct(variable_product_obj);
                                } else {
                                    alert("Not working!!! add-to-cart-with-quantity-variable");
                                }
                            }
                        })
                    }
                });
            }
        }
    });

    function addToCartWithQuantity(url) {
        $.ajax({
            url: url,
            method: 'POST',
            error: function (response) {
                console.log(response);
            }, success: function (response) {
                miniCartAjaxUpdate()
            }
        })
    }




    $(".add-to-cart-with-quantity-btn").on('click', function (e) {
        e.preventDefault();
        let addToCartUrlWithQuantity = this.href;
        let quantity = $("input[name=prod_quantity]").val();
        let getIdFromUrl = addToCartUrlWithQuantity.split('=');
        let productID = parseInt(getIdFromUrl[1]);
        if (parseInt(quantity) == 0) {
            console.log("Not added to cart. Simple product");
        } else {
            $.ajax({
                method: "POST",
                url: woocommerce_params.ajax_url,

                cache: false,
                data: {
                    product_id: productID,
                    action: 'check_if_product_exist_in_cart'
                },
                success: function (response_s) {
                    addToCartUrlWithQuantity += '&quantity=' + quantity;
                    $.ajax({
                        method: 'POST',
                        url: woocommerce_params.ajax_url,
                        cache: false,
                        data: {
                            product_id: productID,
                            action: 'check_if_product_in_stock'
                        },
                        success: function (response_s) {
                            if (response_s.stock_status == true) {
                                addToCartWithQuantity(addToCartUrlWithQuantity)
                            } else {
                                console.log("Not added to cart with quantity. Simple product.");
                            }
                        }
                    })
                }
            })
        }
    });



});













