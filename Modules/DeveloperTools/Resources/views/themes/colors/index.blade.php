@extends('apps::dashboard.layouts.app')
@section('title', __('developertools::developer.home.title'))
@section('css')
    <style>
        .mt-element-list .list-simple.group .list-toggle-container .list-toggle {
            padding: 6px;
            text-align: left;
            overflow: hidden;
            white-space: nowrap;
            border: 1px solid #9e9e9e;
        }

        .mt-element-list .list-simple.mt-list-container {
            border-bottom: none;
            margin-bottom: 12px;
        }
    </style>
@stop
@section('content')

    <div class="page-content-wrapper">

        <div class="page-content">
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <a href="{{ route('dashboard.home') }}">{{ __('apps::dashboard.home.title') }}</a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <a href="#">Themes Colors</a>
                    </li>
                </ul>
            </div>

            <div class="row">
                <form id="updateForm" page="form" class="form-horizontal form-row-seperated" method="post"
                    enctype="multipart/form-data" action="{{ route('developer.themes.colors.update') }}">
                    @csrf
                    @method('PUT')
                    <div class="col-md-12">

                        {{-- RIGHT SIDE --}}
                        <div class="col-md-3">
                            <div class="panel-group accordion scrollable" id="accordion2">
                                <div class="panel panel-default">

                                    <div id="collapse_2_1" class="panel-collapse in">
                                        <div class="panel-body">
                                            <ul class="nav nav-pills nav-stacked">

                                                @foreach ($color_sections as $section)
                                                    <li class="{{ $loop->index == 0 ? 'active' : '' }}">
                                                        <a href="#{{ str_replace(' ', '_', $section['title']) }}"
                                                            data-toggle="tab">
                                                            {{ $section['title'] }}
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        {{-- PAGE CONTENT --}}
                        <div class="col-md-9">
                            <div class="tab-content">

                                {{-- CREATE FORM --}}
                                @foreach ($color_sections as $section)
                                    <div class="tab-pane {{ $loop->index == 0 ? 'active' : '' }} fade in"
                                        id="{{ str_replace(' ', '_', $section['title']) }}">

                                        <div class="row">

                                            @foreach ($section['content'] as $content)
                                                <div class="col-lg-6 col-md-12">
                                                    <div class="portlet light portlet-fit bordered">
                                                        <div class="portlet-title" style="border-bottom: none">
                                                            <div class="caption">
                                                                <span>{{ $content['title'] }}</span>
                                                            </div>
                                                            @if (array_key_exists('key', $content))
                                                                {!! field()->checkBox('theme_sections[' . $content['key'] . ']', '', null, [
                                                                    isset(Setting::get('theme_sections')[$content['key']]) && Setting::get('theme_sections')[$content['key']]
                                                                        ? 'checked'
                                                                        : '' => '',
                                                                ]) !!}
                                                            @endif
                                                        </div>
                                                        <div class="portlet-body">
                                                            <div class="mt-element-list">
                                                                @foreach ($content['colors'] as $color)
                                                                    <div class="mt-list-container list-simple ext-1 group row"
                                                                        style="border: none">
                                                                        <div class="list-todo-icon bg-white col-lg-3">
                                                                            <i class="fa">{{ $color['title'] }}</i>
                                                                        </div>
                                                                        <div class="col-lg-9">
                                                                            @if (isset($color['input_type']))
                                                                                @if ($color['input_type'] == 'color')
                                                                                    <input type="text"
                                                                                        name="{{ $color['var_name'] }}"
                                                                                        class="form-control demo"
                                                                                        data-control="hue"
                                                                                        value="{{ isset($colors_values[$color['var_name']]) ? $colors_values[$color['var_name']] : '0' }}">
                                                                                @else
                                                                                    <div class="form-group">
                                                                                        <input
                                                                                            type="{{ $color['input_type'] }}"
                                                                                            name="{{ $color['var_name'] }}"
                                                                                            class="form-control"
                                                                                            value="{{ isset($colors_values[$color['var_name']]) ? $colors_values[$color['var_name']] : '0' }}">
                                                                                    </div>
                                                                                @endif
                                                                            @else
                                                                                <a class="list-toggle-container"
                                                                                    data-toggle="collapse"
                                                                                    onclick="openColorModal(this,'{{ isset($colors_values[$color['var_name']]) ? $colors_values[$color['var_name']] : '#e8e5ef00' }}')"
                                                                                    aria-expanded="false">
                                                                                    <input type="hidden"
                                                                                        name="{{ $color['var_name'] }}"
                                                                                        class="color_input"
                                                                                        value="{{ isset($colors_values[$color['var_name']]) ? $colors_values[$color['var_name']] : '0' }}">
                                                                                    <div class="list-toggle uppercase color_view"
                                                                                        style="background: {{ isset($colors_values[$color['var_name']]) ? $colors_values[$color['var_name']] : '#e8e5ef00' }}">
                                                                                        {{ isset($colors_values[$color['var_name']]) ? $colors_values[$color['var_name']] : '#e8e5ef00' }}
                                                                                    </div>
                                                                                </a>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @if ($loop->index % 2 && $loop->index != 0)
                                                    <div class="clearfix"></div>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                                {{-- END CREATE FORM --}}
                            </div>
                        </div>

                        {{-- PAGE ACTION --}}
                        <div class="col-md-12">
                            <div class="form-actions">
                                @include('apps::dashboard.layouts._ajax-msg')
                                <div class="form-group">
                                    <button type="submit" id="submit" class="btn btn-lg blue">
                                        {{ __('apps::dashboard.general.add_btn') }}
                                    </button>

                                </div>
                            </div>
                        </div>

                    </div>
                </form>
            </div>

            {{-- <form id="updateForm" page="form" class="form-horizontal form-row-seperated" method="post" --}}
            {{-- enctype="multipart/form-data" action="{{route('developer.themes.colors.update')}}"> --}}
            {{-- @csrf --}}
            {{-- @method('PUT') --}}
            {{-- @foreach ($color_sections as $section) --}}
            {{-- <div class="caption"> --}}
            {{-- <i class=" icon-layers font-green"></i> --}}
            {{-- <span class="caption-subject font-green bold uppercase">{{$section['title']}}</span> --}}
            {{-- </div> --}}
            {{-- <div class="row"> --}}

            {{-- @foreach ($section['content'] as $content) --}}
            {{-- <div class="col-lg-6 col-md-12"> --}}
            {{-- <div class="portlet light portlet-fit bordered"> --}}
            {{-- <div class="portlet-title"> --}}
            {{-- <div class="caption"> --}}
            {{-- <span class="caption-subject font-green bold uppercase">{{$content['title']}}</span> --}}
            {{-- </div> --}}
            {{-- </div> --}}
            {{-- <div class="portlet-body"> --}}
            {{-- <div class="mt-element-list"> --}}
            {{-- @foreach ($content['colors'] as $color) --}}
            {{-- <div class="mt-list-container list-simple ext-1 group row"> --}}
            {{-- <div class="list-todo-icon bg-white col-lg-3"> --}}
            {{-- <i class="fa">{{$color['title']}}</i> --}}
            {{-- </div> --}}
            {{-- <div class="col-lg-9"> --}}
            {{-- @if (isset($color['input_type']) && $color['input_type'] != 'color') --}}
            {{-- <div class="form-group"> --}}
            {{-- <input --}}
            {{-- type="{{$color['input_type']}}" --}}
            {{-- name="{{$color['var_name']}}" --}}
            {{-- class="form-control" --}}
            {{-- value="{{$colors_values[$color['var_name']]}}" --}}
            {{-- > --}}
            {{-- </div> --}}
            {{-- @else --}}
            {{-- <a class="list-toggle-container" data-toggle="collapse" --}}
            {{-- onclick="openColorModal(this,'{{$colors_values[$color['var_name']]}}')" --}}
            {{-- aria-expanded="false"> --}}
            {{-- <input type="hidden" --}}
            {{-- name="{{$color['var_name']}}" --}}
            {{-- class="color_input"> --}}
            {{-- <div class="list-toggle uppercase color_view" --}}
            {{-- style="background: {{$colors_values[$color['var_name']]}}"> --}}
            {{-- {{$colors_values[$color['var_name']]}} --}}
            {{-- </div> --}}
            {{-- </a> --}}
            {{-- @endif --}}
            {{-- </div> --}}
            {{-- </div> --}}
            {{-- @endforeach --}}
            {{-- </div> --}}
            {{-- </div> --}}
            {{-- </div> --}}
            {{-- </div> --}}
            {{-- @if ($loop->index % 2 && $loop->index != 0) --}}
            {{-- <div class="clearfix"></div> --}}
            {{-- @endif --}}
            {{-- @endforeach --}}
            {{-- </div> --}}

            {{-- @endforeach --}}

            {{-- <div class="form-actions"> --}}
            {{-- @include('apps::dashboard.layouts._ajax-msg') --}}
            {{-- <div class="form-group"> --}}
            {{-- <button type="submit" id="submit" class="btn btn-lg blue"> --}}
            {{-- {{__('apps::dashboard.general.add_btn')}} --}}
            {{-- </button> --}}

            {{-- </div> --}}
            {{-- </div> --}}
            {{-- </form> --}}
        </div>
    </div>
    <div class="modal fade bs-modal-sm" id="color_modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <div id="view_color" class="text-center" style="padding: 27px;">
                        <h4 id="view_color_h" style="color: white"></h4>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="row">

                        <div class="col-lg-12">
                            <div class="form-group">
                                <div id="grapick"></div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <select class="form-control" id="switch-type">
                                    <option value="">- Select Type -</option>
                                    <option value="radial">Radial</option>
                                    <option value="linear">Linear</option>
                                    <option value="repeating-radial">Repeating Radial</option>
                                    <option value="repeating-linear">Repeating Linear</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <select class="form-control" id="switch-angle">
                                    <option value="">- Select Direction -</option>
                                    <option value="top">Top</option>
                                    <option value="right">Right</option>
                                    <option value="center">Center</option>
                                    <option value="bottom">Bottom</option>
                                    <option value="left">Left</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                    <button type="button" class="btn green" id="save_color_btn">Save changes</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
@stop

@push('scripts')
    {{-- Grapick scripts generator --}}
    <script type="text/javascript">
        var upType, unAngle, gp;
        var swType = document.getElementById('switch-type');
        var swAngle = document.getElementById('switch-angle');

        swType.addEventListener('change', function(e) {
            gp && gp.setType(this.value || 'linear');
        });

        swAngle.addEventListener('change', function(e) {
            gp && gp.setDirection(this.value || 'right');
        });

        var createGrapick = function() {
            gp = new Grapick({
                el: '#grapick',
                direction: 'right',
                min: 1,
                max: 99,
            });
            gp.addHandler(1, '#085078', 1);
            gp.addHandler(99, '#85D8CE', 1, {
                keepSelect: 1
            });

            $('#view_color').css('background', 'red');
            $('#view_color_h').text('').append('red');

            gp.on('change', function(complete) {
                const value = gp.getValue();
                $('#view_color').css('background', value);
                $('#view_color_h').text('').append(value);
            });
        };

        var destroyGrapick = function() {
            gp.destroy();
            gp = 0;
        };

        createGrapick();
    </script>
    {{-- *************************************** --}}


    {{-- modal and inputs handler scripts --}}
    <script type="text/javascript">
        var element = null;

        function openColorModal(el, color) {
            element = el;
            var item = $(el);
            $('#view_color').css('background', color);
            $('#view_color_h').text('').append(color);
            $('#save_color_btn').attr('onclick', 'saveColor()');
            $('#color_modal').modal('show');

        }

        function saveColor() {
            const value = gp.getValue();
            var item = $(element);
            var input = item.find('.color_input');
            var color_view = item.find('.color_view');
            color_view.css('background', value);
            color_view.text('').append(value);
            input.val(value);
            $('#color_modal').modal('hide');
        }
    </script>
    {{-- *************************************** --}}
@endpush
