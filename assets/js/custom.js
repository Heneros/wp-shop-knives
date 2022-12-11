jQuery(document).ready(function ($) {
    
    $(document.body).on("click", ".add_favorite", function (e) {
        e.preventDefault();
        var prod_id = $(this).attr('data-prodid');
        var that = $(this);
        var action = '';
        if($(that).hasClass('in_list')){
            action = 'remove_from_wishlist';
        }else{
            action = 'add_to_wishlist';
        }
        $.ajax({
            url: woocommerce_params.ajax_url,
            method: 'POST',
            data:{
                action: action,
                prod_id: prod_id
            },
            beforeSend: function(){},
            success: function(data){
                var res = JSON.parse(data);
                if(res.response == 'success' && action == 'add_to_wishlist'){
                    $(that).addClass('in_list');
                }
            }
        })

    })

})
