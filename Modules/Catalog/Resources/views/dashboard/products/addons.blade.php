@extends('apps::dashboard.layouts.app')
@section('title', __('catalog::dashboard.products.routes.add_ons'))
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
                    <a href="{{ url(route('dashboard.products.index')) }}">
                        {{__('catalog::dashboard.products.routes.index')}}
                    </a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <a href="javascript:;">{{__('catalog::dashboard.products.routes.add_ons')}}</a>
                </li>
            </ul>
        </div>

        <h1 class="page-title"></h1>

        <div class="row">
            <form id="addOnsForm" class="form-horizontal form-row-seperated" method="post" enctype="multipart/form-data"
                action="{{route('dashboard.products.store_add_ons', $product->id)}}">
                @csrf
                @method('POST')
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
                                                <a href="#add_ons" data-toggle="tab">
                                                    {{ __('catalog::dashboard.products.form.tabs.add_ons') }}
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

                            <h4>{{ __('catalog::dashboard.products.form.add_ons.product') }}
                                : {{ $product->getTranslation('title', locale()) }}</h4>
                            <hr>
                            <div class="tab-pane active fade in" id="add_ons">
                                <h4 id="pageTitle" class="" style="margin-bottom: 25px;"></h4>
                                <div class="col-md-10">

                                    <div class="form-group">
                                        <label class="col-md-2">
                                            {{__('catalog::dashboard.addon_options.form.addon_category_id')}}
                                        </label>
                                        <div class="col-md-6">
                                            <select name="addon_category_id" class="select2AddonCategory form-control"
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
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-2">
                                            {{ __('catalog::dashboard.products.form.add_ons.type') }}
                                        </label>
                                        <div class="col-md-6">
                                            <div class="mt-radio-inline">
                                                <label class="mt-radio mt-radio-outline">
                                                    {{ __('catalog::dashboard.products.form.add_ons.single') }}
                                                    <input type="radio" id="singleType" name="add_ons_type"
                                                        value="single" checked>
                                                    <span></span>
                                                </label>
                                                <label class="mt-radio mt-radio-outline">
                                                    {{ __('catalog::dashboard.products.form.add_ons.multiple') }}
                                                    <input type="radio" id="multiType" name="add_ons_type"
                                                        value="multi">
                                                    <span></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="optionsCountRow" class="row" style="display: none;">
                                        <div class="col-md-12">

                                            <div class="pull-left">
                                                <div class="mt-checkbox-list">
                                                    <label class="mt-checkbox">
                                                        {{ __('catalog::dashboard.products.form.add_ons.customer_can_select_exactly') }}
                                                        <input type="checkbox" name="options_count_select"
                                                            class="options_count_select" />
                                                        <span></span>
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="pull-right" style="margin-right: 10px;">
                                                <input id="max_options_count" name="max_options_count" type="number"
                                                    class="form-control" disabled="disabled"
                                                    placeholder="{{ __('catalog::dashboard.products.form.add_ons.max_options_count') }}">
                                            </div>
                                            <div class="pull-right">
                                                <input id="min_options_count" name="min_options_count" type="number"
                                                    class="form-control" disabled="disabled"
                                                    placeholder="{{ __('catalog::dashboard.products.form.add_ons.min_options_count') }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="pull-left" id="isRequiredCheckboxSection" style="display: none;">
                                        <div class="mt-checkbox-list">
                                            <label class="mt-checkbox">
                                                {{ __('catalog::dashboard.products.form.add_ons.is_required') }}
                                                <input type="checkbox" name="is_required" class="is_required" />
                                                <span></span>
                                            </label>
                                        </div>
                                    </div>

                                    <br>

                                    <div id="addonsLoader" class="text-center" style="display: none;">
                                        {{__('catalog::dashboard.products.form.add_ons.loading')}}
                                    </div>
                                    <div id="addonOptionsContent"></div>

                                    <button type="submit" id="submit" class="btn btn-success pull-right">
                                        <i class="fa fa-save"></i>
                                        {{__('catalog::dashboard.products.form.add_ons.save_options')}}
                                    </button>
                                    <a href="javascript:;" id="btnClearDefaults"
                                        style="display: none; margin-left: 10px; margin-right: 10px;"
                                        class="pull-right btn" onclick="clearDefaults()">
                                        <i class="fa fa-remove"></i>
                                        {{__('catalog::dashboard.products.form.add_ons.clear_defaults')}}
                                    </a>

                                    <br><br><br>

                                    <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>{{__('catalog::dashboard.products.form.add_ons.add_ons_name')}}</th>
                                                <th>{{__('catalog::dashboard.products.form.add_ons.type')}}</th>
                                                <th>{{__('catalog::dashboard.products.form.add_ons.created_at')}}</th>
                                                <th>{{__('catalog::dashboard.products.form.add_ons.operations')}}</th>
                                            </tr>
                                        </thead>
                                        <tbody id="allAddOnsTable">
                                            @if(count($product->addOns) > 0)
                                            @foreach($product->addOns as $k => $value)
                                            <tr id="addOnsRow-{{ $value->id }}">
                                                <td>{{ $value->addonCategory->getTranslation('title', locale()) }}</td>
                                                <td>
                                                    @if($value->type == 'single')
                                                    <span>{{ __('catalog::dashboard.products.form.add_ons.single') }}</span>
                                                    @else
                                                    <span>{{ __('catalog::dashboard.products.form.add_ons.multiple') }}</span>
                                                    @endif
                                                </td>
                                                <td>{{ $value->created_at }}</td>
                                                <td>
                                                    <a href="javascript:void(0)" class="btn btn-warning"
                                                        onclick="openAddOnsDetails({{ $value->id }})"
                                                        title="{{__('catalog::dashboard.products.form.add_ons.show')}}"><i
                                                            class="fa fa-eye"></i></a>

                                                    <a href="javascript:void(0)" class="btn btn-danger"
                                                        onclick="deleteMasterOptions({{ $value->id }}, 'db')"
                                                        title="{{__('apps::dashboard.general.delete_btn')}}"><i
                                                            class="fa fa-trash"></i></a>
                                                </td>
                                            </tr>
                                            @endforeach
                                            @endif
                                        </tbody>
                                    </table>

                                </div>
                            </div>

                        </div>
                    </div>

                    {{-- PAGE ACTION --}}
                    <div class="col-md-12">
                        <div class="form-actions">
                            @include('apps::dashboard.layouts._ajax-msg')
                            <div class="form-group">
                                <a href="{{url(route('dashboard.products.index')) }}" class="btn btn-lg red">
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

<div id="modalContent"></div>

@stop

@section('scripts')

<script>
    var select2AddonCategory = $('.select2AddonCategory');
        var addonOptionsContent = $('#addonOptionsContent');
        var addonsLoader = $('#addonsLoader');
        var optionsCountRow = $('#optionsCountRow');
        var optionsBody = $('#optionsBody');
        var pageTitle = $('#pageTitle');
        var resetForm = $('#resetForm');
        var allAddOnsTable = $('#allAddOnsTable');
        var rowCountsArray = [0];
        var addOnsData = [];

        $(function () {
            select2AddonCategory.select2({
                placeholder: "{{__('catalog::dashboard.addon_options.alert.select_addon_category')}}",
                allowClear: true,
            });

            $('input[name=add_ons_type]').change(function () {
                var value = $(this).val();
                if (value === 'single') {
                    optionsCountRow.hide();
                } else {
                    optionsCountRow.show();
                }
            });

            $(".options_count_select").change(function () {
                if (this.checked) {
                    $("#min_options_count, #max_options_count").prop("disabled", false)
                } else {
                    $("#min_options_count, #max_options_count").prop("disabled", true).val('');
                }
            });

        });

        select2AddonCategory.on('select2:select', function (e) {
            var vData = e.params.data;
            var selectedText = vData.text.trim();
            var selectedValue = vData.id;

            if (selectedValue != null) {
                getAddonOptionContent(selectedValue);
            }
        });

        select2AddonCategory.on('select2:unselect', function (e) {
            var data = e.params.data;
            addonOptionsContent.empty();
            $('#btnClearDefaults').hide();
            $('#isRequiredCheckboxSection').hide();
        });

        function deleteOptions(index) {
            $('#addonOptionsRow-' + index).remove();
        }

        $('#addOnsForm').on('submit', function (e) {

            e.preventDefault();

            var url = $(this).attr('action');
            var method = $(this).attr('method');

            $.ajax({

                xhr: function () {
                    var xhr = new window.XMLHttpRequest();
                    xhr.upload.addEventListener("progress", function (evt) {
                        if (evt.lengthComputable) {
                            var percentComplete = evt.loaded / evt.total;
                            percentComplete = parseInt(percentComplete * 100);
                            $('.progress-bar').width(percentComplete + '%');
                            $('#progress-status').html(percentComplete + '%');
                        }
                    }, false);
                    return xhr;
                },

                url: url,
                type: method,
                dataType: 'JSON',
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,

                beforeSend: function () {
                    $('#submit').prop('disabled', true);
                    $('.progress-info').show();
                    $('.progress-bar').width('0%');
                    resetErrors();
                },
                success: function (data) {

                    $('#submit').prop('disabled', false);
                    $('#submit').text();
                    addonOptionsContent.empty();
                    $('.img-preview').hide();
                    $("input[name='image[]']").val('');
                    defaultOptionCount();
                    select2AddonCategory.val(null).trigger('change');

                    if (data[0] == true) {
                        successfully(data);
                        resetErrors();

                        appendNewOptionRow(data.data);
                    } else {
                        displayMissing(data);
                    }

                },
                error: function (data) {

                    $('#submit').prop('disabled', false);
                    displayErrors(data);

                },
            });

        });

        function deleteMasterOptions(rowId, flag = '') {

            // remove item from Database
            if (flag === 'db') {

                var r = confirm("{{ __('catalog::dashboard.products.form.add_ons.confirm_msg') }}");
                if (r == true) {

                    $.ajax({
                        url: "{{route('dashboard.products.delete_add_ons')}}?id=" + rowId,
                        type: 'get',
                        dataType: 'JSON',
                        contentType: false,
                        cache: false,
                        processData: false,

                        beforeSend: function () {
                            $('.progress-info').show();
                            $('.progress-bar').width('0%');
                            resetErrors();
                        },
                        success: function (data) {

                            if (data[0] == true) {
                                $('#addOnsRow-' + rowId).remove();
                                successfully(data);
                                resetErrors();
                            } else {
                                displayMissing(data);
                            }

                        },
                        error: function (data) {
                            displayErrors(data);
                        },
                    });

                }
            } else {
                $('#addOnsRow-' + rowId).remove();
            }
        }

        function appendNewOptionRow(data) {
            var rows = ``;
            var addOnsType = '';
            for (let value of data) {

                if (value.type === 'single') {
                    addOnsType = "{{ __('catalog::dashboard.products.form.add_ons.single') }}";
                } else {
                    addOnsType = "{{ __('catalog::dashboard.products.form.add_ons.multiple') }}";
                }

                rows += `<tr id="addOnsRow-${value.id}">
                                <td>${value.title}</td>
                                <td>${addOnsType}</td>
                                <td>${value.created_at}</td>
                                <td>
                                <a href="javascript:void(0)" class="btn btn-warning"
                                   onclick="openAddOnsDetails(${value.id})" title="{{__('catalog::dashboard.products.form.add_ons.show')}}"><i class="fa fa-eye"></i></a>

                                <a href="javascript:void(0)" class="btn btn-danger"
                                   onclick="deleteMasterOptions(${value.id}, 'db')" title="{{__('apps::dashboard.general.delete_btn')}}"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>`;
            }
            allAddOnsTable.html(rows);
        }

        function getAddonOptionContent(addonCategoryId) {
            $.ajax({
                url: "{{route('dashboard.addon_options.get_by_addon_category')}}?product_id={{ $product->id }}&addon_category_id=" + addonCategoryId,
                type: 'get',
                dataType: 'JSON',
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function () {
                    addonsLoader.show();
                    addonOptionsContent.empty();
                },
                success: function (data) {
                    if (data.status == true && data.data.options.length > 0) {
                        buildAddonOptionContent(data.data);
                    }
                },
                error: function (data) {
                    addonsLoader.hide();
                    displayErrors(data);
                },
                complete: function (data) {
                    console.log('addonsLoader:com');
                    addonsLoader.hide();
                },
            });
        }

        function buildAddonOptionContent(data) {
            var rows = `
                            <table class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <th style="width: 80px;" class="text-center">{{__('catalog::dashboard.products.form.add_ons.image')}}</th>
                                <th class="text-center">{{__('catalog::dashboard.products.form.add_ons.title')}}</th>
                                <th class="text-center">{{__('catalog::dashboard.products.form.add_ons.price')}}</th>
                                <th class="text-center">{{__('catalog::dashboard.products.form.add_ons.qty')}}</th>
                                <th class="text-center">{{__('catalog::dashboard.products.form.add_ons.default')}}</th>
                                <th style="width: 40px;" class="text-center">{{__('catalog::dashboard.products.form.add_ons.delete')}}</th>
                            </tr>
                            </thead>
                            <tbody id="optionsBody">`;
            $.each(data.options, function (i, value) {
                rows += `<tr id="addonOptionsRow-${value.id}">
                                            <input type="hidden" name="addon_options[]" value="${value.id}">
                                            <td class="text-center">`;
                if (value.image != null) {
                    rows += `<img src="${value.image}" style="height: 35px;" class="img-thumbnail">`;
                } else {
                    rows += `---`;
                }
                rows += `</td>
                                     <td class="text-center">${value.title}</td>
                                     <td class="text-center">${value.price}</td>
                                     <td class="text-center">${value.qty ?? '---'}</td>
                                     <td class="text-center"><input type="radio" name="default" value="${value.id}" ${value.default == true ? 'checked' : ''}></td>
                                     <td class="text-center">
                                        <button type="button" class="btn btn-danger"
                                             onclick="deleteOptions(${value.id})"><i class="fa fa-trash"></i>
                                        </button>
                                    </td>
                                 </tr>`;
            });
            rows += `</tbody></table>`;
            addonOptionsContent.html(rows);
            defaultOptionCount();
            $('#btnClearDefaults').show();
            $('#isRequiredCheckboxSection').show();
            if(data.product_addon != null && data.product_addon.is_required == 1)
                $("input[name='is_required']").prop("checked", true);

            if (data.product_addon != null && data.product_addon.type == 'multi') {
                $('#multiType').prop("checked", true);
                optionsCountRow.show();
                if (data.product_addon.max_options_count != null || data.product_addon.min_options_count != null) {
                    $("input[name='options_count_select']").prop("checked", true);
                    $("#min_options_count").prop("disabled", false).val(data.product_addon.min_options_count);
                    $("#max_options_count").prop("disabled", false).val(data.product_addon.max_options_count);
                }
            }
        }

        function openAddOnsDetails(rowId) {

            $.ajax({
                url: "{{route('dashboard.addon_options.get_addon_details')}}?product_addon_id=" + rowId,
                type: 'get',
                dataType: 'JSON',
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function () {

                },
                success: function (data) {
                    buildAddonDetails(rowId, data.data);
                },
                error: function (data) {
                    displayErrors(data);
                },
                complete: function (data) {
                },
            });

        }

        function buildAddonDetails(rowId, data) {
            $('#modal-' + rowId).remove();
            var modalContent = $('#modalContent');
            var addOnsType = '';
            var isRequired = '';

            if (data.type === 'single')
                addOnsType = "{{ __('catalog::dashboard.products.form.add_ons.single') }}";
             else
                addOnsType = "{{ __('catalog::dashboard.products.form.add_ons.multiple') }}";

            if (data.is_required == 1)
                isRequired = "{{__('apps::dashboard.general.yes_btn')}}";
            else
                isRequired = "{{__('apps::dashboard.general.no_btn')}}";


            var modal = `<div class="modal fade" id="modal-${rowId}" tabindex="-1" role="dialog" aria-labelledby="modalLabel-${rowId}" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                             <div class="modal-content">
                                  <div class="modal-header">
                                        <h5 class="modal-title" id="modalLabel-${rowId}">{{ __('catalog::dashboard.products.form.tabs.add_ons') }} : {{ $product->getTranslation('title', locale()) }}</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                        </button>
                                  </div>
                                  <div class="modal-body">

                                    <div style='margin-bottom: 7px;'>{{__('catalog::dashboard.products.form.add_ons.add_ons_name')}} : <b>${data.addon_category_title}</b></div>
                                    <div style='margin-bottom: 7px;'>{{__('catalog::dashboard.products.form.add_ons.type')}} : <b>${addOnsType}</b></div>
                                    <div style='margin-bottom: 7px;'>{{__('catalog::dashboard.products.form.add_ons.min_options_count')}} : <b>${data.min_options_count == null ? '---' : data.min_options_count}</b></div>
                                    <div style='margin-bottom: 7px;'>{{__('catalog::dashboard.products.form.add_ons.max_options_count')}} : <b>${data.max_options_count == null ? '---' : data.max_options_count}</b></div>
                                    <div style='margin-bottom: 7px;'>{{__('catalog::dashboard.products.form.add_ons.is_required')}} : <b>${isRequired}</b></div>
                                    <div style='margin-bottom: 7px;'>{{__('catalog::dashboard.products.form.add_ons.created_at')}} : <b>${data.created_at}</b></div>
                                    <br>
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{__('catalog::dashboard.products.form.add_ons.image')}}</th>
                                            <th>{{__('catalog::dashboard.products.form.add_ons.title')}}</th>
                                            <th>{{__('catalog::dashboard.products.form.add_ons.price')}}</th>
                                            <th>{{__('catalog::dashboard.products.form.add_ons.qty')}}</th>
                                            <th>{{__('catalog::dashboard.products.form.add_ons.default')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>`;
            for (let value of data.addonOptions) {
                modal += `
                <tr>
                   <td>${value.id}</td>`;
                if (value.image != null) {
                    var imgUrl = value.image;
                    modal += `<td><img src="${imgUrl}" style="height: 35px;"></td>`;
                } else {
                    modal += `<td>---</td>`;
                }
                modal += `<td>${value.title}</td>
                   <td>${parseFloat(value.price).toFixed(2)}</td>
                   <td>${value.qty ?? '---'}</td>
                   <td>${value.default == 0 ? "{{__('apps::dashboard.general.no_btn')}}" : "{{__('apps::dashboard.general.yes_btn')}}"}</td>
                </tr>
                `;
            }
            modal += `</tbody>
                    </table>

                </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('apps::dashboard.general.close_btn')}}</button>
            </div>
            </div>
            </div>
          </div>`;

            modalContent.append(modal);
            $('#modal-' + rowId).modal('show')
        }

        function defaultOptionCount() {
            $('#singleType').prop("checked", true);
            $("input[name='options_count_select']").prop("checked", false);
            $("#min_options_count").prop("disabled", true).val('');
            $("#max_options_count").prop("disabled", true).val('');
            $('#isRequiredCheckboxSection').hide();
            $("input[name='is_required']").prop("checked", false);
            optionsCountRow.hide();
        }

        function clearDefaults() {
            $("input[name='default']").prop('checked', false);
        }

</script>

@endsection