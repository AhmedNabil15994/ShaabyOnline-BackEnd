@extends('apps::dashboard.layouts.app')
@section('title', __('subscription::dashboard.packages.update.title'))
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
                        <a href="{{ url(route('dashboard.packages.index')) }}">
                            {{ __('subscription::dashboard.packages.index.title') }}
                        </a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <a href="#">{{ __('subscription::dashboard.packages.update.title') }}</a>
                    </li>
                </ul>
            </div>

            <h1 class="page-title"></h1>

            <div class="row">
                <form id="updateForm" page="form" class="form-horizontal form-row-seperated" method="post"
                    enctype="multipart/form-data" action="{{ route('dashboard.packages.update', $package->id) }}">
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
                                                        {{ __('subscription::dashboard.packages.update.form.general') }}
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#other" data-toggle="tab">
                                                        {{ __('subscription::dashboard.packages.update.form.other') }}
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
                                    {{--  <h3 class="page-title">{{ __('subscription::dashboard.packages.update.form.general') }}  --}}
                                    </h3>
                                    <div class="col-md-10">


                                        {{-- tab for lang --}}
                                        <ul class="nav nav-tabs">
                                            @foreach (config('translatable.locales') as $code)
                                                <li class="@if ($loop->first) active @endif"><a
                                                        data-toggle="tab"
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
                                                            {{ __('subscription::dashboard.packages.update.form.title') }}
                                                            - {{ $code }}
                                                        </label>
                                                        <div class="col-md-9">
                                                            <input type="text" name="title[{{ $code }}]"
                                                                class="form-control" data-name="title.{{ $code }}"
                                                                value="{{ $package->getTranslation('title', $code) }}">
                                                            <div class="help-block"></div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="col-md-2">
                                                            {{ __('subscription::dashboard.packages.update.form.description') }}
                                                            - {{ $code }}
                                                        </label>
                                                        <div class="col-md-9">
                                                            <textarea name="description[{{ $code }}]" rows="8" cols="80"
                                                                class="form-control {{ is_rtl($code) }}Editor" data-name="description.{{ $code }}">{{ $package->getTranslation('description', $code) }}</textarea>
                                                            <div class="help-block"></div>
                                                        </div>
                                                    </div>

                                                </div>
                                            @endforeach

                                        </div>





                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{ __('subscription::dashboard.packages.update.form.status') }}
                                            </label>
                                            <div class="col-md-9">
                                                <input type="checkbox" class="make-switch" id="test" data-size="small"
                                                    name="status" {{ $package->status == 1 ? ' checked="" ' : '' }}>
                                                <div class="help-block"></div>
                                            </div>
                                        </div>

                                        @if ($package->trashed())
                                            <div class="form-group">
                                                <label class="col-md-2">
                                                    {{ __('area::dashboard.packages.update.form.restore') }}
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

                                <div class="tab-pane fade in" id="other">
                                    {{--  <h3 class="page-title">{{ __('subscription::dashboard.packages.update.form.other') }}  --}}
                                    </h3>
                                    <div class="col-md-10">

                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{ __('subscription::dashboard.packages.update.form.price') }}
                                            </label>
                                            <div class="col-md-9">
                                                <input type="text" name="price" class="form-control" data-name="price"
                                                    value="{{ $package->price }}">
                                                <div class="help-block"></div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{ __('subscription::dashboard.packages.update.form.special_price') }}
                                            </label>
                                            <div class="col-md-9">
                                                <input type="text" name="special_price" class="form-control"
                                                    data-name="special_price" value="{{ $package->special_price }}">
                                                <div class="help-block"></div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{ __('subscription::dashboard.packages.update.form.months') }}
                                            </label>
                                            <div class="col-md-9">
                                                <input type="text" name="months" class="form-control"
                                                    data-name="months" value="{{ $package->months }}">
                                                <div class="help-block"></div>
                                            </div>
                                        </div>

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
                                    <a href="{{ url(route('dashboard.packages.index')) }}" class="btn btn-lg red">
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
