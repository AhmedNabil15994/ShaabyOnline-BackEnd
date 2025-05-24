@extends('apps::frontend.layouts.master')
@section('title', __('apps::frontend.master.favourites') )
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
                    <li class="breadcrumb-item">
                        <a href="{{ route('frontend.profile.index') }}">{{ __('user::frontend.profile.index.my_account') }}</a>
                    </li>
                    <li class="breadcrumb-item active text-muted"
                        aria-current="page"> {{ __('user::frontend.profile.index.favourites') }}</li>
                </ol>
            </nav>
        </div>

        @if(count($favourites) == 0)
            <div class="inner-page">
                <div class="container">
                    <div class="align-items-center text-center">
                        <div class="order-done">
                            <h1 class="margin-top-20 margin-bottom-20">{{ __('apps::frontend.master.your_wish_list_is_empty') }}</h1>
                            <p>
                                {{ __('apps::frontend.master.wish_list_description') }}
                            </p>
                            <a href="{{ route('frontend.home') }}"
                               class="btn btn-info margin-top-20">{{ __('apps::frontend.master.btn_start_shopping') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="inner-page">
                @include('apps::frontend.layouts._alerts')
                <div class="row">
                    <div class="col-md-3">
                        @include('user::frontend.profile._user-side-menu')
                    </div>
                    <div class="col-md-9">
                        <div class="cart-inner">
                            <div class="cart-items">

                                @foreach($favourites as $k => $product)
                                    <div class="cart-item media align-items-center">
                                        <div class="pro-det d-flex align-items-center">
                                            <div class="pro-img">
                                                <img class="img-fluid" src="{{ url($product->image) }}"
                                                     alt="Author">
                                            </div>
                                            <div class="media-body">
                                                <span class="product-name">
                                                    <a href="{{ route('frontend.products.index', $product->slug) }}">
                                                    {{ $product->title }}
                                                    </a>
                                                </span>
                                                <span class="price d-block">
                                                    {{ $product->price }} {{ __('apps::frontend.master.kwd') }}
                                                </span>

                                                @if($product->offer)
                                                    <span class="price d-block">
                                                        {{ $product->offer->offer_price }} {{ __('apps::frontend.master.kwd') }}
                                                        <span class="text-muted">/ Offer</span>
                                                    </span>
                                                @endif

                                            </div>
                                        </div>
                                        <div class="text-left">

                                            <div class="generalLoaderDiv"
                                                 id="generalLoaderDiv-{{ $product->id }}">
                                                <div class="my-loader"></div>
                                            </div>

                                            <form class="general-form" method="POST">
                                                @csrf
                                                <input type="hidden" id="productImage-{{ $product->id }}"
                                                       value="{{ url($product->image) }}">
                                                <input type="hidden" id="productTitle-{{ $product->id }}"
                                                       value="{{ $product->title }}">
                                                <input type="hidden" id="productQuantity-{{ $product->id }}"
                                                       value="{{ getCartItemById($product->id) ? getCartItemById($product->id)->quantity + 1 : 1 }}">

                                                <button type="button" class="btn add-cart btnGeneralAddToCart mb-2"
                                                        id="general_add_to_cart-{{ $product->id }}"
                                                        onclick="generalAddToCart('{{ route("frontend.shopping-cart.create-or-update", [ $product->slug ]) }}', '{{ $product->id }}')">
                                                    <i class="ti-shopping-cart"></i>
                                                </button>
                                            </form>

                                            <a class="btn remove"
                                               href="{{ route('frontend.profile.favourites.delete', $product->id) }}">
                                                <i class="ti-trash"></i>
                                            </a>

                                        </div>
                                    </div>
                                @endforeach

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

    </div>

@endsection

@section('externalJs')

    <script></script>

@endsection
