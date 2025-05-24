<!DOCTYPE html>
<html dir="{{ locale() == 'ar' ? 'rtl' : 'ltr' }}" lang="{{ locale() == 'ar' ? 'ar' : 'en' }}">

@include('apps::frontend.layouts._header')

<body>
    <div class="main-content">

        @include(
            'apps::frontend.layouts.header-section',
            compact('pages', 'aboutUs', 'headerCategories')
        )

        <div class="site-main">
            @yield('content')
        </div>

        @include('apps::frontend.layouts.footer-section', compact('pages', 'aboutUs'))

    </div>

    {{-- <a href="https://wa.me/{{ config('setting.contact_us.whatsapp') }}" data-toggle="tooltip" data-placement="top"
   title="{{ __('apps::frontend.contact_us.info.technical_support')}}" target="_blank"
   class="whatsapp-chat no-print">
    <img src="{{ url('frontend/images/whatsapp.png') }}" alt=""/>
</a> --}}

    <a href="https://wa.me/{{ config('setting.contact_us.whatsapp') }}" class="whatsapp-chat no-print"
        data-toggle="tooltip" data-placement="top" target="_blank" style="z-index: 999"
        title="{{ __('apps::frontend.contact_us.info.technical_support') }}" target="_blank">
        <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
        <lottie-player src="https://assets2.lottiefiles.com/private_files/lf30_vfaddvqs.json" background="transparent"
            speed="1" style="width: 120px; height: 120px;" loop autoplay></lottie-player>
    </a>

    @include('apps::frontend.layouts.scripts')

</body>

</html>
