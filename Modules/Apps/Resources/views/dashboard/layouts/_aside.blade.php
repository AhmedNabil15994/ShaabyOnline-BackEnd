<div class="page-sidebar-wrapper">
    <div class="page-sidebar navbar-collapse collapse">

        <ul class="page-sidebar-menu  page-header-fixed" data-keep-expanded="false" data-auto-scroll="true"
            data-slide-speed="200">
            <li class="sidebar-toggler-wrapper hide">
                <div class="sidebar-toggler">
                    <span></span>
                </div>
            </li>

            <li class="nav-item {{ active_menu(['home', '']) }}">
                <a href="{{ url(route('dashboard.home')) }}" class="nav-link nav-toggle">
                    <i class="icon-home"></i>
                    <span class="title">{{ __('apps::dashboard.home.title') }}</span>
                    <span class="selected"></span>
                </a>
            </li>
        </ul>

        @if (\Auth::user()->can(['show_roles', 'show_users', 'show_admins']))
            <ul class="page-sidebar-menu  page-header-fixed" data-keep-expanded="false" data-auto-scroll="true"
                data-slide-speed="200">
                <li class="nav-item  {{ active_slide_menu(['roles', 'users', 'admins']) }}">

                    <a href="javascript:;" class="nav-link nav-toggle">
                        <i class="icon-users"></i>
                        <span class="title">{{ __('apps::dashboard.aside.tab.users') }}</span>
                        <span class="arrow open"></span>
                        <span class="selected"></span>
                    </a>

                    <ul class="sub-menu" style="display: block;">

                        @permission('roles')
                            <li class="nav-item {{ active_menu('roles') }}">
                                <a href="{{ url(route('dashboard.roles.index')) }}" class="nav-link nav-toggle">
                                    {{-- <i class="icon-briefcase"></i> --}}
                                    <span class="title">{{ __('apps::dashboard._layout.aside.roles') }}</span>
                                    <span class="selected"></span>
                                </a>
                            </li>
                        @endpermission

                        @permission('show_users')
                            <li class="nav-item {{ active_menu('users') }}">
                                <a href="{{ url(route('dashboard.users.index')) }}" class="nav-link nav-toggle">
                                    {{-- <i class="icon-briefcase"></i> --}}
                                    <span class="title">{{ __('apps::dashboard.aside.users') }}</span>
                                    <span class="selected"></span>
                                </a>
                            </li>
                        @endpermission

                        @permission('show_admins')
                            <li class="nav-item {{ active_menu('admins') }}">
                                <a href="{{ url(route('dashboard.admins.index')) }}" class="nav-link nav-toggle">
                                    {{-- <i class="icon-briefcase"></i> --}}
                                    <span class="title">{{ __('apps::dashboard.aside.admins') }}</span>
                                    <span class="selected"></span>
                                </a>
                            </li>
                        @endpermission
                    </ul>
                </li>
            </ul>
        @endif

        @if (Module::isEnabled('Order'))
            @if (\Auth::user()->can(['show_orders', 'show_all_orders']))
                <ul class="page-sidebar-menu  page-header-fixed" data-keep-expanded="false" data-auto-scroll="true"
                    data-slide-speed="200">
                    <li
                        class="nav-item  {{ active_slide_menu(['current-orders', 'completed-orders', 'not-completed-orders', 'refunded-orders', 'all-orders']) }}">

                        <a href="javascript:;" class="nav-link nav-toggle">
                            <i class="fa fa-shopping-cart"></i>
                            <span class="title">{{ __('apps::dashboard.aside.tab.orders') }}</span>
                            <span class="arrow open"></span>
                            <span class="selected"></span>
                        </a>

                        <ul class="sub-menu" style="display: block;">

                            @permission('show_orders')
                                <li class="nav-item {{ active_menu('current-orders') }}">
                                    <a href="{{ url(route('dashboard.current_orders.index')) }}"
                                        class="nav-link nav-toggle">
                                        {{-- <i class="icon-briefcase"></i> --}}
                                        <span class="title">{{ __('apps::dashboard.aside.current_orders') }}</span>
                                        @if (isset($ordersCount['current_orders']) && $ordersCount['current_orders'] > 0)
                                            <span class="badge badge-danger">{{ $ordersCount['current_orders'] }}</span>
                                        @endif
                                    </a>
                                </li>

                                <li class="nav-item {{ active_menu('completed-orders') }}">
                                    <a href="{{ url(route('dashboard.completed_orders.index')) }}"
                                        class="nav-link nav-toggle">
                                        {{-- <i class="icon-briefcase"></i> --}}
                                        <span class="title">{{ __('apps::dashboard.aside.completed_orders') }}</span>
                                    </a>
                                </li>

                                <li class="nav-item {{ active_menu('not-completed-orders') }}">
                                    <a href="{{ url(route('dashboard.not_completed_orders.index')) }}"
                                        class="nav-link nav-toggle">
                                        {{-- <i class="icon-briefcase"></i> --}}
                                        <span class="title">{{ __('apps::dashboard.aside.not_completed_orders') }}</span>
                                    </a>
                                </li>

                                <li class="nav-item {{ active_menu('refunded-orders') }}">
                                    <a href="{{ url(route('dashboard.refunded_orders.index')) }}"
                                        class="nav-link nav-toggle">
                                        {{-- <i class="icon-briefcase"></i> --}}
                                        <span class="title">{{ __('apps::dashboard.aside.refunded_orders') }}</span>
                                    </a>
                                </li>
                            @endpermission

                            @permission('show_all_orders')
                                <li class="nav-item {{ active_menu('all-orders') }}">
                                    <a href="{{ url(route('dashboard.all_orders.index')) }}" class="nav-link nav-toggle">
                                        {{-- <i class="icon-briefcase"></i> --}}
                                        <span class="title">{{ __('apps::dashboard.aside.all_orders') }}</span>
                                    </a>
                                </li>
                            @endpermission

                        </ul>
                    </li>
                </ul>
            @endif
        @endif

        @if (Module::isEnabled('Catalog'))
            @if (\Auth::user()->can([
                'show_products',
                'review_products',
                'show_categories',
                'show_home_categories',
                'show_options',
                'show_tags',
                'show_search_keywords',
                'show_addon_categories',
            ]))
                <ul class="page-sidebar-menu  page-header-fixed" data-keep-expanded="false" data-auto-scroll="true"
                    data-slide-speed="200">
                    <li
                        class="nav-item  {{ active_slide_menu(['products', 'review-products', 'categories', 'home-categories', 'options', 'tags', 'search-keywords', 'addon-categories']) }}">
                        <a href="javascript:;" class="nav-link nav-toggle">
                            <i class="fa fa-briefcase"></i>
                            <span class="title">{{ __('apps::dashboard.aside.tab.catalog') }}</span>
                            <span class="arrow open"></span>
                            <span class="selected"></span>
                        </a>
                        <ul class="sub-menu" style="display: block;">

                            @permission('show_products')
                                <li class="nav-item {{ active_menu('products') }}">
                                    <a href="{{ url(route('dashboard.products.index')) }}" class="nav-link nav-toggle">
                                        {{-- <i class="icon-briefcase"></i> --}}
                                        <span class="title">{{ __('apps::dashboard.aside.products') }}</span>
                                    </a>
                                </li>
                            @endpermission

                            @permission('review_products')
                                <li class="nav-item {{ active_menu('review-products') }}" id="sideMenuReviewProducts"
                                    style="display: {{ toggleSideMenuItemsByVendorType() }}">
                                    <a href="{{ url(route('dashboard.review_products.index')) }}"
                                        class="nav-link nav-toggle">
                                        {{-- <i class="icon-briefcase"></i> --}}
                                        <span class="title">{{ __('apps::dashboard.aside.review_products') }}</span>
                                        @if (isset($reviewProductsCount) && $reviewProductsCount > 0)
                                            <span class="badge badge-danger">{{ $reviewProductsCount }}</span>
                                        @endif
                                    </a>
                                </li>
                            @endpermission

                            @permission('show_categories')
                                <li class="nav-item {{ active_menu('categories') }}">
                                    <a href="{{ url(route('dashboard.categories.index')) }}" class="nav-link nav-toggle">
                                        {{-- <i class="icon-briefcase"></i> --}}
                                        <span class="title">{{ __('apps::dashboard.aside.categories') }}</span>
                                    </a>
                                </li>
                            @endpermission

                            @permission('show_home_categories')
                                <li class="nav-item {{ active_menu('home-categories') }}">
                                    <a href="{{ url(route('dashboard.home_categories.index')) }}"
                                        class="nav-link nav-toggle">
                                        {{-- <i class="icon-briefcase"></i> --}}
                                        <span class="title">{{ __('apps::dashboard.aside.home_categories') }}</span>
                                    </a>
                                </li>
                            @endpermission

                            @if (config('setting.products.toggle_variations') == 1)
                                @permission('show_options')
                                    <li class="nav-item {{ active_menu('options') }}">
                                        <a href="{{ url(route('dashboard.options.index')) }}"
                                            class="nav-link nav-toggle">
                                            {{-- <i class="icon-briefcase"></i> --}}
                                            <span class="title">{{ __('apps::dashboard.aside.options') }}</span>
                                        </a>
                                    </li>
                                @endpermission
                            @endif

                            @permission('show_tags')
                                <li class="nav-item {{ active_menu('tags') }}">
                                    <a href="{{ url(route('dashboard.tags.index')) }}" class="nav-link nav-toggle">
                                        {{-- <i class="icon-tag"></i> --}}
                                        <span class="title">{{ __('apps::dashboard.aside.tags') }}</span>
                                    </a>
                                </li>
                            @endpermission

                            @permission('show_search_keywords')
                                <li class="nav-item {{ active_menu('search-keywords') }}">
                                    <a href="{{ url(route('dashboard.search_keywords.index')) }}"
                                        class="nav-link nav-toggle">
                                        {{-- <i class="icon-briefcase"></i> --}}
                                        <span class="title">{{ __('apps::dashboard.aside.search_keywords') }}</span>
                                    </a>
                                </li>
                            @endpermission

                            @if (config('setting.products.toggle_addons') == 1 &&
                                auth()->user()->can('show_product_addons'))
                                @permission('show_addon_categories')
                                    <li class="nav-item {{ active_menu('addon-categories') }}">
                                        <a href="{{ url(route('dashboard.addon_categories.index')) }}"
                                            class="nav-link nav-toggle">
                                            {{-- <i class="icon-briefcase"></i> --}}
                                            <span class="title">{{ __('apps::dashboard.aside.addon_categories') }}</span>
                                        </a>
                                    </li>
                                @endpermission

                                @permission('show_addon_options')
                                    <li class="nav-item {{ active_menu('addon-options') }}">
                                        <a href="{{ url(route('dashboard.addon_options.index')) }}"
                                            class="nav-link nav-toggle">
                                            {{-- <i class="icon-briefcase"></i> --}}
                                            <span class="title">{{ __('apps::dashboard.aside.addon_options') }}</span>
                                        </a>
                                    </li>
                                @endpermission
                            @endif

                        </ul>
                    </li>
                </ul>
            @endif
        @endif

        @if (Module::isEnabled('Vendor'))
            @if (\Auth::user()->can([
                'show_sellers',
                'show_vendors',
                'show_sections',
                'show_vendor_categories',
                'show_subscriptions',
            ]))
                <ul class="page-sidebar-menu  page-header-fixed" data-keep-expanded="false" data-auto-scroll="true"
                    data-slide-speed="200">
                    <li
                        class="nav-item  {{ active_slide_menu(['sellers', 'vendors', 'sections', 'vendor-categories', 'subscriptions']) }}">
                        <a href="javascript:;" class="nav-link nav-toggle">
                            <i class="fa fa-group"></i>
                            <span class="title">{{ __('apps::dashboard.aside.tab.vendors') }}</span>
                            <span class="arrow"></span>
                            <span class="selected"></span>
                        </a>
                        <ul class="sub-menu">

                            @permission('show_sellers')
                                <li class="nav-item {{ active_menu('sellers') }}" id="sideMenuVendorsSeller"
                                    style="display: {{ toggleSideMenuItemsByVendorType() }}">
                                    <a href="{{ url(route('dashboard.sellers.index')) }}" class="nav-link nav-toggle">
                                        {{-- <i class="icon-briefcase"></i> --}}
                                        <span class="title">{{ __('apps::dashboard.aside.sellers') }}</span>
                                    </a>
                                </li>
                            @endpermission

                            @permission('show_vendors')
                                <li class="nav-item {{ active_menu('vendors') }}" id="sideMenuVendors"
                                    style="display: {{ toggleSideMenuItemsByVendorType() }}">
                                    <a href="{{ url(route('dashboard.vendors.index')) }}" class="nav-link nav-toggle">
                                        {{-- <i class="icon-briefcase"></i> --}}
                                        <span class="title">{{ __('apps::dashboard.aside.vendors') }}</span>
                                    </a>
                                </li>
                            @endpermission

                            @permission('show_sections')
                                <li class="nav-item {{ active_menu('sections') }}" id="sideMenuVendorsSections"
                                    style="display: {{ toggleSideMenuItemsByVendorType() }}">
                                    <a href="{{ url(route('dashboard.sections.index')) }}" class="nav-link nav-toggle">
                                        {{-- <i class="icon-briefcase"></i> --}}
                                        <span class="title">{{ __('apps::dashboard.aside.sections') }}</span>
                                    </a>
                                </li>
                            @endpermission

                            @permission('show_vendor_categories')
                                <li class="nav-item {{ active_menu('vendor-categories') }}"
                                    id="sideMenuVendorsCategories"
                                    style="display: {{ toggleSideMenuItemsByVendorType() }}">
                                    <a href="{{ url(route('dashboard.vendor_categories.index')) }}"
                                        class="nav-link nav-toggle">
                                        {{-- <i class="icon-briefcase"></i> --}}
                                        <span class="title">{{ __('apps::dashboard.aside.vendor_categories') }}</span>
                                    </a>
                                </li>
                            @endpermission

                            @if (config('setting.other.enable_subscriptions') == 1)
                                @if (Module::isEnabled('Subscription'))
                                    @permission('show_subscriptions')
                                        <li class="nav-item {{ active_menu('subscriptions') }}">
                                            <a href="{{ url(route('dashboard.subscriptions.index')) }}"
                                                class="nav-link nav-toggle">
                                                {{-- <i class="icon-briefcase"></i> --}}
                                                <span
                                                    class="title">{{ __('apps::dashboard.aside.subscriptions') }}</span>
                                            </a>
                                        </li>
                                    @endpermission

                                    @permission('show_packages')
                                        <li class="nav-item {{ active_menu('packages') }}">
                                            <a href="{{ url(route('dashboard.packages.index')) }}"
                                                class="nav-link nav-toggle">
                                                {{-- <i class="icon-briefcase"></i> --}}
                                                <span class="title">{{ __('apps::dashboard.aside.packages') }}</span>
                                            </a>
                                        </li>
                                    @endpermission
                                @endif
                            @endif

                        </ul>
                    </li>
                </ul>
            @endif
        @endif

        @if (Module::isEnabled('Company'))
            @if (\Auth::user()->can(['show_companies', 'show_delivery_charges', 'show_drivers']))
                <ul class="page-sidebar-menu  page-header-fixed" data-keep-expanded="false" data-auto-scroll="true"
                    data-slide-speed="200">
                    <li
                        class="nav-item  {{ active_slide_menu(['companies', 'vendor-delivery-charges', 'delivery-charges', 'drivers']) }}">
                        <a href="javascript:;" class="nav-link nav-toggle">
                            <i class="fa fa-truck"></i>
                            <span class="title">{{ __('apps::dashboard.aside.tab.companies') }}</span>
                            <span class="arrow"></span>
                            <span class="selected"></span>
                        </a>
                        <ul class="sub-menu">

                            @if (config('setting.other.select_shipping_provider') == 'vendor_delivery')
                                @permission('show_delivery_charges')
                                    <li class="nav-item {{ active_menu('vendor-delivery-charges') }}">
                                        <a href="{{ url(route('dashboard.vendor_delivery_charges.index')) }}"
                                            class="nav-link nav-toggle">
                                            {{-- <i class="icon-briefcase"></i> --}}
                                            <span class="title">{{ __('apps::dashboard.aside.delivery_charges') }}</span>
                                        </a>
                                    </li>
                                @endpermission
                            @elseif(config('setting.other.select_shipping_provider') == 'shipping_company')
                                @permission('show_companies')
                                    <li class="nav-item {{ active_menu('companies') }}">
                                        <a href="{{ url(route('dashboard.companies.index')) }}"
                                            class="nav-link nav-toggle">
                                            {{-- <i class="icon-briefcase"></i> --}}
                                            <span class="title">{{ __('apps::dashboard.aside.companies') }}</span>
                                        </a>
                                    </li>
                                @endpermission

                                @permission('show_delivery_charges')
                                    <li class="nav-item {{ active_menu('delivery-charges') }}">
                                        <a href="{{ url(route('dashboard.delivery-charges.index')) }}"
                                            class="nav-link nav-toggle">
                                            {{-- <i class="icon-briefcase"></i> --}}
                                            <span class="title">{{ __('apps::dashboard.aside.delivery_charges') }}</span>
                                        </a>
                                    </li>
                                @endpermission
                            @endif

                            @permission('show_drivers')
                                <li class="nav-item {{ active_menu('drivers') }}">
                                    <a href="{{ url(route('dashboard.drivers.index')) }}" class="nav-link nav-toggle">
                                        {{-- <i class="icon-briefcase"></i> --}}
                                        <span class="title">{{ __('apps::dashboard.aside.drivers') }}</span>
                                    </a>
                                </li>
                            @endpermission

                        </ul>
                    </li>
                </ul>
            @endif
        @endif

        @if (Module::isEnabled('Report'))
            @if (\Auth::user()->can([
                'show_product_sale_reports',
                'show_order_sale_reports',
                'show_vendors_reports',
                'show_product_stock_reports',
            ]))
                <ul class="page-sidebar-menu  page-header-fixed" data-keep-expanded="false" data-auto-scroll="true"
                    data-slide-speed="200">
                    <li
                        class="nav-item  {{ active_slide_menu(['product-sales-reports', 'product-stock-reports', 'vendors-reports', 'order-sales-reports']) }}">
                        <a href="javascript:;" class="nav-link nav-toggle">
                            <i class="fa fa-folder-open"></i>
                            <span class="title">{{ __('apps::dashboard.aside.tab.reports') }}</span>
                            <span class="arrow"></span>
                            <span class="selected"></span>
                        </a>
                        <ul class="sub-menu">

                            @permission('show_product_sale_reports')
                                <li class="nav-item {{ active_menu('product-sales-reports') }}">
                                    <a href="{{ url(route('dashboard.reports.product_sale')) }}"
                                        class="nav-link nav-toggle">
                                        {{-- <i class="icon-briefcase"></i> --}}
                                        <span class="title">{{ __('apps::dashboard.aside.product_sales') }}</span>
                                    </a>
                                </li>
                            @endpermission

                            @permission('show_product_stock_reports')
                                <li class="nav-item {{ active_menu('product-stock-reports') }}">
                                    <a href="{{ url(route('dashboard.reports.product_stock')) }}"
                                        class="nav-link nav-toggle">
                                        {{-- <i class="icon-briefcase"></i> --}}
                                        <span class="title">{{ __('apps::dashboard.aside.product_stock') }}</span>
                                    </a>
                                </li>
                            @endpermission

                            @permission('show_vendors_reports')
                                <li class="nav-item {{ active_menu('vendors-reports') }}">
                                    <a href="{{ url(route('dashboard.reports.vendors')) }}" class="nav-link nav-toggle">
                                        {{-- <i class="icon-briefcase"></i> --}}
                                        <span class="title">{{ __('apps::dashboard.aside.vendors_reports') }}</span>
                                    </a>
                                </li>
                            @endpermission

                            @permission('show_order_sale_reports')
                                <li class="nav-item {{ active_menu('order-sales-reports') }}">
                                    <a href="{{ url(route('dashboard.reports.order_sale')) }}"
                                        class="nav-link nav-toggle">
                                        {{-- <i class="icon-briefcase"></i> --}}
                                        <span class="title">{{ __('apps::dashboard.aside.order_sales') }}</span>
                                    </a>
                                </li>
                            @endpermission

                        </ul>
                    </li>
                </ul>
            @endif
        @endif

        @if (Module::isEnabled('Area'))
            @if (\Auth::user()->can(['show_countries', 'show_cities', 'show_states']))
                <ul class="page-sidebar-menu  page-header-fixed" data-keep-expanded="false" data-auto-scroll="true"
                    data-slide-speed="200">
                    <li class="nav-item  {{ active_slide_menu(['countries', 'cities', 'states']) }}">
                        <a href="javascript:;" class="nav-link nav-toggle">
                            <i class="fa fa-globe"></i>
                            <span class="title">{{ __('apps::dashboard.aside.tab.countries') }}</span>
                            <span class="arrow"></span>
                            <span class="selected"></span>
                        </a>
                        <ul class="sub-menu">

                            @permission('show_countries')
                                <li class="nav-item {{ active_menu('countries') }}">
                                    <a href="{{ url(route('dashboard.countries.index')) }}" class="nav-link nav-toggle">
                                        {{-- <i class="icon-briefcase"></i> --}}
                                        <span class="title">{{ __('apps::dashboard.aside.countries') }}</span>
                                    </a>
                                </li>
                            @endpermission

                            @permission('show_cities')
                                <li class="nav-item {{ active_menu('cities') }}">
                                    <a href="{{ url(route('dashboard.cities.index')) }}" class="nav-link nav-toggle">
                                        {{-- <i class="icon-briefcase"></i> --}}
                                        <span class="title">{{ __('apps::dashboard.aside.cities') }}</span>
                                    </a>
                                </li>
                            @endpermission

                            @permission('show_states')
                                <li class="nav-item {{ active_menu('states') }}">
                                    <a href="{{ url(route('dashboard.states.index')) }}" class="nav-link nav-toggle">
                                        {{-- <i class="icon-briefcase"></i> --}}
                                        <span class="title">{{ __('apps::dashboard.aside.states') }}</span>
                                    </a>
                                </li>
                            @endpermission
                        </ul>
                    </li>
                </ul>
            @endif
        @endif

        @if (\Auth::user()->can([
            'show_apphomes',
            'show_slider',
            'show_coupon',
            'show_notifications',
            'show_advertising',
        ]))
            <ul class="page-sidebar-menu  page-header-fixed" data-keep-expanded="false" data-auto-scroll="true"
                data-slide-speed="200">
                <li
                    class="nav-item  {{ active_slide_menu(['app-homes', 'slider', 'coupons', 'notifications', 'advertising-groups', 'advertising']) }}">
                    <a href="javascript:;" class="nav-link nav-toggle">
                        <i class="fa fa-gift"></i>
                        <span class="title">{{ __('apps::dashboard.aside.tab.marketing') }}</span>
                        <span class="arrow"></span>
                        <span class="selected"></span>
                    </a>
                    <ul class="sub-menu">

                        @permission('show_apphomes')
                            <li class="nav-item {{ active_menu('app-homes') }}">
                                <a href="{{ url(route('dashboard.apphomes.index')) }}" class="nav-link nav-toggle">
                                    {{-- <i class="icon-settings"></i> --}}
                                    <span class="title">{{ __('apps::dashboard.aside.apphomes') }}</span>
                                    <span class="selected"></span>
                                </a>
                            </li>
                        @endpermission

                        @permission('show_slider')
                            <li class="nav-item {{ active_menu('slider') }}">
                                <a href="{{ url(route('dashboard.slider.index')) }}" class="nav-link nav-toggle">
                                    {{-- <i class="icon-briefcase"></i> --}}
                                    <span class="title">{{ __('apps::dashboard.aside.slider') }}</span>
                                </a>
                            </li>
                        @endpermission

                        @permission('show_advertising')
                            <li class="nav-item {{ active_menu('advertising-groups') }}">
                                <a href="{{ url(route('dashboard.advertising_groups.index')) }}"
                                    class="nav-link nav-toggle">
                                    {{-- <i class="icon-briefcase"></i> --}}
                                    <span class="title">{{ __('apps::dashboard.aside.advertising_groups') }}</span>
                                </a>
                            </li>
                        @endpermission

                        @permission('show_coupon')
                            <li class="nav-item {{ active_menu('coupons') }}">
                                <a href="{{ url(route('dashboard.coupons.index')) }}" class="nav-link nav-toggle">
                                    {{-- <i class="icon-calculator"></i> --}}
                                    <span class="title">{{ __('apps::dashboard.aside.coupons') }}</span>
                                </a>
                            </li>
                        @endpermission

                        @permission('show_notifications')
                            <li class="nav-item {{ active_menu('notifications') }}">
                                <a href="{{ url(route('dashboard.notifications.index')) }}" class="nav-link nav-toggle">
                                    {{-- <i class="icon-briefcase"></i> --}}
                                    <span class="title">{{ __('apps::dashboard.aside.notifications') }}</span>
                                </a>
                            </li>
                        @endpermission
                    </ul>
                </li>
            </ul>
        @endif

        @if (\Auth::user()->can(['show_pages']) || \Auth::user()->tocaan_perm == 1)
            <ul class="page-sidebar-menu  page-header-fixed" data-keep-expanded="false" data-auto-scroll="true"
                data-slide-speed="200">
                <li class="nav-item  {{ active_slide_menu(['pages', 'themes']) }}">
                    <a href="javascript:;" class="nav-link nav-toggle">
                        <i class="icon-settings"></i>
                        <span class="title">{{ __('apps::dashboard.aside.tab.setting') }}</span>
                        <span class="arrow"></span>
                        <span class="selected"></span>
                    </a>
                    <ul class="sub-menu">

                        @if (\Auth::user()->tocaan_perm == 1)
                            <li class="nav-item {{ active_menu('themes') }}">
                                <a href="{{ url(route('developer.themes.colors.index')) }}"
                                    class="nav-link nav-toggle">
                                    {{-- <i class="icon-settings"></i> --}}
                                    <span class="title">{{ __('apps::dashboard.aside.theme_colors') }}</span>
                                    <span class="selected"></span>
                                </a>
                            </li>
                        @endif

                        @permission('show_pages')
                            <li class="nav-item {{ active_menu('pages') }}">
                                <a href="{{ url(route('dashboard.pages.index')) }}" class="nav-link nav-toggle">
                                    {{-- <i class="icon-briefcase"></i> --}}
                                    <span class="title">{{ __('apps::dashboard.aside.pages') }}</span>
                                </a>
                            </li>
                        @endpermission

                    </ul>
                </li>
            </ul>
        @endif

    </div>
</div>
