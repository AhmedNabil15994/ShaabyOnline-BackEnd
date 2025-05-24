<script>
    function displayErrorsMsg(data, icon = 'error') {
        // console.log('errors::', $.parseJSON(data.responseText));

        var getJSON = $.parseJSON(data.responseText);

        var output = '<ul>';

        if (typeof getJSON.errors == 'string') {
            output += "<li>" + getJSON.errors + "</li>";
        } else {
            if (getJSON.errors.hasOwnProperty("code")) {
                output += "<li>" + getJSON.errors['code'][0] + "</li>";
            } else {

                for (var error in getJSON.errors) {
                    output += "<li>" + getJSON.errors[error] + "</li>";
                }

            }
        }

        output += '</ul>';

        var wrapper = document.createElement('div');
        wrapper.innerHTML = output;

        swal({
            content: wrapper,
            icon: icon,
            dangerMode: true,

            buttons: {
                close: {
                    className: 'btn btn-danger text-center',
                    text: "{{ __('catalog::frontend.cart.btn.ok') }}",
                    value: 'close',
                    closeModal: true
                },
            }
        })
    }

    function displaySuccessMsg(data) {
        swal({
            closeOnClickOutside: false,
            closeOnEsc: false,
            text: data,
            icon: "success",
            buttons: {
                close: {
                    className: 'btn btn-continue text-center',
                    text: "{{ __('vendor::webservice.rates.btnClose') }}",
                    value: 'close',
                    closeModal: true
                },
            }
        });
    }

    function deleteFromCartByAjax(productID, productType = 'product') {

        var prdListId = productType === 'product' ? productID : 'var-' + productID;
        $('#headerLoaderDiv').show();

        $.ajax({
            method: "GET",
            url: "{{ url(route('frontend.shopping-cart.deleteByAjax')) }}",
            data: {
                "id": productID,
                "product_type": productType,
            },
            beforeSend: function() {

            },
            success: function(data) {
                $('#prdList-' + prdListId).remove();

                var cartIcon = $('#cartIcon');
                var cartItemsInfo = $('#cartItemsInfo');

                $('#cartPrdTotal').html(data.result.cartTotal + " {{ __('apps::frontend.master.kwd') }}");

                if (data.result.cartCount == 0) {

                    var info = `
                        <div class="empty-subtitle">{{ __('catalog::frontend.cart.empty') }}</div>
                    `;
                    cartItemsInfo.html(info);
                    $('#cartItemsContainer').empty();
                    $('.counter-number').remove();

                } else {

                    var rowCount = `
                        <span class="counter-number" id="cartPrdCount">${data.result.cartCount}</span>
                    `;
                    cartIcon.append(rowCount);

                    var rowCartItemsInfo = `
                        <div class="subtitle">{{ __('catalog::frontend.cart.you_have') }} <b>( ${data.result.cartCount} )</b> {{ __('catalog::frontend.cart.products_in_your_cart') }}</div>
                    `;
                    cartItemsInfo.html(rowCartItemsInfo);

                }

            },
            error: function(data) {
                displayErrorsMsg(data);
            },
            complete: function(data) {

                var getJSON = $.parseJSON(data.responseText);

                if (getJSON.errors) {
                    displayErrorsMsg(data, 'warning');
                    return true;
                }

                $('#headerLoaderDiv').hide();

            },
        });

    }

    function updateHeaderCart(params) {

        var rowCount,
            rowCartItemsInfo,
            rowCartItemsContainer,
            rowLi,
            cartIcon = $('#cartIcon'),
            cartItemsInfo = $('#cartItemsInfo'),
            cartItemsContainer = $('#cartItemsContainer'),
            minicartItems = $('.minicart-items'),
            cartPrdTotal = $('#cartPrdTotal');

        var prdListId = params.product_type === 'product' ? params.productId : 'var-' + params.productId;
        $('.cartItemsInfo').remove();

        rowCount = `
                <span class="counter-number" id="cartPrdCount">${params.cartCount}</span>
            `;
        cartIcon.append(rowCount);

        rowCartItemsInfo = `
                <div class="subtitle">{{ __('catalog::frontend.cart.you_have') }} <b>( ${params.cartCount} )</b> {{ __('catalog::frontend.cart.products_in_your_cart') }}</div>
            `;
        cartItemsInfo.html(rowCartItemsInfo);

        rowLi = `
                <div class="media align-items-center">
                    <div class="pro-img d-flex align-items-center">
                        <img class="img-fluid"
                             src="${params.productImage}"
                             alt="Author">
                    </div>
                    <div class="media-body">
                    <span class="product-name">
                        <a href="${params.productDetailsRoute}">${params.productTitle}</a>
                    </span>
                        <div class="product-price d-block">
                            <span class="text-muted">x ${params.productQuantity}</span>
                            <span>${params.productPrice} {{ __('apps::frontend.master.kwd') }}</span>
                        </div>
                    </div>
                    <button type="button"
                            class="btn remove"
                            onclick="deleteFromCartByAjax(${params.productId}, '${params.product_type}')">
                        <i class="ti-trash"></i>
                    </button>
                </div>
            `;

        if (params.cartCount == 1) {

            rowCartItemsContainer = `
                <div class="minicart-items-wrapper">
                     <ol class="minicart-items">

                        <li class="product-item"
                            id="prdList-${prdListId}">
                            ${rowLi}
                        </li>

                    </ol>
                </div>

                <div class="minicart-footer">
                    <div class="subtotal">
                        <span class="label">{{ __('catalog::frontend.cart.subtotal') }} :</span>
                            <span class="price" id="cartPrdTotal">${params.cartSubTotal} {{ __('apps::frontend.master.kwd') }}</span>
                    </div>
                    <div class="actions">
                        <a class="btn btn-viewcart"
                           href="{{ route('frontend.shopping-cart.index') }}">
                            <i class="ti-shopping-cart-full"></i>
                            {{ __('catalog::frontend.cart.cart_details') }}</a>
                    <a class="btn btn-checkout"
                        href="{{ route('frontend.checkout.index') }}">
                                <i class="ti-wallet"></i>
                                {{ __('catalog::frontend.cart.checkout') }}</a>
                </div>
            </div>`;
            cartItemsContainer.html(rowCartItemsContainer);

        } else {

            if ($("#prdList-" + prdListId).length == 0) {
                //it doesn't exist
                $item = `
                    <li class="product-item"
                    id="prdList-${prdListId}">
                        ${rowLi}
                    </li>
                `;
                minicartItems.prepend($item);
            } else {
                //it exist
                $("#prdList-" + prdListId).html(rowLi);
            }

            cartPrdTotal.html(params.cartSubTotal + " " + "{{ __('apps::frontend.master.kwd') }}");

        }

    }

    function generalAddToCart(action, productId) {

        var productImage = $('#productImage-' + productId).val();
        var productTitle = $('#productTitle-' + productId).val();
        // var qty = $('#productQuantity-' + productId).val();

        $('#general_add_to_cart-' + productId).hide();
        // $('#generalLoaderDiv-' + productId).show();

        $.ajax({
            method: "POST",
            url: action,
            data: {
                // "qty": qty,
                "request_type": 'general_cart',
                "product_type": 'product',
                "_token": '{{ csrf_token() }}',
            },
            beforeSend: function() {},
            success: function(data) {
                var params = {
                    'productId': productId,
                    'productImage': productImage,
                    'productTitle': productTitle,
                    'productQuantity': data.data.productQuantity,
                    'productPrice': data.data.productPrice,
                    'productDetailsRoute': data.data.productDetailsRoute,
                    'cartCount': data.data.cartCount,
                    'cartSubTotal': data.data.subTotal,
                };

                updateHeaderCart(params);
                // displaySuccessMsg(data['message']);
            },
            error: function(data) {
                // $('#generalLoaderDiv-' + productId).hide();
                $('#general_add_to_cart-' + productId).show();
                displayErrorsMsg(data);
            },
            complete: function(data) {
                // $('#generalLoaderDiv-' + productId).hide();
                $('#general_add_to_cart-' + productId).show();
            },
        });

    }

    function generalAddToFavourites(action, productId) {

        $('#btnAddToFavourites-' + productId).hide();
        // $('#generalLoaderDiv-' + productId).show();

        $.ajax({
            method: "POST",
            url: action,
            data: {
                "_token": '{{ csrf_token() }}',
            },
            beforeSend: function() {},
            success: function(data) {
                var favouriteBadge = $('#favouriteBadge');
                favouriteBadge.text(data.data.favouritesCount);
                // displaySuccessMsg(data['message']);
            },
            error: function(data) {
                // $('#generalLoaderDiv-' + productId).hide();
                $('#btnAddToFavourites-' + productId).show();
                displayErrorsMsg(data);
            },
            complete: function(data) {
                // $('#generalLoaderDiv-' + productId).hide();
            },
        });

    }

    $(document).on('click', '#btnCheckCoupon', function(e) {

        var token = $(this).closest('.coupon-form').find('input[name="_token"]').val();
        var action = $(this).closest('.coupon-form').attr('action');
        var code = $('#txtCouponCode').val();

        e.preventDefault();

        if (code !== '') {

            $('#loaderCouponDiv').show();

            $.ajax({
                method: "POST",
                url: action,
                data: {
                    "code": code,
                    "_token": token,
                },
                beforeSend: function() {},
                success: function(data) {
                    displaySuccessMsg(data);
                },
                error: function(data) {
                    displayErrorsMsg(data);
                },
                complete: function(data) {

                    $('#loaderCouponDiv').hide();
                    var getJSON = $.parseJSON(data.responseText);
                    if (getJSON.data) {
                        showCouponContainer(getJSON.data.coupon_value, getJSON.data.total);
                        $('#couponForm').remove();
                    }

                },
            });
        }

    });

    function showCouponContainer(coupon_value, total) {
        var row = `
            <div class="d-flex mb-20 align-items-center">
                <span class="d-inline-block right-side flex-1"> {{ __('catalog::frontend.cart.coupon_value') }}</span>
                <span class="d-inline-block left-side">${coupon_value} {{ __('apps::frontend.master.kwd') }}</span>
            </div>
            `;

        $('#couponContainer').html(row);
        $('#cartTotalAmount').html(total + ' ' + "{{ __('apps::frontend.master.kwd') }}");
    }

    $(document).ready(function() {
        $('.img-block').each(function() {
            $(this).height($(this).width());
        });
    });

    $(window).resize(function() {
        $('.img-block').each(function() {
            $(this).height($(this).width());
        });
    }).resize();
</script>

@include('area::frontend.shared._area_tree_js')
