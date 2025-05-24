@extends('apps::dashboard.layouts.app')
@section('title', __('apps::dashboard.app_homes.routes.update'))
@push('css')
<style>
    .select2-container .select2-search--inline {
        float: right !important;
    }

    .select2-container .select2-search--inline .select2-search__field{
        width: auto !important;
    }
</style>
@endpush
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
                        <a href="{{ url(route('dashboard.apphomes.index')) }}">
                            {{__('apps::dashboard.app_homes.routes.index')}}
                        </a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <a href="#">{{__('apps::dashboard.app_homes.routes.update')}}</a>
                    </li>
                </ul>
            </div>

            <h1 class="page-title"></h1>

            <div class="row">
                {!! Form::model($model,[
                              'url'=> route('dashboard.apphomes.update',$model->id),
                              'id'=>'updateForm',
                              'role'=>'form',
                              'page'=>'form',
                              'class'=>'form-horizontal form-row-seperated',
                              'method'=>'PUT',
                              'files' => true
                              ])!!}
                    <div class="col-md-12">

                        {{-- RIGHT SIDE --}}
                        <div class="col-md-3">
                            <div class="panel-group accordion scrollable" id="accordion2">
                                <div class="panel panel-default">

                                    <div id="collapse_2_1" class="panel-collapse in">
                                        <div class="panel-body">
                                            <ul class="nav nav-pills nav-stacked">
                                                <li class="active">
                                                    <a href="#global_setting" data-toggle="tab">
                                                        {{ __('apps::dashboard.app_homes.form.tabs.general') }}
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

                                    <div class="col-md-10">
                                        @include('apps::dashboard.apphomes.form')
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

                                </div>
                            </div>
                        </div>

                    </div>
                {!! Form::close()!!}
            </div>
        </div>
    </div>
@stop
