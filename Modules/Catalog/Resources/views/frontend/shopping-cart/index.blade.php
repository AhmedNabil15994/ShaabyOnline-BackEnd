@extends('apps::frontend.layouts.master')
@section('title', __('catalog::frontend.cart.title'))

@section('externalStyle')
    <style>

        /* start loader style */

        .giftCartLoaderDiv, .cardCartLoaderDiv, .addonsCartLoaderDiv {
            display: none;
            margin: 15px auto;
            justify-content: center;
        }

        .loaderDiv {
            display: none;
            margin: 15px 35px;
            justify-content: center;
        }

        .loaderDiv .my-loader, .giftCartLoaderDiv .my-loader, .cardCartLoaderDiv .my-loader, .addonsCartLoaderDiv .my-loader {
            border: 10px solid #f3f3f3;
            border-radius: 50%;
            border-top: 10px solid #3498db;
            width: 70px;
            height: 70px;
            -webkit-animation: spin 2s linear infinite; /* Safari */
            animation: spin 2s linear infinite;
        }

        /* end loader style */

        .empty-cart-title {
            text-align: center;
        }

    </style>
@endsection

@section('content')

    <div class="container">
        <div class="page-crumb mt-30">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('frontend.home') }}">
                            <i class="ti-home"></i> {{ __('apps::frontend.nav.home_page') }}
                        </a>
                    </li>
                    <li class="breadcrumb-item active text-muted"
                        aria-current="page"> {{ __('catalog::frontend.cart.title') }}</li>
                </ol>
            </nav>
        </div>
        <div class="inner-page">

            @include('apps::frontend.layouts._alerts')

            @if(count(getCartContent()) > 0)
                <div class="row">
                    <div class="col-md-8">
                        <div class="cart-inner cart-page">
                            <div class="cart-items">
                                <h2 class="cart-title">{{ __('catalog::frontend.cart.products') }}</h2>

                                @foreach ($items as $item)

                                    <div class="cart-item media align-items-center">
                                        <div class="pro-det d-flex align-items-center">
                                            <div class="pro-img">
                                                <img class="img-fluid"
                                                     src="{{ url($item->attributes->product->image) }}"
                                                     alt="Author">
                                            </div>
                                            <div class="media-body">
                                                <span class="product-name">
                                                    @if($item->attributes->product_type == 'variation')
                                                        <a href="{{ route('frontend.products.index', [$item->attributes->product->product->slug, generateVariantProductData($item->attributes->product->product, $item->attributes->product->id, $item->attributes->selectedOptionsValue)['slug']]) }}">
                                                            {{ generateVariantProductData($item->attributes->product->product, $item->attributes->product->id, $item->attributes->selectedOptionsValue)['name'] }}
                                                        </a>
                                                    @else
                                                        <a href="{{ url(route('frontend.products.index', [$item->attributes->product->slug])) }}">
                                                            {{ $item->attributes->product->title }}
                                                        </a>
                                                    @endif
                                                </span>
                                                <span class="price d-block">
                                                    {{ $item->price }} {{ __('apps::frontend.master.kwd') }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="pro-counting">

                                            <div class="loaderDiv" id="loaderDiv-{{ $item->attributes->product->id }}">
                                                <div class="my-loader"></div>
                                            </div>

                                            <form class="form"
                                                  @if($item->attributes->product_type == 'product')
                                                  action="{{ url(route('frontend.shopping-cart.create-or-update', [ $item->attributes->product->slug ])) }}"
                                                  @else
                                                  action="{{ url(route('frontend.shopping-cart.create-or-update', [ $item->attributes->product->product->slug, $item->attributes->product->id])) }}"
                                                  @endif
                                                  method="POST"
                                                  data-id="{{ $item->attributes->product->id }}">
                                                @csrf

                                                <input type="hidden"
                                                       id="productImage-{{ $item->attributes->product->id }}"
                                                       value="{{ url($item->attributes->product->image) }}">
                                                <input type="hidden"
                                                       id="productTitle-{{ $item->attributes->product->id }}"
                                                       value="{{ $item->attributes->product_type == 'product' ? $item->attributes->product->title : $item->attributes->product->product->title }}">
                                                <input type="hidden"
                                                       id="productType-{{ $item->attributes->product->id }}"
                                                       value="{{ $item->attributes->product_type == 'product' ? 'product' : 'variation' }}">

                                                <div class="quantity"
                                                     id="quantityContainer-{{ $item->attributes->product->id }}">
                                                    <div class="buttons-added">
                                                        <button class="sign plus btnIncDecQty"><i
                                                                class="fa fa-plus"></i>
                                                        </button>
                                                        <input type="text"
                                                               value="{{ $item->quantity }}"
                                                               title="Qty"
                                                               class="input-text qty text"
                                                               size="1">
                                                        <button class="sign minus btnIncDecQty"><i
                                                                class="fa fa-minus"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>

                                        </div>
                                        <div class="text-left">
                                            <a class="btn remove"
                                               href="{{ url(route('frontend.shopping-cart.delete', [$item->attributes->product->id, 'product_type' => $item->attributes->product_type])) }}">
                                                <i class="ti-trash"></i></a>
                                        </div>
                                    </div>

                                @endforeach

                            </div>

                        </div>
                    </div>
                    <div class="col-md-4">

                        @include('catalog::frontend.shopping-cart._total-side')

                    </div>
                </div>
            @else
                <div class="row">
                    <div class="col-md-12 alert alert-danger">
                        <h4 class="empty-cart-title">{{ __('catalog::frontend.cart.empty') }}.</h4>
                    </div>
                </div>
            @endif

        </div>
    </div>

@endsection

@section('externalJs')

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <script>

        $(document).on('click', '.btnIncDecQty', function (e) {

            var token = $(this).closest('.form').find('input[name="_token"]').val();
            var action = $(this).closest('.form').attr('action');
            var qty = parseInt($(this).closest('.form').find('.qty').val());

            var productId = $(this).closest('.form').attr('data-id');
            var productType = $(this).closest('.form').find('#productType-' + productId).val();
            var productImage = $(this).closest('.form').find('#productImage-' + productId).val();
            var productTitle = $(this).closest('.form').find('#productTitle-' + productId).val();

            if ($(this).is('.plus')) {
                qty += 1;
            } else {
                if (qty != 0) {
                    qty -= 1;
                }
            }

            e.preventDefault();

            if (parseInt(qty) > 0) {

                $('#loaderDiv-' + productId).show();
                $(this).closest('.form').find('.quantity').hide();

                $.ajax({
                    method: "POST",
                    url: action,
                    data: {
                        "qty": qty,
                        "request_type": 'cart',
                        "product_type": productType,
                        "_token": token,
                    },
                    beforeSend: function () {
                    },
                    success: function (data) {
                        var params = {
                            'productId': productId,
                            'productImage': productImage,
                            'productTitle': productTitle,
                            'productQuantity': qty,
                            'productPrice': data.data.productPrice,
                            'productDetailsRoute': data.data.productDetailsRoute,
                            'cartCount': data.data.cartCount,
                            'cartSubTotal': data.data.subTotal,
                        };

                        @if(!in_array(request()->route()->getName(), ['frontend.shopping-cart.index', 'frontend.checkout.index']))
                        updateHeaderCart(params);
                        @endif

                        // displaySuccessMsg(data);

                    },
                    error: function (data) {
                        $('#loaderDiv-' + productId).hide();
                        $('#quantityContainer-' + productId).show();

                        displayErrorsMsg(data);
                    },
                    complete: function (data) {

                        $('#loaderDiv-' + productId).hide();
                        $('#quantityContainer-' + productId).show();

                        var getJSON = $.parseJSON(data.responseText);

                        if (getJSON.data) {
                            $('#cartSubTotal').html(getJSON.data.subTotal + " " + " {{ __('apps::frontend.master.kwd') }}");
                            $('#cartTotalAmount').html(getJSON.data.total + " " + " {{ __('apps::frontend.master.kwd') }}");
                        }

                    },
                });
            }

        });

    </script>

@endsection
