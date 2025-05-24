<div class="page-sidebar-wrapper">
    <div class="page-sidebar navbar-collapse collapse">
        <ul class="page-sidebar-menu  page-header-fixed" data-keep-expanded="false" data-auto-scroll="true"
            data-slide-speed="200" style="padding-top: 20px">
            <li class="sidebar-toggler-wrapper hide">
                <div class="sidebar-toggler">
                    <span></span>
                </div>
            </li>

            <li class="nav-item {{ active_menu('home') }}">
                <a href="{{ url(route('driver.home')) }}" class="nav-link nav-toggle">
                    <i class="icon-home"></i>
                    <span class="title">{{ __('apps::driver.home.title') }}</span>
                    <span class="selected"></span>
                </a>
            </li>


            @if (Module::isEnabled('Order'))
                <li class="heading">
                    <h3 class="uppercase">{{ __('apps::driver.aside.tab.orders') }}</h3>
                </li>

                @permission('show_orders')
                    <li class="nav-item {{ active_menu('orders') }}">
                        <a href="{{ url(route('driver.orders.index')) }}" class="nav-link nav-toggle">
                            <i class="fa fa-shopping-cart"></i>
                            <span class="title">{{ __('apps::driver.aside.orders') }}</span>
                        </a>
                    </li>
                @endpermission
            @endif


        </ul>
    </div>
</div>
