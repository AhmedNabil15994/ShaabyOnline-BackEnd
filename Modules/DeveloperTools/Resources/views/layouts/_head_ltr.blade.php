<head>
    <meta charset="utf-8"/>
    <title>@yield('title', '--') || {{ config('app.name') }}</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport"/>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>

    <link href="https://fonts.googleapis.com/css?family=Cairo" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/emojionearea/3.4.1/emojionearea.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/themes/default/style.min.css"/>
    <link rel="stylesheet" href="/admin/assets/global/css/jquery-ui.min.css">
    <link href="/admin/assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
    <link href="/admin/assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet"ue
          type="text/css"/>
    <link href="/admin/assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="/admin/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet"
          type="text/css"/>
    <link href="/admin/assets/global/plugins/cubeportfolio/css/cubeportfolio.css" rel="stylesheet" type="text/css"/>
    <link href="/admin/assets/global/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css"/>
    <link href="/admin/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet"
          type="text/css"/>
    <link rel="stylesheet"
          href="{{url('admin/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css')}}">
    <link rel="stylesheet"
          href="{{url('admin/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css')}}">
    <link rel="stylesheet"
          href="{{url('admin/assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')}}">
    <link rel="stylesheet"
          href="{{url('admin/assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css')}}">
    <link href="{{ url('admin/assets/global/plugins/jquery-nestable/jquery.nestable.css') }}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ url('admin/assets/global/plugins/grapick/grapick.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('admin/assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('admin/assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet"
          type="text/css"/>
    <link rel="stylesheet" href="{{url('admin/assets/pages/css/invoice.min.css')}}">
    <link href="/admin/assets/global/plugins/morris/morris.css" rel="stylesheet" type="text/css"/>
    <link href="/admin/assets/global/plugins/fullcalendar/fullcalendar.min.css" rel="stylesheet" type="text/css"/>
    <link href="/admin/assets/global/plugins/jqvmap/jqvmap/jqvmap.css" rel="stylesheet" type="text/css"/>
    <link href="/admin/assets/global/css/components-md.min.css" rel="stylesheet" id="style_components" type="text/css"/>
    <link href="/admin/assets/pages/css/portfolio.min.css" rel="stylesheet" type="text/css"/>
    <link href="/admin/assets/global/css/plugins-md.min.css" rel="stylesheet" type="text/css"/>
    <link href="/admin/assets/layouts/layout/css/layout.min.css" rel="stylesheet" type="text/css"/>
    <link href="/admin/assets/layouts/layout/css/themes/darkblue.min.css" rel="stylesheet" type="text/css"
          id="style_color"/>
    <link href="/admin/assets/global/plugins/bootstrap-colorpicker/css/colorpicker.css" rel="stylesheet" type="text/css" />
    <link href="/admin/assets/global/plugins/jquery-minicolors/jquery.minicolors.css" rel="stylesheet" type="text/css">
    <link href="/admin/assets/layouts/layout/css/custom.min.css" rel="stylesheet" type="text/css"/>
    <link href="{{asset('SewidanField/plugins/ck-editor-5/css/ckeditor.css')}}" rel="stylesheet" id="style_components" type="text/css" />
    <link href="/admin/assets/css/main.css" rel="stylesheet" type="text/css"/>

    <link rel="shortcut icon" href="{{url(config('setting.favicon'))}}"/>

    <style>
        .panel-heading{
            display: none;
        }

        .table-striped{
            width: 100% !important;
        }
    </style>

    @include('apps::dashboard.layouts._header_style')

    @yield('css')

</head>
