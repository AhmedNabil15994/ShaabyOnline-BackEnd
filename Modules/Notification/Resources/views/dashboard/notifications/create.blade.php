@extends('apps::dashboard.layouts.app')
@section('title', __('notification::dashboard.notifications.routes.create'))
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
                        <a href="{{ url(route('dashboard.notifications.index')) }}">{{__('notification::dashboard.notifications.routes.index')}}</a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <a href="javascript:;">{{__('notification::dashboard.notifications.routes.create')}}</a>
                    </li>
                </ul>
            </div>

            <h1 class="page-title"></h1>

            <div class="row">
                <form id="form" role="form" class="form-horizontal form-row-seperated" method="post"
                      enctype="multipart/form-data" action="{{ route('dashboard.notifications.store') }}">
                    @csrf
                    <div class="col-md-12 justify-content-center">

                        {{-- CREATE FORM --}}
                        {{--<h3 class="page-title">{{__('notification::dashboard.notifications.form.name')}}</h3>--}}
                        <div class="col-md-6 col-md-offset-3">

                            <div class="form-group text-center">
                                <label
                                    class="">{{ __('notification::dashboard.notifications.form.notification_type.label') }}</label>
                                <div class="mt-radio-inline">
                                    <label class="mt-radio">
                                        <input type="radio" name="notification_type" id="generalLinkRadioBtn"
                                               value="general"
                                               onclick="toggleNotificationType('general')"
                                               checked="">
                                        {{ __('notification::dashboard.notifications.form.notification_type.general') }}
                                        <span></span>
                                    </label>
                                    <label class="mt-radio">
                                        <input type="radio" name="notification_type" id="productLinkRadioBtn"
                                               value="product"
                                               onclick="toggleNotificationType('product')">
                                        {{ __('notification::dashboard.notifications.form.notification_type.product') }}
                                        <span></span>
                                    </label>
                                    <label class="mt-radio">
                                        <input type="radio" name="notification_type" id="categoryLinkRadioBtn"
                                               value="category"
                                               onclick="toggleNotificationType('category')">
                                        {{ __('notification::dashboard.notifications.form.notification_type.category') }}
                                        <span></span>
                                    </label>
                                </div>
                            </div>

                            <div id="productsSection" style="display: none;" class="form-group">
                                <label class="">
                                    {{ __('notification::dashboard.notifications.form.products') }}
                                </label>
                                <div class="">
                                    <select name="product_id" class="select2 form-control" data-name="product_id">
                                        <option value="">
                                            ---{{ __('notification::dashboard.notifications.alert.select_products') }}
                                            ---
                                        </option>
                                        @foreach($sharedActiveProducts as $k => $product)
                                            <option value="{{ $product->id }}">
                                                {{ $product->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="help-block"></div>
                                </div>
                            </div>

                            <div id="categoriesSection" style="display: none;" class="form-group">
                                <label class="">
                                    {{ __('notification::dashboard.notifications.form.categories') }}
                                </label>
                                <div class="">
                                    <select name="category_id" class="select2 form-control" data-name="category_id">
                                        <option value="">
                                            ---{{ __('notification::dashboard.notifications.alert.select_categories') }}
                                            ---
                                        </option>
                                        @foreach($sharedActiveCategories as $k => $category)
                                            <option value="{{ $category->id }}">
                                                {{ $category->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="help-block"></div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="">
                                    {{__('notification::dashboard.notifications.form.msg_title')}}
                                    <span class="required">*</span>
                                </label>
                                <div class="">
                                    <input type="text" name="title" class="form-control"
                                           data-name="title">
                                    <div class="help-block"></div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="">
                                    {{__('notification::dashboard.notifications.form.msg_body')}}
                                    <span class="required">*</span>
                                </label>
                                <div class="">
                                        <textarea name="body" rows="10" cols="30"
                                                  class="form-control"
                                                  data-name="body"></textarea>
                                    <div class="help-block"></div>
                                </div>
                            </div>

                        </div>
                        {{-- END CREATE FORM --}}

                        {{-- PAGE ACTION --}}
                        <div class="col-md-12">
                            <div class="form-actions text-center">
                                @include('apps::dashboard.layouts._ajax-msg')
                                <div class="form-group">
                                    <button type="submit" id="submit" class="btn btn-lg blue">
                                        {{__('notification::dashboard.notifications.send_btn')}}
                                    </button>
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
        function toggleNotificationType(type = '') {
            if (type === 'general') {
                $('#productsSection').hide();
                $('#categoriesSection').hide();
            } else if (type === 'product') {
                $('#categoriesSection').hide();
                $('#productsSection').show();
            } else if (type === 'category') {
                $('#productsSection').hide();
                $('#categoriesSection').show();
            }
        }
    </script>
@endsection
