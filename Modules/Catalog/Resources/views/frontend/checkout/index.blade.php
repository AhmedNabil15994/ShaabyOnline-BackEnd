@extends('apps::frontend.layouts.master')
@section('title', __('catalog::frontend.checkout.index.title'))

@section('externalStyle')
    <style>
        /* start loader style */

        #checkoutInformationLoaderDiv {
            display: none;
            margin: 15px auto;
            justify-content: center;
        }

        #deliveryPriceLoaderDiv {
            display: none;
            margin: 15px 112px;
            justify-content: center;
        }

        #checkoutInformationLoaderDiv .my-loader,
        #deliveryPriceLoaderDiv .my-loader {
            border: 10px solid #f3f3f3;
            border-radius: 50%;
            border-top: 10px solid #3498db;
            width: 70px;
            height: 70px;
            -webkit-animation: spin 2s linear infinite;
            /* Safari */
            animation: spin 2s linear infinite;
        }

        /* end loader style */
    </style>
@endsection

@section('content')

    <div class="container">
        <div class="page-crumb mt-30">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('frontend.home') }}">
                            <i class="ti-home"></i> {{ __('apps::frontend.nav.home_page') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('frontend.shopping-cart.index') }}">{{ __('catalog::frontend.cart.title') }}</a>
                    </li>
                    <li class="breadcrumb-item active text-muted" aria-current="page">
                        {{ __('catalog::frontend.checkout.index.title') }}
                    </li>
                </ol>
            </nav>
        </div>
        <div class="inner-page">

            @include('apps::frontend.layouts._alerts')

            <form method="post" action="{{ route('frontend.orders.create_order') }}">
                @csrf
                @if (auth()->user())
                    <input type="hidden" name="address_type" id="checkoutAddressType" value="selected_address">
                @else
                    <input type="hidden" name="address_type" id="checkoutAddressType" value="known_address">
                @endif

                <input type="hidden" id="selectedStateFromAddress"
                    value="{{ get_cookie_value(config('core.config.constants.ORDER_STATE_ID')) ?? 0 }}">

                <div class="row">

                    <div class="col-md-8">
                        <div class="cart-inner">

                            @if (auth()->check())
                                <div class="previous-address">
                                    <h4 class="margin-bottom-20"> {{ __('catalog::frontend.checkout.address.title') }} </h4>

                                    {{-- <input type="hidden" name="selected_address_id"> --}}

                                    @foreach (auth()->user()->addresses as $k => $address)
                                        <div class="checkboxes address-block radios margin-bottom-20">
                                            <input type="radio" class="" name="selected_address_id"
                                                value="{{ $address->id }}" id="checkoutSelectedAddress-{{ $address->id }}"
                                                @if (!is_null(Cart::getCondition('company_delivery_fees'))) {{ Cart::getCondition('company_delivery_fees')->getAttributes()['address_id'] == $address->id ? 'checked' : '' }}
                                    @else {{ old('selected_address_id') == $address->id ? 'checked' : '' }} @endif
                                                onclick="getDeliveryPriceOnStateChanged('{{ $address->state_id }}', '{{ $address->id }}')">
                                            <label class="" for="checkoutSelectedAddress-{{ $address->id }}">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-1">

                                                        <p class="d-flex">
                                                            <span class="d-inline-block right-side text-secondary">
                                                                {{ __('catalog::frontend.checkout.address.form.address_name') }}
                                                                :
                                                            </span>
                                                            <span class="d-inline-block left-side">
                                                                {{ $address->state->title }}
                                                            </span>
                                                        </p>

                                                        @if ($address->street)
                                                            <p class="d-flex">
                                                                <span class="d-inline-block right-side text-secondary">
                                                                    {{ __('catalog::frontend.checkout.address.form.street') }}
                                                                    :
                                                                </span>
                                                                <span
                                                                    class="d-inline-block left-side">{{ $address->street }}</span>
                                                            </p>
                                                        @endif

                                                        @if ($address->mobile)
                                                            <p class="d-flex">
                                                                <span class="d-inline-block right-side text-secondary">
                                                                    {{ __('catalog::frontend.checkout.address.form.mobile') }}
                                                                    :
                                                                </span>
                                                                <span class="d-inline-block left-side">
                                                                    {{ $address->mobile }} </span>
                                                            </p>
                                                        @endif

                                                    </div>

                                                    {{-- <div class="justify-content-end address-operations">
                                                                    <a href="#" class="btn link-muted" data-toggle="modal"
                                                                       data-target="#exampleModalLong">
                                                                        <i class="ti-pencil"></i>
                                                                        Edit
                                                                    </a>
                                                                </div> --}}

                                                </div>
                                            </label>
                                        </div>
                                    @endforeach

                                    <div class="margin-bottom-20 text-right">
                                        <a href="#" class="new-add" data-toggle="modal"
                                            data-target="#createNewAddressModal">
                                            <i class="ti-plus"></i>
                                            {{ __('user::frontend.addresses.create.title') }}
                                        </a>
                                    </div>
                                </div>
                            @else
                                <div class="margin-bottom-20 text-center">
                                    @if (env('LOGIN'))
                                        <a href="{{ route('frontend.login', ['type' => 'checkout']) }}" class="new-add">
                                            <i class="fa fa-user"></i>
                                            {{ __('catalog::frontend.checkout.create_account') }}
                                        </a>
                                    @endif
                                </div>

                                <div class="panel panel-default mt-3">
                                    <div class="panel-heading panel-heading-custom">
                                        <h4 class="panel-title">
                                            {{ __('user::frontend.addresses.create.title') }}
                                        </h4>
                                    </div>
                                    <div class="panel-body">

                                        @include('area::frontend.shared._area_tree')

                                        <div class="row">
                                            {{-- <div class="col-md-6 col-12">
                                                 <div class="form-group">
                                                     <select class="select-detail select2 form-control" id="selectState"
                                                             name="state_id"
                                                             onchange="onStateChanged(event.target.value)">
                                                         <option>{{ __('user::frontend.addresses.form.states') }}
                                                    </option>
                                                    @if (isset($states) && count($states) > 0)
                                                    @foreach ($states as $state)

                                                    <option value="{{$state->id}}"
                                                        @if (!is_null(Cart::getCondition('company_delivery_fees')))
                                                        {{ Cart::getCondition('company_delivery_fees')->getAttributes()['state_id'] == $state->id ? 'selected' : '' }}
                                                        @else {{ old('state_id') == $state->id ? 'selected' : '' }} @endif>
                                                        {{ $state->title }}
                                                    </option>

                                                    @endforeach
                                                    @endif
                                                    </select>
                                                </div>
                                            </div> --}}

                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <input type="text" class="form-control" name="username"
                                                        value="{{ old('username') }}" autocomplete="off"
                                                        placeholder="{{ __('user::frontend.addresses.form.username') }}" />
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <input type="text" class="form-control" value="{{ old('mobile') }}"
                                                        name="mobile" id="txtMobile"
                                                        placeholder="{{ __('user::frontend.addresses.form.mobile') }}"
                                                        autocomplete="off" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <input type="text" value="{{ old('block') }}" class="form-control"
                                                        name="block" id="txtBlock"
                                                        placeholder="{{ __('user::frontend.addresses.form.block') }}"
                                                        autocomplete="off" />
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <input type="text" value="{{ old('building') }}"
                                                        class="form-control" name="building" id="txtBuilding"
                                                        placeholder="{{ __('user::frontend.addresses.form.building') }}"
                                                        autocomplete="off" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <input type="text" name="avenue" value="{{ old('avenue') }}"
                                                        autocomplete="off" class="form-control"
                                                        placeholder="{{ __('user::frontend.addresses.form.avenue') }}" />
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <input type="text" name="floor" value="{{ old('floor') }}"
                                                        autocomplete="off" class="form-control"
                                                        placeholder="{{ __('user::frontend.addresses.form.floor') }}" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <input type="text" name="flat" value="{{ old('flat') }}"
                                                        autocomplete="off" class="form-control"
                                                        placeholder="{{ __('user::frontend.addresses.form.flat') }}" />
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <input type="text" name="automated_number"
                                                        value="{{ old('automated_number') }}" autocomplete="off"
                                                        class="form-control"
                                                        placeholder="{{ __('user::frontend.addresses.form.automated_number') }}" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12 col-12">
                                                <div class="form-group">
                                                    <input type="text" value="{{ old('street') }}" name="street"
                                                        class="form-control" id="txtStreet"
                                                        placeholder="{{ __('user::frontend.addresses.form.street') }}"
                                                        autocomplete="off" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12 col-12">
                                                <div class="form-group">
                                                    <textarea name="address" id="txtAddress" rows="5" class="form-control"
                                                        placeholder="{{ __('user::frontend.addresses.form.additional_instructions') }}">{{ old('address') }}</textarea>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            @endif

                            {{-- Start - Hide Shipping Company In This Project --}}
                            @if (!empty($deliveryTimes))
                                <div class="time-delivery choose-companies mt-20 pt-30">

                                    <h2 class="cart-title">
                                        {{ __('catalog::frontend.checkout.companies.choose_delivery_time') }}
                                    </h2>

                                    @if (!empty($deliveryTimes['supported_types']))
                                        @foreach ($deliveryTimes['supported_types'] as $type)
                                            <label>
                                                <input type="radio" class="delivery_type_radio"
                                                    id="delivery_type_{{ $type }}" name="shipping[type]"
                                                    {{ old('shipping.type') == $type ? 'checked' : '' }}
                                                    value="{{ $type }}">
                                                {{ __('catalog::frontend.checkout.delivery_time_types.' . $type) ?? $type }}
                                            </label>
                                        @endforeach
                                    @endif

                                    <input type="hidden" name="shipping[day]" value="{{ old('shipping.day') ?? '' }}">
                                    <input type="hidden" name="shipping[date]" value="{{ old('shipping.date') ?? '' }}">

                                    <div id="scheduleContent"
                                        style="margin-top: 10px; display: {{ old('shipping.type') == 'schedule' ? 'block' : 'none' }}">
                                        @if (in_array('schedule', $deliveryTimes['supported_types']) &&
                                            isset($deliveryTimes['data']['schedule']) &&
                                            !empty($deliveryTimes['data']['schedule']))

                                            <div
                                                class="nav nav-pills choose-day d-flex align-items-center text-center mb-30">

                                                @foreach ($deliveryTimes['data']['schedule'] as $k => $day)
                                                    <a data-toggle="pill" href="#menu-{{ $day['day_code'] }}"
                                                        class="day-block  day-block-company deliveryDay-{{ $day['day_code'] }}
                                                {{ old('shipping.day') == $day['day_code'] ? 'active' : '' }}"
                                                        onclick="chooseCompanyDeliveryDay('{{ $deliveryProviderId }}', '{{ $day['day_code'] }}', '{{ $day['date'] }}')"
                                                        data-companyName="{{ $deliveryProviderId }}"
                                                        data-dayCode="{{ $day['day_code'] }}" data-state-value="0">
                                                        <span class="d-block">{{ $day['date'] }}</span>
                                                        {{ $day['day_name'] }}
                                                    </a>
                                                @endforeach

                                            </div>

                                            <div class="tab-content" id="tab-content-times">

                                                @foreach ($deliveryTimes['data']['schedule'] as $k => $day)
                                                    <div id="menu-{{ $day['day_code'] }}"
                                                        class="tab-pane fade {{ old('shipping.day') == $day['day_code'] ? 'show active' : '' }}">
                                                        <div class="panel panel-default">
                                                            <div class="panel-body">

                                                                <div class="choose-time comp-time">
                                                                    @if (!empty($day['times']))
                                                                        @foreach ($day['times'] as $i => $time)
                                                                            <div class="radios mb-20">

                                                                                <input type="hidden"
                                                                                    name="shipping[{{ $day['day_code'] }}][time_from]"
                                                                                    value="{{ old('shipping.' . $day['day_code'] . '.time_from') ?? $time['time_from'] }}">
                                                                                <input type="hidden"
                                                                                    name="shipping[{{ $day['day_code'] }}][time_to]"
                                                                                    value="{{ old('shipping.' . $day['day_code'] . '.time_to') ?? $time['time_to'] }}">

                                                                                <label>
                                                                                    <input type="radio"
                                                                                        class="time-radio-btn"
                                                                                        id="time_{{ $day['day_code'] }}_{{ $i }}"
                                                                                        name="delivered_time_{{ $day['day_code'] }}"
                                                                                        value="{{ $time['time_from'] . '_' . $time['time_to'] }}"
                                                                                        {{ old('delivered_time_' . $day['day_code']) == $time['time_from'] . '_' . $time['time_to'] ? 'checked' : '' }}>
                                                                                    {{ __('catalog::frontend.checkout.companies.times.from') . ': ' . $time['time_from'] . ' - ' . __('catalog::frontend.checkout.companies.times.to') . ': ' . $time['time_to'] }}
                                                                                </label>
                                                                            </div>
                                                                        @endforeach
                                                                    @else
                                                                        <b>{{ __('catalog::frontend.checkout.validation.delivery_time.not_found') }}</b>
                                                                    @endif
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach

                                            </div>

                                        @endif
                                    </div>

                                    <div id="directContent"
                                        style="margin-top: 10px; display: {{ old('shipping.type') == 'direct' ? 'block' : 'none' }}">
                                        @if (in_array('direct', $deliveryTimes['supported_types']))
                                            {{ $deliveryTimes['data']['direct'] ?? '' }}
                                        @endif
                                    </div>

                                </div>
                            @endif
                            {{-- End - Hide Shipping Company In This Project --}}

                        </div>
                    </div>
                    <div class="col-md-4">
                        @include('catalog::frontend.shopping-cart._total-side')
                    </div>

                </div>

            </form>

        </div>
    </div>

    @if (auth()->check())
        <div class="modal fade" id="createNewAddressModal" tabindex="-1" role="dialog"
            aria-labelledby="createNewAddressModalTitle" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">
                            {{ __('user::frontend.addresses.create.title') }}
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form class="mt-20" method="post" action="{{ route('frontend.profile.address.store') }}">
                            @csrf

                            @include('area::frontend.shared._area_tree')

                            <div class="row">

                                {{-- <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <select class="select-detail select2 form-control" name="state">
                                        <option>{{ __('user::frontend.addresses.form.states') }}</option>
                        @if (isset($states) && count($states) > 0)
                        @foreach ($states as $state)

                        <option value="{{$state->id}}" @if (!is_null(Cart::getCondition('company_delivery_fees')))
                            {{ Cart::getCondition('company_delivery_fees')->getAttributes()['state_id'] == $state->id ? 'selected' : '' }}
                            @else {{ old('state_id') == $state->id ? 'selected' : '' }} @endif>
                            {{ $state->title }}
                        </option>

                        @endforeach
                        @endif
                        </select>
                    </div>
            </div> --}}

                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="username"
                                            value="{{ old('username') }}" autocomplete="off"
                                            placeholder="{{ __('user::frontend.addresses.form.username') }}" />
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <input type="text" class="form-control" value="{{ old('mobile') }}"
                                            name="mobile" id="txtMobile"
                                            placeholder="{{ __('user::frontend.addresses.form.mobile') }}"
                                            autocomplete="off" />
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <input type="text" value="{{ old('block') }}" class="form-control"
                                            name="block" id="txtBlock"
                                            placeholder="{{ __('user::frontend.addresses.form.block') }}"
                                            autocomplete="off" />
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <input type="text" value="{{ old('building') }}" class="form-control"
                                            name="building" id="txtBuilding"
                                            placeholder="{{ __('user::frontend.addresses.form.building') }}"
                                            autocomplete="off" />
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <input type="text" name="avenue" value="{{ old('avenue') }}"
                                            autocomplete="off" class="form-control"
                                            placeholder="{{ __('user::frontend.addresses.form.avenue') }}" />
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <input type="text" name="floor" value="{{ old('floor') }}"
                                            autocomplete="off" class="form-control"
                                            placeholder="{{ __('user::frontend.addresses.form.floor') }}" />
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <input type="text" name="flat" value="{{ old('flat') }}"
                                            autocomplete="off" class="form-control"
                                            placeholder="{{ __('user::frontend.addresses.form.flat') }}" />
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <input type="text" name="automated_number"
                                            value="{{ old('automated_number') }}" autocomplete="off"
                                            class="form-control"
                                            placeholder="{{ __('user::frontend.addresses.form.automated_number') }}" />
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 col-12">
                                    <div class="form-group">
                                        <input type="text" value="{{ old('street') }}" name="street"
                                            class="form-control" id="txtStreet"
                                            placeholder="{{ __('user::frontend.addresses.form.street') }}"
                                            autocomplete="off" />
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 col-12">
                                    <div class="form-group">
                                        <textarea name="address" id="txtAddress" rows="5" class="form-control"
                                            placeholder="{{ __('user::frontend.addresses.form.additional_instructions') }}">{{ old('address') }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-20 mt-20 text-left">
                                <button type="submit" class="btn btn-them">
                                    {{ __('user::frontend.profile.index.btn_add_new_address') }} </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif

@endsection

@section('externalJs')

    <script>
        // $('.checkout-choose-address').on('click', function (e) {
        //     var addressType = $(this).attr('data-name');
        //     if ($(this).attr('data-click-state') == 0) {
        //         $(this).attr('data-click-state', 1);
        //         $('#checkoutAddressType').val(addressType);
        //     } else {
        //         $(this).attr('data-click-state', 0);
        //         $('#checkoutAddressType').val('');
        //     }
        // });

        function onStateChanged(val) {
            $('#selectedStateFromAddress').val(val);
            getDeliveryPriceOnStateChanged($('#selectedStateFromAddress').val());
        }

        /*function selectPreviousAddress(addressId) {
            var selectedAddressId = $("input[name='selected_address_id']"),
                checkoutSelectedAddress = $('#checkoutSelectedAddress-' + addressId),
                thisID = '#checkoutSelectedAddress-' + addressId;

            selectedAddressId.val('');

            if (checkoutSelectedAddress.attr('data-click-state') == 0) {
                checkoutSelectedAddress.attr('data-click-state', 1);
                $(`.address-item:not(${thisID})`).attr('data-click-state', 0);
                selectedAddressId.val(addressId);
            } else {
                $('.address-item').attr('data-click-state', 0);
                selectedAddressId.val('');
            }
        }*/

        function checkoutSelectCompany(vendorId, companyId) {
            var thisID = '#checkVendorCompany-' + vendorId + '-' + companyId;
            var stateId = $('#selectedStateFromAddress').val();

            // START TO make radio button selected
            $(`.check-${vendorId}`).prop('checked', false);
            $('.vendor-company-' + vendorId + '-' + companyId).toggleClass("cut-radio-style");
            $(`.checkout-company-${vendorId}:not(${thisID})`).removeClass("cut-radio-style");
            // END TO make radio button selected

            if ($('#checkVendorCompany-' + vendorId + '-' + companyId).attr('data-state') == 0) {
                $('.checkout-company-' + vendorId).attr('data-state', 0);
                $('#checkVendorCompany-' + vendorId + '-' + companyId).attr('data-state', 1);
                // $(`.checkout-company:not(${thisID})`).attr('data-state', 0);
                $("input[name='vendor_company[" + vendorId + "]']").val(companyId);

                getStateDeliveryPrice(vendorId, companyId, stateId, 'checked');

            } else {
                $('.checkout-company-' + vendorId).attr('data-state', 0);
                $("input[name='vendor_company[" + vendorId + "]']").val('');
                getStateDeliveryPrice(vendorId, companyId, stateId, 'un_checked');
            }

        }

        function chooseCompanyDeliveryDay(companyId, dayCode, dayDate) {

            // $('.day-block-company').not('.deliveryDay-' + dayCode).removeClass('active');
            // $('.deliveryDay-' + dayCode).toggleClass("active");
            // console.log('toggle::', $('.deliveryDay-' + dayCode).toggleClass("active"));

            $(this).toggleClass("active");
            $('#tab-content-times > div').removeClass('active show');
            $('#menu-' + dayCode).addClass('active show');

            if ($('.deliveryDay-' + dayCode).attr('data-state-value') == 0) {
                $('.day-block-company').attr('data-state-value', 0);
                $('.deliveryDay-' + dayCode).attr('data-state-value', 1);
                $("input[name='shipping[day]']").val(dayCode);
                $("input[name='shipping[date]']").val(dayDate);
            } else {
                $('.day-block-company').attr('data-state-value', 0);
                $("input[name='shipping[day]']").val('');
                $("input[name='shipping[date]']").val('');
            }

        }

        /*function chooseCompanyDeliveryDay(vendorId, companyId, dayCode) {
                $('.day-block-' + vendorId + '-' + companyId).not('.deliveryDay-' + vendorId + '-' + companyId + '-' + dayCode).removeClass('active');
                $('.deliveryDay-' + vendorId + '-' + companyId + '-' + dayCode).toggleClass("active");

            if ($('.deliveryDay-' + vendorId + '-' + companyId + '-' + dayCode).attr('data-state-value') == 0) {
                $('.day-block-' + vendorId + '-' + companyId).attr('data-state-value', 0);
                $('.deliveryDay-' + vendorId + '-' + companyId + '-' + dayCode).attr('data-state-value', 1);
                $("input[name='vendor_company_day[" + vendorId + "][" + companyId + "]']").val(dayCode);
            } else {
                $('.day-block-' + vendorId + '-' + companyId).attr('data-state-value', 0);
                $("input[name='vendor_company_day[" + vendorId + "][" + companyId + "]']").val('');
            }

        }*/

        function getStateDeliveryPrice(vendorId, companyId, stateId, type) {
            var data = {
                'vendor_id': vendorId,
                'company_id': companyId,
                'state_id': stateId,
                'type': type,
            };
            getDeliveryPrice(data, stateId, type, vendorId, companyId);
        }

        function getDeliveryPriceOnStateChanged(stateId, addressId = null) {
            var type = 'selected_state',
                data = {
                    'state_id': stateId,
                    'address_id': addressId,
                    'company_id': $("input[name='shipping_company[id]']").val(),
                    'type': type,
                };
            getDeliveryPrice(data, stateId, type);
        }

        function getDeliveryPrice(data, stateId, type, vendorId = null, companyId = null) {

            $('#deliveryPriceLoaderDiv').show();
            var deliveryPriceRow;

            $.ajax({
                method: "GET",
                url: '{{ route('frontend.checkout.get_state_delivery_price') }}',
                data: data,
                beforeSend: function() {},
                success: function(data) {
                    var totalCompaniesDeliveryPrice = $('#totalCompaniesDeliveryPrice');

                    if (type === 'selected_state') {

                        $('.checkedCompanyInput').prop('checked', false);
                        $('.checkedCompany').removeClass("cut-radio-style");
                        $('.checkedCompany').attr('data-state', 0);
                        $(".vendor-company-input").val('');

                        deliveryPriceRow = `
                                <div class="d-flex margin-bottom-20 align-items-center mb-3">
                                    <span class="d-inline-block right-side flex-1"> {{ __('catalog::frontend.checkout.shipping') }}</span>
                                    <span class="d-inline-block left-side"
                                          id="totalDeliveryPrice">${data.data.totalDeliveryPrice} {{ __('apps::frontend.master.kwd') }}</span>
                                </div>
                                <div class="d-flex margin-bottom-20 align-items-center mb-3">
                                    <span class="d-inline-block right-side flex-1"> {{ __('catalog::frontend.checkout.delivery_time_note') }}</span>
                                    <span class="d-inline-block left-side"
                                          id="deliveryTimeNote">${data.data.delivery_time_note}</span>
                                </div>
                                `;
                        totalCompaniesDeliveryPrice.html(deliveryPriceRow);

                    } else {

                        if (data.data.price != null) {
                            deliveryPriceRow = `
                                <div class="d-flex margin-bottom-20 align-items-center mb-3">
                                    <span class="d-inline-block right-side flex-1"> {{ __('catalog::frontend.checkout.shipping') }}</span>
                                    <span class="d-inline-block left-side"
                                          id="totalDeliveryPrice">${data.data.totalDeliveryPrice} {{ __('apps::frontend.master.kwd') }}</span>
                                </div>
                                <div class="d-flex margin-bottom-20 align-items-center mb-3">
                                    <span class="d-inline-block right-side flex-1"> {{ __('catalog::frontend.checkout.delivery_time_note') }}</span>
                                    <span class="d-inline-block left-side"
                                          id="deliveryTimeNote">${data.data.delivery_time_note}</span>
                                </div>
                                `;
                            totalCompaniesDeliveryPrice.html(deliveryPriceRow);
                        }

                    }

                },
                error: function(data) {
                    $('#deliveryPriceLoaderDiv').hide();
                    // $('#btnCheckoutSaveInformation').show();
                    displayErrorsMsg(data);

                    var getJSON = $.parseJSON(data.responseText);

                    if (getJSON.data.price == null) {

                        if (type !== 'selected_state') {
                            $('#check-vendor-company-' + vendorId + '-' + companyId).prop('checked', false);
                            $('.checkout-company-' + vendorId).removeClass("cut-radio-style");
                            $("input[name='vendor_company[" + vendorId + "]']").val('');
                        }

                        var totalCompaniesDeliveryPrice = $('#totalCompaniesDeliveryPrice');
                        deliveryPriceRow = `
                                <div class="d-flex margin-bottom-20 align-items-center mb-3">
                                    <span class="d-inline-block right-side flex-1"> {{ __('catalog::frontend.checkout.shipping') }}</span>
                                    <span class="d-inline-block left-side"
                                          id="totalDeliveryPrice">${data.data.totalDeliveryPrice} {{ __('apps::frontend.master.kwd') }}</span>
                                </div>
                                `;
                        totalCompaniesDeliveryPrice.html(deliveryPriceRow);
                    }
                },
                complete: function(data) {
                    $('#deliveryPriceLoaderDiv').hide();
                    var getJSON = $.parseJSON(data.responseText);
                    if (getJSON.data) {
                        $('#cartTotalAmount').html(getJSON.data.total +
                            " {{ __('apps::frontend.master.kwd') }}");
                    }
                },
            });
        }

        $('.delivery_type_radio').on('change', function(e) {
            if (this.value == 'schedule') {
                $('#scheduleContent').show();
                $('#directContent').hide();
            } else if (this.value == 'direct') {
                $('#directContent').show();
                $('#scheduleContent').hide();
            } else {
                $('#directContent').hide();
                $('#scheduleContent').hide();
            }
        });

        {{-- function saveCheckoutInformation(action) { --}}

        {{-- var vData = {}, selectedAddressId = null; --}}
        {{-- var checkoutAddressType = $('#checkoutAddressType').val(); --}}
        {{-- var receiverName = $('#txtReceiverName').val(); --}}
        {{-- var receiverMobile = $('#txtReceiverMobile').val(); --}}

        {{-- var selectState = $('#selectState').val(); --}}
        {{-- var txtBuilding = $('#txtBuilding').val(); --}}
        {{-- var txtBlock = $('#txtBlock').val(); --}}
        {{-- var txtStreet = $('#txtStreet').val(); --}}
        {{-- var txtAddress = $('#txtAddress').val(); --}}

        {{-- $('#btnCheckoutSaveInformation').hide(); --}}
        {{-- $('#checkoutInformationLoaderDiv').show(); --}}

        {{-- $(".address-item").each(function () { --}}
        {{-- if ($(this).hasClass("active") === true) { --}}
        {{-- selectedAddressId = $(this).attr('data-id'); --}}
        {{-- } --}}
        {{-- }); --}}

        {{-- if (checkoutAddressType === 'unknown_address') { --}}
        {{-- vData = { --}}
        {{-- "receiver_name": receiverName, --}}
        {{-- "receiver_mobile": receiverMobile, --}}
        {{-- }; --}}
        {{-- } else if (checkoutAddressType === 'known_address') { --}}
        {{-- vData = { --}}
        {{-- "state_id": selectState, --}}
        {{-- "building": txtBuilding, --}}
        {{-- "block": txtBlock, --}}
        {{-- "street": txtStreet, --}}
        {{-- "address": txtAddress, --}}
        {{-- }; --}}
        {{-- } else if (checkoutAddressType === 'selected_address') { --}}
        {{-- vData = { --}}
        {{-- "selected_address_id": selectedAddressId, --}}
        {{-- }; --}}
        {{-- } --}}

        {{-- vData['address_type'] = checkoutAddressType; --}}
        {{-- vData['_token'] = '{{ csrf_token() }}'; --}}

        {{-- $.ajax({ --}}
        {{-- method: "POST", --}}
        {{-- url: action, --}}
        {{-- data: vData, --}}
        {{-- beforeSend: function () { --}}
        {{-- }, --}}
        {{-- success: function (data) { --}}
        {{-- /*var params = { --}}
        {{-- 'productId': productId, --}}
        {{-- 'productImage': productImage, --}}
        {{-- 'productTitle': productTitle, --}}
        {{-- 'productQuantity': data.data.productQuantity, --}}
        {{-- 'productPrice': data.data.productPrice, --}}
        {{-- 'productDetailsRoute': data.data.productDetailsRoute, --}}
        {{-- 'cartCount': data.data.cartCount, --}}
        {{-- 'cartSubTotal': data.data.subTotal, --}}
        {{-- }; --}}
        {{-- updateHeaderCart(params);*/ --}}

        {{-- displaySuccessMsg(data['message']); --}}
        {{-- }, --}}
        {{-- error: function (data) { --}}
        {{-- $('#checkoutInformationLoaderDiv').hide(); --}}
        {{-- $('#btnCheckoutSaveInformation').show(); --}}
        {{-- displayErrorsMsg(data); --}}
        {{-- }, --}}
        {{-- complete: function (data) { --}}
        {{-- $('#checkoutInformationLoaderDiv').hide(); --}}
        {{-- $('#btnCheckoutSaveInformation').show(); --}}
        {{-- }, --}}
        {{-- }); --}}
        {{-- } --}}
    </script>

@endsection
