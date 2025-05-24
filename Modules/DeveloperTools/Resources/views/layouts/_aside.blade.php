<div class="page-sidebar-wrapper">
    <div class="page-sidebar navbar-collapse collapse">
        <ul class="page-sidebar-menu  page-header-fixed" data-keep-expanded="false" data-auto-scroll="true"
            data-slide-speed="200" style="padding-top: 20px">
            <li class="sidebar-toggler-wrapper hide">
                <div class="sidebar-toggler">
                    <span></span>
                </div>
            </li>

            <li class="nav-item {{ active_menu(['home', '']) }}">
                <a href="{{ url(route('developer.home')) }}" class="nav-link nav-toggle">
                    <i class="icon-home"></i>
                    <span class="title">{{ __('developertools::developer.home.title') }}</span>
                    <span class="selected"></span>
                </a>
            </li>
            <li class="nav-item {{ active_menu('colors') }}">
                <a href="{{ url(route('developer.themes.colors.index')) }}" class="nav-link nav-toggle">
                    <i class="icon-settings"></i>
                    <span class="title">{{ __('developertools::developer.aside.colors') }}</span>
                </a>
            </li>
        </ul>
    </div>
</div>
