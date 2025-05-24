@extends('apps::dashboard.layouts.app')
@section('title', __('vendor::dashboard.payments.update.title'))
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
                    <a href="{{ url(route('dashboard.payments.index')) }}">
                        {{__('vendor::dashboard.payments.index.title')}}
                    </a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <a href="#">{{__('vendor::dashboard.payments.update.title')}}</a>
                </li>
            </ul>
        </div>

        <h1 class="page-title"></h1>

        <div class="row">
            <form id="updateForm" user="form" class="form-horizontal form-row-seperated" method="post" enctype="multipart/form-data" action="{{route('dashboard.payments.update',$payment->id)}}">
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
                                                    {{ __('vendor::dashboard.payments.update.form.general') }}
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
                                {{--  <h3 class="page-title">{{__('vendor::dashboard.payments.update.form.general')}}</h3>  --}}
                                <div class="col-md-10">

                                    {{--  tab for lang --}}
                                    <ul class="nav nav-tabs">
                                        @foreach (config('translatable.locales') as $code)
                                             <li class="@if($loop->first) active @endif"><a data-toggle="tab" href="#first_{{$code}}">{{__('catalog::dashboard.products.form.tabs.input_lang',["lang"=>$code])}}</a></li>
                                        @endforeach
                                    </ul>

                                    {{--  tab for content --}}
                                    <div class="tab-content">

                                        @foreach (config('translatable.locales') as $code)
                                            <div id="first_{{$code}}" class="tab-pane fade @if($loop->first) in active @endif">
                                                <div class="form-group">
                                                    <label class="col-md-2">
                                                        {{__('vendor::dashboard.sections.update.form.title')}} - {{ $code }}
                                                    </label>
                                                    <div class="col-md-9">
                                                        <input type="text" name="title[{{$code}}]" class="form-control" data-name="title.{{$code}}" value="{{ $payment->translate($code)->title }}">
                                                        <div class="help-block"></div>
                                                    </div>
                                                </div>

                                            </div>
                                        @endforeach

                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-2">
                                            {{__('vendor::dashboard.payments.update.form.code')}}
                                        </label>
                                        <div class="col-md-9">
                                            <input type="text" name="code" class="form-control" data-name="code" value="{{ $payment->code }}">
                                            <div class="help-block"></div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-2">
                                          {{__('vendor::dashboard.payments.update.form.image')}}
                                        </label>
                                        <div class="col-md-9">
                                            <div class="input-group">
                                                <span class="input-group-btn">
                                                    <a data-input="image" data-preview="holder" class="btn btn-primary lfm">
                                                        <i class="fa fa-picture-o"></i>
                                                        {{__('apps::dashboard.general.upload_btn')}}
                                                    </a>
                                                </span>
                                                <input name="image" class="form-control image" type="text" readonly>
                                                <span class="input-group-btn">
                                                    <a data-input="image" data-preview="holder" class="btn btn-danger delete">
                                                        <i class="glyphicon glyphicon-remove"></i>
                                                    </a>
                                                </span>
                                            </div>
                                            <span class="holder" style="margin-top:15px;max-height:100px;">
                                              <img src="{{url($payment->image)}}" style="height: 15rem;">
                                            </span>
                                            <input type="hidden" data-name="image">
                                            <div class="help-block"></div>
                                        </div>
                                    </div>

{{--                                    @if ($payment->trashed())--}}
{{--                                      <div class="form-group">--}}
{{--                                          <label class="col-md-2">--}}
{{--                                            {{__('area::dashboard.payments.update.form.restore')}}--}}
{{--                                          </label>--}}
{{--                                          <div class="col-md-9">--}}
{{--                                              <input type="checkbox" class="make-switch" id="test" data-size="small" name="restore">--}}
{{--                                              <div class="help-block"></div>--}}
{{--                                          </div>--}}
{{--                                      </div>--}}
{{--                                    @endif--}}

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
                                    {{__('apps::dashboard.general.edit_btn')}}
                                </button>
                                <a href="{{url(route('dashboard.payments.index')) }}" class="btn btn-lg red">
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
