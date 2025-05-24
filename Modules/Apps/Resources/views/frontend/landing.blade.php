<!DOCTYPE html>
<html dir="{{ locale() == 'ar' ? 'rtl' : 'ltr' }}" lang="{{ locale() == 'ar' ? 'ar' : 'en' }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('setting.app_name.' . locale()) }}</title>
    <meta name="description" content="">
    <link rel="stylesheet" href="{{ url('frontend/landing/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ url('frontend/landing/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ url('frontend/landing/css/owl.carousel.min.css') }}">
    @if (locale() == 'ar')
        <link rel="stylesheet" href="{{ url('frontend/landing/css/style-ar.css') }}">
    @else
        <link rel="stylesheet" href="{{ url('frontend/landing/css/style-en.css') }}">
    @endif
    <link rel="icon"
        href="{{ config('setting.images.favicon') ? url(config('setting.images.favicon')) : url('frontend/favicon.png') }}" />
</head>

<body>
    <div class="page-content"
        style="background: url({{ config('setting.images.landing_background') ?? url('frontend/landing/images/bg.png') }}); background-size: cover; background-repeat: no-repeat;">
        <ul class="animate-particle">
            <li><img src="{{ url('frontend/landing/images/ta1.png') }}" alt="images"></li>
            <li><img src="{{ url('frontend/landing/images/ta4.png') }}" alt="images"></li>
            <li><img src="{{ url('frontend/landing/images/ta2.png') }}" alt="images"></li>
            <li><img src="{{ url('frontend/landing/images/ta3.png') }}" alt="images"></li>
            <li><img src="{{ url('frontend/landing/images/ta2.png') }}" alt="images"></li>
            <li><img src="{{ url('frontend/landing/images/ta1.png') }}" alt="images"></li>
            <li><img src="{{ url('frontend/landing/images/cm1.png') }}" alt="images"></li>
            <li><img src="{{ url('frontend/landing/images/circle.png') }}" alt="images"></li>
            <li class="bubble"></li>
        </ul>
        <div class="container position-relative">
            @foreach (config('laravellocalization.supportedLocales') as $localeCode => $properties)
                @if ($localeCode != locale())
                    <a hreflang="{{ $localeCode }}"
                        href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}"
                        class="lang"><i class="fas fa-globe-americas"></i> {{ $properties['native'] }} </a>
                @endif
            @endforeach
            <a class="logo d-block text-center" href="{{ route('frontend.home') }}"><img class="img-fluid"
                    src="{{ config('setting.images.logo') ? url(config('setting.images.logo')) : url('frontend/images/header-logo.png') }}"
                    alt="" /></a>
            @if (config('setting.app_name.' . locale()))
                <div class="row">
                    <div class="col-md-7 text-center">
                        <h1>{{ config('setting.app_name.' . locale()) }}</h1>
                    </div>
                </div>
            @endif

            <div class="row app-content">
                <div class="col-md-7">
                    <div class="app-description text-center">
                        @if (config('setting.app_description.' . locale()))
                            <p>
                                {!! config('setting.app_description.' . locale()) !!}
                            </p>
                        @endif

                        @if (config('setting.about_app.android_download_url') || config('setting.about_app.ios_download_url'))
                            <div class="app-download">
                                <h2>{{ __('apps::frontend.download.title') }}</h2>
                                <div class=" d-flex justify-content-center">

                                    @if (config('setting.about_app.android_download_url'))
                                        <a class="d-flex align-items-center download-btn"
                                            href="{{ config('setting.about_app.android_download_url') ?? '#' }}">
                                            <i class="fab fa-apple"></i>
                                            <div>
                                                <p>{{ __('apps::frontend.download.available_on_the') }}</p>
                                                <h6>{{ __('apps::frontend.download.app_store') }}</h6>
                                            </div>
                                        </a>
                                    @endif

                                    @if (config('setting.about_app.ios_download_url'))
                                        <a class="d-flex align-items-center download-btn"
                                            href="{{ config('setting.about_app.ios_download_url') ?? '#' }}">
                                            <i class="fab fa-google-play"></i>
                                            <div>
                                                <p>{{ __('apps::frontend.download.get_it_on') }}</p>
                                                <h6>{{ __('apps::frontend.download.google_play') }}</h6>
                                            </div>
                                        </a>
                                    @endif

                                </div>
                            </div>
                        @endif

                        <div class="d-flex align-items-center justify-content-center share-buttons">
                            @if (config('setting.social.facebook'))
                                <a class="facebook" href="{{ config('setting.social.facebook') ?? '#' }}">
                                    <span class="fab fa-facebook-f"></span>
                                </a>
                            @endif

                            @if (config('setting.social.twitter'))
                                <a class="twitter" href="{{ config('setting.social.twitter') ?? '#' }}">
                                    <span class="fab fa-twitter"></span>
                                </a>
                            @endif

                            @if (config('setting.social.instagram'))
                                <a class="rounded-circle instagram"
                                    href="{{ config('setting.social.instagram') ?? '#' }}">
                                    <span class="fab fa-instagram"></span>
                                </a>
                            @endif

                            @if (config('setting.social.snapchat'))
                                <a class="rounded-circle snapchat"
                                    href="{{ config('setting.social.snapchat') ?? '#' }}">
                                    <span class="fab fa-snapchat-ghost"></span>
                                </a>
                            @endif

                        </div>
                    </div>
                </div>
                <div class="col-md-5 position-relative">
                    @if (!empty(config('setting.app_gallery')))
                        <div class="app-screens">
                            
                            <div class="screens owl-carousel">
                                @foreach (config('setting.app_gallery') as $image)
                                    <div class="item">
                                        <img class="img-fluid"
                                            src="{{ url(config('core.config.app_gallery_img_path') . '/' . $image) }}"
                                            alt="app image" />
                                    </div>
                                @endforeach
                            </div>

                            {{-- <div class="screens owl-carousel">
                                <div class="item">
                                    <img class="img-fluid" src="{{ url('frontend/landing/images/screen/5.png') }}"
                                        alt="" />
                                </div>
                                <div class="item">
                                    <img class="img-fluid" src="{{ url('frontend/landing/images/screen/6.png') }}"
                                        alt="" />
                                </div>
                                <div class="item">
                                    <img class="img-fluid" src="{{ url('frontend/landing/images/screen/7.png') }}"
                                        alt="" />
                                </div>
                            </div> --}}

                        </div>
                    @endif
                </div>
            </div>
        </div>
        {{-- <div class="phone-call cbh-phone cbh-green cbh-show  cbh-static" id="clbh_phone_div">
            <a target="_blank" id="WhatsApp-button"
                href="https://wa.me/{{ config('setting.contact_us.whatsapp') }}?text={{ __('apps::frontend.general.how_can_we_help') }}"
                class="phoneJs" title="Tocaan!">
                <div class="cbh-ph-circle"></div>
                <div class="cbh-ph-circle-fill"></div>
                <div class="cbh-ph-img-circle1"></div>
            </a>
        </div> --}}
        <a href="https://wa.me/{{ config('setting.contact_us.whatsapp') }}?text={{ __('apps::frontend.general.how_can_we_help') }}"
            target="_blank">
            <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
            <lottie-player src="https://assets2.lottiefiles.com/private_files/lf30_vfaddvqs.json"
                background="transparent" speed="1"
                style="width: 120px; height: 120px; position: fixed; bottom:10px; right:10px; z-index: 99" loop
                autoplay></lottie-player>

        </a>
    </div>

    <script src="{{ url('frontend/landing/js/jquery.min.js') }}"></script>
    <script src="{{ url('frontend/landing/js/bootstrap.min.js') }}"></script>
    <script src="{{ url('frontend/landing/js/owl.carousel.min.js') }}"></script>
    <script>
        $('.screens').owlCarousel({
            responsiveClass: true,
            nav: false,
            dots: true,
            items: 1,
            smartSpeed: 10000,
            dotsSpeed: 1000,
            dragEndSpeed: 1000,
            singleItem: true,
            animateIn: 'fadeIn',
            animateOut: 'fadeOut',
            pagination: false,
            autoplay: true,
            autoplayTimeout: 5000,
            loop: true,
            @if (locale() == 'ar')
                rtl: true
            @endif
        });
    </script>
</body>

</html>
