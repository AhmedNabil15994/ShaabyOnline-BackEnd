@extends('apps::dashboard.layouts.app')
@section('title', __('company::dashboard.delivery_charges.update.title'))
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
                        <a href="{{ url(route('dashboard.delivery-charges.index')) }}">
                            {{ __('company::dashboard.delivery_charges.index.title') }}
                        </a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <a href="#">{{ __('company::dashboard.delivery_charges.update.title') }}</a>
                    </li>
                </ul>
            </div>

            <h1 class="page-title"></h1>

            <div class="row">
                <form id="updateForm" page="form" class="form-horizontal form-row-seperated" method="post"
                    enctype="multipart/form-data" action="{{ route('dashboard.delivery-charges.update', $company->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="col-md-12">

                        <h4 class="text-center" style="margin: 0px 0px 15px 0px;">{{ $company->title }}</h4>

                        {{-- RIGHT SIDE --}}
                        <div class="col-md-3">

                            {{-- <div class="panel-group accordion scrollable" id="accordion2">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                    </div>
                                    <div id="collapse_2_1" class="panel-collapse in">
                                        <div class="panel-body">
                                            <ul class="nav nav-pills nav-stacked">
                                                @foreach ($cities as $key => $city)
                                                    <li class="{{ $key == 0 ? 'active' : '' }}">
                                                        <a href="#cities_{{ $key }}" data-toggle="tab">
                                                            {{ $city->title }}
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}

                            <div class="panel-group accordionTab" id="accordion">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion"
                                                href="#collapseOne">
                                                {{ __('company::dashboard.delivery_charges.index.title') }}
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseOne" class="panel-collapse collapse in">
                                        <div class="panel-body">
                                            <ul class="nav nav-pills nav-stacked">
                                                @foreach ($cities as $key => $city)
                                                    <li class="li-state {{ $key == 0 ? 'active' : '' }}">
                                                        <a href="#cities_{{ $key }}" data-toggle="tab">
                                                            {{ $city->title }}
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                @if (in_array('schedule', $company->delivery_time_types ?? []))
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion"
                                                    href="#collapseTwo">
                                                    {{ __('vendor::dashboard.vendors.tabs.delivery_times') }}
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="collapseTwo" class="panel-collapse collapse in">
                                            <div class="panel-body">
                                                <ul class="nav nav-pills nav-stacked">
                                                    <li class="" id="vendorDeliveryTimesTab">
                                                        <a href="#vendorDeliveryTimes" data-toggle="tab">
                                                            {{ __('vendor::dashboard.vendors.tabs.show_delivery_times') }}
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                            </div>

                        </div>

                        {{-- PAGE CONTENT --}}
                        <div class="col-md-9">
                            <div class="tab-content" id="deliveryStatesTabContent">
                                {{-- UPDATE FORM --}}

                                @foreach ($cities as $key2 => $city2)
                                    <div class="tab-pane fade in {{ $key2 == 0 ? 'active' : '' }}"
                                        id="cities_{{ $key2 }}">
                                        {{-- <h3 class="page-title">{{ $city2->title }}</h3> --}}
                                        <div class="col-md-12">

                                            <div class="table-responsive">
                                                <table class="table table-striped table-bordered table-hover">
                                                    <thead>
                                                        <th style="padding: 15px 5px 15px 0;">
                                                            {{ __('company::dashboard.delivery_charges.update.state') }}
                                                        </th>
                                                        <th style="width: 165px">
                                                            <span>{{ __('company::dashboard.delivery_charges.update.delivery_price') }}</span>
                                                            <button type="button" class="btn btn-success btn-sm pull-right"
                                                                onclick="copyToAllInputValues('delivery_price')"
                                                                title="{{ __('company::dashboard.delivery_charges.update.btn.copy') }}">
                                                                <i class="fa fa-copy"></i>
                                                            </button>
                                                        </th>
                                                        <th style="width: 550px">
                                                            <span>{{ __('company::dashboard.delivery_charges.update.delivery_time') }}</span>

                                                            <button type="button" class="btn btn-success btn-sm pull-right"
                                                                onclick="copyToAllInputValues('delivery_time')"
                                                                title="{{ __('company::dashboard.delivery_charges.update.btn.copy') }}">
                                                                <i class="fa fa-copy"></i>
                                                            </button>

                                                            @foreach (config('translatable.locales') as $k => $code)
                                                                <button type="button"
                                                                    class="btn btn-{{ locale() == $code ? 'info' : 'default' }} btn-sm pull-right deliveryTimeLangBtn deliveryTimeBtnLang-{{ $code }}"
                                                                    onclick="toggleDelivertTimeLang('{{ $code }}')">
                                                                    {{ $code }}
                                                                </button>
                                                                <input type="hidden" class="hiddenSelectedDeliveryTimeLang"
                                                                    value="{{ locale() }}" />
                                                            @endforeach

                                                        </th>
                                                        <th>
                                                            <span>{{ __('company::dashboard.delivery_charges.update.min_order_amount') }}</span>
                                                            <button type="button" class="btn btn-success btn-sm pull-right"
                                                                onclick="copyToAllInputValues('min_order_amount')"
                                                                title="{{ __('company::dashboard.delivery_charges.update.btn.copy') }}">
                                                                <i class="fa fa-copy"></i>
                                                            </button>
                                                        </th>
                                                        <th style="width: 140px;">
                                                            <span>{{ __('company::dashboard.delivery_charges.update.status') }}</span>
                                                            <div class="pull-right"
                                                                title="{{ __('company::dashboard.delivery_charges.update.btn.activate_all') }}">
                                                                <input type="checkbox"
                                                                    class="make-switch makeAllActiveCheckbox"
                                                                    data-size="small" name="active_all_statuses">
                                                            </div>
                                                        </th>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($city2->states as $key3 => $state)
                                                            <tr>
                                                                <td>{{ $state->title }}</td>
                                                                <td>
                                                                    <input type="text" name="delivery[]"
                                                                        class="form-control delivery-price-input"
                                                                        value="{{ !array_key_exists($state->id, $charges) ? '' : $charges[$state->id] }}"
                                                                        placeholder="{{ __('company::dashboard.delivery_charges.update.charge') }}">
                                                                    <input type="hidden" name="state[]"
                                                                        value="{{ $state->id }}">
                                                                </td>
                                                                <td>
                                                                    @foreach (config('translatable.locales') as $k => $code)
                                                                        @php
                                                                            $deliveryNoteObject = collect($times)
                                                                                ->where('state_id', $state->id)
                                                                                ->first();
                                                                        @endphp
                                                                        <input type="text"
                                                                            style="display: {{ locale() == $code ? 'block' : 'none' }}"
                                                                            name="delivery_time[{{ $state->id }}][{{ $code }}]"
                                                                            class="form-control delivery-time-input delivery-time-input-lang-{{ $code }}"
                                                                            value="{{ !is_null($deliveryNoteObject) ? $deliveryNoteObject['delivery_time'][$code] ?? '' : '' }}"
                                                                            placeholder="{{ __('company::dashboard.delivery_charges.update.time') . ' - ' . $code }}">
                                                                        <div class="help-block"></div>
                                                                    @endforeach
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="min_order_amount[]"
                                                                        class="form-control min-order-amount-input"
                                                                        value="{{ !array_key_exists($state->id, $min_order_amounts) ? '' : $min_order_amounts[$state->id] }}"
                                                                        placeholder="{{ __('company::dashboard.delivery_charges.update.min_order_amount') }}">
                                                                </td>
                                                                <td>
                                                                    <input type="checkbox"
                                                                        class="make-switch delivery-status-input"
                                                                        data-size="small"
                                                                        name="status[{{ $state->id }}]"
                                                                        {{ array_key_exists($state->id, $statuses) && $statuses[$state->id] == 1 ? 'checked' : '' }}>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                {{-- END UPDATE FORM --}}
                            </div>

                            @if (in_array('schedule', $company->delivery_time_types ?? []))
                                <div class="tab-content" id="deliveryTimesTabContent">
                                    @include('company::dashboard.delivery-times._edit_times')

                                </div>
                            @endif

                        </div>

                        {{-- PAGE ACTION --}}
                        <div class="col-md-12">
                            <div class="form-actions">
                                @include('apps::dashboard.layouts._ajax-msg')
                                <div class="form-group">
                                    <button type="submit" id="submit" class="btn btn-lg green">
                                        {{ __('apps::dashboard.general.edit_btn') }}
                                    </button>
                                    <a href="{{ url(route('dashboard.delivery-charges.index')) }}"
                                        class="btn btn-lg red">
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
@section('scripts')
    <script>
        $(function() {

            $('.accordionTab').collapse({
                toggle: false
            });

            $('#vendorDeliveryTimesTab').on('click', function() {
                $('.li-state').removeClass('active');
                $('#deliveryStatesTabContent').hide();
                $('#deliveryTimesTabContent').show();
            });

            $('.li-state').on('click', function() {
                $('#vendorDeliveryTimesTab').removeClass('active');
                $('#deliveryTimesTabContent').hide();
                $('#deliveryStatesTabContent').show();
            });
        });
    </script>

    <script>
        jQuery(document).ready(function() {
            $('.makeAllActiveCheckbox').on('switchChange.bootstrapSwitch', function(e) {
                $('.makeAllActiveCheckbox').not(this).prop('checked', e.target.checked).change();
                $('.delivery-status-input').each(function(event) {
                    $(this).prop('checked', e.target.checked).change();
                });
            });
        });

        function copyToAllInputValues(type) {
            if (type == 'delivery_time') {
                var deliveryTimeInputVal = $('#updateForm').find('.delivery-time-input').filter(':visible:first').val();
                var lang = $('.hiddenSelectedDeliveryTimeLang').val();
                $('.delivery-time-input-lang-' + lang).each(function() {
                    $(this).val(deliveryTimeInputVal);
                });
            } else if (type == 'delivery_price') {
                var deliveryPriceInputVal = $('#updateForm').find('.delivery-price-input').filter(':visible:first').val();
                $('.delivery-price-input').each(function() {
                    $(this).val(deliveryPriceInputVal);
                });
            } else if (type == 'min_order_amount') {
                var deliveryMinOrderAmountInputVal = $('#updateForm').find('.min-order-amount-input').filter(
                    ':visible:first').val();
                $('.min-order-amount-input').each(function() {
                    $(this).val(deliveryMinOrderAmountInputVal);
                });
            }
        }

        function toggleDelivertTimeLang(code) {
            $('.hiddenSelectedDeliveryTimeLang').val(code);
            $('.deliveryTimeLangBtn').each(function() {
                $(this).removeClass('btn-info');
                $(this).addClass('btn-default');
                $('.delivery-time-input').hide();
            });
            $('.deliveryTimeBtnLang-' + code).addClass('btn-info');
            $('.delivery-time-input-lang-' + code).show();
        }
    </script>

    <script>
        var timePicker = $(".timepicker");
        timePicker.timepicker({
            timeFormat: 'HH',
        });

        var rowCountsArray = [];

        function hideCustomTime(id) {
            $("#collapse-" + id).hide();
        }

        function showCustomTime(id) {
            $("#collapse-" + id).show();
        }

        function addMoreDayTimes(e, dayCode) {

            if (e.preventDefault) {
                e.preventDefault();
            } else {
                e.returnValue = false;
            }

            var rowCount = Math.floor(Math.random() * 9000000000) + 1000000000;
            rowCountsArray.push(rowCount);

            var divContent = $('#div-content-' + dayCode);
            var newRow = `
            <div class="row times-row" id="rowId-${dayCode}-${rowCount}">
                <div class="col-md-3">
                    <div class="input-group">
                        <input type="text" class="form-control timepicker 24_format" name="availability[time_from][${dayCode}][]"
                               data-name="availability[time_from][${dayCode}][]" value="00">
                        <span class="input-group-btn">
                            <button class="btn default" type="button">
                                <i class="fa fa-clock-o"></i>
                            </button>
                        </span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="input-group">
                        <input type="text" class="form-control timepicker 24_format" name="availability[time_to][${dayCode}][]"
                               data-name="availability[time_to][${dayCode}][]" value="23">
                        <span class="input-group-btn">
                            <button class="btn default" type="button">
                                <i class="fa fa-clock-o"></i>
                            </button>
                        </span>
                    </div>
                </div>
                <div class="col-md-3">
                    <button type="button" class="btn btn-danger" onclick="removeDayTimes('${dayCode}', ${rowCount}, 'row')">X</button>
                </div>
            </div>
            `;

            divContent.append(newRow);

            $(".timepicker").timepicker({
                timeFormat: 'HH',
            });
        }

        function removeDayTimes(dayCode, index, flag = '') {

            if (flag === 'row') {
                $('#rowId-' + dayCode + '-' + index).remove();
                const i = rowCountsArray.indexOf(index);
                if (i > -1) {
                    rowCountsArray.splice(i, 1);
                }
            }

        }
    </script>
@stop
