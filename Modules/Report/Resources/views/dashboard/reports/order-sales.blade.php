@extends('apps::dashboard.layouts.app')
@section('title', __('report::dashboard.reports.routes.order_sales'))
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
                        <a href="#">{{__('report::dashboard.reports.routes.order_sales')}}</a>
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

                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <label class="control-label">
                                                                    {{__('report::dashboard.reports.datatable.vendor_id')}}
                                                                </label>
                                                                <div >
                                                                    <select  name="vendor_id"  class="form-control">
                                                                        <option value=""> {{__('report::dashboard.reports.datatable.all')}}</option>
                                                                        @foreach ($vendors as $vendor)
                                                                            <option value="{{$vendor->id}}">{{$vendor->title}}</option>
                                                                        @endforeach
                                                                    </select>
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
                                {{__('report::dashboard.reports.routes.order_sales')}}
                            </span>
                            </div>
                        </div>

                        {{-- DATATABLE CONTENT --}}
                        <div class="portlet-body">
                            <table class="table table-striped table-bordered table-hover" id="dataTable">
                                <thead>
                                <tr>

                                    <th class="desktop" data-priority="1" >{{__('report::dashboard.reports.order_sales.order_id')}}</th>
                                    <th class="desktop" data-priority="1">{{__('report::dashboard.reports.order_sales.vendors_count')}}</th>
                                    <th class="desktop" data-priority="1">{{__('report::dashboard.reports.order_sales.qty')}}</th>
                                    <th class="desktop"  data-priority="1">{{__('report::dashboard.reports.order_sales.total')}}</th>
                                    <th class="desktop"  data-priority="1">{{__('report::dashboard.reports.order_sales.discount')}}</th>
                                    <th class="desktop" data-priority="1" >{{__('report::dashboard.reports.order_sales.user')}}</th>
{{--                                    <th class="desktop" data-priority="1" >{{__('report::dashboard.reports.order_sales.cashier')}}</th>--}}

                                    <th class="desktop" data-priority="1">{{__('report::dashboard.reports.order_sales.payment_method')}}</th>
                                    <th class="desktop" data-priority="1">{{__('report::dashboard.reports.order_sales.order_date')}}</th>
                                </tr>
                                </thead>
                                <tfoot>
                                    <th>-</th>
                                    <th>-</th>
                                    <th>-</th>
                                    <th>-</th>
                                    <th>-</th>
                                    <th>-</th>
{{--                                    <th>-</th>--}}
                                    <th>-</th>
                                    <th>-</th>


                                </tfoot>
                            </table>
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
                        url: "{{ url(route('dashboard.reports.order_sale_datatable')) }}",
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
                    order: [[7, "desc"]],
                    columns: [
                        {data: 'id', className: 'dt-center',
                        render: function (data, type, row) {
                                var showUrl = '{{ route("dashboard.orders.show", [":id", "all_orders"]) }}';
                                    showUrl = showUrl.replace(':id', data)
                                 return `
                                 @permission('show_orders')
                                    <a href="${showUrl}">${data}</a>
                                 @else
                                    ${data}
                                 @endpermission
                                 `

                        }},
                        {data: 'vendors_count', className: 'dt-center'},
                        {data: 'qty', className: 'dt-center',orderable: true },
                        {data: 'total', className: 'dt-center'},
                        {data: 'discount', className: 'dt-center'},
                        {data: 'user_id', className: 'dt-center'},
                        // {data: 'cashier_id', className: 'dt-center'},
                        {data: 'transactions_id', className: 'dt-center'},
                        {data: 'created_at', className: 'dt-center'},
                    ],
                    columnDefs: [



                    ],
                    dom: 'Bfrtip',
                    lengthMenu: [
                        [10, 25, 50, 100, 500, 1000, 2000],
                        ['10', '25', '50', '100', '500', "1000", "2000"]
                    ],
                    buttons: [
                        {
                            extend: "pageLength",
                            className: "btn blue btn-outline",
                            text: "{{__('apps::dashboard.datatable.pageLength')}}",
                            exportOptions: {
                                stripHtml: false,
                                columns: ':visible',
                                columns: [0,1, 2, 3, 4, 5,6,7]
                            }
                        },
                        {
                            extend: "print",
                            className: "btn blue btn-outline",
                            text: "{{__('apps::dashboard.datatable.print')}}",
                            footer: true,
                            header: true,
                            exportOptions: {
                                stripHtml: true,
                                columns: ':visible',
                                columns: [0,1, 2, 3, 4, 5,6,7]
                            }
                        },
                        {
                            extend: "pdfHtml5",
                            className: "btn blue btn-outline",
                            text: "{{__('apps::dashboard.datatable.pdf')}}",
                            footer: true,
                            header: true,
                            "charset": "utf-8",
                            bom: true,
                            exportOptions: {
                                stripHtml: true,
                                header: true,
                                columns: ':visible',
                                columns: [0, 1, 2, 3, 4, 5,7],

                            }
                        },

                        {
                            extend: "excel",
                            className: "btn blue btn-outline ",
                            text: "{{__('apps::dashboard.datatable.excel')}}",
                            footer: true,
                            header: true,
                            exportOptions: {
                                stripHtml: true,
                                columns: ':visible',
                                columns: [0,1, 2, 3, 4, 5,7]
                            }
                        },
                        {
                            extend: "colvis",
                            className: "btn blue btn-outline",
                            text: "{{__('apps::dashboard.datatable.colvis')}}",
                            exportOptions: {
                                stripHtml: false,
                                columns: ':visible',
                                columns: [0, 1, 2, 3, 4, 5, 7]
                            }
                        }
                    ],
                    footerCallback:function(row, data, start, end, display){
                        var api = this.api()

                        var intVal = function ( i ) {
                            return typeof i === 'string' ?
                                i.replace(/[\$,]/g, '')*1 :
                                typeof i === 'number' ?
                                    i : 0;
                        };

                        var total = api
                        .column( 3 )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );

                        var totalQty = api
                        .column( 2 )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );



                        $( api.column( 3 ).footer() ).html(
                            `<div style="color:green">${total} <span>KWT</span></div> `
                        );

                        $( api.column( 2 ).footer() ).html(
                            totalQty
                        );

                    }
                });
        }

        jQuery(document).ready(function () {
            tableGenerate();
        });
    </script>

@stop
