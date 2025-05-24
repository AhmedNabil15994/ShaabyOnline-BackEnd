<form id="formFilter" class="horizontal-form">
    <div class="form-body">

        <div class="row">

            <div class="col-md-3">
                <div class="form-group">
                    <label class="control-label">
                        {{ __('apps::dashboard.datatable.form.date_range') }}
                    </label>
                    <div id="reportrange" class="btn default form-control">
                        <i class="fa fa-calendar"></i> &nbsp;
                        <span> </span>
                        <b class="fa fa-angle-down"></b>
                        <input type="hidden" name="from">
                        <input type="hidden" name="to">
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label class="control-label">
                        {{ __('apps::dashboard.datatable.form.search_by_vendor') }}
                    </label>
                    <select name="vendor" class="searchableSelect form-control select2">
                        <option value=""></option>
                        @foreach ($vendors as $item)
                            <option value="{{ $item->id }}">
                                {{ $item->title }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label class="control-label">
                        {{ __('apps::dashboard.datatable.form.search_by_order_status') }}
                    </label>
                    <select name="order_status" class="searchableSelect form-control select2">
                        <option value=""></option>
                        @foreach ($orderStatuses as $item)
                            <option value="{{ $item->id }}">
                                {{ $item->title }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label class="control-label">
                        {{ __('apps::dashboard.datatable.form.search_by_driver') }}
                    </label>
                    <select name="driver_id" class="searchableSelect form-control select2">
                        <option value=""></option>
                        @foreach ($drivers as $item)
                            <option value="{{ $item->id }}">
                                {{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

        </div>

        <div class="row">

            <div class="col-md-3">
                <div class="form-group">
                    <label class="control-label">
                        {{ __('apps::dashboard.datatable.form.search_by_client') }}
                    </label>
                    <select name="user_id" class="searchableSelect form-control select2">
                        <option value=""></option>
                        @foreach ($users as $item)
                            <option value="{{ $item->id }}">
                                {{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-md-2">
                <div class="form-group">
                    <label class="control-label">
                        {{ __('apps::dashboard.datatable.form.search_by_country') }}
                    </label>
                    <select id="filterCountryId" name="country_id" class="searchableSelect form-control select2">
                        <option value=""></option>
                        @foreach ($activeCountries as $item)
                            <option value="{{ $item->id }}" {{ $item->code == 'KW' ? 'selected' : '' }}>
                                {{ $item->title }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-md-3" id="countryCitiesSection">
                <div class="form-group">
                    <label class="control-label">
                        {{ __('apps::dashboard.datatable.form.search_by_city') }}
                    </label>
                    <select id="filterCityId" name="city_id" class="searchableSelect form-control select2">
                        <option value=""></option>
                        @foreach ($activeCities as $item)
                            <option value="{{ $item->id }}">
                                {{ $item->title }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-md-3" id="countryCityStatesSection">
                <div class="form-group">
                    <label class="control-label">
                        {{ __('apps::dashboard.datatable.form.search_by_state') }}
                    </label>
                    <select id="filterStateId" name="state_id" class="searchableSelect form-control select2">
                        <option value=""></option>
                        @foreach ($activeStates as $item)
                            <option value="{{ $item->id }}">
                                {{ $item->title }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-md-3" id="countryCitiesLoader" style="display: none; margin-top: 30px;">
                <div class="form-group">
                    <label class="control-label">
                        <b>{{ __('apps::dashboard.general.loader') }} ...</b>
                    </label>
                </div>
            </div>

        </div>

        <div class="row">

            <div class="col-md-3">
                <div class="form-group">
                    <label class="control-label">
                        {{ __('apps::dashboard.datatable.form.search_by_payment_type') }}
                    </label>
                    <select name="payment_type" class="searchableSelect form-control select2">
                        <option value=""></option>
                        <option value="cash">{{ __('apps::dashboard.datatable.form.payment_types.cash') }}</option>
                        <option value="online">{{ __('apps::dashboard.datatable.form.payment_types.online') }}
                        </option>
                    </select>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label class="control-label">
                        {{ __('apps::dashboard.datatable.form.search_by_payment_status') }}
                    </label>
                    <select name="payment_status" class="searchableSelect form-control select2">
                        <option value=""></option>
                        <option value="success">{{ __('apps::dashboard.datatable.form.payment_statuses.success') }}
                        </option>
                        <option value="failed">{{ __('apps::dashboard.datatable.form.payment_statuses.failed') }}
                        </option>
                        <option value="pending">{{ __('apps::dashboard.datatable.form.payment_statuses.pending') }}
                        </option>
                        <option value="cash">{{ __('apps::dashboard.datatable.form.payment_statuses.cash') }}
                        </option>
                    </select>
                </div>
            </div>

        </div>

    </div>
</form>
<div class="form-actions">
    <button class="btn btn-sm green btn-outline filter-submit margin-bottom" id="search">
        <i class="fa fa-search"></i>
        {{ __('apps::dashboard.datatable.search') }}
    </button>

    <button class="btn btn-sm red btn-outline filter-cancel">
        <i class="fa fa-times"></i>
        {{ __('apps::dashboard.datatable.reset') }}
    </button>
</div>

<hr>

@permission('statistics')
    <div class="form-actions mt-4 text-center">
        <div class="col-md-4">
            @include('apps::dashboard.components.datatable.show-deleted-btn', ['withoutGrid' => true])
        </div>
        <div class="col-md-4">
            <b>{{ __('apps::dashboard.datatable.orders_total') }} :
            </b>
            <span id="sum_total_orders">0</span>
        </div>
        <div class="col-md-4">
            <b>{{ __('apps::dashboard.datatable.orders_count') }} :
            </b>
            <span id="count_orders">0</span>
        </div>
    </div>
@endpermission
