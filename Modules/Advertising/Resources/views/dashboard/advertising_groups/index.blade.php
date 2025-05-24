@extends('apps::dashboard.layouts.app')
@section('title', __('advertising::dashboard.advertising_groups.routes.index'))
@section('css')
    <style>
        .mt-widget-3 .mt-head {
            border-radius: 15px !important;
            background-color: #364150 !important;
            /*background: linear-gradient(rgb(27 38 53), rgb(15 44 82)) !important;*/
        }

        /*.mt-widget-3 .mt-head .mt-head-date {
            color: #f2f2f261 !important;
        }*/
    </style>
@endsection
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
                        <a href="#">{{__('advertising::dashboard.advertising_groups.routes.index')}}</a>
                    </li>
                </ul>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="portlet light bordered">

                        @permission('add_advertising')
                        <div class="table-toolbar">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="btn-group">
                                        <a href="{{ url(route('dashboard.advertising_groups.create')) }}"
                                           class="btn sbold green">
                                            <i class="fa fa-plus"></i> {{__('apps::dashboard.general.add_new_btn')}}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endpermission

                    </div>
                </div>
            </div>

            <div class="row">

                @forelse($items as $k => $item)
                    <div class="col-lg-4 col-xs-12 col-sm-12" id="advertisingGroup-{{$item->id}}">
                        <div class="mt-widget-3" style="border: none;">
                            <div class="mt-head bg-green-hoki" style="margin-bottom: 0;">
                                <div class="mt-head-desc">{{ $item->title }}</div>
                                <div class="mt-head-date">
                                    <button type="button" style="cursor: default;"
                                            class="btn btn-circle blue-ebonyclay btn-sm">
                                        <i class="icon-tag"></i>
                                        {{ $item->position }}
                                    </button>

                                    {{--@if($item->status == 1)
                                        <button type="button" style="float: left;"
                                                class="btn btn-circle btn-default btn-sm">{{ __('apps::dashboard.datatable.active') }}</button>
                                    @else
                                        <button type="button" style="float: left;"
                                                class="btn btn-circle btn-danger btn-sm">{{ __('apps::dashboard.datatable.unactive') }}</button>
                                    @endif--}}
                                </div>
                                <span class="mt-head-date"> {{ $item->created_at->format('Y-m-d') }} </span>
                                <div class="mt-head-button">
                                    <a href="{{ route("dashboard.advertising.create", ['advertising_group' => $item->id]) }}"
                                       class="btn btn-circle green">
                                        <i class="glyphicon glyphicon-plus-sign"></i>
                                        {{ __('advertising::dashboard.advertising.routes.create_advert') }}
                                    </a>
                                    <a href="{{ route("dashboard.advertising.index", ['advertising_group' => $item->id]) }}"
                                       class="btn btn-circle green">
                                        <i class="glyphicon glyphicon-eye-open"></i>
                                        {{ __('advertising::dashboard.advertising.routes.all_adverts') }}
                                    </a>
                                </div>
                            </div>
                            <div class="mt-body-actions-icons">
                                <div class="btn-group btn-group btn-group-justified">
                                    @permission('edit_advertising')
                                    <a href="{{ route("dashboard.advertising_groups.edit", $item->id) }}"
                                       class="btn">
                                        <span class="mt-icon">
                                        <i class="glyphicon glyphicon-edit"></i>
                                    </span>{{--{{ __('apps::dashboard.general.edit_btn') }}--}}
                                    </a>
                                    @endpermission

                                    @permission('delete_advertising')
                                    @csrf
                                    <a href="javascript:;"
                                       onclick="deleteRow('{{ route("dashboard.advertising_groups.destroy", $item->id) }}', '{{ $item->id }}', 'advertising_groups')"
                                       class="btn">
                                         <span class="mt-icon">
                                        <i class="glyphicon glyphicon-trash"></i>
                                    </span>{{--{{ __('apps::dashboard.general.delete_btn') }}--}}
                                    </a>
                                    @endpermission
                                    <div class="btn">
                                        <input type="checkbox"
                                               class="make-switch advertGroupStatus"
                                               {{ $item->status == '1' ? 'checked' : '' }}
                                               data-id="{{ $item->id }}"
                                               data-on-color="success" data-off-color="danger" data-size="normal">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <h4 class="text-center">{{ __('advertising::dashboard.advertising_groups.alert.no_ad_groups_now') }}</h4>
                @endforelse

            </div>

        </div>
    </div>
@stop

@section('scripts')

    <script>
        jQuery(document).ready(function () {

            $('.advertGroupStatus').on('switchChange.bootstrapSwitch', function (event, state) {
                var data = {
                    'id': $(this).attr('data-id'),
                    'status': $(this).is(":checked") == true ? 1 : 0,
                };
                $.ajax({
                        method: "GET",
                        url: '{{ route('dashboard.advertising_groups.change_advert_group_status') }}',
                        data: data,
                        beforeSend: function () {
                            $(this).prop('disabled', true);
                            resetErrors();
                        },
                        success: function (data) {
                            $(this).prop('disabled', false);

                            if (data[0] === true) {
                                successfully(data);
                                resetErrors();
                            } else {
                                displayMissing(data);
                            }
                        },
                        error: function (data) {
                            $(this).prop('disabled', false);
                            displayErrors(data);
                        },
                        complete: function (data) {

                        },
                    }
                );

            });

        });

    </script>

@stop
