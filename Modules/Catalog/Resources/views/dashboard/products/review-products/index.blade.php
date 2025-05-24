@extends('apps::dashboard.layouts.app')
@section('title', __('catalog::dashboard.products.routes.review_products'))
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
                        <a href="#">{{__('catalog::dashboard.products.routes.review_products')}}</a>
                    </li>
                </ul>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="portlet light bordered">

                        {{-- DATATABLE FILTER --}}
                        <div class="row">
                            <div class="portlet box grey-cascade">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="fa fa-gift"></i>
                                        {{__('apps::dashboard.datatable.search')}}
                                    </div>
                                    <div class="tools">
                                        <a href="javascript:;" class="collapse" data-original-title="" title=""> </a>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <div id="filter_data_table">
                                        <div class="panel-body">
                                            <form id="formFilter" class="horizontal-form">
                                                <div class="form-body">
                                                    <div class="row">

                                                        {{--<div class="col-md-3">
                                                            <div class="form-group">
                                                                <label class="control-label">
                                                                    {{__('apps::dashboard.datatable.form.date_range')}}
                                                                </label>
                                                                <div id="reportrange" class="btn default form-control">
                                                                    <i class="fa fa-calendar"></i> &nbsp;
                                                                    <span> </span>
                                                                    <b class="fa fa-angle-down"></b>
                                                                    <input type="hidden" name="from">
                                                                    <input type="hidden" name="to">
                                                                </div>
                                                            </div>
                                                        </div>--}}

                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <label class="control-label">
                                                                    {{__('apps::dashboard.datatable.form.status')}}
                                                                </label>
                                                                <div class="mt-radio-list">
                                                                    <label class="mt-radio">
                                                                        {{__('apps::dashboard.datatable.form.active')}}
                                                                        <input type="radio" value="1" name="status"/>
                                                                        <span></span>
                                                                    </label>
                                                                    <label class="mt-radio">
                                                                        {{__('apps::dashboard.datatable.form.unactive')}}
                                                                        <input type="radio" value="0" name="status"/>
                                                                        <span></span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        @if (config('setting.other.is_multi_vendors') == 1)
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class="control-label">
                                                                        {{__('apps::dashboard.datatable.form.search_by_vendor')}}
                                                                    </label>
                                                                    <select name="vendor"
                                                                            class="searchableSelect form-control select2">
                                                                        <option value=""></option>
                                                                        @foreach ($vendors as $item)
                                                                            <option value="{{ $item->id }}">
                                                                                {{ $item->title }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        @endif

                                                    </div>
                                                </div>
                                            </form>
                                            <div class="form-actions">
                                                <button class="btn btn-sm green btn-outline filter-submit margin-bottom"
                                                        id="search">
                                                    <i class="fa fa-search"></i>
                                                    {{__('apps::dashboard.datatable.search')}}
                                                </button>
                                                <button class="btn btn-sm red btn-outline filter-cancel">
                                                    <i class="fa fa-times"></i>
                                                    {{__('apps::dashboard.datatable.reset')}}
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- END DATATABLE FILTER --}}


                        <div class="portlet-title">
                            <div class="caption font-dark">
                                <i class="icon-settings font-dark"></i>
                                <span class="caption-subject bold uppercase">
                                {{__('catalog::dashboard.products.routes.index')}}
                            </span>
                            </div>
                        </div>

                        {{-- DATATABLE CONTENT --}}
                        <div class="portlet-body">
                            <div>
                                @include('apps::dashboard.components.datatable.show-deleted-btn')
                            </div>
                            <table class="table table-striped table-bordered table-hover" id="dataTable">
                                <thead>
                                <tr>
                                    <th>
                                        <a href="javascript:;" onclick="CheckAll()">
                                            {{__('apps::dashboard.general.select_all_btn')}}
                                        </a>
                                    </th>
                                    <th>#</th>
                                    <th>{{__('catalog::dashboard.products.datatable.image')}}</th>
                                    <th>{{__('catalog::dashboard.products.datatable.status')}}</th>
                                    <th>{{__('catalog::dashboard.products.datatable.title')}}</th>
                                    <th>{{__('catalog::dashboard.products.datatable.vendor')}}</th>
                                    <th>{{__('catalog::dashboard.products.datatable.price')}}</th>
                                    <th>{{__('catalog::dashboard.products.datatable.qty')}}</th>
                                    <th>{{__('catalog::dashboard.products.datatable.created_at')}}</th>
                                    <th>{{__('catalog::dashboard.products.datatable.options')}}</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <button type="submit" id="deleteChecked" class="btn red btn-sm"
                                        onclick="deleteAllChecked('{{ url(route('dashboard.products.deletes')) }}')">
                                    {{__('apps::dashboard.datatable.delete_all_btn')}}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('scripts')

    <script>
        function tableGenerate(data = '') {

            var dataTable =
                $('#dataTable').DataTable({
                    "createdRow": function (row, data, dataIndex) {
                        if (data["deleted_at"] != null) {
                            $(row).addClass('danger');
                        }
                    },
                    ajax: {
                        url: "{{ url(route('dashboard.review_products.datatable')) }}",
                        type: "GET",
                        data: {
                            req: data,
                        },
                    },
                    language: {
                        url: "//cdn.datatables.net/plug-ins/1.10.16/i18n/{{ucfirst(LaravelLocalization::getCurrentLocaleName())}}.json"
                    },
                    stateSave: true,
                    processing: true,
                    serverSide: true,
                    responsive: !0,
                    order: [[1, "desc"]],
                    columns: [
                        {data: 'id', className: 'dt-center'},
                        {data: 'id', className: 'dt-center'},
                        {
                            data: "image", orderable: false, width: "1%",
                            render: function (data, type, row) {
                                return '<img src="' + data + '" width="50px"/>'
                            }
                        },
                        {data: 'status', className: 'dt-center'},
                        {data: 'title', className: 'dt-center', orderable: false},
                        {data: 'vendor', className: 'dt-center', orderable: false},
                        {data: 'price', className: 'dt-center', orderable: false},
                        {data: 'qty', className: 'dt-center', orderable: false},
                        {data: 'created_at', className: 'dt-center', width: '75px'},
                        {data: 'id'},
                    ],
                    columnDefs: [
                        {
                            targets: 0,
                            width: '20px',
                            className: 'dt-center',
                            orderable: false,
                            render: function (data, type, full, meta) {
                                return `<label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                          <input type="checkbox" value="` + data + `" class="group-checkable" name="ids">
                          <span></span>
                        </label>
                      `;
                            },
                        },
                        {
                            targets: 3,
                            width: '20px',
                            className: 'dt-center',
                            render: function (data, type, full, meta) {
                                if (data == 1) {
                                    return '<span class="badge badge-success"> {{__('apps::dashboard.datatable.active')}} </span>';
                                } else {
                                    return '<span class="badge badge-danger"> {{__('apps::dashboard.datatable.unactive')}} </span>';
                                }
                            },
                        },
                        {
                            targets: -1,
responsivePriority:1,
                            width: '255px',
                            title: '{{__('catalog::dashboard.products.datatable.options')}}',
                            className: 'dt-center',
                            orderable: false,
                            render: function (data, type, full, meta) {

                                {{--// Show Details
                                var showUrl = '{{ route("dashboard.products.show", ":id") }}';
                                showUrl = showUrl.replace(':id', data);--}}

                                // Edit
                                var editUrl = '{{ route("dashboard.products.edit", ":id") }}';
                                editUrl = editUrl.replace(':id', data);

                                // Edit
                                var addOnsUrl = '{{ route("dashboard.products.add_ons", ":id") }}';
                                addOnsUrl = addOnsUrl.replace(':id', data);

                                // Delete
                                var deleteUrl = '{{ route("dashboard.products.destroy", ":id") }}';
                                deleteUrl = deleteUrl.replace(':id', data);

                                return `
                                {{--@permission('show_products')
                                    <a href="` + showUrl + `" class="btn btn-sm yellow" title="Show">
                                    <i class="fa fa-eye"></i>
                                    </a>
                                @endpermission--}}
                                @if(config('setting.products.toggle_addons') == 1)
                                <a href="` + addOnsUrl + `" class="btn btn-sm green" title="Add Ons"><i class="fa fa-plus"></i></a>
                                @endif
                                @permission('edit_products')
                                    <a href="` + editUrl + `" class="btn btn-sm blue" title="Edit">
                                    <i class="fa fa-edit"></i>
                                    </a>
                                @endpermission

                                @permission('delete_products')
                                @csrf
                                <a href="javascript:;" onclick="deleteRow('` + deleteUrl + `')" class="btn btn-sm red">
                                    <i class="fa fa-trash"></i>
                                </a>
                                @endpermission`;
                            },
                        },
                    ],
                    dom: 'Bfrtip',
                    lengthMenu: [
                        [10, 25, 50, 100, 500],
                        ['10', '25', '50', '100', '500']
                    ],
                    buttons: [
                        {
                            extend: "pageLength",
                            className: "btn blue btn-outline",
                            text: "{{__('apps::dashboard.datatable.pageLength')}}",
                            exportOptions: {
                                stripHtml: false,
                                columns: ':visible',
                                columns: [1, 2, 3, 4, 5]
                            }
                        },
                        {
                            extend: "print",
                            className: "btn blue btn-outline",
                            text: "{{__('apps::dashboard.datatable.print')}}",
                            exportOptions: {
                                stripHtml: false,
                                columns: ':visible',
                                columns: [1, 2, 3, 4, 5]
                            }
                        },
                        {
                            extend: "pdf",
                            className: "btn blue btn-outline",
                            text: "{{__('apps::dashboard.datatable.pdf')}}",
                            exportOptions: {
                                stripHtml: false,
                                columns: ':visible',
                                columns: [1, 2, 3, 4, 5]
                            }
                        },
                        {
                            extend: "excel",
                            className: "btn blue btn-outline ",
                            text: "{{__('apps::dashboard.datatable.excel')}}",
                            exportOptions: {
                                stripHtml: false,
                                columns: ':visible',
                                columns: [1, 2, 3, 4, 5]
                            }
                        },
                        {
                            extend: "colvis",
                            className: "btn blue btn-outline",
                            text: "{{__('apps::dashboard.datatable.colvis')}}",
                            exportOptions: {
                                stripHtml: false,
                                columns: ':visible',
                                columns: [1, 2, 3, 4, 5]
                            }
                        }
                    ]
                });
        }

        jQuery(document).ready(function () {
            tableGenerate();
        });
    </script>

@stop
