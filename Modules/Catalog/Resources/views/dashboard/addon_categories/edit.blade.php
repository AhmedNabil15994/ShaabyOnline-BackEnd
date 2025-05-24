@extends('apps::dashboard.layouts.app')
@section('title', __('catalog::dashboard.addon_categories.routes.update'))
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
                        <a href="{{ url(route('dashboard.addon_categories.index')) }}">
                            {{__('catalog::dashboard.addon_categories.routes.index')}}
                        </a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <a href="#">{{__('catalog::dashboard.addon_categories.routes.update')}}</a>
                    </li>
                </ul>
            </div>

            <h1 class="page-title"></h1>

            <div class="row">
                <form id="updateForm" page="form" class="form-horizontal form-row-seperated" method="post"
                      enctype="multipart/form-data"
                      action="{{route('dashboard.addon_categories.update',$category->id)}}">
                    @csrf
                    @method('PUT')
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
                                                    <a href="#global_setting" data-toggle="tab">
                                                        {{ __('catalog::dashboard.addon_categories.form.tabs.general') }}
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
                                <div class="tab-pane active fade in" id="global_setting">
                                    <div class="col-md-10">

                                        {{--  tab for lang --}}
                                        <ul class="nav nav-tabs">
                                            @foreach (config('translatable.locales') as $code)
                                                <li class="@if($loop->first) active @endif">
                                                    <a data-toggle="tab"
                                                       href="#first_{{$code}}">{{__('catalog::dashboard.products.form.tabs.input_lang',["lang"=>$code])}}</a>
                                                </li>
                                            @endforeach
                                        </ul>

                                        {{--  tab for content --}}
                                        <div class="tab-content">

                                            @foreach (config('translatable.locales') as $code)
                                                <div id="first_{{$code}}"
                                                     class="tab-pane fade @if($loop->first) in active @endif">

                                                    <div class="form-group">
                                                        <label class="col-md-2">
                                                            {{__('catalog::dashboard.addon_categories.form.title')}}
                                                            - {{ $code }}
                                                        </label>
                                                        <div class="col-md-9">
                                                            <input type="text" name="title[{{$code}}]"
                                                                   class="form-control"
                                                                   data-name="title.{{$code}}"
                                                                   value="{{$category->getTranslation('title',$code)}}">
                                                            <div class="help-block"></div>
                                                        </div>
                                                    </div>


                                                </div>
                                            @endforeach

                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{__('catalog::dashboard.addon_categories.form.sort')}}
                                            </label>
                                            <div class="col-md-3">
                                                <input type="number" name="sort" class="form-control" data-name="sort"
                                                       value="{{ $category->sort ?? 0 }}">
                                                <div class="help-block"></div>
                                            </div>
                                        </div>

                                        @if ($category->trashed())
                                            <div class="form-group">
                                                <label class="col-md-2">
                                                    {{__('apps::dashboard.general.restore')}}
                                                </label>
                                                <div class="col-md-9">
                                                    <input type="checkbox" class="make-switch" id="test"
                                                           data-size="small"
                                                           name="restore">
                                                    <div class="help-block"></div>
                                                </div>
                                            </div>
                                        @endif

                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- PAGE ACTION --}}
                        <div class="col-md-12">
                            <div class="form-actions">
                                @include('apps::dashboard.layouts._ajax-msg')
                                <div class="form-group">
                                    <button type="submit" id="submit" class="btn btn-lg green">
                                        {{__('apps::dashboard.general.edit_btn')}}
                                    </button>
                                    <a href="{{url(route('dashboard.addon_categories.index')) }}"
                                       class="btn btn-lg red">
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

    <script type="text/javascript">
        $(function () {
        });
    </script>

@endsection
