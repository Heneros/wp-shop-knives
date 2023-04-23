jQuery(document).ready(function ($) {


    var offset = 0;
    var next_page = 2;
    var posts_per_page = 2;
    var post_type = 'product';
    $(document.body).on("click", "#load-more", function () {
        var button = $(this);
        var next_page = button.data('nextpage');
        var max_pages = button.data('maxpages');

        $.ajax({
            url: my_ajax_object.ajax_url,
            type: 'POST',
            data: {
                action: 'loadmore_shop',
                offset: offset + posts_per_page,
                posts_per_page: posts_per_page,
                next_page: next_page,
                post_type: post_type
            },
            beforeSend: function () {
                $("#load-more").text("Loading...");
            },
            success: function (data) {
                $("#load-more").text("Load More");
                $(".shop-catalog__products").append(data);
                offset += posts_per_page;
                next_page++;
                if (next_page + 1 > max_pages) {
                    button.hide();
                }
            }
        })
    });



    ///Filter Shop. Adaptive
    var btnFilter = document.querySelector("#btn-filters");
    var shopCatalogLeft = document.querySelector(".shop-catalog__left");
    var shopCatalogFilters = document.querySelector(".shop-catalog__filters");
    var bodyy = document.querySelector("body");
    var blank = document.querySelector(".blank");

    var close = function close() {
        shopCatalogFilters.classList.remove("activeLeft");
        shopCatalogLeft.classList.remove("blur");
        bodyy.classList.remove("overflowHidden");
    };

    if (btnFilter != null) {
        btnFilter.addEventListener("click", function (e) {
            // alert(123);
            shopCatalogFilters.classList.add("activeLeft");
            shopCatalogLeft.classList.add("blur");
            bodyy.classList.add("overflowHidden");
        });
    }

    if (blank != null) {
        blank.addEventListener("click", function (e) {
            close();
        });
    }




    $(".woocommerce-ordering .orderby").addClass("filter-style select-item");


    $("#reset-btn").on("click", function () {
        $('.woocommerce-ordering select[name="orderby"]').val('menu_order');
        $('.woocommerce-ordering input[name="paged"]').val('1');
        $('.woocommerce-ordering input[name="removed_item"]').val('1');

        history.pushState(null, null, window.location.href.split('?')[0]);
        $('.woocommerce-ordering').submit();
    });

    // $("#reset-btn").on("click", function () {
    //     $('.woocommerce-ordering')[0].reset();
    //     $('.orderby.filter-style.select-item').val('menu_order');
    //     window.history.replaceState({}, document.title, window.location.pathname);
    // });;


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



                miniCartCount.innerText = response.cart_items_count;
            }
        })
    }
    $("#alg-product-input-fields-table").remove();


    $(document.body).on('click', '.quantity-plus', function (e) {
        e.preventDefault();
        var val = parseInt($(this).parent('.parent-quantity').find('.input_qty').val());
        var new_val = val + 1;
        if (new_val < 1) new_val = 1;
        $(this).parents('.parent-quantity').find('.input_qty').val(new_val);
        $(this).parents('.parent-quantity').find('.quantity-minus').removeClass('disabled');
        return false;
    });



    $(document.body).on('click', '.quantity-minus', function (e) {
        e.preventDefault();
        var val = parseInt($(this).parent('.parent-quantity').find('.input_qty').val());
        var new_val = val - 1;
        if (new_val < 1) {
            new_val = 1;
            $(this).addClass('disabled')
        }

        $(this).parents('.parent-quantity').find('.input_qty').val(new_val);
        return false;
    });


    // $(document.body).on("click", ".card-item .quantity-plus", function (e) {
    //     e.preventDefault();

    //     let quantity_inp_elem = this.parentElement.nextElementSibling;
    //     console.log(quantity_inp_elem);
    //     let quantity_inp = this.previousElementSibling;
    //     let prod_id = quantity_inp_elem.getAttribute("data-product_id");
    //     quantity_inp.value = parseInt(quantity_inp.value) + 1;

    //     $.ajax({
    //         method: "POST",
    //         url: my_ajax_object.ajax_url,
    //         cache: false,
    //         data: {
    //             prod_id: prod_id,
    //             quantity: quantity_inp.value,
    //             action: "update_product_quantity"
    //         },
    //         success: function (response) {
    //             miniCartAjaxUpdate();
    //         }
    //     })
    // });

    // $(document.body).on("click", ".card-item .quantity-minus", function (e) {
    //     e.preventDefault();
    //     let quantity_inp_elem = this.parentElement.nextElementSibling;
    //     let quantity_inp = this.nextElementSibling;
    //     let prod_id = quantity_inp_elem.getAttribute("data-product_id");

    //     if (parseInt(quantity_inp.value) != 1) {
    //         quantity_inp.value = parseInt(quantity_inp.value) - 1;
    //         $.ajax({
    //             method: "POST",
    //             url: my_ajax_object.ajax_url,
    //             cache: false,
    //             data: {
    //                 prod_id: prod_id,
    //                 quantity: quantity_inp.value,
    //                 action: 'update_product_quantity'
    //             },
    //             success: function (response) {
    //                 miniCartAjaxUpdate();
    //             }
    //         });
    //     }
    // });


    // $(document.body).on('click', '.quantity-minus, .quantity-plus', function () {
    //     var product_id = $(this).data('product_id');
    //     var cart_item_key = $(this).data('cart_item_key');
    //     var quantity = $(this).siblings('.js-quantity-input').val();

    //     if ($(this).hasClass('quantity-minus')) {
    //         quantity--;
    //     } else {
    //         quantity++;
    //     }

    //     if (quantity < 1) {
    //         quantity = 1;
    //     }

    //     $(this).siblings('.js-quantity-input').val(quantity);

    //     var data = {
    //         action: 'update_cart_item_quantity',
    //         product_id: product_id,
    //         cart_item_key: cart_item_key,
    //         quantity: quantity,
    //         _wpnonce: my_ajax_object.nonce
    //     };

    //     $(document.body).trigger('update_checkout');

    //     $.ajax({
    //         type: 'POST',
    //         url: my_ajax_object.ajax_url,

    //         data: data,
    //         success: function (response) {
    //             if (response && response.fragments) {
    //                 $.each(response.fragments, function (key, value) {
    //                     $(key).replaceWith(value);
    //                 });

    //                 if (response.cart_hash) {
    //                     $(document.body).trigger('wc_fragment_refresh');
    //                 }
    //             }
    //         }
    //     });
    // });




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



    $('.add-to-cart-btn').on('click', function (e) {
        e.preventDefault();

        let addToCartUrl = this.href;
        let getIdFromUrl = addToCartUrl.split('=');

        let productID = parseInt(getIdFromUrl[1]);
        $.ajax({
            type: "POST",
            url: my_ajax_object.ajax_url,
            cache: false,
            data: {
                product_id: productID,
                action: 'check_if_product_exist_in_cart'
            },
            success: function (response) {
                $.ajax({
                    type: 'POST',
                    url: my_ajax_object.ajax_url,
                    cache: false,
                    data: {
                        product_id: productID,
                        action: 'check_if_product_in_stock'
                    },
                    success: function (response_s) {
                        if (response_s.stock_status == true) {
                            addToCart(addToCartUrl);
                        } else {
                            alert("Error happend add-to-cart");
                        }
                    }
                })
            }
        })

    })





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

    $('select[data-jqselect="filter-style select-item"]').css('display', 'none');
    $('select[data-jqselect="filter-style select-item"]').each(function () {
        var $this = $(this);
        var $dropdown = $('<ul>', {
            class: 'jq-selectbox__dropdown'
        }).css({
            width: $this.outerWidth(),
            top: $this.outerHeight(),
            left: 0,
            display: 'none'
        });
        $this.children('option').each(function () {
            var $option = $(this);
            var $li = $('<li>', {
                html: $option.text(),
                class: $option.is(':selected') ? 'selected sel' : '',
                style: $option.is(':disabled') ? 'display:none' : ''
            });
            $li.click(function () {
                $this.val($option.val());
                $dropdown.hide();
                $this.trigger('change');
                return false;
            });
            $li.appendTo($dropdown);
        });
        var $select = $('<div>', {
            class: 'jq-selectbox__select'
        }).insertBefore($dropdown);
        $('<div>', {
            class: 'jq-selectbox__select-text',
            html: $this.children('option:selected').text()
        }).appendTo($select);
        $('<div>', {
            class: 'jq-selectbox__trigger'
        }).html('<div class="jq-selectbox__trigger-arrow"></div>').appendTo($select);
        $dropdown.insertAfter($select);
    });


    $('.jq-selectbox__select').click(function () {
        var $selectbox = $(this).closest('.jq-selectbox');
        var $dropdown = $selectbox.children('.jq-selectbox__dropdown');
        $('.jq-selectbox__dropdown').not($dropdown).hide();
        $dropdown.toggle();
        return false;
    });


    $(document).click(function (event) {
        if (!$(event.target).closest('.jq-selectbox').length) {
            $('.jq-selectbox__dropdown').hide();
        }
    });


    $('.jq-selectbox__dropdown ul li').click(function () {
        var select_val = $(this).text();
        $(this).parents('.jq-selectbox').find('.jq-selectbox__select-text').html(select_val);
    });


});




jQuery(document).ready(function ($) {




    $('.select-header-list').click(function () {
        var dropdown = $(this).next();
        dropdown.toggleClass('open');
        $(this).toggleClass('rotate-up');
    });

    $('.filter-button').on('click', function () {
        $('.filter-form').slideToggle();
    });







    $('.select-header-list').click(function () {
        var dropdown = $(this).next();
        dropdown.toggleClass('open');
        $(this).toggleClass('rotate-up');
    });






    $(document.body).on('click', '.filter-form .filter-close', function (e) {
        e.preventDefault();
        $(".filter-form").removeClass('open');
        $("body").removeClass('overlayy');
    });



    $('.input-search').on('input', function () {
        var inputValue = $(this).val();

        $.ajax({
            type: 'POST',
            url: my_ajax_object.ajax_url,
            data: {
                action: 'seach_value_filters',
                search_value: inputValue
            },
            success: function (response) {
                $('.items-project').html(response);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log("AJAX Error: " + textStatus + " " + errorThrown);
            }
        })
    });



    $('.filter-toggle').click(function (e) {
        e.preventDefault();
        $('.filter-form').toggleClass('open');
        $('body').toggleClass('overlayy');

        var $firstSelect = $('.filter-form').find('.select-wrapper:first-of-type');
        $firstSelect.find('.select-header-list').toggleClass('rotate-up');
    });



    $('.filter-form').each(function () {
        var $form = $(this);
        var $selects = $form.find('.select-wrapper');
        $form.find(':checkbox').change(function () {
            $form.submit();
        });

        $selects.each(function () {
            var $select = $(this).find('.select-header-list');
            var $dropdown = $(this).find('.select-droppdown');
            $select.click(function (e) {
                e.preventDefault();
                var $this = $(this);

                $dropdown.toggleClass('open');
                $this.toggleClass('rotate-up', $dropdown.hasClass('open'));

                $selects.not($this.parent()).find('.select-droppdown').removeClass('open');
                $selects.not($this.parent()).find('.select-header-list').removeClass('rotate-up');
            });
        });
    });


    ///filter search

    if ($(window).width() <= 767) {
        $(document).on('click', function (event) {
            if (!$(event.target).closest('.filter-search').length) {
                $('.filter-search').removeClass('open');
                $('.input-search').hide();
            }
        });

        $('.filter-search').on('click', function () {
            $('.input-search').show().focus();
            $(this).toggleClass('open');

        });
        $('.input-search').on('blur', function () {
            $(this).hide();
        });
    }

    $(document.body).on('click', '.clear_wishlist', function (e) {
        e.preventDefault();
        $.ajax({
            url: woocommerce_params.ajax_url,
            method: 'POST',
            data: {
                clear_wishlist: true,
                action: 'clear_wishlist'
            },
            beforeSend: function () { },
            success: function (data) {
                var res = JSON.parse(data);
                $(".wishlist_products").html(res.wishlist_reset)
                $(".count_wishlist").html(res.foundd_posts)

                $('.clear_wishlist').hide();
            }
        })
    });




});
