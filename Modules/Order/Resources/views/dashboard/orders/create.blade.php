@extends('apps::dashboard.layouts.app')
@section('title', __('order::dashboard.orders.create.title'))
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
                        <a href="#">{{ __('order::dashboard.orders.create.title') }}</a>
                    </li>
                </ul>
            </div>

            @include('apps::dashboard.layouts._msg')

            <div class="row">
                <form role="form" class="form-horizontal form-row-seperated" method="post"
                    action="{{ route('dashboard.orders.store') }}" enctype="multipart/form-data">
                    <div class="col-md-12">
                        @csrf
                        <div class="col-md-3">
                            <div class="panel-group accordion scrollable" id="accordion2">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a class="accordion-toggle">
                                                {{ __('order::dashboard.orders.create.info') }}
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapse_2_1" class="panel-collapse in">
                                        <div class="panel-body">
                                            <ul class="nav nav-pills nav-stacked">
                                                <li class="active">
                                                    <a href="#tab1" data-toggle="tab">
                                                        {{ __('order::dashboard.orders.create.tabs.products') }}
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#tab2" data-toggle="tab">
                                                        {{ __('order::dashboard.orders.create.tabs.user_info') }}
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

                                <div class="tab-pane active fade in" id="tab1">
                                    {{--  <h3 class="page-title">{{ __('order::dashboard.orders.create.tabs.products') }}</h3>  --}}
                                    <div class="col-md-12">

                                        {{-- <div class="form-group"> --}}
                                        {{-- <label class="col-md-2"> --}}
                                        {{-- {{ __('setting::dashboard.settings.form.default_language') }} --}}
                                        {{-- </label> --}}
                                        {{-- <div class="col-md-9"> --}}
                                        {{-- <select name="default_locale" class="form-control select2"> --}}
                                        {{-- @foreach (config('core.available-locales') as $key => $language) --}}
                                        {{-- <option value="{{ $key }}" --}}
                                        {{-- @if (config('default_locale') == $key) --}}
                                        {{-- selected --}}
                                        {{-- @endif> --}}
                                        {{-- {{ $language['native'] }} --}}
                                        {{-- </option> --}}
                                        {{-- @endforeach --}}
                                        {{-- </select> --}}
                                        {{-- </div> --}}
                                        {{-- </div> --}}

                                    </div>
                                </div>

                                <div class="tab-pane fade" id="tab2">
                                    {{--  <h3 class="page-title">{{ __('order::dashboard.orders.create.tabs.user_info') }}</h3>  --}}

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="user_id">
                                                    {{ __('order::dashboard.orders.create.form.users') }}
                                                </label>
                                                <select id="user_id" name="user_id" class="form-control select2">
                                                    <option value="">
                                                        {{ __('order::dashboard.orders.create.form.select_order_user') }}
                                                    </option>
                                                    @foreach ($users as $k => $user)
                                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <hr>
                                    <h3>{{ __('order::dashboard.orders.create.form.address_info') }}</h3>
                                    <div class="row">
                                        <div class="col-md-12">
                                            {{-- <table class="table table-striped table-bordered table-hover"> --}}
                                            {{-- <thead> --}}
                                            {{-- <tr> --}}
                                            {{-- <th>#</th> --}}
                                            {{-- <th>{{__('order::dashboard.orders.datatable.subtotal')}}</th> --}}
                                            {{-- <th>{{__('order::dashboard.orders.datatable.shipping')}}</th> --}}
                                            {{-- <th>{{__('order::dashboard.orders.datatable.total')}}</th> --}}
                                            {{-- </tr> --}}
                                            {{-- </thead> --}}
                                            {{-- <tbody> --}}
                                            {{-- <tr> --}}
                                            {{-- <td></td> --}}
                                            {{-- <td></td> --}}
                                            {{-- <td></td> --}}
                                            {{-- <td></td> --}}
                                            {{-- </tr> --}}
                                            {{-- </tbody> --}}
                                            {{-- </table> --}}
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-9 text-center">
                                <button type="submit" id="submit" class="btn btn-lg blue">
                                    {{ __('order::dashboard.orders.create.btn.save') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
    </div>

@stop
