@extends('apps::dashboard.layouts.app')
@section('title', __('company::dashboard.companies.routes.create'))
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
                        <a href="{{ url(route('dashboard.companies.index')) }}">
                            {{ __('company::dashboard.companies.routes.index') }}
                        </a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <a href="#">{{ __('company::dashboard.companies.routes.create') }}</a>
                    </li>
                </ul>
            </div>

            <h1 class="page-title"></h1>

            <div class="row">
                <form id="form" role="form" class="form-horizontal form-row-seperated" method="post"
                    enctype="multipart/form-data" action="{{ route('dashboard.companies.store') }}">
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
                                                        {{ __('company::dashboard.companies.form.tabs.general') }}
                                                    </a>
                                                </li>

                                                <li>
                                                    <a href="#system" data-toggle="tab">
                                                        {{ __('company::dashboard.companies.form.tabs.system') }}
                                                    </a>
                                                </li>

                                                {{-- <li>
                                                    <a href="#availabilities" data-toggle="tab">
                                                        {{ __('company::dashboard.companies.form.tabs.availabilities') }}
                                                    </a>
                                                </li> --}}

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
                                    {{-- <h3 class="page-title">{{ __('company::dashboard.companies.form.tabs.general') }}</h3> --}}

                                    <ul class="nav nav-pills">
                                        @foreach (config('translatable.locales') as $k => $code)
                                            <li class="{{ $code == locale() ? 'active' : '' }}">
                                                <a id="{{ $k }}-general-tab" data-toggle="tab"
                                                    aria-controls="general-tab-{{ $k }}"
                                                    href="#general-tab-{{ $k }}"
                                                    aria-expanded="{{ $code == locale() ? 'true' : 'false' }}">{{ $code }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <div class="tab-content px-1 pt-1">

                                        @foreach (config('translatable.locales') as $k => $code)
                                            <div role="tabpanel" class="tab-pane {{ $code == locale() ? 'active' : '' }}"
                                                id="general-tab-{{ $k }}"
                                                aria-expanded="{{ $code == locale() ? 'true' : 'false' }}"
                                                aria-labelledby="{{ $k }}-general-tab">

                                                <div class="col-md-12">

                                                    <div class="form-group">
                                                        <label class="col-md-2">
                                                            {{ __('company::dashboard.companies.form.name') }}
                                                            - {{ $code }}
                                                        </label>
                                                        <div class="col-md-9">
                                                            <input type="text" name="name[{{ $code }}]"
                                                                class="form-control" data-name="name.{{ $code }}">
                                                            <div class="help-block"></div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="col-md-2">
                                                            {{ __('company::dashboard.companies.form.description') }}
                                                            - {{ $code }}
                                                        </label>
                                                        <div class="col-md-9">
                                                            <textarea name="description[{{ $code }}]" rows="8" cols="80"
                                                                class="form-control {{ is_rtl($code) }}Editor" data-name="description.{{ $code }}"></textarea>
                                                            <div class="help-block"></div>
                                                        </div>
                                                    </div>

                                                </div>

                                            </div>
                                        @endforeach

                                        <div class="col-md-12">

                                            <div class="form-group">
                                                <label class="col-md-2">
                                                    {{ __('company::dashboard.companies.form.status') }}
                                                </label>
                                                <div class="col-md-9">
                                                    <input type="checkbox" class="make-switch" id="test"
                                                        data-size="small" name="status">
                                                    <div class="help-block"></div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-2">
                                                    {{ __('user::dashboard.users.create.form.image') }}
                                                </label>
                                                <div class="col-md-9">
                                                    @include('core::dashboard.shared.file_upload', [
                                                        'image' => null,
                                                    ])
                                                    <div class="help-block"></div>
                                                </div>
                                            </div>

                                            @if (config('setting.other.select_shipping_provider') == 'shipping_company')
                                                <div class="form-group">
                                                    <label
                                                        class="col-md-3">{{ __('company::dashboard.companies.form.delivery_time_types.title') }}</label>
                                                    <div class="col-md-8">
                                                        <label class="checkbox-inline">
                                                            <input type="checkbox" id="deliveryTimeDirectCheckbox"
                                                                name="delivery_time_types[]" value="direct" checked>
                                                            {{ __('company::dashboard.companies.form.delivery_time_types.direct') }}
                                                        </label>
                                                        <label class="checkbox-inline">
                                                            <input type="checkbox" name="delivery_time_types[]"
                                                                value="schedule">
                                                            {{ __('company::dashboard.companies.form.delivery_time_types.schedule') }}
                                                        </label>
                                                    </div>
                                                </div>

                                                <div class="form-group" id="deliveryTimeMessageContent">
                                                    <label
                                                        class="col-md-3">{{ __('company::dashboard.companies.form.delivery_time_types.direct_delivery_message') }}</label>
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

                                </div>

                                <div class="tab-pane fade in" id="system">
                                    {{-- <h3 class="page-title">{{ __('company::dashboard.companies.form.tabs.system') }}</h3> --}}
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{ __('company::dashboard.companies.form.manager_name') }}
                                            </label>
                                            <div class="col-md-9">
                                                <input type="text" name="manager_name" class="form-control"
                                                    data-name="manager_name" value="{{ old('manager_name') }}">
                                                <div class="help-block"></div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{ __('company::dashboard.companies.form.email') }}
                                            </label>
                                            <div class="col-md-9">
                                                <input type="email" name="email" class="form-control"
                                                    data-name="email" value="{{ old('email') }}">
                                                <div class="help-block"></div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{ __('company::dashboard.companies.form.mobile') }}
                                            </label>
                                            <div class="col-md-9">
                                                <input type="text" name="mobile" class="form-control"
                                                    data-name="mobile" value="{{ old('mobile') }}">
                                                <div class="help-block"></div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{ __('company::dashboard.companies.form.password') }}
                                            </label>
                                            <div class="col-md-9">
                                                <input type="password" name="password" class="form-control"
                                                    data-name="password">
                                                <div class="help-block"></div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{ __('company::dashboard.companies.form.confirm_password') }}
                                            </label>
                                            <div class="col-md-9">
                                                <input type="password" name="confirm_password" class="form-control"
                                                    data-name="confirm_password">
                                                <div class="help-block"></div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                {{-- @include('company::dashboard.availabilities._create_times') --}}

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
                                    <a href="{{ url(route('dashboard.companies.index')) }}" class="btn btn-lg red">
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
            $('#deliveryTimeDirectCheckbox').on("click", function() {
                $('#deliveryTimeMessageContent').toggle($(this).is(':checked'));
            });
        });
    </script>

@endsection
