<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', '--') || {{ config('app.name') }} </title>
    <meta name="description" content="@yield('meta_description', '')">
    <meta name="keywords" content="@yield('meta_keywords', '')">
    <meta name="author" content="{{ config('setting.app_name.' . locale()) ?? '' }}">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <!-- Font Icons -->
    <link rel="stylesheet" href="{{ url('frontend/css/font-awesome.css') }}">
    <link rel="stylesheet" href="{{ url('frontend/css/themify-icons.css') }}">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{ url('frontend/css/bootstrap.min.css') }}">
    <!-- Animation -->
    <link rel="stylesheet" href="{{ url('frontend/css/animate.min.css') }}">
    <!-- Owl Carousel -->
    <link rel="stylesheet" href="{{ url('frontend/css/owl.carousel.min.css') }}">
    <!-- Smooth Product -->
    <link rel="stylesheet" href="{{ url('frontend/css/select2.min.css') }}" type="text/css">
    <!-- Select 2 -->
    <link rel="stylesheet" href="{{ url('frontend/css/smoothproducts.css') }}" type="text/css">

    <link href="{{ url('frontend/plugins/live-search/jquery.autocomplete.css') }}" rel="stylesheet"
        id="style_components" type="text/css" />

    {{-- Start - Bind Css Code From Dashboard Daynamic --}}
    {!! config('setting.custom_codes.css_in_head') ?? null !!}
    {{-- End - Bind Css Code From Dashboard Daynamic --}}

    <link rel="stylesheet" href="{{ asset('frontend/css/vars.css') }}">

    @if (locale() == 'ar')
        <link rel="stylesheet" href="{{ url('frontend/css/style-ar.css') }}">
    @else
        <link rel="stylesheet" href="{{ url('frontend/css/style-en.css') }}">
    @endif
    <link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}">

    <link rel="icon"
        href="{{ config('setting.images.favicon') ? url(config('setting.images.favicon')) : url('frontend/favicon.png') }}" />

    <style>
        /* start loader style */

        #loaderDiv,
        #headerLoaderDiv {
            display: none;
            margin: 15px auto;
            justify-content: center;
        }

        .generalLoaderDiv {
            display: none;
            margin: 15px 100px;
            justify-content: center;
        }

        #loaderCouponDiv {
            display: none;
            margin: 15px 100px;
            justify-content: center;
        }

        #loaderDiv .my-loader,
        #headerLoaderDiv .my-loader,
        .generalLoaderDiv .my-loader,
        #loaderCouponDiv .my-loader {
            border: 10px solid #f3f3f3;
            border-radius: 50%;
            border-top: 10px solid #3498db;
            width: 70px;
            height: 70px;
            -webkit-animation: spin 2s linear infinite;
            /* Safari */
            animation: spin 2s linear infinite;
        }

        /* Safari */
        @-webkit-keyframes spin {
            0% {
                -webkit-transform: rotate(0deg);
            }

            100% {
                -webkit-transform: rotate(360deg);
            }
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* end loader style */

        .empty-cart-title {
            text-align: center;
        }

        .label-tag-product {
            position: relative;
            color: #fff;
            margin: 10px;
            border-radius: 20px;
            padding: 2px 15px;
            font-size: 12px;
        }

        .percentage-discount {
            color: red;
        }

        figure img {
            max-width: 100%;
        }
    </style>

    <style type="text/css" media="print">
        @page {
            size: auto;
            margin: 0;
        }

        @media print {
            a[href]:after {
                content: none !important;
            }

            .contentPrint {
                width: 100%;
                /* font-family: tahoma; */
                font-size: 16px;
            }

            .invoice-body td.notbold {
                padding: 2px;
            }

            h2.invoice-title.uppercase {
                margin-top: 0px;
            }

            .invoice-content-2 {
                background-color: #fff;
                padding: 5px 20px;
            }

            .invoice-content-2 .invoice-cust-add,
            .invoice-content-2 .invoice-head {
                margin-bottom: 0px;
            }

            .no-print,
            .no-print * {
                display: none !important;
            }
        }
    </style>

    @yield('externalStyle')

    {{-- Start - Bind Js Code From Dashboard Daynamic --}}
    {!! config('setting.custom_codes.js_before_head') ?? null !!}
    {{-- End - Bind Js Code From Dashboard Daynamic --}}

</head>
