@extends('apps::dashboard.layouts.app')
@section('title', __('order::dashboard.orders.completed_orders.title'))
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
                        <a href="#">{{ __('order::dashboard.orders.completed_orders.title') }}</a>
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
                                        {{ __('apps::dashboard.datatable.search') }}
                                    </div>
                                    <div class="tools">
                                        <a href="javascript:;" class="collapse" data-original-title="" title=""> </a>
                                    </div>
                                </div>
                                <div class="portlet-body" style="padding: 27px 12px 10px !important;">
                                    <div id="filter_data_table">
                                        <div class="panel-body">
                                            @include('order::dashboard.shared._filter')
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
                                    {{ __('order::dashboard.orders.index.title') }}
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
                                                {{ __('apps::dashboard.general.select_all_btn') }}
                                            </a>
                                        </th>
                                        <th>#</th>
                                        <th>{{ __('order::dashboard.orders.datatable.subtotal') }}</th>
                                        <th>{{ __('order::dashboard.orders.datatable.shipping') }}</th>
                                        <th>{{ __('order::dashboard.orders.datatable.total') }}</th>
                                        <th>{{ __('order::dashboard.orders.datatable.status') }}</th>
                                        <th>{{ __('order::dashboard.orders.datatable.method') }}</th>
                                        <th>{{ __('order::dashboard.orders.datatable.state') }}</th>
                                        <th>{{ __('order::dashboard.orders.datatable.created_at') }}</th>
                                        <th>{{ __('order::dashboard.orders.datatable.options') }}</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <th>-</th>
                                    <th>-</th>
                                    <th>-</th>
                                    <th>-</th>
                                    <th>-</th>
                                    <th>-</th>
                                    <th>-</th>
                                    <th>-</th>
                                    <th>-</th>
                                    <th>-</th>
                                </tfoot>
                            </table>
                        </div>

                        @include('order::dashboard.shared._bulk_order_actions', [
                            'printPage' => 'all-orders',
                        ])

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

                    'fnDrawCallback': function(data) {
                        $('#count_orders').html(data.json.recordsTotal);
                        $('#sum_total_orders').html(data.json.recordsTotalSum);
                    },
                    "createdRow": function(row, data, dataIndex) {
                        if (data["deleted_at"] != null) {
                            $(row).addClass('danger');
                        }

                        if (data["unread"] == false) {
                            $(row).addClass('danger');
                        }
                    },
                    ajax: {
                        url: "{{ url(route('dashboard.completed_orders.datatable')) }}",
                        type: "GET",
                        data: {
                            req: data,
                        },
                    },
                    language: {
                        url: "//cdn.datatables.net/plug-ins/1.10.16/i18n/{{ ucfirst(LaravelLocalization::getCurrentLocaleName()) }}.json"
                    },
                    stateSave: true,
                    processing: true,
                    serverSide: true,
                    responsive: !0,
                    order: [
                        [1, "desc"]
                    ],
                    columns: [{
                            data: 'id',
                            className: 'dt-center'
                        },
                        {
                            data: 'id',
                            className: 'dt-center'
                        },
                        {
                            data: 'subtotal',
                            className: 'dt-center'
                        },
                        {
                            data: 'shipping',
                            className: 'dt-center'
                        },
                        {
                            data: 'total',
                            className: 'dt-center'
                        },
                        {
                            data: 'order_status_id',
                            className: 'dt-center'
                        },
                        {
                            data: 'transaction',
                            className: 'dt-center',
                            orderable: false
                        },
                        {
                            data: 'state',
                            className: 'dt-center',
                            orderable: false
                        },
                        {
                            data: 'created_at',
                            className: 'dt-center'
                        },
                        {
                            data: 'id'
                        },
                    ],
                    columnDefs: [{
                            targets: 0,
                            width: '30px',
                            className: 'dt-center',
                            orderable: false,
                            render: function(data, type, full, meta) {
                                return `<label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                          <input type="checkbox" value="` + data + `" class="group-checkable" name="ids">
                          <span></span>
                        </label>
                      `;
                            },
                        },
                        {
                            targets: -1,
                            responsivePriority: 1,
                            width: '13%',
                            title: '{{ __('order::dashboard.orders.datatable.options') }}',
                            className: 'dt-center',
                            orderable: false,
                            render: function(data, type, full, meta) {

                                // Show
                                var showUrl =
                                    '{{ route('dashboard.orders.show', [':id', 'completed_orders']) }}';
                                showUrl = showUrl.replace(':id', data);

                                // Delete
                                var deleteUrl = '{{ route('dashboard.orders.destroy', ':id') }}';
                                deleteUrl = deleteUrl.replace(':id', data);

                                return `
                                        @permission('show_all_orders')
                                            <a href="` + showUrl + `" class="btn btn-sm btn-warning" title="Show">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                        @endpermission
                                        @permission('delete_orders')
                                            @csrf<a href="javascript:;" onclick="deleteRow('` + deleteUrl + `')" class="btn btn-sm red">
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
                    buttons: [{
                            extend: "pageLength",
                            className: "btn blue btn-outline",
                            text: "{{ __('apps::dashboard.datatable.pageLength') }}",
                            exportOptions: {
                                stripHtml: false,
                                columns: ':visible',
                                columns: [1, 2, 3, 4, 5, 7, 8]
                            }
                        },
                        {
                            extend: "print",
                            className: "btn blue btn-outline",
                            text: "{{ __('apps::dashboard.datatable.print') }}",
                            exportOptions: {
                                stripHtml: false,
                                columns: ':visible',
                                columns: [1, 2, 3, 4, 5, 7, 8]
                            }
                        },
                        {
                            extend: "pdf",
                            className: "btn blue btn-outline",
                            text: "{{ __('apps::dashboard.datatable.pdf') }}",
                            exportOptions: {
                                stripHtml: false,
                                columns: ':visible',
                                columns: [1, 2, 3, 4, 5, 7, 8]
                            }
                        },
                        {
                            extend: "excel",
                            className: "btn blue btn-outline ",
                            text: "{{ __('apps::dashboard.datatable.excel') }}",
                            exportOptions: {
                                stripHtml: false,
                                columns: ':visible',
                                columns: [1, 2, 3, 4, 5, 7, 8]
                            }
                        },
                        {
                            extend: "colvis",
                            className: "btn blue btn-outline",
                            text: "{{ __('apps::dashboard.datatable.colvis') }}",
                            exportOptions: {
                                stripHtml: false,
                                columns: ':visible',
                                columns: [1, 2, 3, 4, 5, 7, 8]
                            }
                        }
                    ],
                    footerCallback: function(row, data, start, end, display) {
                        var api = this.api()

                        var intVal = function(i) {
                            return typeof i === 'string' ?
                                i.replace(/[\$,]/g, '') * 1 :
                                typeof i === 'number' ?
                                i : 0;
                        };

                        var subtotal = api.column(2).data().reduce(function(a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);
                        $(api.column(2).footer()).html(subtotal.toFixed(3));

                        var deliveryTotal = api.column(3).data().reduce(function(a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);
                        $(api.column(3).footer()).html(deliveryTotal.toFixed(3));

                        var total = api.column(4).data().reduce(function(a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);
                        $(api.column(4).footer()).html(total.toFixed(3));

                    }
                });
        }

        jQuery(document).ready(function() {
            tableGenerate();

            $(".searchableSelect").select2({
                placeholder: "{{ __('apps::dashboard.datatable.form.select_option') }}",
                allowClear: true
            });

        });
    </script>

    @include('order::dashboard.shared._filter_area_js')

@stop
