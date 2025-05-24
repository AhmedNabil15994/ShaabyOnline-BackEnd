@extends('apps::dashboard.layouts.app')
@section('title', __('area::dashboard.cities.routes.create'))
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
                    <a href="{{ url(route('dashboard.cities.index')) }}">
                        {{__('area::dashboard.cities.routes.index')}}
                    </a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <a href="#">{{__('area::dashboard.cities.routes.create')}}</a>
                </li>
            </ul>
        </div>

        <h1 class="page-title"></h1>

        <div class="row">
            <form id="form" role="form" class="form-horizontal form-row-seperated" method="post" enctype="multipart/form-data" action="{{route('dashboard.cities.store')}}">
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
                                                <a href="#general" data-toggle="tab">
                                                    {{ __('area::dashboard.cities.form.tabs.general') }}
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
                            <div class="tab-pane active fade in" id="general">
                                {{--  <h3 class="page-title">{{__('area::dashboard.cities.form.tabs.general')}}</h3>  --}}
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
                                                        {{__('area::dashboard.cities.form.title')}} - {{ $code }}
                                                    </label>
                                                    <div class="col-md-9">
                                                        <input type="text" name="title[{{$code}}]" class="form-control" data-name="title.{{$code}}">
                                                        <div class="help-block"></div>
                                                    </div>
                                                </div>



                                            </div>
                                        @endforeach

                                  </div>

                                  <div class="form-group">
                                      <label class="col-md-2">
                                        {{__('area::dashboard.cities.form.countries')}}
                                      </label>
                                      <div class="col-md-9">
                                          <select name="country_id" id="single" class="form-control select2">
                                              <option value=""></option>
                                              @foreach ($countries as $country)
                                              <option value="{{ $country['id'] }}">
                                                  {{ $country->title }}
                                              </option>
                                              @endforeach
                                          </select>
                                      </div>
                                  </div>





                                    <div class="form-group">
                                        <label class="col-md-2">
                                            {{__('area::dashboard.cities.form.status')}}
                                        </label>
                                        <div class="col-md-9">
                                            <input type="checkbox" class="make-switch" id="test" data-size="small" name="status">
                                            <div class="help-block"></div>
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
                                <a href="{{url(route('dashboard.cities.index')) }}" class="btn btn-lg red">
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
