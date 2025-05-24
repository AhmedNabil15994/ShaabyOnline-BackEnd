@extends('apps::frontend.layouts.master')
@section('title', __('apps::frontend.home.title'))
@section('externalStyle')
    <style>
        @media only screen and (min-width: 576px) {
            .owl-stage-outer {
                max-height: 450px !important;
            }
        }

    </style>
@endsection
@section('meta_description', config('setting.app_description.' . locale()) ?? '')
@section('meta_keywords', '')
@section('content')

    <div class="home-slider-container">
        <div class="owl-carousel home-slides">

            @foreach ($sliders as $k => $slider)
                <div class="item">
                    <img src="{{ url($slider->image) }}" alt="{{ $slider->title }}" />
                </div>
            @endforeach

        </div>
    </div>

    {{-- <div class="container">
        <div class="home-banner mb-20">
            <a href="javascript:;">
                <img src="{{ url('frontend/images/banner-home-1.png') }}" class="img-fluid" alt=""/>
            </a>
        </div>
    </div> --}}

    <div class="container">

        @if (count($categories) > 0)
            <div class="home-products">
                <h3 class="slider-title">{{ __('apps::frontend.master.categories') }}</h3>
                <div class="owl-carousel products-slider">

                    @foreach ($categories as $k => $category)
                        <div class="product-grid">
                            <div class="product-image d-flex align-items-center">
                                <a href="{{ route('frontend.categories.products', $category->slug) }}">
                                    <img class="pic-1" src="{{ url($category->image) }}">
                                </a>
                            </div>
                            <div class="product-content">
                                <h3 class="title">
                                    <a
                                        href="{{ route('frontend.categories.products', $category->slug) }}">{{ $category->title }}</a>
                                </h3>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        @endif

        @if (count($featuredProducts) > 0)
            <div class="home-products">
                <h3 class="slider-title">{{ __('apps::frontend.master.featured_products') }}</h3>
                <div class="owl-carousel products-slider">

                    @foreach ($featuredProducts as $k => $prd)
                        <div class="product-grid">
                            <div class="product-image d-flex align-items-center">
                                {{-- <span class="pro-bdge new">جديد</span> --}}
                                <a href="{{ route('frontend.products.index', $prd->slug) }}">
                                    @if ($prd->tags)
                                        @foreach ($prd->tags as $i => $tag)
                                            <label class="label-tag-product"
                                                style="background-color: {{ $tag->background ?? '#ddd' }}; color: {{ $tag->color ?? '#fff' }}">{{ $tag->title }}</label>
                                        @endforeach
                                    @endif
                                    <img class="pic-1" src="{{ url($prd->image) }}">
                                </a>
                                <ul class="social">
                                    <li>
                                        <a href="{{ route('frontend.products.index', $prd->slug) }}"
                                            data-tip="{{ __('apps::frontend.products.details.title') }}">
                                            <i class="ti ti-eye"></i>
                                        </a>
                                    </li>
                                    <li>

                                        @if (auth()->check() &&
                                            !in_array(
                                                $prd->id,
                                                array_column(
                                                    auth()->user()->favourites->toArray(),
                                                    'id',
                                                ),
                                            ))
                                            <form class="favourites-form" method="POST">
                                                @csrf
                                                <a href="javascript:;" id="btnAddToFavourites-{{ $prd->id }}"
                                                    onclick="generalAddToFavourites('{{ route('frontend.profile.favourites.store', [$prd->id]) }}', '{{ $prd->id }}')"
                                                    data-tip="{{ __('apps::frontend.products.add_to_favourite') }}">
                                                    <i class="ti-heart"></i>
                                                </a>
                                            </form>
                                        @endif

                                    </li>

                                    @if (is_null($prd->variants) || count($prd->variants) == 0)
                                        <li>

                                            <div class="generalLoaderDiv" id="generalLoaderDiv-{{ $prd->id }}">
                                                <div class="my-loader"></div>
                                            </div>

                                            <form class="general-form" method="POST">
                                                @csrf

                                                <input type="hidden" id="productImage-{{ $prd->id }}"
                                                    value="{{ url($prd->image) }}">
                                                <input type="hidden" id="productTitle-{{ $prd->id }}"
                                                    value="{{ $prd->title }}">
                                                <input type="hidden" id="productQuantity-{{ $prd->id }}"
                                                    value="{{ getCartQuantityById($prd->id) ? getCartQuantityById($prd->id) + 1 : 1 }}">

                                                <a href="javascript:;" id="general_add_to_cart-{{ $prd->id }}"
                                                    class="btnGeneralAddToCart"
                                                    onclick="generalAddToCart('{{ route('frontend.shopping-cart.create-or-update', [$prd->slug]) }}', '{{ $prd->id }}')"
                                                    data-tip="{{ __('apps::frontend.products.add_to_cart') }}">
                                                    <i class="ti-shopping-cart-full"></i>
                                                </a>

                                            </form>

                                        </li>
                                    @endif

                                </ul>

                            </div>
                            <div class="product-content">
                                <h3 class="title">
                                    <a href="{{ route('frontend.products.index', $prd->slug) }}">{{ $prd->title }}</a>
                                </h3>
                                <span class="price">{{ $prd->price }}
                                    {{ __('apps::frontend.master.kwd') }}</span>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        @endif

        @if (count($latestOffers) > 0)
            <div class="home-products">
                <h3 class="slider-title">{{ __('apps::frontend.master.latest_offers') }}</h3>
                <div class="owl-carousel products-slider">

                    @foreach ($latestOffers as $k => $prd)
                        <div class="product-grid">
                            <div class="product-image d-flex align-items-center">
                                {{-- <span class="pro-bdge discount">%10</span> --}}
                                <a href="{{ route('frontend.products.index', $prd->slug) }}">
                                    @if ($prd->tags)
                                        @foreach ($prd->tags as $i => $tag)
                                            <label class="label-tag-product"
                                                style="background-color: {{ $tag->color ?? '#ccc' }}">{{ $tag->title }}</label>
                                        @endforeach
                                    @endif
                                    <img class="pic-1" src="{{ url($prd->image) }}">
                                </a>
                                <ul class="social">
                                    <li>
                                        <a href="{{ route('frontend.products.index', $prd->slug) }}"
                                            data-tip="{{ __('apps::frontend.products.details.title') }}">
                                            <i class="ti ti-eye"></i>
                                        </a>
                                    </li>
                                    <li>
                                        @if (auth()->check() &&
                                            !in_array(
                                                $prd->id,
                                                array_column(
                                                    auth()->user()->favourites->toArray(),
                                                    'id',
                                                ),
                                            ))
                                            <form class="favourites-form" method="POST">
                                                @csrf
                                                <a href="javascript:;" id="btnAddToFavourites-{{ $prd->id }}"
                                                    onclick="generalAddToFavourites('{{ route('frontend.profile.favourites.store', [$prd->id]) }}', '{{ $prd->id }}')"
                                                    data-tip="{{ __('apps::frontend.products.add_to_favourite') }}">
                                                    <i class="ti-heart"></i>
                                                </a>
                                            </form>
                                        @endif
                                    </li>

                                    @if (is_null($prd->variants) || count($prd->variants) == 0)
                                        <li>

                                            <div class="generalLoaderDiv" id="generalLoaderDiv-{{ $prd->id }}">
                                                <div class="my-loader"></div>
                                            </div>

                                            <form class="general-form" method="POST">
                                                @csrf

                                                <input type="hidden" id="productImage-{{ $prd->id }}"
                                                    value="{{ url($prd->image) }}">
                                                <input type="hidden" id="productTitle-{{ $prd->id }}"
                                                    value="{{ $prd->title }}">
                                                <input type="hidden" id="productQuantity-{{ $prd->id }}"
                                                    value="{{ getCartItemById($prd->id) ? getCartItemById($prd->id)->quantity + 1 : 1 }}">

                                                <a href="javascript:;" id="general_add_to_cart-{{ $prd->id }}"
                                                    class="btnGeneralAddToCart"
                                                    onclick="generalAddToCart('{{ route('frontend.shopping-cart.create-or-update', [$prd->slug]) }}', '{{ $prd->id }}')"
                                                    data-tip="{{ __('apps::frontend.products.add_to_cart') }}">
                                                    <i class="ti-shopping-cart-full"></i>
                                                </a>

                                            </form>

                                        </li>
                                    @endif

                                </ul>

                            </div>
                            <div class="product-content">
                                <h3 class="title">
                                    <a href="{{ route('frontend.products.index', $prd->slug) }}">{{ $prd->title }}</a>
                                </h3>
                                <span class="price have-discount">
                                    <span class="price-before">{{ $prd->price }}
                                        {{ __('apps::frontend.master.kwd') }}</span>
                                    {{ $prd->offer->offer_price }} {{ __('apps::frontend.master.kwd') }}
                                </span>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        @endif

        {{-- @if (count($mostSellingProducts) > 0)
            <div class="home-products">
                <h3 class="slider-title">{{ __('apps::frontend.master.most_selling_products') }}</h3>
                <div class="owl-carousel products-slider">

                    @foreach ($mostSellingProducts as $k => $prd)
                        <div class="product-grid">
                            <div class="product-image d-flex align-items-center">
                                <a href="{{ route('frontend.products.index', $prd->slug) }}">
                                    <img class="pic-1" src="{{ url($prd->image) }}">
                                </a>
                                <ul class="social">
                                    <li>
                                        <a href="{{ route('frontend.products.index', $prd->slug) }}"
                                           data-tip="{{ __('apps::frontend.products.details.title') }}">
                                            <i class="ti ti-eye"></i>
                                        </a>
                                    </li>
                                    <li>

                                        @if (auth()->check() &&
    !in_array(
        $prd->id,
        array_column(
            auth()->user()->favourites->toArray(),
            'id',
        ),
    ))
                                            <form class="favourites-form" method="POST">
                                                @csrf
                                                <a href="javascript:;"
                                                   id="btnAddToFavourites-{{ $prd->id }}"
                                                   onclick="generalAddToFavourites('{{ route('frontend.profile.favourites.store', [ $prd->id ]) }}', '{{ $prd->id }}')"
                                                   data-tip="{{ __('apps::frontend.products.add_to_favourite') }}">
                                                    <i class="ti-heart"></i>
                                                </a>
                                            </form>
                                        @endif

                                    </li>

                                    @if (is_null($prd->variants) || count($prd->variants) == 0)
                                        <li>

                                            <div class="generalLoaderDiv" id="generalLoaderDiv-{{ $prd->id }}">
                                                <div class="my-loader"></div>
                                            </div>

                                            <form class="general-form" method="POST">
                                                @csrf

                                                <input type="hidden" id="productImage-{{ $prd->id }}"
                                                       value="{{ url($prd->image) }}">
                                                <input type="hidden" id="productTitle-{{ $prd->id }}"
                                                       value="{{ $prd->title }}">
                                                <input type="hidden" id="productQuantity-{{ $prd->id }}"
                                                       value="{{ getCartItemById($prd->id) ? getCartItemById($prd->id)->quantity + 1 : 1 }}">

                                                <a href="javascript:;" id="general_add_to_cart-{{ $prd->id }}"
                                                   class="btnGeneralAddToCart"
                                                   onclick="generalAddToCart('{{ route("frontend.shopping-cart.create-or-update", [ $prd->slug ]) }}', '{{ $prd->id }}')"
                                                   data-tip="{{ __('apps::frontend.products.add_to_cart') }}">
                                                    <i class="ti-shopping-cart-full"></i>
                                                </a>

                                            </form>

                                        </li>
                                    @endif

                                </ul>

                            </div>
                            <div class="product-content">
                                <h3 class="title">
                                    <a href="{{ route('frontend.products.index', $prd->slug) }}">{{ $prd->title }}</a>
                                </h3>
                                <span class="price">{{ $prd->price }} {{ __('apps::frontend.master.kwd') }}</span>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        @endif --}}

    </div>


@endsection

@section('externalJs')

    <script></script>

@endsection
