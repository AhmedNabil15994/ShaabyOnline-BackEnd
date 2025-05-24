@extends('apps::vendor.layouts.app')
@section('title', __('apps::vendor.home.title'))
@section('content')

    <div class="page-content-wrapper">
        <div class="page-content">

            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <a href="{{ url(route('vendor.home')) }}">{{ __('apps::vendor.home.title') }}</a>
                    </li>
                </ul>
            </div>

            <h1 class="page-title"> {{ __('apps::vendor.home.welcome_message') }} ,
                <small><b style="color:red">{{ Auth::user()->name }} </b></small>
            </h1>

            @permission('statistics')
                <div class="row">

                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <a class="dashboard-stat dashboard-stat-v2 red" href="#">
                            <div class="visual">
                                <i class="fa fa-bar-chart-o"></i>
                            </div>
                            <div class="details">
                                <div class="number">
                                    <span data-counter="counterup" data-value="{{ $completeOrders }}">0</span>
                                </div>
                                <div class="desc">{{ __('apps::dashboard.home.statistics.comleted_orders') }}</div>
                            </div>
                        </a>
                    </div>

                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <a class="dashboard-stat dashboard-stat-v2 yellow-casablanca" href="#">
                            <div class="visual">
                                <i class="fa fa-bar-chart-o"></i>
                            </div>
                            <div class="details">
                                <div class="number">
                                    <span data-counter="counterup" data-value="{{ $todayProfit }}">0</span> KWD
                                </div>
                                <div class="desc">{{ __('apps::dashboard.home.statistics.todayProfit') }}</div>
                            </div>
                        </a>
                    </div>

                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <a class="dashboard-stat dashboard-stat-v2 yellow-lemon" href="#">
                            <div class="visual">
                                <i class="fa fa-bar-chart-o"></i>
                            </div>
                            <div class="details">
                                <div class="number">
                                    <span data-counter="counterup" data-value="{{ $monthProfit }}">0</span> KWD
                                </div>
                                <div class="desc">{{ __('apps::dashboard.home.statistics.monthProfit') }}</div>
                            </div>
                        </a>
                    </div>

                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <a class="dashboard-stat dashboard-stat-v2 yellow-gold" href="#">
                            <div class="visual">
                                <i class="fa fa-bar-chart-o"></i>
                            </div>
                            <div class="details">
                                <div class="number">
                                    <span data-counter="counterup" data-value="{{ $yearProfit }}">0</span> KWD
                                </div>
                                <div class="desc">{{ __('apps::dashboard.home.statistics.yearProfit') }}</div>
                            </div>
                        </a>
                    </div>

                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <a class="dashboard-stat dashboard-stat-v2 green" href="#">
                            <div class="visual">
                                <i class="fa fa-bar-chart-o"></i>
                            </div>
                            <div class="details">
                                <div class="number">
                                    <span data-counter="counterup" data-value="{{ $totalProfit }}">0</span> KWD
                                </div>
                                <div class="desc">
                                    {{ __('apps::dashboard.home.statistics.total_completed_orders') }}</div>
                            </div>
                        </a>
                    </div>

                    {{-- <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <a class="dashboard-stat dashboard-stat-v2 blue" href="#">
                        <div class="visual">
                            <i class="fa fa-bar-chart-o"></i>
                        </div>
                        <div class="details">
                            <div class="number">
                                <span data-counter="counterup" data-value="{{$totalProfitCommission}}">0</span> KWD
                            </div>
                            <div class="desc">{{ __('apps::dashboard.home.statistics.total_profit_commission') }}</div>
                        </div>
                    </a>
                </div> --}}

                </div>
            @endpermission

            <div class="portlet light portlet-fit ">
                <div class="portlet-title">
                    <div class="caption">
                        <i class=" icon-layers font-green"></i>
                        <span class="caption-subject font-green bold uppercase">
                            {{ __('apps::vendor.home.my_vendors') }}
                        </span>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="row">
                        @foreach ($vendors as $vendor)
                            <div class="col-md-3">
                                <div class="mt-widget-2">
                                    <div class="mt-head"
                                        style="background-image: url({{ url($vendor->image) }});">
                                        <div class="mt-head-label">

                                            @if (config('setting.other.enable_subscriptions') == 1)
                                                @if ($vendor->subscribed)
                                                    <span class="label label-success">
                                                        {{ __('apps::vendor.home.subscriptions.active') }}
                                                    </span>
                                                @else
                                                    <span class="label label-danger">
                                                        {{ __('apps::vendor.home.subscriptions.unactive') }}
                                                    </span>
                                                @endif
                                            @endif
                                        </div>
                                        <div class="mt-head-user">
                                            <div class="mt-head-user-info">
                                                <span class="mt-user-name"></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-body" style="padding-top: 83px;">

                                        <h3 class="mt-body-title">

                                            <form class="busyCheckboxForm busyForm-{{ $vendor->id }}" page="form"
                                                class="form-horizontal form-row-seperated" method="post"
                                                enctype="multipart/form-data"
                                                action="{{ route('vendor.update.info', $vendor->id) }}">
                                                @csrf
                                                @method('POST')
                                                <input type="hidden" name="vendor_id" value="{{ $vendor->id }}" />

                                                <div class="form-group text-center">
                                                    <label>{{ __('vendor::dashboard.vendors.create.form.busy') }}</label>
                                                    <input type="checkbox" class="make-switch busyCheckbox"
                                                        data-size="small" name="vendor_status_id"
                                                        {{ $vendor->vendor_status_id == 4 ? ' checked="" ' : '' }}>
                                                </div>
                                            </form>
                                            <div id="busyLoading-{{ $vendor->id }}"
                                                style="display: none; padding: 10px; font-weight: 100;">
                                                ...
                                            </div>

                                            {{ $vendor->title }}
                                        </h3>

                                        @if (config('setting.other.enable_subscriptions') == 1)
                                            @if ($vendor->subscribed)
                                                <p class="mt-body-description">
                                                    {{ __('apps::vendor.home.subscriptions.end_at') }} :
                                                    {{ $vendor->subbscription['end_at'] }}
                                                </p>
                                            @else
                                                <p class="mt-body-description" style="color: #ed6a75;">
                                                    {{ __('apps::vendor.home.subscriptions.unactive') }}
                                                    {{-- : {{ $vendor->subbscription['end_at']  }} --}}
                                                </p>
                                            @endif
                                            @if (!$vendor->subscribed)
                                                <div class="mt-body-actions">
                                                    <div class="btn-group btn-group btn-group-justified">
                                                        <a href="javascript:;" class="btn ">
                                                            {{ __('apps::vendor.home.subscriptions.renew') }}
                                                        </a>
                                                    </div>
                                                </div>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('scripts')
    <script>
        $(function() {
            $('.busyCheckboxForm .busyCheckbox').on('switchChange.bootstrapSwitch', function(e) {

                var vendorId = $(this).closest('.busyCheckboxForm').find('input[name="vendor_id"]').val();
                var token = $(this).closest('.busyCheckboxForm').find('input[name="_token"]').val();
                var action = $(this).closest('.busyCheckboxForm').attr('action');
                e.preventDefault();

                $.ajax({
                    method: "POST",
                    url: action,
                    data: {
                        "_token": token,
                        "vendor_status_id": e.target.checked,
                    },
                    beforeSend: function() {
                        $('.busyForm-' + vendorId).hide();
                        $('#busyLoading-' + vendorId).show();
                    },
                    success: function(data) {
                        if (data && data[0] == true) {
                            successfully(data);
                        } else {
                            displayMissing(data);
                        }
                    },
                    error: function(data) {
                        displayMissing(data);
                    },
                    complete: function(data) {
                        $('#busyLoading-' + vendorId).hide();
                        $('.busyForm-' + vendorId).show();
                    },
                });

            });
        });
    </script>
@endsection
