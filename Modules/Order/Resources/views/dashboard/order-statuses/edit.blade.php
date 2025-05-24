@extends('apps::dashboard.layouts.app')
@section('title', __('order::dashboard.order_statuses.form.update.title'))
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
                    <a href="{{ url(route('dashboard.order-statuses.index')) }}">
                        {{__('order::dashboard.order_statuses.index.title')}}
                    </a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <a href="#">{{__('order::dashboard.order_statuses.form.update.title')}}</a>
                </li>
            </ul>
        </div>

        <h1 class="page-title"></h1>

        <div class="row">
            <form id="updateForm" page="form" class="form-horizontal form-row-seperated" method="post"
                enctype="multipart/form-data" action="{{route('dashboard.order-statuses.update',$orderStatus->id)}}">
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
                                                    {{ __('order::dashboard.order_statuses.form.tabs.general') }}
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
                                <h3 class="page-title">{{__('order::dashboard.order_statuses.form.update.title')}}</h3>
                                <div class="col-md-10">

                                    @foreach (config('translatable.locales') as $code)
                                    <div class="form-group">
                                        <label class="col-md-2">
                                            {{__('order::dashboard.order_statuses.form.title')}} - {{ $code }}
                                        </label>
                                        <div class="col-md-9">
                                            <input type="text" name="title[{{$code}}]" class="form-control"
                                                data-name="title.{{$code}}"
                                                value="{{ $orderStatus->getTranslation('title', $code) }}">
                                            <div class="help-block"></div>
                                        </div>
                                    </div>
                                    @endforeach

                                    <div class="form-group form-md-radios">
                                        <label class="col-md-2">
                                            {{__('order::dashboard.order_statuses.form.color_label')}}
                                        </label>
                                        <div class="col-md-9">
                                            <div class="md-radio-list">
                                                <div class="md-radio has-success">
                                                    <input type="radio" id="success" name="color_label"
                                                        class="md-radiobtn" value="success"
                                                        {{($orderStatus->color_label->text == 'success') ? ' checked="" ' : ''}}>
                                                    <label for="success">
                                                        <span></span>
                                                        <span class="check"></span>
                                                        <span class="box"></span>
                                                    </label>
                                                </div>
                                                <div class="md-radio has-warning">
                                                    <input type="radio" id="warning" name="color_label"
                                                        class="md-radiobtn" value="warning"
                                                        {{($orderStatus->color_label->text == 'warning') ? ' checked="" ' : ''}}>
                                                    <label for="warning">
                                                        <span></span>
                                                        <span class="check"></span>
                                                        <span class="box"></span>
                                                    </label>
                                                </div>
                                                <div class="md-radio has-error">
                                                    <input type="radio" id="error" name="color_label"
                                                        class="md-radiobtn" value="danger"
                                                        {{($orderStatus->color_label->text == 'danger') ? ' checked="" ' : ''}}>
                                                    <label for="error">
                                                        <span></span>
                                                        <span class="check"></span>
                                                        <span class="box"></span>
                                                    </label>
                                                </div>
                                                <div class="md-radio has-info">
                                                    <input type="radio" id="info" name="color_label" class="md-radiobtn"
                                                        value="info"
                                                        {{($orderStatus->color_label->text == 'info') ? ' checked="" ' : ''}}>
                                                    <label for="info">
                                                        <span></span>
                                                        <span class="check"></span>
                                                        <span class="box"></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-2">
                                            {{__('order::dashboard.order_statuses.form.is_success')}}
                                        </label>
                                        <div class="col-md-9">
                                            <div class="mt-radio-inline">
                                                <label class="mt-radio mt-radio-outline">
                                                    {{ __('order::dashboard.order_statuses.form.success') }}
                                                    <input type="radio" name="is_success" value="1"
                                                        {{ $orderStatus->is_success == 1 ? 'checked' : '' }}>
                                                    <span></span>
                                                </label>
                                                <label class="mt-radio mt-radio-outline">
                                                    {{ __('order::dashboard.order_statuses.form.failed') }}
                                                    <input type="radio" name="is_success" value="0"
                                                        {{ $orderStatus->is_success == 0 ? 'checked' : '' }}>
                                                    <span></span>
                                                </label>

                                                {{--<label class="mt-radio mt-radio-outline">
                                                        {{ __('order::dashboard.order_statuses.form.other_wise') }}
                                                <input type="radio" name="is_success" value="other"
                                                    {{ is_null($orderStatus->is_success) ? 'checked' : '' }}>
                                                <span></span>
                                                </label>--}}

                                            </div>
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
                                    {{__('apps::dashboard.general.edit_btn')}}
                                </button>
                                <a href="{{url(route('dashboard.order-statuses.index')) }}" class="btn btn-lg red">
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