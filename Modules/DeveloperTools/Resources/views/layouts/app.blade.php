<!DOCTYPE html>
<html lang="{{ locale() }}" dir="{{ is_rtl() }}">

    @if (is_rtl() == 'rtl')
      @include('developertools::layouts._head_rtl')
    @else
      @include('developertools::layouts._head_ltr')
    @endif

    <body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white page-md">
        <div class="page-wrapper">

            @include('developertools::layouts._header')

            <div class="clearfix"> </div>

            <div class="page-container">
                @include('developertools::layouts._aside')

                @yield('content')
            </div>

            @include('developertools::layouts._footer')
        </div>

        @include('developertools::layouts._jquery')
        @include('developertools::layouts._js')
    </body>
</html>
