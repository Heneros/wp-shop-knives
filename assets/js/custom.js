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



    /////////Add to favorites




});

