@extends('apps::dashboard.layouts.app')
@section('title', __('subscription::dashboard.subscriptions.update.title'))
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
                    <a href="{{ url(route('dashboard.subscriptions.index')) }}">
                        {{__('subscription::dashboard.subscriptions.index.title')}}
                    </a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <a href="#">{{__('subscription::dashboard.subscriptions.update.title')}}</a>
                </li>
            </ul>
        </div>

        <h1 class="page-title"></h1>

        <div class="row">
            <form id="updateForm" page="form" class="form-horizontal form-row-seperated" method="post" enctype="multipart/form-data" action="{{route('dashboard.subscriptions.update',$subscription->id)}}">
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
                                                    {{ __('subscription::dashboard.subscriptions.update.form.general') }}
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
                                {{--  <h3 class="page-title">{{__('subscription::dashboard.subscriptions.update.form.general')}}</h3>  --}}
                                <div class="col-md-10">

                                    <div class="form-group">
                                        <label class="col-md-2">
                                            {{__('subscription::dashboard.subscriptions.update.form.packages')}}
                                        </label>
                                        <div class="col-md-9">
                                            <select name="package_id" id="single" class="form-control select2" disabled>
                                                <option value=""></option>
                                                @foreach ($packages as $package)
                                                <option value="{{ $package['id'] }}" @if ($subscription->package_id == $package->id)
                                                selected
                                                @endif>
                                                    {{ $package->title }}
                                                    </option>
                                                    @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-2">
                                            {{__('subscription::dashboard.subscriptions.update.form.vendors')}}
                                        </label>
                                        <div class="col-md-9">
                                            <select name="vendor_id" id="single" class="form-control select2" disabled>
                                                <option value=""></option>
                                                @foreach ($vendors as $vendor)
                                                <option value="{{ $vendor['id'] }}" @if ($subscription->vendor_id == $vendor->id)
                                                selected
                                                @endif>
                                                    {{ $vendor->title }}
                                                    </option>
                                                    @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2">
                                          {{__('subscription::dashboard.subscriptions.update.form.start_at')}}
                                        </label>
                                        <div class="col-md-9">
                                            <div class="input-group input-medium date date-picker" data-date-format="yyyy-mm-dd" data-date-start-date="+0d">
                                                <input type="text" class="form-control" name="start_at" value="{{$subscription->start_at}}" disabled>
                                                <span class="input-group-btn">
                                                    <button class="btn default" type="button">
                                                        <i class="fa fa-calendar"></i>
                                                    </button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2">
                                            {{__('subscription::dashboard.subscriptions.update.form.end_at')}}
                                        </label>
                                        <div class="col-md-9">
                                            <div class="input-group input-medium date date-picker" data-date-format="yyyy-mm-dd" data-date-start-date="+0d">
                                                <input type="text" class="form-control" name="end_at" value="{{$subscription->end_at}}">
                                                <span class="input-group-btn">
                                                    <button class="btn default" type="button">
                                                        <i class="fa fa-calendar"></i>
                                                    </button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2">
                                          {{__('subscription::dashboard.subscriptions.update.form.original_price')}}
                                        </label>
                                        <div class="col-md-9">
                                            <input type="text" name="original_price" class="form-control" data-name="price" value="{{$subscription->original_price}}" disabled>
                                            <div class="help-block"></div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2">
                                          {{__('subscription::dashboard.subscriptions.update.form.total')}}
                                        </label>
                                        <div class="col-md-9">
                                            <input type="text" name="total" class="form-control" data-name="price" value="{{$subscription->total}}">
                                            <div class="help-block"></div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2">
                                            {{__('subscription::dashboard.subscriptions.update.form.status')}}
                                        </label>
                                        <div class="col-md-9">
                                            <input type="checkbox" class="make-switch" id="test" data-size="small" name="status" {{($subscription->status == 1) ? ' checked="" ' : ''}}>
                                            <div class="help-block"></div>
                                        </div>
                                    </div>

                                    @if ($subscription->trashed())
                                      <div class="form-group">
                                          <label class="col-md-2">
                                            {{__('area::dashboard.subscriptions.update.form.restore')}}
                                          </label>
                                          <div class="col-md-9">
                                              <input type="checkbox" class="make-switch" id="test" data-size="small" name="restore">
                                              <div class="help-block"></div>
                                          </div>
                                      </div>
                                    @endif

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
                                <a href="{{url(route('dashboard.subscriptions.index')) }}" class="btn btn-lg red">
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
