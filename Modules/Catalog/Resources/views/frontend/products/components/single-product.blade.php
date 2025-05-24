<div class="product-grid">
    <div class="product-image img-block d-flex align-items-center">
        @if ($product->is_new)
            <span class="pro-bdge new">جديد</span>
        @endif
        <a href="{{ route('frontend.products.index', $product->slug) }}">
            <img class="pic-1" src="{{ asset($product->image) }}">
        </a>
        <ul class="social">
            <li><a href="{{ route('frontend.products.index', $product->slug) }}" data-tip="Product Details"><i
                        class="ti ti-eye"></i></a></li>
            <li>
                @if (auth()->check() &&
                    !in_array(
                        $product->id,
                        array_column(auth()->user()->favourites->toArray(),
                            'id')))
                    <form class="favourites-form" method="POST">
                        @csrf
                        <a href="javascript:;" id="btnAddToFavourites-{{ $product->id }}"
                            onclick="generalAddToFavourites('{{ route('frontend.profile.favourites.store', [$product->id]) }}', '{{ $product->id }}')"
                            data-tip="{{ __('apps::frontend.products.add_to_favourite') }}">
                            <i class="ti-heart"></i>
                        </a>
                    </form>
                @endif
            </li>
            @if ($product->variants_count == 0)
                <li>

                    <div class="single-product-add-to-cart-content">
                        <div class="productLoader" style="display: none">
                            <div class="d-flex justify-content-center">
                                <div class="spinner-border" role="status" style="width: 2rem; height: 2rem;">
                                    <span class="sr-only">{{ __('apps::frontend.Loading') }}</span>
                                </div>
                            </div>
                        </div>
                        <form class="general-form" method="POST">
                            @csrf
                            <input type="hidden" id="productImage-{{ $product->id }}"
                                value="{{ url($product->image) }}">
                            <input type="hidden" id="productTitle-{{ $product->id }}" value="{{ $product->title }}">
                            <input type="hidden" id="productQuantity-{{ $product->id }}"
                                value="{{ getCartQuantityById($product->id) ? getCartQuantityById($product->id) + 1 : 1 }}">

                            <a href="javascript:;" id="general_add_to_cart-{{ $product->id }}"
                                class="btnGeneralAddToCart"
                                onclick="generalAddToCart('{{ route('frontend.shopping-cart.create-or-update', [$product->slug]) }}', '{{ $product->id }}',this)"
                                data-tip="{{ __('apps::frontend.products.add_to_cart') }}">
                                <i class="ti-shopping-cart-full"></i>
                            </a>

                        </form>
                    </div>
                </li>
            @endif
        </ul>

    </div>
    <div class="product-content">
        <h3 class="title"><a href="{{ route('frontend.products.index', $product->slug) }}">{{ $product->title }}</a>
        </h3>
        <span class="price">
            @if ($product->offer)
                @if (!is_null($product->offer->offer_price))
                    <span class="price-before">{{ $product->price }} {{ __('apps::frontend.master.kwd') }}</span>
                    {{ $product->offer->offer_price }} {{ __('apps::frontend.master.kwd') }}
                @else
                    <span style="text-decoration: line-through;color: red">{{ $product->price }}
                        {{ __('apps::frontend.master.kwd') }}</span>
                    /

                    {{ calculateOfferAmountByPercentage($product->price, $product->offer->percentage) }}
                @endif
            @else
                {{ $product->price }} {{ __('apps::frontend.master.kwd') }}
            @endif
        </span>

        @if ($product->variants_count == 0)
            {{-- <form class="general-form" method="POST">
                @csrf
                <input type="hidden" id="productImage-{{ $product->id }}"
                       value="{{ url($product->image) }}">
                <input type="hidden" id="productTitle-{{ $product->id }}"
                       value="{{ $product->title }}">
                <input type="hidden" id="productQuantity-{{ $product->id }}"
                       value="{{ getCartQuantityById($product->id) ? getCartQuantityById($product->id) + 1 : 1 }}">

                <a href="javascript:;" id="general_add_to_cart-{{ $product->id }}"
                   class="btnGeneralAddToCart btn main-custom-btn" style="margin: 10px 0px;"
                   onclick="generalAddToCart('{{ route("frontend.shopping-cart.create-or-update", [ $product->slug ]) }}', '{{ $product->id }}',this)"
                   data-tip="{{ __('apps::frontend.products.add_to_cart') }}">
                    <i class="ti-shopping-cart-full"></i>
                    {{ __('apps::frontend.products.add_to_cart') }}
                </a>
            </form> --}}
        @else
            <div>
                <a href="{{ route('frontend.products.index', $product->slug) }}" style="margin: 10px 0px;"
                    class="btnGeneralAddToCart btn main-custom-btn">
                    {{ __('apps::frontend.products.show_product') }}
                </a>
            </div>
        @endif
    </div>
</div>
