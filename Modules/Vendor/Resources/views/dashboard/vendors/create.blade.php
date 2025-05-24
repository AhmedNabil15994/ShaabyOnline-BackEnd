@extends('apps::dashboard.layouts.app')
@section('title', __('vendor::dashboard.vendors.create.title'))
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
                        <a href="{{ url(route('dashboard.vendors.index')) }}">
                            {{ __('vendor::dashboard.vendors.index.title') }}
                        </a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <a href="#">{{ __('vendor::dashboard.vendors.create.title') }}</a>
                    </li>
                </ul>
            </div>

            <h1 class="page-title"></h1>

            <div class="row">
                <form id="form" role="form" class="form-horizontal form-row-seperated" method="post"
                    enctype="multipart/form-data" action="{{ route('dashboard.vendors.store') }}">
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
                                                    <a href="#global_setting" data-toggle="tab">
                                                        {{ __('vendor::dashboard.vendors.create.form.general') }}
                                                    </a>
                                                </li>

                                                <li class="">
                                                    <a href="#categories" data-toggle="tab">
                                                        {{ __('vendor::dashboard.vendors.create.form.categories') }}
                                                    </a>
                                                </li>

                                                <li>
                                                    <a href="#other" data-toggle="tab">
                                                        {{ __('vendor::dashboard.vendors.create.form.other') }}
                                                    </a>
                                                </li>

                                                @if (config('setting.supported_payments.upayment.account_type') == 'vendor_account')
                                                    <li>
                                                        <a href="#payment" data-toggle="tab">
                                                            {{ __('vendor::dashboard.vendors.create.form.payment') }}
                                                        </a>
                                                    </li>
                                                @endif

                                                {{-- @if (config('setting.other.select_shipping_provider') == 'vendor_delivery') --}}
                                                    <li>
                                                        <a href="#availabilities" data-toggle="tab">
                                                            {{ __('vendor::dashboard.vendors.tabs.availabilities') }}
                                                        </a>
                                                    </li>
                                                {{-- @endif --}}

                                                <li>
                                                    <a href="#seo" data-toggle="tab">
                                                        {{ __('vendor::dashboard.vendors.create.form.seo') }}
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
                                <div class="tab-pane active fade in" id="global_setting">
                                    {{-- <h3 class="page-title">{{ __('vendor::dashboard.vendors.create.form.general') }}
                                    </h3> --}}
                                    <div class="col-md-10">


                                        {{-- tab for lang --}}
                                        <ul class="nav nav-tabs">
                                            @foreach (config('translatable.locales') as $code)
                                                <li class="@if ($loop->first) active @endif">
                                                    <a data-toggle="tab"
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
                                                            {{ __('vendor::dashboard.vendors.create.form.title') }}
                                                            - {{ $code }}
                                                        </label>
                                                        <div class="col-md-9">
                                                            <input type="text" name="title[{{ $code }}]"
                                                                class="form-control" data-name="title.{{ $code }}">
                                                            <div class="help-block"></div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="col-md-2">
                                                            {{ __('vendor::dashboard.vendors.create.form.description') }}
                                                            - {{ $code }}
                                                        </label>
                                                        <div class="col-md-9">
                                                            <textarea name="description[{{ $code }}]" rows="8" cols="80"
                                                                class="form-control {{ is_rtl($code) }}" data-name="description.{{ $code }}"></textarea>
                                                            <div class="help-block"></div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="col-md-2">
                                                            {{ __('vendor::dashboard.vendors.create.form.address') }}
                                                            - {{ $code }}
                                                        </label>
                                                        <div class="col-md-9">
                                                            <input type="text" name="address[{{ $code }}]"
                                                                class="form-control"
                                                                data-name="address.{{ $code }}">
                                                            <div class="help-block"></div>
                                                        </div>
                                                    </div>

                                                </div>
                                            @endforeach

                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{ __('vendor::dashboard.vendors.create.form.mobile') }}
                                            </label>
                                            <div class="col-md-4">
                                                <input type="text" name="mobile" class="form-control"
                                                    data-name="mobile">
                                                <div class="help-block"></div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{ __('vendor::dashboard.vendors.create.form.status') }}
                                            </label>
                                            <div class="col-md-9">
                                                <input type="checkbox" class="make-switch" id="test" data-size="small"
                                                    name="status">
                                                <div class="help-block"></div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{ __('vendor::dashboard.vendors.create.form.is_new') }}
                                            </label>
                                            <div class="col-md-9">
                                                <input type="checkbox" class="make-switch" id="is_new" data-size="small"
                                                    name="is_new">
                                                <div class="help-block"></div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{ __('vendor::dashboard.vendors.create.form.use_app_drivers') }}
                                            </label>
                                            <div class="col-md-9">
                                                <input type="checkbox" class="make-switch" id="use_app_drivers"
                                                    data-size="small" name="use_app_drivers">
                                                <div class="help-block"></div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="tab-pane fade in" id="categories">
                                    <div id="jstree">
                                        @include('vendor::dashboard.tree.vendors.view', [
                                            'mainVendorCategories' => $mainVendorCategories,
                                        ])
                                    </div>
                                    <div class="form-group">
                                        <input type="hidden" name="vendor_category_id" id="root_category" value=""
                                            data-name="vendor_category_id">
                                        <div class="help-block"></div>
                                    </div>
                                </div>

                                <div class="tab-pane fade in" id="other">
                                    {{-- <h3 class="page-title">{{ __('vendor::dashboard.vendors.create.form.other') }}
                                    </h3> --}}
                                    <div class="col-md-10">

                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{ __('vendor::dashboard.vendors.create.form.vendor_statuses') }}
                                            </label>
                                            <div class="col-md-9">
                                                <select name="vendor_status_id" id="single"
                                                    class="form-control select2-allow-clear">
                                                    <option value=""></option>
                                                    @foreach ($vendorStatuses as $vendorStatus)
                                                        <option value="{{ $vendorStatus['id'] }}">
                                                            {{ $vendorStatus->title }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{ __('vendor::dashboard.vendors.create.form.sections') }}
                                            </label>
                                            <div class="col-md-9">
                                                <select name="section_id" id="single"
                                                    class="form-control select2-allow-clear">
                                                    <option value=""></option>
                                                    @foreach ($sections as $section)
                                                        <option value="{{ $section['id'] }}">
                                                            {{ $section->title }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{ __('vendor::dashboard.vendors.create.form.sellers') }}
                                            </label>
                                            <div class="col-md-9">
                                                <select name="seller_id[]" id="single"
                                                    class="form-control select2-allow-clear" multiple>
                                                    <option value=""></option>
                                                    @foreach ($sellers as $seller)
                                                        <option value="{{ $seller['id'] }}">
                                                            {{ $seller['name'] }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{ __('vendor::dashboard.vendors.create.form.image') }}
                                            </label>
                                            <div class="col-md-9">
                                                @include('core::dashboard.shared.file_upload', [
                                                    'image' => null,
                                                ])
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{ __('vendor::dashboard.vendors.create.form.vendor_email') }}
                                            </label>
                                            <div class="col-md-9">
                                                <input type="text" name="vendor_email" class="form-control"
                                                    data-name="vendor_email">
                                                <div class="help-block"></div>
                                            </div>
                                        </div>

                                        @if (config('setting.other.select_shipping_provider') == 'vendor_delivery')
                                            <div class="form-group">
                                                <label
                                                    class="col-md-3">{{ __('vendor::dashboard.vendors.create.form.delivery_time_types.title') }}</label>
                                                <div class="col-md-8">
                                                    <label class="checkbox-inline">
                                                        <input type="checkbox" id="deliveryTimeDirectCheckbox"
                                                            name="delivery_time_types[]" value="direct" checked>
                                                        {{ __('vendor::dashboard.vendors.create.form.delivery_time_types.direct') }}
                                                    </label>
                                                    <label class="checkbox-inline">
                                                        <input type="checkbox" name="delivery_time_types[]"
                                                            value="schedule">
                                                        {{ __('vendor::dashboard.vendors.create.form.delivery_time_types.schedule') }}
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="form-group" id="deliveryTimeMessageContent">
                                                <label
                                                    class="col-md-3">{{ __('vendor::dashboard.vendors.create.form.delivery_time_types.direct_delivery_message') }}</label>
                                                <div class="col-md-8">
                                                    <ul class="nav nav-tabs">
                                                        @foreach (config('translatable.locales') as $code)
                                                            <li class="@if ($loop->first) active @endif">
                                                                <a data-toggle="tab"
                                                                    href="#direct_delivery_first_{{ $code }}">{{ __('catalog::dashboard.products.form.tabs.input_lang', ['lang' => $code]) }}</a>
                                                            </li>
                                                        @endforeach
                                                    </ul>

                                                    <div class="tab-content">
                                                        @foreach (config('translatable.locales') as $code)
                                                            <div id="direct_delivery_first_{{ $code }}"
                                                                class="tab-pane fade @if ($loop->first) in active @endif">

                                                                <div class="form-group">
                                                                    <div class="col-md-12">
                                                                        <input type="text"
                                                                            name="direct_delivery_message[{{ $code }}]"
                                                                            class="form-control"
                                                                            data-name="direct_delivery_message.{{ $code }}">
                                                                        <div class="help-block"></div>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                    </div>
                                </div>

                                @if (config('setting.supported_payments.upayment.account_type') == 'vendor_account')
                                    <div class="tab-pane fade in" id="payment">
                                        {{-- <h3 class="page-title">{{__('vendor::dashboard.vendors.create.form.payment')}}</h3> --}}
                                        <div class="col-md-10">

                                            <div class="form-group">
                                                <label class="col-md-3">
                                                    {{ __('vendor::dashboard.vendors.payment.fixed_app_commission') }}
                                                    <i class="fa fa-question-circle tooltips"
                                                        data-original-title="{{ __('vendor::dashboard.vendors.payment.app_commission_tooltip') }}"></i>
                                                </label>
                                                <div class="col-md-9">
                                                    <input type="number" step="0.01" min="0"
                                                        name="payment_data[fixed_app_commission]" class="form-control"
                                                        data-name="payment_data.fixed_app_commission">
                                                    <div class="help-block"></div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-3">
                                                    {{ __('vendor::dashboard.vendors.payment.percentage_app_commission') }}
                                                    <i class="fa fa-question-circle tooltips"
                                                        data-original-title="{{ __('vendor::dashboard.vendors.payment.app_commission_tooltip') }}"></i>
                                                </label>
                                                <div class="col-md-9">
                                                    <input type="number" step="0.01" min="0"
                                                        name="payment_data[percentage_app_commission]"
                                                        class="form-control"
                                                        data-name="payment_data.percentage_app_commission">
                                                    <div class="help-block"></div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-3">
                                                    {{ __('vendor::dashboard.vendors.payment.ibans') }}
                                                </label>
                                                <div class="col-md-9">
                                                    <input type="text" name="payment_data[ibans]" class="form-control"
                                                        data-name="payment_data.ibans">
                                                    <div class="help-block"></div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                @endif

                                {{-- @if (config('setting.other.select_shipping_provider') == 'vendor_delivery') --}}
                                    @include('vendor::dashboard.vendors.availabilities._create_times')
                                {{-- @endif --}}

                                <div class="tab-pane fade in" id="seo">
                                    {{-- <h3 class="page-title">{{ __('vendor::dashboard.vendors.create.form.seo') }}</h3> --}}
                                    <div class="col-md-10">


                                        {{-- tab for lang --}}
                                        <ul class="nav nav-tabs">
                                            @foreach (config('translatable.locales') as $code)
                                                <li class="@if ($loop->first) active @endif">
                                                    <a data-toggle="tab"
                                                        href="#second_{{ $code }}">{{ __('catalog::dashboard.products.form.tabs.input_lang', ['lang' => $code]) }}</a>
                                                </li>
                                            @endforeach
                                        </ul>

                                        {{-- tab for content --}}
                                        <div class="tab-content">

                                            @foreach (config('translatable.locales') as $code)
                                                <div id="second_{{ $code }}"
                                                    class="tab-pane fade @if ($loop->first) in active @endif">

                                                    <div class="form-group">
                                                        <label class="col-md-2">
                                                            {{ __('vendor::dashboard.vendors.create.form.meta_keywords') }}
                                                            - {{ $code }}
                                                        </label>
                                                        <div class="col-md-9">
                                                            <textarea name="seo_keywords[{{ $code }}]" rows="8" cols="80" class="form-control"
                                                                data-name="seo_keywords.{{ $code }}"></textarea>
                                                            <div class="help-block"></div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="col-md-2">
                                                            {{ __('vendor::dashboard.vendors.create.form.meta_description') }}
                                                            - {{ $code }}
                                                        </label>
                                                        <div class="col-md-9">
                                                            <textarea name="seo_description[{{ $code }}]" rows="8" cols="80" class="form-control"
                                                                data-name="seo_description.{{ $code }}"></textarea>
                                                            <div class="help-block"></div>
                                                        </div>
                                                    </div>

                                                </div>
                                            @endforeach

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
                                        {{ __('apps::dashboard.general.add_btn') }}
                                    </button>
                                    <a href="{{ url(route('dashboard.vendors.index')) }}" class="btn btn-lg red">
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
            $('#jstree').jstree();

            $('#jstree').on("changed.jstree", function(e, data) {
                $('#root_category').val(data.selected);
            });
        });
    </script>

    <script>
        $(function() {
            $('#deliveryTimeDirectCheckbox').on("click", function() {
                $('#deliveryTimeMessageContent').toggle($(this).is(':checked'));
            });
        });
    </script>

    <script>
        $(function() {
            var timePicker = $(".timepicker");
            timePicker.timepicker({
                timeFormat: 'HH',
            });
        });

        var rowCountsArray = [0];

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
@endsection
