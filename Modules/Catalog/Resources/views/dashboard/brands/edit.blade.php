@extends('apps::dashboard.layouts.app')
@section('title', __('catalog::dashboard.brands.routes.update'))
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
                        <a href="{{ url(route('dashboard.brands.index')) }}">
                            {{ __('catalog::dashboard.brands.routes.index') }}
                        </a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <a href="#">{{ __('catalog::dashboard.brands.routes.update') }}</a>
                    </li>
                </ul>
            </div>

            <h1 class="page-title"></h1>

            <div class="row">
                <form id="updateForm" page="form" class="form-horizontal form-row-seperated" method="post"
                    enctype="multipart/form-data" action="{{ route('dashboard.brands.update', $brand->id) }}">
                    @csrf
                    @method('PUT')
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
                                                        {{ __('catalog::dashboard.brands.form.tabs.general') }}
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#seo" data-toggle="tab">
                                                        {{ __('catalog::dashboard.brands.form.tabs.seo') }}
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

                                {{-- UPDATE FORM --}}
                                <div class="tab-pane active fade in" id="global_setting">
                                    {{-- <h3 class="page-title">{{__('catalog::dashboard.brands.form.tabs.general')}}</h3> --}}
                                    <div class="col-md-10">

                                        @foreach (config('translatable.locales') as $code)
                                            <div class="form-group">
                                                <label class="col-md-2">
                                                    {{ __('catalog::dashboard.brands.form.title') }} - {{ $code }}
                                                </label>
                                                <div class="col-md-9">
                                                    <input type="text" name="title[{{ $code }}]"
                                                        class="form-control" data-name="title.{{ $code }}"
                                                        value="{{ $brand->getTranslation('title', $code) }}">
                                                    <div class="help-block"></div>
                                                </div>
                                            </div>
                                        @endforeach

                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{ __('catalog::dashboard.brands.form.image') }}
                                            </label>
                                            <div class="col-md-9">
                                                <div class="input-group">
                                                    <span class="input-group-btn">
                                                        <a data-input="image" data-preview="holder"
                                                            class="btn btn-primary lfm">
                                                            <i class="fa fa-picture-o"></i>
                                                            {{ __('apps::dashboard.general.upload_btn') }}
                                                        </a>
                                                    </span>
                                                    <input name="image" class="form-control image" type="text"
                                                        readonly>
                                                    <span class="input-group-btn">
                                                        <a data-input="image" data-preview="holder"
                                                            class="btn btn-danger delete">
                                                            <i class="glyphicon glyphicon-remove"></i>
                                                        </a>
                                                    </span>
                                                </div>
                                                <span class="holder" style="margin-top:15px;max-height:100px;">
                                                    <img src="{{ url($brand->image) }}" style="height: 15rem;">
                                                </span>
                                                <input type="hidden" data-name="image">
                                                <div class="help-block"></div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{ __('catalog::dashboard.brands.form.status') }}
                                            </label>
                                            <div class="col-md-9">
                                                <input type="checkbox" class="make-switch" id="test" data-size="small"
                                                    name="status" {{ $brand->status == 1 ? ' checked="" ' : '' }}>
                                                <div class="help-block"></div>
                                            </div>
                                        </div>

                                        @if ($brand->trashed())
                                            <div class="form-group">
                                                <label class="col-md-2">
                                                    {{ __('apps::dashboard.general.restore') }}
                                                </label>
                                                <div class="col-md-9">
                                                    <input type="checkbox" class="make-switch" id="test"
                                                        data-size="small" name="restore">
                                                    <div class="help-block"></div>
                                                </div>
                                            </div>
                                        @endif

                                    </div>
                                </div>
                                <div class="tab-pane fade in" id="seo">
                                    {{-- <h3 class="page-title">{{__('catalog::dashboard.brands.form.tabs.seo')}}</h3> --}}
                                    <div class="col-md-10">

                                        @foreach (config('translatable.locales') as $code)
                                            <div class="form-group">
                                                <label class="col-md-2">
                                                    {{ __('catalog::dashboard.brands.form.meta_keywords') }} -
                                                    {{ $code }}
                                                </label>
                                                <div class="col-md-9">
                                                    <textarea name="seo_keywords[{{ $code }}]" rows="8" cols="80" class="form-control"
                                                        data-name="seo_keywords.{{ $code }}">{{ $brand->getTranslation('seo_keywords', $code) }}</textarea>
                                                    <div class="help-block"></div>
                                                </div>
                                            </div>
                                        @endforeach

                                        @foreach (config('translatable.locales') as $code)
                                            <div class="form-group">
                                                <label class="col-md-2">
                                                    {{ __('catalog::dashboard.brands.form.meta_description') }} -
                                                    {{ $code }}
                                                </label>
                                                <div class="col-md-9">
                                                    <textarea name="seo_description[{{ $code }}]" rows="8" cols="80" class="form-control"
                                                        data-name="seo_description.{{ $code }}">{{ $brand->getTranslation('seo_description', $code) }}</textarea>
                                                    <div class="help-block"></div>
                                                </div>
                                            </div>
                                        @endforeach

                                    </div>
                                </div>
                                {{-- END UPDATE FORM --}}

                            </div>
                        </div>

                        {{-- PAGE ACTION --}}
                        <div class="col-md-12">
                            <div class="form-actions">
                                @include('apps::dashboard.layouts._ajax-msg')
                                <div class="form-group">
                                    <button type="submit" id="submit" class="btn btn-lg green">
                                        {{ __('apps::dashboard.general.edit_btn') }}
                                    </button>
                                    <a href="{{ url(route('dashboard.brands.index')) }}" class="btn btn-lg red">
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
