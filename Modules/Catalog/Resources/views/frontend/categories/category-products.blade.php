@extends('apps::frontend.layouts.master', [
    'headerCategories' => $categories,
])
@section('title', __('catalog::frontend.category_products.title'))

@section('externalStyle')

    <style>
        .filter-price .custom-slider-range-price {
            background: #e4e4e4 none repeat scroll 0 0;
            height: 4px;
            margin-bottom: 18px;
            position: relative;
            margin-top: 26px;
        }

        .filter-price .custom-slider-range-price .ui-slider-range {
            background: #5466a6 none repeat scroll 0 0;
            height: 4px;
            left: 65px;
            position: absolute;
            top: 0;
            width: 160px;
        }

        .filter-price .custom-slider-range-price .ui-slider-handle {
            background: #fff none repeat scroll 0 0;
            cursor: pointer;
            height: 15px;
            left: 25px;
            position: absolute;
            top: -6px;
            width: 15px;
            border-radius: 50%;
            border: 2px solid #5466a6;
        }
    </style>

@endsection

@section('content')

    {{-- <div class="category-header d-flex align-items-center">
        <div class="container">
            @if ($category)
                <p style="color: #FFFFFF; font-size: 16px;">{{ $category->title }}</p>
                <img src="{{ url($category->image) }}" alt="{{ $category->title }}"/>
            @endif
        </div>
    </div> --}}

    <div class="second-header category-headr d-flex align-items-center"
        @if ($category && $category->cover) style="background: url({{ url($category->cover) }});"
         @else style="background: none; background-color: #a7bec5;" @endif>
        <div class="container">
            @if ($category)
                <h1>{{ $category->title }} </h1>
            @endif

            @if ($vendor)
                <h1>{{ $vendor->title }}</h1>
            @endif
        </div>
    </div>
    <div class="container">
        <div class="inner-page">
            <div class="row">

                <div class="col-md-3">
                    @include('catalog::frontend.categories._filter')
                </div>

                <div class="col-md-9">
                    <div class="toolbar-products">
                        <div class="row">
                            <div class="col-md-6 col-7">
                                <div class="toolbar-per">
                                    <span> {{ __('catalog::frontend.category_products.show_results') }}
                                        <b>{{ $products->count() }}</b>
                                        {{ __('catalog::frontend.category_products.products_from') }}
                                        <b>{{ $products->total() }}</b> </span>
                                </div>
                            </div>
                            <div class="col-md-6 col-5 pr0">

                                @if ($products->count() > 0)
                                    <div class="toolbar-sort">
                                        <select class="sorter-options form-control">
                                            <!--<option selected="selected" disabled value=""> رتب حسب</option>-->
                                            <option value="price">
                                                {{ __('catalog::frontend.category_products.recent_added') }}</option>
                                            <option value="price">
                                                {{ __('catalog::frontend.category_products.most_popular') }}</option>
                                        </select>
                                    </div>
                                @endif

                            </div>
                        </div>
                    </div>
                    <div class="list-products">
                        <div class="row">

                            @foreach ($products as $k => $product)
                                <div class="col-md-4 col-6">
                                    <div class="product-grid">
                                        <div class="product-image d-flex align-items-center">
                                            <a href="{{ route('frontend.products.index', $product->slug) }}">
                                                @if ($product->tags)
                                                    @foreach ($product->tags as $i => $tag)
                                                        <label class="label-tag-product"
                                                            style="background-color: {{ $tag->background ?? '#ddd' }}; color: {{ $tag->color ?? '#fff' }}">{{ $tag->title }}</label>
                                                    @endforeach
                                                @endif
                                                <img class="pic-1" src="{{ url($product->image) }}">
                                            </a>
                                            <ul class="social">
                                                <li>
                                                    <a href="{{ route('frontend.products.index', $product->slug) }}"
                                                        data-tip="{{ __('apps::frontend.products.details.title') }}">
                                                        <i class="ti ti-eye"></i>
                                                    </a>
                                                </li>
                                                <li>

                                                    @if (auth()->check() &&
                                                        !in_array(
                                                            $product->id,
                                                            array_column(auth()->user()->favourites->toArray(),
                                                                'id')))
                                                        <form class="favourites-form" method="POST">
                                                            @csrf
                                                            <a href="javascript:;"
                                                                id="btnAddToFavourites-{{ $product->id }}"
                                                                onclick="generalAddToFavourites('{{ route('frontend.profile.favourites.store', [$product->id]) }}', '{{ $product->id }}')"
                                                                data-tip="{{ __('apps::frontend.products.add_to_favourite') }}">
                                                                <i class="ti-heart"></i>
                                                            </a>
                                                        </form>
                                                    @endif

                                                </li>

                                                @if (is_null($product->variants) || count($product->variants) == 0)
                                                    <li>

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
                                                                {{-- value="{{ getCartItemById($product->id) ? getCartItemById($product->id)->quantity + 1 : 1 }}" --}}
                                                                value="{{ getCartQuantityById($product->id) ? getCartQuantityById($product->id) + 1 : 1 }}">

                                                            <a href="javascript:;"
                                                                id="general_add_to_cart-{{ $product->id }}"
                                                                class="btnGeneralAddToCart"
                                                                onclick="generalAddToCart('{{ route('frontend.shopping-cart.create-or-update', [$product->slug]) }}', '{{ $product->id }}')"
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
                                                <a
                                                    href="{{ route('frontend.products.index', $product->slug) }}">{{ $product->title }}</a>
                                            </h3>
                                            <span class="price have-discount">
                                                @if ($product->offer)
                                                    @if (!is_null($product->offer->offer_price))
                                                        <span class="price-before">{{ $product->price }}
                                                            {{ __('apps::frontend.master.kwd') }}</span>
                                                        {{ $product->offer->offer_price }}
                                                        {{ __('apps::frontend.master.kwd') }}
                                                    @else
                                                        <span>{{ $product->price }}
                                                            {{ __('apps::frontend.master.kwd') }}</span>
                                                        /
                                                        <span class="percentage-discount">
                                                            {{ $product->offer->percentage . ' %' }}
                                                            {{ __('apps::frontend.master.discount') }} </span>
                                                        {{-- {{ calculateOfferAmountByPercentage($product->price, $product->offer->percentage) }} {{ __('apps::frontend.master.kwd') }} --}}
                                                    @endif
                                                @else
                                                    {{ $product->price }} {{ __('apps::frontend.master.kwd') }}
                                                @endif
                                            </span>
                                            {{-- <span
                                                class="price">{{ $product->price }} {{ __('apps::frontend.master.kwd') }}</span> --}}
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>

                    <div class="pagination-items mt-20">
                        <div class="row">
                            <div class="col-md-3 col-4">

                                @if ($products->count() > 0)
                                    <p class="pagination-counter">
                                        {{ $products->count() }} {{ __('catalog::frontend.category_products.from') }}
                                        {{ $products->currentPage() }}
                                        -{{ $products->total() }}
                                    </p>
                                @endif

                            </div>
                            <div class="col-md-9 col-8">

                                @include('core::frontend.components.paginate', ['paginator' => $products])

                                {{-- {{ $products->links('catalog::frontend.categories._custom_pagination', ['paginator' => $products]) }} --}}

                                {{-- <ul class="pagination d-md-flex justify-content-md-end align-items-md-center">
                                    <li class="page-item disabled">
                                        <a class="page-link" href="#" aria-label="Previous">
                                            <span aria-hidden="true">&laquo;</span>
                                            <span class="sr-only">Previous</span>
                                        </a>
                                    </li>
                                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                                    <li class="page-item">
                                        <a class="page-link" href="#" aria-label="Next">
                                            <span aria-hidden="true">&raquo;</span>
                                            <span class="sr-only">Next</span>
                                        </a>
                                    </li>
                                </ul> --}}

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection


@section('pageJs')
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
@endsection

@section('externalJs')

    <script>
        // Slider range price
        $('.custom-slider-range-price').each(function() {
            var min = parseInt($(this).data('min'));
            var max = parseInt($(this).data('max'));
            var unit = $(this).data('unit');
            var value_min = parseInt($(this).data('value-min'));
            var value_max = parseInt($(this).data('value-max'));
            var label_reasult = $(this).data('label-reasult');
            var t = $(this);
            $(this).slider({
                range: true,
                min: min,
                max: max,
                values: [value_min, value_max],
                slide: function(event, ui) {
                    var result = label_reasult + " <span>" + unit + ui.values[0] +
                        ' </span> - <span> ' + unit + ui.values[1] + '</span>';
                    t.closest('.price_slider_wrapper').find('.price_slider_amount').html(result);

                    /************* Edited By Mahmoud Elzohairy **************/
                    t.closest('.price_slider_wrapper').find('#hiddenPriceSliderAmount #priceFrom').val(
                        ui.values[0]);
                    t.closest('.price_slider_wrapper').find('#hiddenPriceSliderAmount #priceTo').val(ui
                        .values[1]);
                }
            });
        });
    </script>

@endsection
