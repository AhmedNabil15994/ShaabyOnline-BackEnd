<!DOCTYPE html>
<html lang="{{ locale() }}" dir="{{ is_rtl() }}">

    @if (is_rtl() == 'rtl')
      @include('apps::dashboard.layouts._head_rtl')
    @else
      @include('apps::dashboard.layouts._head_ltr')
    @endif

    <body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white page-md">
        <div class="page-wrapper">

            @include('apps::dashboard.layouts._header')

            <div class="clearfix"> </div>

            <div class="page-container">
                @include('apps::dashboard.layouts._aside')

                @yield('content')
            </div>

            @include('apps::dashboard.layouts._footer')
        </div>

        @include('apps::dashboard.layouts._jquery')
        @include('apps::dashboard.layouts._js')
        @include('apps::shared._general-js')
    </body>
</html>
