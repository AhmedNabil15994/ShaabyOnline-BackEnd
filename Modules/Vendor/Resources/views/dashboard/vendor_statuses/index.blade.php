@extends('apps::dashboard.layouts.app')
@section('title', __('vendor::dashboard.vendor_statuses.index.title'))
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
                    <a href="#">{{__('vendor::dashboard.vendor_statuses.index.title')}}</a>
                </li>
            </ul>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="portlet light bordered">

                    <div class="table-toolbar">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="btn-group">
                                    <a href="{{ url(route('dashboard.vendor_statuses.create')) }}" class="btn sbold green">
                                        <i class="fa fa-plus"></i> {{__('apps::dashboard.general.add_new_btn')}}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="portlet-title">
                        <div class="caption font-dark">
                            <i class="icon-settings font-dark"></i>
                            <span class="caption-subject bold uppercase">
                                {{__('vendor::dashboard.vendor_statuses.index.title')}}
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
                                    <th>{{__('vendor::dashboard.vendor_statuses.datatable.title')}}</th>
                                    <th>{{__('vendor::dashboard.vendor_statuses.datatable.accepted_orders')}}</th>
                                    <th>{{__('vendor::dashboard.vendor_statuses.datatable.created_at')}}</th>
                                    <th>{{__('vendor::dashboard.vendor_statuses.datatable.options')}}</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <button type="submit" id="deleteChecked" class="btn red btn-sm" onclick="deleteAllChecked('{{ url(route('dashboard.vendor_statuses.deletes')) }}')">
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
   function tableGenerate(data='') {

      var dataTable =
      $('#dataTable').DataTable({
          "createdRow": function( row, data, dataIndex ) {
             if ( data["deleted_at"] != null ) {
                $(row).addClass('danger');
             }
          },
          ajax : {
              url   : "{{ url(route('dashboard.vendor_statuses.datatable')) }}",
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
          order     : [[ 1 , "desc" ]],
          columns: [
            {data: 'id' 		 	        , className: 'dt-center'},
      			{data: 'id' 		 	        , className: 'dt-center'},
            {data: 'title' 			      , className: 'dt-center'},
      			{data: 'accepted_orders' 	, className: 'dt-center'},
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
      				targets: 3,
      				width: '30px',
      				className: 'dt-center',
      				render: function(data, type, full, meta) {
                if (data == 1) {
                  return '<span class="badge badge-success"> {{__('apps::dashboard.datatable.active')}} </span>';
                }else{
                  return '<span class="badge badge-danger"> {{__('apps::dashboard.datatable.unactive')}} </span>';
                }
      				},
      			},
            {
              targets: -1,
responsivePriority:1,
              width: '13%',
              title: '{{__('vendor::dashboard.vendor_statuses.datatable.options')}}',
              className: 'dt-center',
              orderable: false,
              render: function(data, type, full, meta) {

                // Edit
      					var editUrl = '{{ route("dashboard.vendor_statuses.edit", ":id") }}';
      					editUrl = editUrl.replace(':id', data);

      					// Delete
      					var deleteUrl = '{{ route("dashboard.vendor_statuses.destroy", ":id") }}';
      					deleteUrl = deleteUrl.replace(':id', data);

      					return `
                @permission('edit_vendor_statuses')
      						<a href="`+editUrl+`" class="btn btn-sm blue" title="Edit">
      			              <i class="fa fa-edit"></i>
      			            </a>
      					@endpermission

                @permission('delete_vendor_statuses')
                @csrf
                  <a href="javascript:;" onclick="deleteRow('`+deleteUrl+`')" class="btn btn-sm red">
                    <i class="fa fa-trash"></i>
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
                text: "{{__('apps::dashboard.datatable.pageLength')}}",
                exportOptions: {
                    stripHtml : false,
                    columns: ':visible',
                    columns: [ 1 , 2 , 3 , 4]
                }
  					},
  					{
    						extend: "print",
                className: "btn blue btn-outline" ,
                text: "{{__('apps::dashboard.datatable.print')}}",
                exportOptions: {
                    stripHtml : false,
                    columns: ':visible',
                    columns: [ 1 , 2 , 3 , 4]
                }
  					},
  					{
  							extend: "pdf",
                className: "btn blue btn-outline" ,
                text: "{{__('apps::dashboard.datatable.pdf')}}",
                exportOptions: {
                    stripHtml : false,
                    columns: ':visible',
                    columns: [ 1 , 2 , 3 , 4]
                }
  					},
  					{
  							extend: "excel",
                className: "btn blue btn-outline " ,
                text: "{{__('apps::dashboard.datatable.excel')}}",
                exportOptions: {
                    stripHtml : false,
                    columns: ':visible',
                    columns: [ 1 , 2 , 3 , 4]
                }
  					},
  					{
  							extend: "colvis",
                className: "btn blue btn-outline",
                text: "{{__('apps::dashboard.datatable.colvis')}}",
                exportOptions: {
                    stripHtml : false,
                    columns: ':visible',
                    columns: [ 1 , 2 , 3 , 4]
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
