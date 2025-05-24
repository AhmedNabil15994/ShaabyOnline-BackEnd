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
                <form id="addOnsForm" class="form-horizontal form-row-seperated" method="post"
                      enctype="multipart/form-data" action="{{route('dashboard.products.store_add_ons',$product->id)}}">
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

                                <div class="tab-pane active fade in" id="add_ons">
                                    <h3 id="pageTitle"
                                        class="page-title">{{ __('catalog::dashboard.products.form.tabs.add_ons') }}</h3>
                                    <div class="col-md-10">

                                        <input type="hidden" name="add_on_id" value="">

                                        @foreach (config('translatable.locales') as $code)
                                            <div class="form-group">
                                                <label class="col-md-2">
                                                    {{__('catalog::dashboard.products.form.add_ons.name')}}
                                                    - {{ $code }} <span class="required-input">*</span>
                                                </label>
                                                <div class="col-md-9">
                                                    <input type="text" name="option_name[{{$code}}]"
                                                           data-name="option_name.{{$code}}"
                                                           class="form-control" autocomplete="off">
                                                    <div class="help-block"></div>
                                                </div>
                                            </div>
                                        @endforeach

                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{ __('catalog::dashboard.products.form.add_ons.type') }}
                                            </label>
                                            <div class="col-md-9">
                                                <div class="mt-radio-inline">
                                                    <label class="mt-radio mt-radio-outline"> {{ __('catalog::dashboard.products.form.add_ons.single') }}
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

                                        <table class="table table-striped table-bordered table-hover">
                                            <thead>
                                            <tr>
                                                <th>{{__('catalog::dashboard.products.form.add_ons.option')}}</th>
                                                <th>{{__('catalog::dashboard.products.form.add_ons.price')}}</th>
                                                <th>{{__('catalog::dashboard.products.form.add_ons.default')}}</th>
                                                <th></th>
                                            </tr>
                                            </thead>
                                            <tbody id="optionsBody">
                                            <tr id="optionRow-0">
                                                <input type="hidden" name="rowId[]" value="0">
                                                <td>
                                                    @foreach (config('translatable.locales') as $code)
                                                        <input type="text"
                                                               class="form-control add_ons_option"
                                                               name="option[0][{{$code}}]"
                                                               autocomplete="off"
                                                               placeholder="{{__('catalog::dashboard.products.form.add_ons.option')}} - {{ $code }}">
                                                    @endforeach
                                                </td>
                                                <td><input type="number" step="0.01" class="form-control optionPrice"
                                                           name="price[]"
                                                           autocomplete="off">
                                                </td>
                                                <td><input type="radio" name="default" value="0"></td>
                                                <td>
                                                    <button type="button" class="btn btn-danger"
                                                            onclick="deleteOptions(0, 0, 'row')">x
                                                    </button>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        <div id="optionsCountRow" class="row" style="display: none;">
                                            <div class="col-md-12">
                                                <div class="pull-left">{{ __('catalog::dashboard.products.form.add_ons.customer_can_select_exactly') }}
                                                    <input class="options_count_select" type="checkbox"
                                                           name="options_count_select"></div>
                                                <div class="pull-right">
                                                    <input id="options_count" name="options_count" type="number"
                                                           class="form-control"
                                                           disabled="disabled"
                                                           placeholder="{{ __('catalog::dashboard.products.form.add_ons.options_count') }}">
                                                </div>
                                            </div>
                                        </div>
                                        <br>

                                        <a href="javascript:;" class="pull-left" onclick="addMoreOptions()"><i
                                                    class="fa fa-plus"></i> {{__('catalog::dashboard.products.form.add_ons.add_more')}}
                                        </a>
                                        <button type="submit" id="submit" class="btn btn-success pull-right"><i
                                                    class="fa fa-save"></i> {{__('catalog::dashboard.products.form.add_ons.save_options')}}
                                        </button>
                                        <a href="javascript:;" style="margin-left: 10px; margin-right: 10px;"
                                           class="pull-right"
                                           onclick="clearDefaults()"><i
                                                    class="fa fa-remove"></i> {{__('catalog::dashboard.products.form.add_ons.clear_defaults')}}
                                        </a>
                                        <a id="resetForm" href="javascript:;"
                                           style="display: none; margin-left: 10px; margin-right: 10px;"
                                           class="pull-right"
                                           onclick="defaultMode()"><i
                                                    class="fa fa-refresh"></i> {{__('catalog::dashboard.products.form.add_ons.reset_form')}}
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
                                                        <td>{{ $value->name }}</td>
                                                        <td>
                                                            @if($value->type == 'single')
                                                                <span>{{ __('catalog::dashboard.products.form.add_ons.single') }}</span>
                                                            @else
                                                                <span>{{ __('catalog::dashboard.products.form.add_ons.multiple') }}</span>
                                                            @endif
                                                        </td>
                                                        <td>{{ $value->created_at }}</td>
                                                        <td>
                                                            <a href="javascript:void(0)" class="btn btn-primary"
                                                               onclick="editMasterOptions('', {{ $value->id }}, {{ $product->addOns[$k] }})"
                                                               title="{{__('apps::dashboard.general.edit_btn')}}"><i
                                                                        class="fa fa-edit"></i></a>

                                                            <a href="javascript:void(0)" class="btn btn-warning"
                                                               onclick="openAddOnsDetails('', {{ $value->id }}, {{ $product->addOns[$k] }})"
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
        var optionsCountRow = $('#optionsCountRow');
        var optionsBody = $('#optionsBody');
        var pageTitle = $('#pageTitle');
        var resetForm = $('#resetForm');
        var rowCountsArray = [0];
        var addOnsData = [];
        var lang     = "{{locale()}}"
        var langues = @json(config("translatable.locales"))

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
                $("#options_count").prop("disabled", false)
            } else {
                $("#options_count").prop("disabled", true).val('');
            }
        });

        function addMoreOptions() {

            var rowCount = Math.floor(Math.random() * 9000000000) + 1000000000;
            rowCountsArray.push(rowCount);

            var newRow = `
            <tr id="optionRow-${rowCount}">
                            <td>
                            <input type="hidden" name="rowId[]" value="${rowCount}">
                                @foreach (config('translatable.locales') as $code)
                <input type="text" class="form-control add_ons_option"
               name="option[${rowCount}][{{$code}}]" placeholder="{{__('catalog::dashboard.products.form.add_ons.option')}} - {{ $code }}" autocomplete="off">
                                @endforeach
                </td>
                <td><input type="number" step="0.01" class="form-control optionPrice" name="price[]" autocomplete="off"></td>
                <td><input type="radio" name="default" value="${rowCount}"></td>
                <td>
                    <button type="button" class="btn btn-danger" onclick="deleteOptions(${rowCount}, ${rowCount}, 'row')">x</button>
                </td>
            </tr>`;

            optionsBody.append(newRow);
        }

        function deleteOptions(index, rowId, flag = '') {

            if (rowCountsArray.length > 1) {

                if (flag === 'db') {

                    var r = confirm("{{ __('catalog::dashboard.products.form.add_ons.confirm_msg') }}");
                    if (r == true) {

                        $.ajax({
                            url: "{{route('dashboard.products.delete_add_ons_option')}}?id=" + rowId,
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

                                    $('#optionRow-' + index).remove();
                                    const k = rowCountsArray.indexOf(index);
                                    if (k > -1) {
                                        rowCountsArray.splice(k, 1);
                                    }

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
                    $('#optionRow-' + index).remove();
                    const i = rowCountsArray.indexOf(index);
                    if (i > -1) {
                        rowCountsArray.splice(i, 1);
                    }
                }

            } else {
                alert("{{__('catalog::dashboard.products.form.add_ons.at_least_one_field')}}");
                return false;
            }
        }

        $('#addOnsForm').on('submit', function (e) {

            e.preventDefault();

            var url = $(this).attr('action');
            var method = $(this).attr('method');
            var addOnId = $("input[name='add_on_id']").val();
            var optionsCount = $("#options_count").val();

            if (optionsCount && optionsCount !== '') {
                var rows = $("input[name='rowId[]']").map(function () {
                    return $(this).val();
                }).get();

                if (optionsCount > rows.length) {
                    alert("{{__('catalog::dashboard.products.form.add_ons.options_count_greater_than_rows')}}");
                    return;
                }
            }

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
                    $('#optionRow-0').nextAll().remove();

                    // console.log('data:::', data.data);

                    if (data[0] == true) {
                        successfully(data);
                        resetErrors();
                        if (addOnId && addOnId != '') {
                            //Default Mode
                            defaultMode('edit');
                            // Delete Old Row
                            $('#addOnsRow-' + addOnId).remove();
                            appendNewOptionRow(data.data);
                        } else {
                            appendNewOptionRow(data.data);
                        }
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

            if (data.type === 'single') {
                addOnsType = "{{ __('catalog::dashboard.products.form.add_ons.single') }}";
            } else {
                addOnsType = "{{ __('catalog::dashboard.products.form.add_ons.multiple') }}";
            }
            var allAddOnsTable = $('#allAddOnsTable');
            var newRow = `<tr id="addOnsRow-${data.id}">
                                            <td>${lang in data.name && data.name[lang]}</td>
                                            <td>${addOnsType}</td>
                                            <td>${data.created_at}</td>
                                            <td>
                                            <a href="javascript:void(0)" class="btn btn-primary"
                                               onclick="editMasterOptions('row', ${data.id})" title="{{__('apps::dashboard.general.edit_btn')}}"><i class="fa fa-edit"></i></a>

                                            <a href="javascript:void(0)" class="btn btn-warning"
                                               onclick="openAddOnsDetails('row', ${data.id})" title="{{__('catalog::dashboard.products.form.add_ons.show')}}"><i class="fa fa-eye"></i></a>

                                            <a href="javascript:void(0)" class="btn btn-danger"
                                               onclick="deleteMasterOptions(${data.id}, 'db')" title="{{__('apps::dashboard.general.delete_btn')}}"><i class="fa fa-trash"></i></a>
                                            </td>
                                        </tr>`;
            allAddOnsTable.append(newRow);
            addOnsData[data.id] = data;
        }

        function clearDefaults() {
            $("input[name='default']").prop('checked', false);
        }

        function openAddOnsDetails(flag = '', rowId, data = {}) {

            if (flag === 'row') {
                data = addOnsData[rowId];
            }

            var modalContent = $('#modalContent');
            if (data.type === 'single') {
                addOnsType = "{{ __('catalog::dashboard.products.form.add_ons.single') }}";
            } else {
                addOnsType = "{{ __('catalog::dashboard.products.form.add_ons.multiple') }}";
            }
            var modal = `<div class="modal fade" id="modal-${data.id}" tabindex="-1" role="dialog" aria-labelledby="modalLabel-${data.id}" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="modalLabel-${data.id}">{{ __('catalog::dashboard.products.form.tabs.add_ons') }}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                                <div class="modal-body">

                                    <div style='margin-bottom: 7px;'>{{__('catalog::dashboard.products.form.add_ons.add_ons_name')}} : <b>${lang in data.name && data.name[lang]}</b></div>
                                    <div style='margin-bottom: 7px;'>{{__('catalog::dashboard.products.form.add_ons.type')}} : <b>${addOnsType}</b></div>
                                    <div style='margin-bottom: 7px;'>{{__('catalog::dashboard.products.form.add_ons.options_count')}} : <b>${data.options_count == null ? '---' : data.options_count}</b></div>
                                    <div style='margin-bottom: 7px;'>{{__('catalog::dashboard.products.form.add_ons.created_at')}} : <b>${data.created_at}</b></div>
                                    <br>
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{__('catalog::dashboard.products.form.add_ons.option')}}</th>
                                            <th>{{__('catalog::dashboard.products.form.add_ons.price')}}</th>
                                            <th>{{__('catalog::dashboard.products.form.add_ons.default')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>`;
            for (let $value of data.add_on_options) {
                modal += `
                <tr>
                   <td>${$value.id}</td>
                   <td>${lang in $value.option &&  $value.option[lang]}</td>
                   <td>${$value.price}</td>
                   <td>${$value.default == null ? "{{__('apps::dashboard.general.no_btn')}}" : "{{__('apps::dashboard.general.yes_btn')}}"}</td>
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
            $('#modal-' + data.id).modal('show')
        }

        function editMasterOptions(flag = '', rowId, data = {}) {

            if (flag === 'row') {
                data = addOnsData[rowId];
            }

            resetForm.show();
            var pTitle = "{{ __('catalog::dashboard.products.form.tabs.edit_add_ons') }}" + " - " +  (lang in data.name  &&  data.name[lang]);
            pageTitle.text(pTitle);

            $("input[name='add_on_id']").val(data.id);
            if (data.type === 'single') {
                $('#singleType').prop("checked", true);
                optionsCountRow.hide();
            } else {
                $('#multiType').prop("checked", true);
                optionsCountRow.show();
            }

            if (data.type === 'multi' && data.options_count != null) {
                $("input[name='options_count_select']").prop("checked", true);
                $("#options_count").prop("disabled", false).val(data.options_count);
            } else {
                $("input[name='options_count_select']").prop("checked", false);
                $("#options_count").prop("disabled", true).val('');
            }

            optionsBody.empty();
            assignAddOnsName('', data);

            data.add_on_options.forEach(function (item, i) {


                rowCountsArray.push(i);

                var newRow = `
                        <tr id="optionRow-${i}">
                            <td><input type="hidden" name="rowId[]" value="${item.id}">`;
                langues.forEach(function (index) {

                    newRow += `<input type="text" class="form-control add_ons_option"
                                name="option[${item.id}][${index}]"
                                value="${index in item.option && item.option[index]}"
                                 placeholder="{{__('catalog::dashboard.products.form.add_ons.option')}} - ${index}" autocomplete="off">`;
                });

                newRow += `</td>
                        <td><input type="number" step="0.01" class="form-control optionPrice" name="price[]" autocomplete="off" value="${item.price}"></td>
                        <td><input type="radio" name="default" value="${item.id}" ${item.default == 1 ? 'checked' : ''}></td>
                            <td>
                                <button type="button" class="btn btn-danger" onclick="deleteOptions(${i}, (${item.id}, 'db')">x</button>
                            </td>
                        </tr>`;

                optionsBody.append(newRow);

            });

        }

        function defaultMode(flag = '') {
            resetForm.hide();
            rowCountsArray = [0];
            if (flag !== 'edit') {
                addOnsData = [];
            }
            var pTitle = "{{ __('catalog::dashboard.products.form.tabs.add_ons') }}";
            pageTitle.text(pTitle);
            $('#singleType').prop("checked", true);
            $("input[name='options_count_select']").prop("checked", false);
            $("#options_count").prop("disabled", true).val('');
            optionsCountRow.hide();
            $('#optionRow-0').nextAll().remove();
            $('.optionPrice').val('');
            assignAddOnsName('reset');
            $("input[name='add_on_id']").val('');
            clearDefaults();
        }

        function assignAddOnsName(flag = '', data = {}) {

            if (flag === 'reset') {
                @foreach (config('translatable.locales') as $k => $code)
                $("input[name='option_name[{{ $code }}]']").val('');
                $("input[name='option[0][{{ $code }}]']").val('');
                @endforeach
            } else {


                for (const code of langues) {

                    $(`input[name="option_name[${code}]"]`).val(data.name[code])

                }

            }

        }

    </script>

@endsection
