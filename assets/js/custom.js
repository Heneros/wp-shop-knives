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
                miniCartSubtotal.innerHTML = '';

                checkoutTotalPrice.innerHTML = response.cart_total;

                $("#mini-cart-subtotal").append(response.cart_total);
                $("#mini-cart-all-items").append(response.cart_contents);



                miniCartCount.innerText = response.cart_items_count;
            }
        })
    }
    ////////////Add To cart
    function addToCart(url) {

        $.ajax({
            url: url,
            method: "POST",
            error: function (response) {
                console.log(response);
            },
            success: function (response) {
                miniCartAjaxUpdate();
                let miniCartCount = document.getElementById("mini-cart-count");
                let currentCount = parseInt(miniCartCount.innerText) + 1;
                miniCartCount.innerText = currentCount;
            }
        });

    }


    $(".add-to-cart-btn").on('click', function (e) {
        e.preventDefault();

        var $this = $(this);
        let thisBtn = this;
        let addToCartUrl = this.href;
        let getIdFromUrl = addToCartUrl.split("=");
        let productID = parseInt(getIdFromUrl[1]);
        $.ajax({
            method: 'POST',
            url: woocommerce_params.ajax_url,
            cache: false,
            data: {
                product_id: productID,
                action: "check_if_product_exist_in_cart"
            },
            success: function (response) {
                $.ajax({
                    method: 'POST',
                    url: woocommerce_params.ajax_url,
                    cache: false,
                    data: {
                        product_id: productID,
                        action: "check_if_product_in_stock"
                    },
                    success: function (response_s) {
                        if (response_s.stock_status == true) {
                            addToCart(addToCartUrl);
                        } else {
                            alert("Error addtocart");
                        }
                    }
                })
            }
        })
    });


    $(document.body).on("click", ".card-quantity .js-quantity-plus", function (e) {
        e.preventDefault();

        let quantity_inp_elem = this.parentElement.nextElementSibling;
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

    $(document.body).on("click", ".card-quantity .js-quantity-minus", function (e) {
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
});

