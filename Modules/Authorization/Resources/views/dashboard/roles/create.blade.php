@extends('apps::dashboard.layouts.app')
@section('title', __('authorization::dashboard.roles.routes.create'))
@section('content')
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <a href="{{ url(route('dashboard.home')) }}">{{ __('apps::dashboard.home.title') }}</a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <a href="{{ url(route('dashboard.roles.index')) }}">
                            {{ __('authorization::dashboard.roles.routes.index') }}
                        </a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <a href="#">{{ __('authorization::dashboard.roles.routes.create') }}</a>
                    </li>
                </ul>
            </div>

            <h1 class="page-title"></h1>

            <div class="row">
                <form id="form" role="form" class="form-horizontal form-row-seperated" method="post"
                    enctype="multipart/form-data" action="{{ route('dashboard.roles.store') }}">
                    @csrf
                    <div class="col-md-12">
                        <div class="col-md-3">
                            <div class="panel-group accordion scrollable" id="accordion2">
                                <div class="panel panel-default">
                                    {{-- <div class="panel-heading">
                                        <h4 class="panel-title"><a class="accordion-toggle"></a></h4>
                                    </div> --}}
                                    <div id="collapse_2_1" class="panel-collapse in">
                                        <div class="panel-body">
                                            <ul class="nav nav-pills nav-stacked">
                                                <li class="active">
                                                    <a href="#general" data-toggle="tab">
                                                        {{ __('authorization::dashboard.roles.form.tabs.general') }}
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="tab-content">
                                {{-- CREATE FORM --}}
                                <div class="tab-pane active fade in" id="general">
                                    {{--  <h3 class="page-title">{{ __('authorization::dashboard.roles.form.tabs.general') }}</h3>  --}}
                                    <div class="col-md-10">

                                        {{-- tab for lang --}}
                                        <ul class="nav nav-tabs">
                                            @foreach (config('translatable.locales') as $code)
                                                <li class="@if ($loop->first) active @endif">
                                                    <a data-toggle="tab"
                                                        href="#first_{{ $code }}">{{ __('catalog::dashboard.products.form.tabs.input_lang', ['lang' => $code]) }}</a>
                                                </li>
                                            @endforeach
                                        </ul>

                                        {{-- tab for content --}}
                                        <div class="tab-content">

                                            @foreach (config('translatable.locales') as $code)
                                                <div id="first_{{ $code }}"
                                                    class="tab-pane fade @if ($loop->first) in active @endif">

                                                    <div class="form-group">
                                                        <label class="col-md-2">
                                                            {{ __('authorization::dashboard.roles.form.key') }}
                                                            - {{ $code }}
                                                        </label>
                                                        <div class="col-md-9">
                                                            <input type="text" name="display_name[{{ $code }}]"
                                                                placeholder="users" class="form-control"
                                                                data-name="display_name.{{ $code }}">
                                                            <div class="help-block"></div>
                                                        </div>
                                                    </div>

                                                    {{-- <div class="form-group">
                                                        <label class="col-md-2">
                                                            {{__('authorization::dashboard.roles.form.description')}}
                                                            - {{ $code }}
                                                        </label>
                                                        <div class="col-md-9">
                                                            <textarea name="description[{{$code}}]" rows="8" cols="80"
                                                                      class="form-control"
                                                                      data-name="description.{{$code}}"></textarea>
                                                            <div class="help-block"></div>
                                                        </div>
                                                    </div> --}}

                                                </div>
                                            @endforeach

                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{ __('authorization::dashboard.roles.form.permissions') }}
                                            </label>
                                            <div class="col-md-9">
                                                <div class="mt-checkbox-list">
                                                    <ul>
                                                        @foreach ($permissions->groupBy('display_name') as $key => $perm)
                                                            <li style="list-style-type:none">
                                                                <label class="mt-checkbox">
                                                                    <input type="checkbox" class="permission-group">
                                                                    <strong>{{ title_case(str_replace('_', ' ', $key)) }}</strong>
                                                                    <span></span>
                                                                </label>
                                                                <ul class="row" style="list-style-type:none">
                                                                    @foreach ($perm as $permission)
                                                                        <li style="list-style-type:none">
                                                                            <label class="mt-checkbox col-md-3">
                                                                                <input class="child" type="checkbox"
                                                                                    name="permission[]"
                                                                                    value="{{ $permission->id }}">
                                                                                {{ $permission->description }}
                                                                                <span></span>
                                                                            </label>
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            </li>
                                                            <br>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                                <div class="help-block"></div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                {{-- END CREATE FORM --}}
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-actions">
                                @include('apps::dashboard.layouts._ajax-msg')
                                <div class="form-group">
                                    <button type="submit" id="submit" class="btn btn-lg blue">
                                        {{ __('apps::dashboard.general.add_btn') }}
                                    </button>
                                    <a href="{{ url(route('dashboard.roles.index')) }}" class="btn btn-lg red">
                                        {{ __('apps::dashboard.general.back_btn') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('scripts')
    <script>
        $(document).ready(
            function() {
                $(".permission-group").click(function() {
                    $(this).parents('li').find('.child').prop('checked', this.checked);
                });
            }
        );
    </script>
@stop
