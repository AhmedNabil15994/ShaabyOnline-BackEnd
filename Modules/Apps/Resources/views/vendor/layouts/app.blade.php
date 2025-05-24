<!DOCTYPE html>
<html lang="{{ locale() }}" dir="{{ is_rtl() }}">

    @if (is_rtl() == 'rtl')
      @include('apps::vendor.layouts._head_rtl')
    @else
      @include('apps::vendor.layouts._head_ltr')
    @endif

    <body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white page-md">
        <div class="page-wrapper">

            @include('apps::vendor.layouts._header')

            <div class="clearfix"> </div>

            <div class="page-container">
                @include('apps::vendor.layouts._aside')

                @yield('content')
            </div>

            @include('apps::vendor.layouts._footer')
        </div>

        @include('apps::vendor.layouts._jquery')
        @include('apps::vendor.layouts._js')
        @include('apps::shared._general-js')
    </body>
</html>
