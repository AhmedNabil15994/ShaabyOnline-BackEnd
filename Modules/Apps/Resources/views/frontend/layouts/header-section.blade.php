@section('externalStyle')
    <style>
        .empty-subtitle {
            text-align: center;
            color: #434343;
            font-size: 13px;
        }
    </style>
@endsection

<header class="site-header header-option no-print">

    @if (isset(Setting::get('theme_sections')['top_header']) && Setting::get('theme_sections')['top_header'])
        <div class="header-top">
            <div class="container">
                <div class="topp">
                    <ul class="header-top-left">
                        <li>
                            @if (config('setting.contact_us.mobile'))
                                <a href="javascript:;"> {{ __('apps::frontend.contact_us.header_title') }}
                                    : {{ config('setting.contact_us.mobile') }}</a>
                            @endif
                        </li>
                    </ul>
                    <ul class="header-top-right">
                        <li>
                            {{-- @if (auth()->guest())
                            <a href="{{ route('frontend.orders.index') }}">
                        <i class="ti-truck"></i>
                        <span>{{ __('user::frontend.profile.index.my_orders') }}</span>
                        </a>
                        @else
                        <a href="{{ route('frontend.profile.index') }}">
                            <i class="fa fa-user"></i> <span>{{ __('apps::frontend.master.my_account') }}</span>
                        </a>
                        @endif --}}

                            @if (env('LOGIN'))
                                <a href="{{ route('frontend.profile.index') }}">
                                    <i class="fa fa-user"></i>
                                    <span>{{ __('apps::frontend.master.my_account') }}</span>
                                </a>
                            @endif

                        </li>
                        <li class="menu-item-has-children">
                            @foreach (config('laravellocalization.supportedLocales') as $localeCode => $properties)
                                @if ($localeCode != locale())
                                    <a hreflang="{{ $localeCode }}"
                                        href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                                        @if ($localeCode == 'ar')
                                            <img src="{{ url('frontend/images/kw.svg') }}"
                                                alt="{{ $properties['native'] }}">
                                        @else
                                            <img src="{{ url('frontend/images/us.svg') }}"
                                                alt="{{ $properties['native'] }}">
                                        @endif
                                        {{ $properties['native'] }}
                                    </a>
                                @endif
                            @endforeach
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    @endif

    @if (isset(Setting::get('theme_sections')['middle_header']) && Setting::get('theme_sections')['middle_header'])
        <div class="header-content">
            <div class="container">
                <div class="row">
                    <div class="col-lg-2 col-md-3 col-4">
                        <div class="logo-header">
                            <a href="{{ route('frontend.home') }}">
                                <img src="{{ config('setting.images.logo') ? url(config('setting.images.logo')) : url('frontend/images/header-logo.png') }}"
                                    alt="logo">
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-8 col-md-6 d-re-no">
                        <div class="block-search">

                            <form method="get" action="{{ route('frontend.categories.products') }}"
                                class="form-search">
                                <div class="form-content">
                                    <div class="search-input">
                                        <input type="text" class="input"
                                            onkeyup="showResult(this.value,'{{ route('frontend.home.filter') }}')"
                                            autocomplete="off"
                                            placeholder="{{ __('apps::frontend.home.search_product') }}" name="s"
                                            value="{{ request('s') }}">
                                        <i class="ti-search"></i>
                                    </div>
                                    <div class="xdsoft_autocomplete" style="display: inline-block; width: 473px;">
                                        <div id="livesearch" class="xdsoft_autocomplete_dropdown" style="top: -13px;">
                                        </div>
                                    </div>
                                </div>
                            </form>

                            {{-- <form method="get" action="{{ route('frontend.categories.products') }}"
                            class="form-search">
                            <div class="form-content">
                                <div class="search-input">
                                    <input type="text" class="input" name="s"
                                        value="{{ request()->get('s') }}" autocomplete="off">
                                    <i class="ti-search"></i>
                                </div>
                            </div>
                        </form> --}}

                        </div>
                    </div>

                    <div class="col-lg-2 col-md-3 col-8 header-cart mt-30">
                        <button class="res-searc-icon">
                            <i class="ti-search"></i>
                        </button>

                        <div class="block-minicart dropdown">

                            @if (!in_array(request()->route()->getName(),
                                ['frontend.shopping-cart.index', 'frontend.checkout.index']))

                                <a class="minicart d-flex align-items-center" href="#">
                                    <span class="counter qty" id="cartIcon">
                                        <span class="cart-icon">
                                            <i class="ti-shopping-cart-full"></i>
                                        </span>

                                        @if (count(getCartContent(null, true)) > 0)
                                            <span class="counter-number"
                                                id="cartPrdCount">{{ count(getCartContent()) }}</span>
                                        @endif

                                    </span>
                                    <span class="counter-your-cart">
                                        <span class="d-block">{{ __('catalog::frontend.cart.shipping_cart') }}</span>
                                        {{-- <span class="counter-price">500 د.ك</span> --}}
                                    </span>
                                </a>

                                <div class="dropdown-menu">
                                    <div class="minicart-content-wrapper">

                                        <div id="cartItemsInfo">
                                            @if (count(getCartContent()) > 0)
                                                <div class="subtitle">
                                                    {{ __('catalog::frontend.cart.you_have') }}
                                                    <b>( {{ count(getCartContent()) }} )</b>
                                                    {{ __('catalog::frontend.cart.products_in_your_cart') }}
                                                </div>
                                            @else
                                                <div class="empty-subtitle">{{ __('catalog::frontend.cart.empty') }}
                                                </div>
                                            @endif
                                        </div>

                                        <div id="cartItemsContainer">

                                            @if (count(getCartContent()) > 0)


                                                <div class="minicart-items-wrapper">
                                                    <ol class="minicart-items">

                                                        @foreach (getCartContent() as $k => $item)
                                                            <li class="product-item"
                                                                id="prdList-{{ $item->attributes->product->id }}">
                                                                <div class="media align-items-center">
                                                                    <div class="pro-img d-flex align-items-center">
                                                                        <img class="img-fluid"
                                                                            src="{{ url($item->attributes->product->image) }}"
                                                                            alt="Author">
                                                                    </div>
                                                                    <div class="media-body">
                                                                        <span class="product-name">
                                                                            @if ($item->attributes->product_type == 'variation')
                                                                                <a
                                                                                    href="{{ route('frontend.products.index', [$item->attributes->product->product->slug, generateVariantProductData($item->attributes->product->product, $item->attributes->product->id, $item->attributes->selectedOptionsValue)['slug']]) }}">
                                                                                    {{ generateVariantProductData($item->attributes->product->product, $item->attributes->product->id, $item->attributes->selectedOptionsValue)['name'] }}
                                                                                </a>
                                                                            @else
                                                                                <a
                                                                                    href="{{ route('frontend.products.index', [$item->attributes->product->slug]) }}">
                                                                                    {{ $item->attributes->product->title }}
                                                                                </a>
                                                                            @endif
                                                                        </span>
                                                                        <div class="product-price d-block">
                                                                            <span class="text-muted">x
                                                                                {{ $item->quantity }}</span>
                                                                            <span>{{ $item->price }}
                                                                                {{ __('apps::frontend.master.kwd') }}</span>
                                                                        </div>
                                                                    </div>

                                                                    @if (!in_array(request()->route()->getName(),
                                                                        ['frontend.shopping-cart.index', 'frontend.checkout.index']))
                                                                        <button type="button" class="btn remove"
                                                                            onclick="deleteFromCartByAjax('{{ $item->attributes->product->id }}', '{{ $item->attributes->product->product_type }}')">
                                                                            <i class="ti-trash"></i>
                                                                        </button>
                                                                    @endif

                                                                </div>
                                                            </li>
                                                        @endforeach

                                                    </ol>
                                                </div>

                                                <div class="minicart-footer">
                                                    <div class="subtotal">
                                                        <span
                                                            class="label">{{ __('catalog::frontend.cart.subtotal') }}
                                                            :</span>
                                                        <span class="price" id="cartPrdTotal">{{ getCartSubTotal() }}
                                                            {{ __('apps::frontend.master.kwd') }}</span>
                                                    </div>
                                                    <div class="actions">
                                                        <a class="btn btn-viewcart"
                                                            href="{{ route('frontend.shopping-cart.index') }}">
                                                            <i class="ti-shopping-cart-full"></i>
                                                            {{ __('catalog::frontend.cart.cart_details') }}
                                                        </a>
                                                        <a class="btn btn-checkout"
                                                            href="{{ route('frontend.checkout.index') }}">
                                                            <i class="ti-wallet"></i>
                                                            {{ __('catalog::frontend.cart.checkout') }}
                                                        </a>
                                                    </div>
                                                </div>

                                            @endif

                                        </div>

                                    </div>
                                </div>
                            @else
                                <a class="minicart d-flex align-items-center"
                                    href="{{ route('frontend.shopping-cart.index') }}">
                                    <span class="counter qty" id="cartIcon">
                                        <span class="cart-icon">
                                            <i class="ti-shopping-cart-full"></i>
                                        </span>
                                    </span>
                                    <span class="counter-your-cart">
                                        <span class="d-block">{{ __('catalog::frontend.cart.shipping_cart') }}</span>
                                    </span>
                                </a>
                            @endif

                        </div>
                    </div>

                </div>
            </div>
        </div>
    @endif

    @if (isset(Setting::get('theme_sections')['bottom_header']) && Setting::get('theme_sections')['bottom_header'])
        <div class="header-menu-nar">
            <div class="container">
                <div class="header-menu">
                    <ul class="header-nav">
                        <li class="btn-close hidden-mobile"><i class="fa fa-times" aria-hidden="true"></i></li>
                        <li class="menu-item">
                            <a href="{{ route('frontend.home') }}">{{ __('apps::frontend.master.home') }}</a>
                        </li>
                        <li class="menu-item menu-item-has-children arrow">
                            <a href="" class="dropdown-toggle">
                                {{ __('apps::frontend.master.categories') }} <i class="fa fa-angle-down"></i>
                            </a>
                            <span class="toggle-submenu hidden-mobile"></span>
                            <ul class="submenu dropdown-menu">

                                @if (count($headerCategories) > 0)
                                    @foreach ($headerCategories as $k => $category)
                                        @php $children = $category->children; @endphp
                                        <li
                                            class="menu-item menu-item-has-children  {{ count($children) > 0 ? 'arrowleft' : '' }}">
                                            <a href="{{ route('frontend.categories.products', $category->slug) }}"
                                                class="dropdown-toggle">{{ $category->title }}</a>
                                            {{-- <span class="toggle-submenu hidden-mobile"></span> --}}

                                            @if (count($children))
                                                @include('apps::frontend.layouts._nested_categories', [
                                                    'children' => $children,
                                                ])
                                            @endif

                                        </li>
                                    @endforeach
                                @endif

                            </ul>
                        </li>
                        <li>
                            <a
                                href="{{ $aboutUs ? route('frontend.pages.index', $aboutUs->slug) : '#' }}">{{ __('apps::frontend.master.about_us') }}</a>
                        </li>
                        <li>
                            <a
                                href="{{ route('frontend.contact_us') }}">{{ __('apps::frontend.master.contact_us') }}</a>
                        </li>
                    </ul>
                </div>
                <span data-action="toggle-nav" class="menu-on-mobile hidden-mobile">
                    <span class="btn-open-mobile home-page">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                    {{ __('apps::frontend.master.main_menu') }}
                </span>
            </div>
        </div>
    @endif

</header>
