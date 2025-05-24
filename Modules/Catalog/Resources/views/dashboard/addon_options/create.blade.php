@extends('apps::dashboard.layouts.app')
@section('title', __('catalog::dashboard.addon_options.routes.create'))
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
                        <a href="{{ url(route('dashboard.addon_options.index')) }}">
                            {{__('catalog::dashboard.addon_options.routes.index')}}
                        </a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <a href="#">{{__('catalog::dashboard.addon_options.routes.create')}}</a>
                    </li>
                </ul>
            </div>

            <h1 class="page-title"></h1>

            <div class="row">
                <form id="form" role="form" class="form-horizontal form-row-seperated" method="post"
                      enctype="multipart/form-data" action="{{route('dashboard.addon_options.store')}}">
                    @csrf
                    <div class="col-md-12">

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
                                                        {{ __('catalog::dashboard.addon_options.form.tabs.general') }}
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-9">
                            <div class="tab-content">
                                <div class="tab-pane active fade in" id="global_setting">
                                    <div class="col-md-10">


                                        {{--  tab for lang --}}
                                        <ul class="nav nav-tabs">
                                            @foreach (config('translatable.locales') as $code)
                                                <li class="@if($loop->first) active @endif">
                                                    <a data-toggle="tab"
                                                       href="#first_{{$code}}">{{__('catalog::dashboard.products.form.tabs.input_lang',["lang"=>$code])}}</a>
                                                </li>
                                            @endforeach
                                        </ul>

                                        {{--  tab for content --}}
                                        <div class="tab-content">

                                            @foreach (config('translatable.locales') as $code)
                                                <div id="first_{{$code}}"
                                                     class="tab-pane fade @if($loop->first) in active @endif">

                                                    <div class="form-group">
                                                        <label class="col-md-2">
                                                            {{__('catalog::dashboard.addon_options.form.title')}}
                                                            - {{ $code }}
                                                        </label>
                                                        <div class="col-md-9">
                                                            <input type="text" name="title[{{$code}}]"
                                                                   class="form-control"
                                                                   data-name="title.{{$code}}">
                                                            <div class="help-block"></div>
                                                        </div>
                                                    </div>


                                                </div>
                                            @endforeach

                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{__('catalog::dashboard.addon_options.form.addon_category_id')}}
                                            </label>
                                            <div class="col-md-9">
                                                <select name="addon_category_id"
                                                        class="select2AddonCategory form-control"
                                                        data-name="addon_category_id">
                                                    <option value="">
                                                        ---{{ __('catalog::dashboard.addon_options.alert.select_addon_category') }}
                                                        ---
                                                    </option>
                                                    @foreach($sharedActiveAddonCategories as $k => $addonCategory)
                                                        <option value="{{ $addonCategory->id }}">
                                                            {{ $addonCategory->getTranslation('title', locale()) }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <div class="help-block"></div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{__('catalog::dashboard.addon_options.form.price')}}
                                            </label>
                                            <div class="col-md-9">
                                                <input type="text" name="price" class="form-control"
                                                       data-name="price">
                                                <div class="help-block"></div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{__('catalog::dashboard.addon_options.form.qty')}}
                                            </label>
                                            <div class="col-md-9">
                                                <div class="form-check">
                                                    <span style="margin: 10px;">
                                                        <input type="radio"
                                                               class="manageQty"
                                                               name="manage_qty"
                                                               value="unlimited"
                                                               onchange="manageQty(this.value)"
                                                               checked>
                                                        <label class="form-check-label">
                                                            {{__('catalog::dashboard.addon_options.form.unlimited')}}
                                                        </label>
                                                    </span>

                                                    <span style="margin: 10px;">
                                                        <input type="radio"
                                                               name="manage_qty"
                                                               class="manageQty"
                                                               value="limited"
                                                               onchange="manageQty(this.value)">
                                                        <label class="form-check-label">
                                                            {{__('catalog::dashboard.addon_options.form.limited')}}
                                                        </label>

                                                         <input type="number" id="prdQty" name="qty"
                                                                class="form-control"
                                                                data-name="qty" style="display: none;">
                                                        <div class="help-block"></div>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{__('catalog::dashboard.addon_options.form.image')}}
                                            </label>
                                            <div class="col-md-9">
                                                @include('core::dashboard.shared.file_upload', ['image' => null])
                                                <div class="help-block"></div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-actions">
                                @include('apps::dashboard.layouts._ajax-msg')
                                <div class="form-group">
                                    <button type="submit" id="submit" class="btn btn-lg blue">
                                        {{__('apps::dashboard.general.add_btn')}}
                                    </button>
                                    <a href="{{url(route('dashboard.addon_options.index')) }}"
                                       class="btn btn-lg red">
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


@section('scripts')

    <script type="text/javascript">
        $(function () {
            $(".select2AddonCategory").select2({
                placeholder: "{{__('catalog::dashboard.addon_options.alert.select_addon_category')}}",
            });
        });

        function manageQty(value) {
            if (value == 'limited')
                $('#prdQty').show();
            else
                $('#prdQty').hide();
        }
    </script>

@endsection
