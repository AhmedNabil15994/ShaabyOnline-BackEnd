@extends('apps::dashboard.layouts.app')
@section('title', __('variation::dashboard.options.routes.update'))
@section('content')

    @include('variation::dashboard.html.option_values_html')

    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <a href="{{ url(route('dashboard.home')) }}">{{ __('apps::dashboard.home.title') }}</a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <a href="{{ url(route('dashboard.options.index')) }}">
                            {{ __('variation::dashboard.options.routes.index') }}
                        </a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <a href="#">{{ __('variation::dashboard.options.routes.update') }}</a>
                    </li>
                </ul>
            </div>

            <h1 class="page-title"></h1>

            <div class="row">
                <form id="updateForm" page="form" class="form-horizontal form-row-seperated" method="post"
                    enctype="multipart/form-data" action="{{ route('dashboard.options.update', $option->id) }}">
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
                                                    <a href="#genral" data-toggle="tab">
                                                        {{ __('variation::dashboard.options.form.tabs.general') }}
                                                    </a>
                                                </li>
                                                <li class="">
                                                    <a href="#option_values" data-toggle="tab">
                                                        {{ __('variation::dashboard.options.form.tabs.option_values') }}
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
                                <div class="tab-pane active fade in" id="genral">
                                    <div class="col-md-10">

                                        <ul class="nav nav-tabs">
                                            @foreach (config('translatable.locales') as $code)
                                                <li class="@if ($loop->first) active @endif"><a
                                                        data-toggle="tab"
                                                        href="#first_{{ $code }}">{{ __('catalog::dashboard.products.form.tabs.input_lang', ['lang' => $code]) }}</a>
                                                </li>
                                            @endforeach
                                        </ul>

                                        <div class="tab-content">

                                            @foreach (config('translatable.locales') as $code)
                                                <div id="first_{{ $code }}"
                                                    class="tab-pane fade @if ($loop->first) in active @endif">

                                                    <div class="form-group">
                                                        <label class="col-md-2">
                                                            {{ __('variation::dashboard.options.form.title') }}
                                                            - {{ $code }}
                                                        </label>
                                                        <div class="col-md-9">
                                                            <input type="text" name="title[{{ $code }}]"
                                                                class="form-control" data-name="title.{{ $code }}"
                                                                value="{{ $option->getTranslation('title', $code) }}">
                                                            <div class="help-block"></div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="col-md-2">
                                                            {{ __('variation::dashboard.options.form.notes') }}
                                                            - {{ $code }}
                                                        </label>
                                                        <div class="col-md-9">
                                                            <input type="text" name="notes[{{ $code }}]"
                                                                class="form-control" data-name="notes.{{ $code }}"
                                                                value="{{ $option->getTranslation('notes', $code) ?? '' }}">
                                                            <div class="help-block"></div>
                                                        </div>
                                                    </div>

                                                </div>
                                            @endforeach

                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{ __('variation::dashboard.options.form.status') }}
                                            </label>
                                            <div class="col-md-9">
                                                <input type="checkbox" class="make-switch" id="status" data-size="small"
                                                    name="status" {{ $option->status == 1 ? ' checked="" ' : '' }}>
                                                <div class="help-block"></div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{ __('variation::dashboard.options.form.is_color') }}
                                            </label>
                                            <div class="col-md-9">
                                                <input type="checkbox" class="make-switch" id="isColorCheckbox" data-size="small"
                                                    name="is_color" {{ $option->is_color == 1 ? ' checked="" ' : '' }}>
                                                <div class="help-block"></div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{ __('variation::dashboard.options.form.option_as_filter') }}
                                            </label>
                                            <div class="col-md-9">
                                                <input type="checkbox" class="make-switch" data-size="small"
                                                    name="option_as_filter"
                                                    {{ $option->option_as_filter == 1 ? ' checked="" ' : '' }}>
                                                <div class="help-block"></div>
                                            </div>
                                        </div>

                                        @if ($option->trashed())
                                            <div class="form-group">
                                                <label class="col-md-2">
                                                    {{ __('area::dashboard.update.form.restore') }}
                                                </label>
                                                <div class="col-md-9">
                                                    <input type="checkbox" class="make-switch" id="test"
                                                        data-size="small" name="restore">
                                                    <div class="help-block"></div>
                                                </div>
                                            </div>
                                        @endif

                                    </div>
                                </div>

                                <div class="tab-pane fade in" id="option_values">
                                    {{--  <h3 class="page-title">{{__('variation::dashboard.options.form.tabs.option_values')}}</h3>  --}}
                                    <div class="col-md-10">

                                        <div class="option_values_form">
                                            @foreach ($option->values as $key => $optionValues)
                                                <div class="content">
                                                    <input type="hidden" name="valueIndex[]" value="1" />
                                                    <input type="hidden" name="option_values_ids[]"
                                                        value="{{ $optionValues->id }}">
                                                    <input type="hidden" name="color_values[]"
                                                        value="{{ $optionValues->value }}">

                                                    @foreach (config('translatable.locales') as $code)
                                                        <div class="form-group">
                                                            <label class="col-md-2">
                                                                {{ __('variation::dashboard.options.form.title') }}
                                                                - {{ $code }}
                                                            </label>
                                                            <div class="col-md-9">
                                                                <input type="text"
                                                                    name="option_value_title[{{ $code }}][]"
                                                                    class="form-control"
                                                                    data-name="option_value_title.{{ $code }}"
                                                                    value="{{ $optionValues->getTranslation('title', $code) }}">
                                                                <div class="help-block"></div>
                                                            </div>
                                                        </div>
                                                    @endforeach

                                                    <div class="form-group optionColorValue">
                                                        <label class="col-md-2">
                                                            {{ __('variation::dashboard.options.form.value') }}
                                                        </label>
                                                        <div class="col-md-9">
                                                            <input type="color" name="value[]" class="form-control"
                                                                data-name="value.{{ $key }}"
                                                                value="{{ $optionValues->value ?? '' }}">
                                                            <div class="help-block"></div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="col-md-2">
                                                            {{ __('variation::dashboard.options.form.status') }}
                                                        </label>
                                                        <div class="col-md-9">
                                                            <input type="checkbox" class="ischecked make-switch"
                                                                name="option_value_status[]" value="1"
                                                                onclick="checkFunction()"
                                                                {{ $optionValues->status ? 'checked' : '' }}>
                                                            {{-- <input type="hidden" class="isUnchecked"
                                                                name="option_value_status[]" value="0"
                                                                {{ $optionValues->status ? 'disabled' : '' }}> --}}
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <a href="javascript:;" class="remove_html btn red">
                                                            <i class="fa fa-times"></i>
                                                        </a>
                                                    </div>
                                                    <hr>
                                                </div>
                                            @endforeach
                                        </div>

                                        <button id="copy" type="button"
                                            class="btn green btn-lg mt-ladda-btn ladda-button btn-circle btn-outline"
                                            data-style="slide-down" data-spinner-color="#333">
                                            <span class="ladda-label">
                                                <i class="icon-plus"></i>
                                            </span>
                                        </button>
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
                                    <a href="{{ url(route('dashboard.options.index')) }}" class="btn btn-lg red">
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

            console.log('isColorCheckbox::' + $('#isColorCheckbox').is(':checked'));
            $('.optionColorValue').toggle($('#isColorCheckbox').is(':checked'));

            $('#isColorCheckbox').on('switchChange.bootstrapSwitch', function(e) {
                $('.optionColorValue').toggle(e.target.checked);
            });

            var html = $("div.option_values_form_copier").html();
            $('#copy').click(function(event) {
                $(".option_values_form").append(html);
                $('.make-switch-a').bootstrapSwitch();

            console.log('isColorCheckbox1::' + $('#isColorCheckbox').is(':checked'));

                $('.optionColorValue').toggle($('#isColorCheckbox').is(':checked'));
            });

            $(".option_values_form").on("click", ".remove_html", function(e) {
                e.preventDefault();
                $(this).closest('.content').remove();
            });

        });


        function checkFunction() {

            $('[name="option_value_status[]"]').change(function() {
                if ($(this).is(':checked'))
                    $(this).next().prop('disabled', true);
                else
                    $(this).next().prop('disabled', false);
            });

        }
    </script>
@stop
