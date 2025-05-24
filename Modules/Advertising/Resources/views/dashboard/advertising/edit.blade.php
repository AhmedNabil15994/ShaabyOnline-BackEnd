@extends('apps::dashboard.layouts.app')
@section('title', __('advertising::dashboard.advertising.routes.update'))
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
                        <a
                            href="{{ route('dashboard.advertising_groups.index') }}">{{ __('advertising::dashboard.advertising_groups.routes.index') }}</a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <a
                            href="{{ route('dashboard.advertising.index', ['advertising_group' => $advertising->ad_group_id]) }}">
                            {{ __('advertising::dashboard.advertising.routes.index') }}
                        </a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <a href="#">{{ __('advertising::dashboard.advertising.routes.update') }}</a>
                    </li>
                </ul>
            </div>

            <h1 class="page-title"></h1>

            <div class="row">
                <form id="updateForm" page="form" class="form-horizontal form-row-seperated" method="post"
                    enctype="multipart/form-data" action="{{ route('dashboard.advertising.update', $advertising->id) }}">
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
                                                    <a href="#general" data-toggle="tab">
                                                        {{ __('advertising::dashboard.advertising.form.tabs.general') }}
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
                                <div class="tab-pane active fade in" id="general">
                                    {{-- <h3 class="page-title">
                                        {{ __('advertising::dashboard.advertising.form.tabs.general') }}</h3> --}}
                                    <div class="col-md-10">

                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{ __('advertising::dashboard.advertising.form.groups') }}
                                            </label>
                                            <div class="col-md-9">
                                                <select name="group_id" class="form-control" data-name="group_id">
                                                    <option value="">
                                                        ---{{ __('advertising::dashboard.advertising.alert.select_groups') }}
                                                        ---
                                                    </option>
                                                    @foreach ($groups as $k => $group)
                                                        <option value="{{ $group->id }}"
                                                            {{ $advertising->ad_group_id == $group->id ? 'selected' : '' }}>
                                                            {{ $group->title }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <div class="help-block"></div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{ __('advertising::dashboard.advertising.form.link_type.label') }}
                                            </label>
                                            <div class="col-md-9">

                                                <label class="radio-inline">
                                                    <input type="radio" name="link_type" id="externalLinkRadioBtn"
                                                        value="external"
                                                        {{ is_null($advertising->advertable_id) && !is_null($advertising->link) ? 'checked' : '' }}
                                                        onclick="toggleLink('external')">
                                                    {{ __('advertising::dashboard.advertising.form.link_type.external') }}
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="link_type" id="productLinkRadioBtn"
                                                        onclick="toggleLink('product')"
                                                        {{ !is_null($advertising->advertable_id) && $advertising->morph_model == 'Product' ? 'checked' : '' }}
                                                        value="product">
                                                    {{ __('advertising::dashboard.advertising.form.link_type.product') }}
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="link_type" id="categoryLinkRadioBtn"
                                                        onclick="toggleLink('category')"
                                                        {{ !is_null($advertising->advertable_id) && $advertising->morph_model == 'Category' ? 'checked' : '' }}
                                                        value="category">
                                                    {{ __('advertising::dashboard.advertising.form.link_type.category') }}
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="link_type" id="vendorLinkRadioBtn"
                                                        onclick="toggleLink('vendor')"
                                                        {{ !is_null($advertising->advertable_id) && $advertising->morph_model == 'Vendor' ? 'checked' : '' }}
                                                        value="vendor">
                                                    {{ __('advertising::dashboard.advertising.form.link_type.vendor') }}
                                                </label>

                                            </div>
                                        </div>

                                        <div id="externalSection" class="form-group"
                                            style="{{ is_null($advertising->advertable_id) && !is_null($advertising->link) ? 'display: block;' : 'display: none;' }}">
                                            <label class="col-md-2">
                                                {{ __('advertising::dashboard.advertising.form.link') }}
                                            </label>
                                            <div class="col-md-9">
                                                <input type="text" name="link" class="form-control" data-name="link"
                                                    value="{{ $advertising->link }}">
                                                <div class="help-block"></div>
                                            </div>
                                        </div>

                                        <div id="productsSection" class="form-group"
                                            style="{{ !is_null($advertising->advertable_id) && $advertising->morph_model == 'Product' ? 'display: block;' : 'display: none;' }}">
                                            <label class="col-md-2">
                                                {{ __('advertising::dashboard.advertising.form.products') }}
                                            </label>
                                            <div class="col-md-9">
                                                <select name="product_id" class="select2 form-control"
                                                    data-name="product_id">
                                                    <option value="">
                                                        ---{{ __('advertising::dashboard.advertising.alert.select_products') }}
                                                        ---
                                                    </option>
                                                    @foreach ($sharedActiveProducts as $k => $product)
                                                        <option value="{{ $product->id }}"
                                                            {{ $advertising->morph_model == 'Product' && $advertising->advertable_id == $product->id ? 'selected' : '' }}>
                                                            {{ $product->title }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <div class="help-block"></div>
                                            </div>
                                        </div>

                                        <div id="categoriesSection" class="form-group"
                                            style="{{ !is_null($advertising->advertable_id) && $advertising->morph_model == 'Category' ? 'display: block;' : 'display: none;' }}">

                                            <label class="col-md-2">
                                                {{ __('advertising::dashboard.advertising.form.categories') }}
                                            </label>
                                            <div class="col-md-9">
                                                <select name="category_id" class="select2 form-control"
                                                    data-name="category_id">
                                                    <option value="">
                                                        ---{{ __('advertising::dashboard.advertising.alert.select_categories') }}
                                                        ---
                                                    </option>
                                                    @foreach ($sharedActiveCategories as $k => $category)
                                                        <option value="{{ $category->id }}"
                                                            {{ $advertising->morph_model == 'Category' && $advertising->advertable_id == $category->id ? 'selected' : '' }}>
                                                            {{ $category->title }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <div class="help-block"></div>
                                            </div>
                                        </div>

                                        <div id="vendorsSection" class="form-group"
                                            style="{{ !is_null($advertising->advertable_id) && $advertising->morph_model == 'Vendor' ? 'display: block;' : 'display: none;' }}">

                                            <label class="col-md-2">
                                                {{ __('advertising::dashboard.advertising.form.vendors') }}
                                            </label>
                                            <div class="col-md-9">
                                                <select name="vendor_id" class="select2 form-control"
                                                    data-name="vendor_id">
                                                    <option value="">
                                                        ---{{ __('advertising::dashboard.advertising.alert.select_vendors') }}
                                                        ---
                                                    </option>
                                                    @foreach ($activeVendors as $k => $vendor)
                                                        <option value="{{ $vendor->id }}"
                                                            {{ $advertising->morph_model == 'Vendor' && $advertising->advertable_id == $vendor->id ? 'selected' : '' }}>
                                                            {{ $vendor->title }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <div class="help-block"></div>
                                            </div>
                                        </div>

                                        <hr>

                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{ __('advertising::dashboard.advertising.form.start_at') }}
                                            </label>
                                            <div class="col-md-9">
                                                <div class="input-group input-medium date date-picker"
                                                    data-date-format="yyyy-mm-dd" data-date-start-date="+0d">
                                                    <input type="text" class="form-control" name="start_at"
                                                        value="{{ $advertising->start_at }}">
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
                                                {{ __('advertising::dashboard.advertising.form.end_at') }}
                                            </label>
                                            <div class="col-md-9">
                                                <div class="input-group input-medium date date-picker"
                                                    data-date-format="yyyy-mm-dd" data-date-start-date="+0d">
                                                    <input type="text" class="form-control" name="end_at"
                                                        value="{{ $advertising->end_at }}">
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
                                                {{ __('advertising::dashboard.advertising.form.sort') }}
                                            </label>
                                            <div class="col-md-2">
                                                <input type="number" class="form-control"
                                                    value="{{ $advertising->sort }}" name="sort">
                                                <div class="help-block"></div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{ __('advertising::dashboard.advertising.form.status') }}
                                            </label>
                                            <div class="col-md-9">
                                                <input type="checkbox" class="make-switch" id="test"
                                                    data-size="small" name="status"
                                                    {{ $advertising->status == 1 ? ' checked="" ' : '' }}>
                                                <div class="help-block"></div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{ __('advertising::dashboard.advertising.form.image') }}
                                            </label>
                                            <div class="col-md-9">
                                                @include('core::dashboard.shared.file_upload', [
                                                    'image' => $advertising->image,
                                                ])
                                                <div class="help-block"></div>
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
                                        {{ __('apps::dashboard.general.edit_btn') }}
                                    </button>
                                    <a href="{{ route('dashboard.advertising.index', ['advertising_group' => $advertising->ad_group_id]) }}"
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
        function toggleLink(type = '') {
            if (type === 'external') {
                $('#externalSection').show();
                $('#productsSection').hide();
                $('#categoriesSection').hide();
                $('#vendorsSection').hide();
            } else if (type === 'product') {
                $('#externalSection').hide();
                $('#categoriesSection').hide();
                $('#vendorsSection').hide();
                $('#productsSection').show();
            } else if (type === 'category') {
                $('#externalSection').hide();
                $('#productsSection').hide();
                $('#vendorsSection').hide();
                $('#categoriesSection').show();
            } else if (type === 'vendor') {
                $('#externalSection').hide();
                $('#productsSection').hide();
                $('#categoriesSection').hide();
                $('#vendorsSection').show();
            }
        }
    </script>
@endsection
