@extends('apps::dashboard.layouts.app')
@section('title', __('user::dashboard.users.show.title'))
@section('css')
    <style>
        .dataTables_wrapper .dt-buttons {
            float: {{ locale() == 'ar' ? 'right' : 'left' }} !important;
        }
    </style>

    <style type="text/css" media="print">
        @page {
            size: auto;
            margin: 0;
        }

        @media print {
            a[href]:after {
                content: none !important;
            }

            .contentPrint {
                width: 100%;
            }

            .no-print,
            .no-print * {
                display: none !important;
            }
        }
    </style>
@stop

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
                        <a href="{{ url(route('dashboard.users.index')) }}">
                            {{ __('user::dashboard.users.index.title') }}
                        </a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <a href="#">{{ __('user::dashboard.users.show.title') }}</a>
                    </li>
                </ul>
            </div>

            <h1 class="page-title"></h1>

            <div class="row">
                <div class="col-md-12">
                    <div class="no-print">
                        <div class="col-md-3">
                            <ul class="ver-inline-menu tabbable margin-bottom-10">
                                <li class="active">
                                    <a data-toggle="tab" href="#general">
                                        <i class="fa fa-cog"></i>
                                        {{ __('user::dashboard.users.create.form.general') }}
                                    </a>
                                </li>

                            @permission('show_user_addresses')
                                <li class="">
                                    <a data-toggle="tab" href="#addresses">
                                        <i class="fa fa-cog"></i>
                                        {{ __('user::dashboard.users.create.form.addresses') }}
                                    </a>
                                </li>
                            @endpermission

                            </ul>
                        </div>
                    </div>
                    <div class="col-md-9 contentPrint">
                        @include('apps::dashboard.layouts._msg')
                        <div class="tab-content">

                            <div class="tab-pane active" id="general">
                                <div class="invoice-content-2 busered">
                                    <div class="row invoice-head">
                                        <div class="col-md-12 col-xs-12">
                                            <div class="row invoice-logo">
                                                <div class="col-xs-6">
                                                    @if ($user->image)
                                                        <img src="{{ url($user->image) }}" class="img-responsive"
                                                            style="width:20%" />
                                                    @endif
                                                    <span>
                                                        {{ $user->name }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-xs-6">
                                            <div class="company-address">
                                                <h6 class="uppercase">
                                                    #{{ $user['id'] }}
                                                </h6>
                                                <h6 class="uppercase">
                                                    {{ date('Y-m-d / H:i:s', strtotime($user->created_at)) }}</h6>

                                                <span class="bold">
                                                    {{ __('user::dashboard.users.datatable.mobile') }} :
                                                </span>
                                                @if ($user)
                                                    @if (locale() != 'ar')
                                                        {{ '+' . $user->calling_code . $user->mobile }}
                                                    @else
                                                        {{ $user->calling_code . $user->mobile . '+' }}
                                                    @endif
                                                @endif
                                                <br />
                                            </div>
                                        </div>

                                        <div class="row invoice-body">
                                            <div class="col-xs-12 table-responsive" style="margin-top: 20px">
                                                <table class="table table-bordered ">

                                                    <tbody>
                                                        <tr>
                                                            <td class="invoice-title uppercase" style="width: 200px">
                                                                {{ __('user::dashboard.users.datatable.name') }}
                                                            </td>
                                                            <td>
                                                                {{ $user->name ?? '-----' }}
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td class="invoice-title uppercase" style="width: 200px">
                                                                {{ __('user::dashboard.users.datatable.email') }}
                                                            </td>
                                                            <td>
                                                                {{ $user->email ?? '-----' }}
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td class="invoice-title uppercase" style="width: 200px">
                                                                {{ __('user::dashboard.users.datatable.is_verified') }}
                                                            </td>
                                                            <td>

                                                                @if ($user->is_verified == 1)
                                                                    <span class="badge badge-success">
                                                                        {{ __('apps::dashboard.datatable.yes') }} </span>
                                                                @else
                                                                    <span class="badge badge-danger">
                                                                        {{ __('apps::dashboard.datatable.no') }} </span>
                                                                @endif

                                                            </td>
                                                        </tr>

                                                        @if ($user->roles->count() > 0)
                                                            <tr>
                                                                <td class="invoice-title uppercase" style="width: 200px">
                                                                    {{ __('user::dashboard.admins.update.form.roles') }}
                                                                </td>
                                                                <td>
                                                                    @foreach ($user->roles as $role)
                                                                        <span class="badge badge-info">
                                                                            {{ $role->display_name }} </span>
                                                                    @endforeach
                                                                </td>
                                                            </tr>

                                                        @endif

                                                    </tbody>
                                                    <thead>
                                                </table>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            @permission('show_user_addresses')
                            <div class="tab-pane" id="addresses">

                                @permission('add_user_addresses')
                                <div class="table-toolbar">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="btn-group">
                                                <a class="btn sbold green" data-toggle="modal" href="#userCreateAddressModal"> {{ __('apps::dashboard.general.btn_add_address') }} </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endpermission

                                <div class="portlet-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover" id="addressesDataTable">
                                            <thead>
                                                <tr>
                                                    <th>
                                                        <a href="javascript:;" onclick="CheckAll()">
                                                            {{ __('apps::dashboard.general.select_all_btn') }}
                                                        </a>
                                                    </th>
                                                    <th>#</th>
                                                    <th>{{ __('user::dashboard.users.datatable.address.state') }}</th>
                                                    <th>{{ __('user::dashboard.users.datatable.address.username') }}</th>
                                                    <th>{{ __('user::dashboard.users.datatable.address.email') }}</th>
                                                    <th>{{ __('user::dashboard.users.datatable.address.mobile') }}</th>
                                                    <th>{{ __('user::dashboard.users.datatable.address.block') }}</th>
                                                    <th>{{ __('user::dashboard.users.datatable.address.building') }}</th>
                                                    <th>{{ __('user::dashboard.users.datatable.created_at') }}</th>
                                                    <th>{{ __('user::dashboard.users.datatable.options') }}</th>
                                                </tr>
                                            </thead>
                                        </table>
                                   </div>
                                </div>
                                <div class="row">
                                    <div class="form-group">
                                        <button type="submit" id="deleteChecked" class="btn red btn-sm"
                                            onclick="deleteAllChecked('{{ url(route('dashboard.user_addresses.deletes')) }}')">
                                            {{ __('apps::dashboard.datatable.delete_all_btn') }}
                                        </button>
                                    </div>
                                </div>

                            </div>
                            @endpermission

                        </div>

                    </div>
                </div>

                <div class="col-md-12">
                    <div class="col-xs-4">
                        <a href="{{ url(route('dashboard.users.index')) }}" class="btn btn-lg red">
                            {{ __('apps::dashboard.general.back_btn') }}
                        </a>
                    </div>

                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="userCreateAddressModal" tabindex="-1" role="userCreateAddressModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">{{ __('user::dashboard.users.create.form.address_details.titles.create') }}</h4>
                </div>
                @include('user::dashboard.addresses._create_modal')
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

@stop

@include('area::dashboard.shared._area_tree_js')

@section('scripts')

    <script>
        function tableGenerate(data = '') {

            var dataTable =
                $('#addressesDataTable').DataTable({
                    "createdRow": function(row, data, dataIndex) {
                        if (data["deleted_at"] != null) {
                            $(row).addClass('danger');
                        }
                    },
                    ajax: {
                        url: "{{ url(route('dashboard.user_addresses.datatable')) .'?user_id='. $user->id }}",
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
                            data: 'state',
                            className: 'dt-center',
                            orderable: false,
                        },
                        {
                            data: 'username',
                            className: 'dt-center',
                            orderable: false,
                        },
                        {
                            data: 'email',
                            className: 'dt-center',
                            orderable: false,
                        },
                        {
                            data: 'mobile',
                            className: 'dt-center',
                            orderable: false,
                        },
                        {
                            data: 'block',
                            className: 'dt-center',
                            orderable: false,
                        },
                        {
                            data: 'building',
                            className: 'dt-center',
                            orderable: false,
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
                            width: '17%',
                            title: '{{ __('user::dashboard.users.datatable.options') }}',
                            className: 'dt-center',
                            orderable: false,
                            render: function(data, type, full, meta) {

                                // Delete
                                var deleteUrl = '{{ route('dashboard.user_addresses.destroy', ':id') }}';
                                deleteUrl = deleteUrl.replace(':id', data);

                                return `
                                    @permission('delete_user_addresses')
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
                    buttons: [{
                            extend: "pageLength",
                            className: "btn blue btn-outline",
                            text: "{{ __('apps::dashboard.datatable.pageLength') }}",
                            exportOptions: {
                                stripHtml: true,
                                columns: ':visible',
                                columns: [1, 2, 3, 4, 5, 6]
                            }
                        },
                        {
                            extend: "print",
                            className: "btn blue btn-outline",
                            text: "{{ __('apps::dashboard.datatable.print') }}",
                            exportOptions: {
                                stripHtml: false,
                                columns: ':visible',
                                columns: [1, 2, 3, 4, 5, 6]
                            }
                        },
                        {
                            extend: "pdf",
                            className: "btn blue btn-outline",
                            text: "{{ __('apps::dashboard.datatable.pdf') }}",
                            exportOptions: {
                                stripHtml: false,
                                columns: ':visible',
                                columns: [1, 2, 3, 4, 5, 6]
                            }
                        },
                        {
                            extend: "excel",
                            className: "btn blue btn-outline ",
                            text: "{{ __('apps::dashboard.datatable.excel') }}",
                            exportOptions: {
                                stripHtml: false,
                                columns: ':visible',
                                columns: [1, 2, 3, 4, 5, 6]
                            }
                        },
                        {
                            extend: "colvis",
                            className: "btn blue btn-outline",
                            text: "{{ __('apps::dashboard.datatable.colvis') }}",
                            exportOptions: {
                                stripHtml: false,
                                columns: ':visible',
                                columns: [1, 2, 3, 4, 5, 6]
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
