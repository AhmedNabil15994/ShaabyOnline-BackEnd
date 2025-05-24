@extends('apps::dashboard.layouts.app')
@section('title', __('tags::dashboard.tags.routes.create'))
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
                        <a href="{{ url(route('dashboard.tags.index')) }}">
                            {{__('tags::dashboard.tags.routes.index')}}
                        </a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <a href="#">{{__('tags::dashboard.tags.routes.create')}}</a>
                    </li>
                </ul>
            </div>

            <h1 class="page-title"></h1>

            <div class="row">
                <form id="form" role="form" class="form-horizontal form-row-seperated" method="post"
                      enctype="multipart/form-data" action="{{route('dashboard.tags.store')}}">
                    @csrf
                    <div class="col-md-12">

                        {{-- RIGHT SIDE --}}
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
                                                    <a href="#global_setting" data-toggle="tab">
                                                        {{ __('tags::dashboard.tags.form.tabs.general') }}
                                                    </a>
                                                </li>
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

                                <div class="tab-pane active fade in" id="global_setting">
                                    {{--                                    <h3 class="page-title">{{__('tags::dashboard.tags.form.tabs.general')}}</h3>--}}

                                    <ul class="nav nav-pills">
                                        @foreach (config('translatable.locales') as $k => $code)
                                            <li class="{{ $code == locale() ? 'active' : '' }}">
                                                <a id="{{$k}}-general-tab" data-toggle="tab"
                                                   aria-controls="general-tab-{{$k}}" href="#general-tab-{{$k}}"
                                                   aria-expanded="{{ $code == locale() ? 'true' : 'false' }}">{{ $code }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <div class="tab-content px-1 pt-1">

                                        @foreach (config('translatable.locales') as $k => $code)
                                            <div role="tabpanel"
                                                 class="tab-pane {{ $code == locale() ? 'active' : '' }}"
                                                 id="general-tab-{{$k}}"
                                                 aria-expanded="{{ $code == locale() ? 'true' : 'false' }}"
                                                 aria-labelledby="{{$k}}-general-tab">

                                                <div class="col-md-10">

                                                    <div class="form-group">
                                                        <label class="col-md-2">
                                                            {{__('tags::dashboard.tags.form.title')}}
                                                            - {{ $code }}
                                                        </label>
                                                        <div class="col-md-9">
                                                            <input type="text" name="title[{{$code}}]"
                                                                   class="form-control"
                                                                   data-name="title.{{$code}}">
                                                            <div class="help-block"></div>
                                                        </div>
                                                    </div>

                                                </div>

                                            </div>
                                        @endforeach

                                        <div class="col-md-10">

                                            <div class="form-group">
                                                <label class="col-md-2">
                                                    {{__('tags::dashboard.tags.form.image')}}
                                                </label>
                                                <div class="col-md-9">
                                                    @include('core::dashboard.shared.file_upload', ['image' => null])
                                                    <div class="help-block"></div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-2">
                                                    {{__('tags::dashboard.tags.form.color')}}
                                                </label>
                                                <div class="col-md-2">
                                                    <input type="color"
                                                           class="form-control"
                                                           name="color">
                                                    <div class="help-block"></div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-2">
                                                    {{__('tags::dashboard.tags.form.background')}}
                                                </label>
                                                <div class="col-md-2">
                                                    <input type="color"
                                                           class="form-control"
                                                           name="background">
                                                    <div class="help-block"></div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-2">
                                                    {{__('tags::dashboard.tags.form.status')}}
                                                </label>
                                                <div class="col-md-9">
                                                    <input type="checkbox" class="make-switch" id="test"
                                                           data-size="small"
                                                           name="status">
                                                    <div class="help-block"></div>
                                                </div>
                                            </div>

                                        </div>

                                    </div>

                                </div>

                                {{-- END CREATE FORM --}}
                            </div>
                        </div>

                        {{-- PAGE ACTION --}}
                        <div class="col-md-12">
                            <div class="form-actions">
                                @include('apps::dashboard.layouts._ajax-msg')
                                <div class="form-group">
                                    <button type="submit" id="submit" class="btn btn-lg blue">
                                        {{__('apps::dashboard.general.add_btn')}}
                                    </button>
                                    <a href="{{url(route('dashboard.tags.index')) }}" class="btn btn-lg red">
                                        {{__('apps::dashboard.general.back_btn')}}
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

    <script></script>

@endsection
