@extends('apps::driver.layouts.app')
@section('title', __('order::driver.orders.index.title'))
@section('content')
<div class="page-content-wrapper">
    <div class="page-content">
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <a href="{{ url(route('driver.home')) }}">{{ __('apps::driver.home.title') }}</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <a href="#">{{__('order::driver.orders.index.title')}}</a>
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
                                    {{__('apps::driver.datatable.search')}}
                                </div>
                                <div class="tools">
                                    <a href="javascript:;" class="expand" data-original-title="" title=""> </a>
                                </div>
                            </div>
                            <div class="portlet-body portlet-collapsed">
                                <div id="filter_data_table">
                                    <div class="panel-body">
                                        <form id="formFilter" class="horizontal-form">
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="control-label">
                                                                {{__('apps::driver.datatable.form.date_range')}}
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
                                                                {{__('apps::driver.datatable.form.soft_deleted')}}
                                                            </label>
                                                            <div class="mt-radio-list">
                                                                <label class="mt-radio">
                                                                    {{__('apps::driver.datatable.form.delete_only')}}
                                                                    <input type="radio" value="only" name="deleted" />
                                                                    <span></span>
                                                                </label>
                                                                <label class="mt-radio">
                                                                    {{__('apps::driver.datatable.form.with_deleted')}}
                                                                    <input type="radio" value="with" name="deleted" />
                                                                    <span></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="control-label">
                                                                {{__('apps::driver.datatable.form.status')}}
                                                            </label>
                                                            <div class="mt-radio-list">
                                                                <label class="mt-radio">
                                                                    {{__('apps::driver.datatable.form.active')}}
                                                                    <input type="radio" value="1" name="status" />
                                                                    <span></span>
                                                                </label>
                                                                <label class="mt-radio">
                                                                    {{__('apps::driver.datatable.form.unactive')}}
                                                                    <input type="radio" value="0" name="status" />
                                                                    <span></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                        <div class="form-actions">
                                            <button class="btn btn-sm green btn-outline filter-submit margin-bottom" id="search">
                                                <i class="fa fa-search"></i>
                                                {{__('apps::driver.datatable.search')}}
                                            </button>
                                            <button class="btn btn-sm red btn-outline filter-cancel">
                                                <i class="fa fa-times"></i>
                                                {{__('apps::driver.datatable.reset')}}
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
                                {{__('order::driver.orders.index.title')}}
                            </span>
                        </div>
                    </div>

                    {{-- DATATABLE CONTENT --}}
                    <div class="portlet-body">
                        <table class="table table-striped table-bordered table-hover" id="dataTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{__('order::driver.orders.datatable.subtotal')}}</th>
                                    <th>{{__('order::driver.orders.datatable.shipping')}}</th>
                                    <th>{{__('order::driver.orders.datatable.total')}}</th>
                                    <th>{{__('order::dashboard.orders.datatable.method')}}</th>
                                    <th>{{__('order::driver.orders.datatable.created_at')}}</th>
                                    <th>{{__('order::driver.orders.datatable.options')}}</th>
                                </tr>
                            </thead>
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
   function tableGenerate(data='') {

      var dataTable =
      $('#dataTable').DataTable({

          "createdRow": function( row, data, dataIndex ) {
             if ( data["deleted_at"] != null ) {
                $(row).addClass('danger');
             }
          },
          ajax : {
              url   : "{{ url(route('driver.orders.datatable')) }}",
              type  : "GET",
              data  : {
                  req : data,
              },
          },
          language: {
              url:"//cdn.datatables.net/plug-ins/1.10.16/i18n/{{ucfirst(LaravelLocalization::getCurrentLocaleName())}}.json"
          },
          stateSave: true,
          processing: true,
          serverSide: true,
          responsive: !0,
          order     : [[ 0 , "desc" ]],
          columns: [
      			{data: 'id' 		 	        , className: 'dt-center'},
            {data: 'subtotal' 			  , className: 'dt-center'},
            {data: 'shipping' 	      , className: 'dt-center'},
            {data: 'total' 	          , className: 'dt-center'},
            {data: 'transaction' 	    , className: 'dt-center' , orderable: false},
            {data: 'created_at' 		  , className: 'dt-center'},
            {data: 'id'},
      		],
          columnDefs: [
            {
      				targets: 0,
      				width: '30px',
      				className: 'dt-center',
      				orderable: false,
      				render: function(data, type, full, meta) {
      					return `<label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                          <input type="checkbox" value="`+data+` class="group-checkable" name="ids">
                          <span></span>
                        </label>
                      `;
      				},
      			},
            {
              targets: -1,
responsivePriority:1,
              width: '13%',
              title: '{{__('order::driver.orders.datatable.options')}}',
              className: 'dt-center',
              orderable: false,
              render: function(data, type, full, meta) {

                // Show
      					var showUrl = '{{ route("driver.orders.show", ":id") }}';
      					showUrl = showUrl.replace(':id', data);

      					return `
                @permission('show_orders')
      						<a href="`+showUrl+`" class="btn btn-sm btn-warning" title="Show">
      			              <i class="fa fa-eye"></i>
      			            </a>
      					@endpermission`;

              },
            },
          ],
          dom: 'Bfrtip',
          lengthMenu: [
              [ 10, 25, 50 , 100 , 500 ],
              [ '10', '25', '50', '100' , '500']
          ],
  				buttons:[
  					{
    						extend: "pageLength",
                className: "btn blue btn-outline",
                text: "{{__('apps::driver.datatable.pageLength')}}",
                exportOptions: {
                    stripHtml : false,
                    columns: ':visible',
                    columns: [ 1 , 2 , 3 , 4 , 5]
                }
  					},
  					{
    						extend: "print",
                className: "btn blue btn-outline" ,
                text: "{{__('apps::driver.datatable.print')}}",
                exportOptions: {
                    stripHtml : false,
                    columns: ':visible',
                    columns: [ 1 , 2 , 3 , 4 , 5]
                }
  					},
  					{
  							extend: "pdf",
                className: "btn blue btn-outline" ,
                text: "{{__('apps::driver.datatable.pdf')}}",
                exportOptions: {
                    stripHtml : false,
                    columns: ':visible',
                    columns: [ 1 , 2 , 3 , 4 , 5]
                }
  					},
  					{
  							extend: "excel",
                className: "btn blue btn-outline " ,
                text: "{{__('apps::driver.datatable.excel')}}",
                exportOptions: {
                    stripHtml : false,
                    columns: ':visible',
                    columns: [ 1 , 2 , 3 , 4 , 5]
                }
  					},
  					{
  							extend: "colvis",
                className: "btn blue btn-outline",
                text: "{{__('apps::driver.datatable.colvis')}}",
                exportOptions: {
                    stripHtml : false,
                    columns: ':visible',
                    columns: [ 1 , 2 , 3 , 4 , 5]
                }
  					}
  				]
      });
  }

  jQuery(document).ready(function() {
  	tableGenerate();
  });
  </script>

@stop
