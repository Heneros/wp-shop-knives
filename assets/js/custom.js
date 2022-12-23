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
                        $('.found_recent b').html(res.found_posts);
                        if (res.found_posts == 0) {
                            $(".clear_wishlist").hide();
                        }
                        $('.products-wishlist').html(res.products);
                    }
                }
            }
        })
    });



    ////////Mini Cart Update
    function miniCartAjaxUpdate(){
        $.ajax({
            type: "post",
            url: my_ajax_object.ajax_url,
            cache: false,
            data:{
                action: 'update_mini_cart_action'
            },
            success: function(response){
                let miniCartCount = document.getElementById('mini-cart-count');
                let miniCartItemsContainer = document.getElementById('mini-cart-all-items');
                let miniCartSubtotal = document.getElementById('cart-subtotal');

                miniCartCount.innerText = response.cart_items_count;
                miniCartItemsContainer.innerHTML = '';
                miniCartSubtotal.innerHTML = '';

                
                $("#cart-subtotal").append(response.cart_total);
                $("#mini-cart-all-items").append(response.cart_contents);
                
                
            }
        })
    }




});

