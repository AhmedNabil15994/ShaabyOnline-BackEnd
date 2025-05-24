@extends('apps::dashboard.layouts.app')
@section('title', __('company::dashboard.delivery_charges.index.title'))
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
                        <a href="#">{{__('company::dashboard.delivery_charges.index.title')}}</a>
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
                                                        <div class="col-md-3">
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
                                                        </div>

                                                        <div class="col-md-3">
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
                                                <div style="margin-top: 10px;">
                                                    @include('apps::dashboard.components.datatable.show-deleted-btn',['withoutGrid' => true])
                                                </div>
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
                                {{__('company::dashboard.delivery_charges.index.title')}}
                            </span>
                            </div>
                        </div>

                        {{-- DATATABLE CONTENT --}}
                        <div class="portlet-body">
                            <table class="table table-striped table-bordered table-hover" id="dataTable">
                                <thead>
                                <tr>
                                    <th>
                                        <a href="javascript:;" onclick="CheckAll()">
                                            {{__('apps::dashboard.general.select_all_btn')}}
                                        </a>
                                    </th>
                                    <th>#</th>
                                    <th>{{__('company::dashboard.delivery_charges.datatable.company')}}</th>
                                    <th>{{__('company::dashboard.delivery_charges.datatable.state')}}</th>
                                    <th>{{__('company::dashboard.delivery_charges.datatable.options')}}</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <button type="submit" id="deleteChecked" class="btn red btn-sm"
                                        onclick="deleteAllChecked('{{ url(route('dashboard.delivery-charges.deletes')) }}')">
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
                        } else {
                            if (data["special_price"] != null) {
                                $(row).addClass('warning');
                            }
                        }
                    },
                    ajax: {
                        url: "{{ url(route('dashboard.delivery-charges.datatable')) }}",
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
                        {data: 'name', className: 'dt-center'},
                        {data: 'delivery_charges', className: 'dt-center'},
                        {data: 'id'},
                    ],
                    columnDefs: [
                        {
                            targets: 0,
                            width: '30px',
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
                            targets: -1,
responsivePriority:1,
                            width: '13%',
                            title: '{{__('company::dashboard.delivery_charges.datatable.options')}}',
                            className: 'dt-center',
                            orderable: false,
                            render: function (data, type, full, meta) {

                                // Edit
                                var editUrl = '{{ route("dashboard.delivery-charges.edit", ":id") }}';
                                editUrl = editUrl.replace(':id', data);

                                return `
      					@auth ()
                                    <a href="` + editUrl + `" class="btn btn-sm blue" title="Edit">
      			              <i class="fa fa-edit"></i>
      			            </a>
      					@endauth`;
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
                                columns: [1, 2, 3]
                            }
                        },
                        {
                            extend: "print",
                            className: "btn blue btn-outline",
                            text: "{{__('apps::dashboard.datatable.print')}}",
                            exportOptions: {
                                stripHtml: false,
                                columns: ':visible',
                                columns: [1, 2, 3]
                            }
                        },
                        {
                            extend: "pdf",
                            className: "btn blue btn-outline",
                            text: "{{__('apps::dashboard.datatable.pdf')}}",
                            exportOptions: {
                                stripHtml: false,
                                columns: ':visible',
                                columns: [1, 2, 3]
                            }
                        },
                        {
                            extend: "excel",
                            className: "btn blue btn-outline ",
                            text: "{{__('apps::dashboard.datatable.excel')}}",
                            exportOptions: {
                                stripHtml: false,
                                columns: ':visible',
                                columns: [1, 2, 3]
                            }
                        },
                        {
                            extend: "colvis",
                            className: "btn blue btn-outline",
                            text: "{{__('apps::dashboard.datatable.colvis')}}",
                            exportOptions: {
                                stripHtml: false,
                                columns: ':visible',
                                columns: [1, 2, 3]
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
