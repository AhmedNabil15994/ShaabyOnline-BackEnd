@extends('apps::dashboard.layouts.app')
@section('title', __('order::dashboard.orders.show.title'))
@section('css')
    <style>
        .btn:not(.md-skip):not(.bs-select-all):not(.bs-deselect-all).btn-lg {

            padding: 12px 20px 10px;
        }

        .hide_admin_tag {
            display: none;
        }

        .well {
            box-shadow: none;
        }
    </style>

@stop

@section('content')
    <style type="text/css">
        .table>thead>tr>th {
            border-bottom: none !important;
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
                /* font-family: tahoma; */
                font-size: 16px;
            }

            .invoice-body td.notbold {
                padding: 2px;
            }

            h2.invoice-title.uppercase {
                margin-top: 0px;
            }

            .invoice-content-2 {
                background-color: #fff;
                padding: 5px 20px;
            }

            .invoice-content-2 .invoice-cust-add,
            .invoice-content-2 .invoice-head {
                margin-bottom: 0px;
            }

            .no-print,
            .no-print * {
                display: none !important;
            }

        }
    </style>

    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <a href="{{ url(route('vendor.home')) }}">{{ __('apps::dashboard.home.title') }}</a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <a href="{{ url(route('vendor.' . $flag . '.index')) }}">
                            {{ __('order::dashboard.orders.flags.' . $flag) }}
                        </a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <a href="#">{{ __('order::dashboard.orders.show.title') }}</a>
                    </li>
                </ul>
            </div>

            <h1 class="page-title"></h1>

            <div class="row">
                <div class="col-md-8">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    <div class="portlet light bordered" style="    border: 1px solid #e7ecf1!important">
                        <div class="portlet-title no-print">
                            <div class="caption font-red-sunglo">
                                <i class="font-red-sunglo fa fa-file-text-o"></i>
                                <span class="caption-subject bold uppercase">
                                    {{ __('order::dashboard.orders.show.invoice_customer') }}
                                </span>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="row invoice-head contentPrint">
                                <div class="col-md-12 col-xs-12" style="    margin-bottom: 30px;">
                                    <div class="invoice-logo row">

                                        <span class="header">
                                            <h3 class="uppercase">#{{ $order['id'] }}</h6>
                                        </span>
                                        @if (config('setting.images.logo'))
                                            <span class="image">
                                                <img src="{{ url(config('setting.images.logo')) }}" alt="" />
                                            </span>
                                        @endif
                                        <span class="order_Status">
                                            <span
                                                style="background-color: {{ json_decode($order->orderStatus->color_label)->value }};padding: 2px 14px; color: #000000; border-radius: 25px; float: none;">
                                                {{ $order->orderStatus->title }}
                                            </span>
                                        </span>
                                    </div>
                                </div>

                                @if ($order->orderAddress != null)
                                    <div class="col-md-6 col-xs-6">
                                        <div class="note well">
                                            @if (!is_null($order->orderAddress->state))
                                                <span class="bold uppercase">
                                                    {{ $order->orderAddress->state->city->title }}
                                                    /
                                                    {{ $order->orderAddress->state->title }}
                                                </span>
                                            @endif
                                            <br />

                                            @if ($order->orderAddress->governorate)
                                                <span
                                                    class="bold">{{ __('order::dashboard.orders.show.address.governorate') }}
                                                    :
                                                </span>
                                                {{ $order->orderAddress->governorate }}
                                                <br />
                                            @endif

                                            @if ($order->orderAddress->block)
                                                <span class="bold">{{ __('order::dashboard.orders.show.address.block') }}
                                                    :
                                                </span>
                                                {{ $order->orderAddress->block }}
                                                <br />
                                            @endif

                                            @if ($order->orderAddress->district)
                                                <span
                                                    class="bold">{{ __('order::dashboard.orders.show.address.district') }}
                                                    :
                                                </span>
                                                {{ $order->orderAddress->district }}
                                                <br />
                                            @endif

                                            @if ($order->orderAddress->street)
                                                <span
                                                    class="bold">{{ __('order::dashboard.orders.show.address.street') }}
                                                    :
                                                </span>
                                                {{ $order->orderAddress->street }}
                                                <br />
                                            @endif

                                            @if ($order->orderAddress->building)
                                                <span
                                                    class="bold">{{ __('order::dashboard.orders.show.address.building') }}
                                                    :
                                                </span>
                                                {{ $order->orderAddress->building }}
                                                <br />
                                            @endif

                                            @if ($order->orderAddress->floor)
                                                <span class="bold">{{ __('order::dashboard.orders.show.address.floor') }}
                                                    :
                                                </span>
                                                {{ $order->orderAddress->floor }}
                                                <br />
                                            @endif

                                            @if ($order->orderAddress->flat)
                                                <span class="bold">{{ __('order::dashboard.orders.show.address.flat') }}
                                                    : </span>
                                                {{ $order->orderAddress->flat }}
                                                <br />
                                            @endif

                                            <span class="bold">{{ __('order::dashboard.orders.show.address.details') }}
                                                :
                                            </span>
                                            {{ $order->orderAddress->address ?? '---' }}
                                        </div>
                                    </div>
                                @endif

                                <div class="col-md-6 col-xs-6">
                                    <div class="note well">
                                        <div class="company-address">
                                            <h6 class="uppercase">#{{ $order['id'] }}</h6>
                                            <h6 class="uppercase">
                                                {{ date('Y-m-d / H:i:s', strtotime($order->created_at)) }}
                                            </h6>
                                            <span class="bold">
                                                {{ __('order::dashboard.orders.show.user.username') }} :
                                            </span>
                                            {{ $order->orderAddress->username ?? '---' }}
                                            <br />
                                            <span class="bold">
                                                {{ __('order::dashboard.orders.show.user.mobile') }} :
                                            </span>
                                            {{ $order->orderAddress ? $order->orderAddress->mobile : $order->unknownOrderAddress->receiver_mobile }}
                                            <br />
                                            <span class="bold">
                                                {{ __('transaction::dashboard.orders.show.transaction.method') }} :
                                            </span>
                                            {{ ucfirst($order->transactions->method) }}
                                            <br />
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xs-12 table-responsive">
                                    <br>
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th class="invoice-title uppercase text-left">
                                                    {{ __('order::dashboard.orders.show.items.title') }}
                                                </th>
                                                <th class="invoice-title uppercase text-left">
                                                    {{ __('order::dashboard.orders.show.items.price') }}
                                                </th>
                                                <th class="invoice-title uppercase text-left">
                                                    {{ __('order::dashboard.orders.show.items.qty') }}
                                                </th>
                                                <th class="invoice-title uppercase text-left">
                                                    {{ __('order::dashboard.orders.show.items.total') }}
                                                </th>
                                                @if ($order->orderCoupons && !empty($order->orderCoupons->products))
                                                    <th class="invoice-title uppercase text-left">
                                                        {{ __('order::dashboard.orders.show.items.coupon_discount') }}
                                                    </th>
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $customSubTotal = 0;
                                            @endphp
                                            @foreach ($order->allProducts as $product)
                                                @if (isset($product->product_variant_id) || $product->product_variant_title)
                                                    <tr>
                                                        <td class="text-left sbold">
                                                            @if ($product->product_variant_id)
                                                                <a
                                                                    href="{{ route('vendor.products.edit', $product->variant->product->id) }}">
                                                                    <img class="product_photo"
                                                                        src="{{ asset($product->variant->image) }}"
                                                                        width="39px" style="margin: 0px 2px;">
                                                                    {{ generateVariantProductData($product->variant->product, $product->product_variant_id, $product->variant->productValues->pluck('option_value_id')->toArray())['name'] }}
                                                                    @if ($product->variant->product->vendor)
                                                                        ({{ $product->variant->product->vendor->title }})
                                                                    @endif
                                                                </a>
                                                            @else
                                                                {{ $product->product_variant_title }}
                                                            @endif

                                                            @if ($product->notes)
                                                                <h5>
                                                                    <b>#
                                                                        {{ __('order::dashboard.orders.show.items.notes') }}</b>
                                                                    : {{ $product->notes }}
                                                                </h5>
                                                            @endif

                                                        </td>
                                                        <td class="text-left sbold">
                                                            {{ $product->sale_price }}
                                                        </td>
                                                        <td class="text-left sbold">
                                                            {{ $product->qty }}
                                                        </td>
                                                        <td class="text-left sbold">
                                                            {{ $product->total }}
                                                        </td>
                                                        @if ($order->orderCoupons &&
                                                            !empty($order->orderCoupons->products) &&
                                                            in_array($product->variant->product->id, $order->orderCoupons->products ?? []))
                                                            <td class="text-left sbold">
                                                                @if ($order->orderCoupons->discount_type == 'value')
                                                                    <span>{{ $order->orderCoupons->discount_value }}
                                                                        {{ __('apps::frontend.master.kwd') }}</span>
                                                                @else
                                                                    <span>{{ round($order->orderCoupons->discount_percentage, 1) }}
                                                                        %</span>
                                                                @endif
                                                            </td>
                                                        @endif
                                                    </tr>
                                                @else
                                                    @php
                                                        if ($order->orderCoupons && empty($order->orderCoupons->products)) {
                                                            if (!empty($product->add_ons_option_ids)) {
                                                                $customSubTotal += (floatval(json_decode($product->add_ons_option_ids)->total_amount) + floatval($product->sale_price)) * intval($product->qty);
                                                            } else {
                                                                $customSubTotal += $product->total;
                                                            }
                                                        }
                                                    @endphp
                                                    <tr>
                                                        <td class="notbold text-left">

                                                            @if ($product->product_id)
                                                                <a
                                                                    href="{{ route('vendor.products.edit', $product->product->id) }}">
                                                                    <img class="product_photo"
                                                                        src="{{ asset($product->product->image) }}"
                                                                        width="39px" style="margin: 0px 2px;">
                                                                    <span>
                                                                        {{ $product->product->title }}

                                                                        ({{ $product->product->sku }})

                                                                        @if ($product->product->vendor)
                                                                            ({{ $product->product->vendor->title }})
                                                                        @endif
                                                                    </span>
                                                                </a>
                                                            @else
                                                                {{ $product->product_title }}
                                                            @endif

                                                            @if ($product->notes)
                                                                <h5>
                                                                    <b>#
                                                                        {{ __('order::dashboard.orders.show.items.notes') }}</b>
                                                                    : {{ $product->notes }}
                                                                </h5>
                                                            @endif

                                                        </td>
                                                        <td class="text-left notbold">
                                                            {{ $product->sale_price }}
                                                        </td>
                                                        <td class="text-left notbold"> {{ $product->qty }}
                                                        </td>
                                                        <td class="text-left notbold">
                                                            @if (!empty($product->add_ons_option_ids))
                                                                {{ (floatval(json_decode($product->add_ons_option_ids)->total_amount) + floatval($product->sale_price)) * intval($product->qty) }}
                                                            @else
                                                                {{ $product->total }}
                                                            @endif
                                                        </td>
                                                        @if ($order->orderCoupons &&
                                                            !empty($order->orderCoupons->products) &&
                                                            in_array($product->product->id, $order->orderCoupons->products ?? []))
                                                            <td class="text-left sbold">
                                                                @if ($order->orderCoupons->discount_type == 'value')
                                                                    <span>{{ $order->orderCoupons->discount_value }}
                                                                        {{ __('apps::frontend.master.kwd') }}</span>
                                                                @else
                                                                    <span>{{ round($order->orderCoupons->discount_percentage, 1) }}
                                                                        %</span>
                                                                @endif
                                                            </td>
                                                        @endif
                                                    </tr>

                                                    @if (!is_null($product->add_ons_option_ids) && !empty($product->add_ons_option_ids))
                                                        @foreach (json_decode($product->add_ons_option_ids)->data as $key => $addons)
                                                            @foreach ($addons->options as $k => $option)
                                                                <tr>
                                                                    <td>
                                                                        <b>#
                                                                            {{ getAddonsTitle($addons->id) }}</b>
                                                                        - {{ getAddonsOptionTitle($option) }}
                                                                    </td>
                                                                    <td class="text-left notbold">
                                                                        {{ getOrderAddonsOptionPrice(json_decode($product->add_ons_option_ids), $option) }}
                                                                    </td>
                                                                    <td class="text-left notbold">1</td>
                                                                    <td class="text-left notbold">
                                                                        {{ getOrderAddonsOptionPrice(json_decode($product->add_ons_option_ids), $option) }}
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        @endforeach
                                                    @endif
                                                @endif
                                            @endforeach
                                        </tbody>
                                        <thead>

                                            <tr>
                                                <th class="text-left bold">
                                                    {{ __('order::dashboard.orders.show.order.subtotal') }}
                                                </th>
                                                <th></th>
                                                <th></th>
                                                @if ($order->orderCoupons && empty($order->orderCoupons->products))
                                                    <th class="text-left bold"> {{ $customSubTotal }} </th>
                                                @else
                                                    <th class="text-left bold"> {{ $order->subtotal }} </th>
                                                @endif
                                            </tr>
                                            @if ($order->orderCoupons && empty($order->orderCoupons->products))
                                                <tr style="border-top: 2px solid #d6dae0;">
                                                    <th class="text-left bold">
                                                        {{ __('order::dashboard.orders.show.order.coupon_discount') }}
                                                    </th>
                                                    <th></th>
                                                    <th></th>
                                                    <th class="text-left bold">
                                                        @if ($order->orderCoupons->discount_type == 'value')
                                                            {{ $order->orderCoupons->discount_value }}
                                                        @else
                                                            {{ $order->orderCoupons->discount_percentage }} %
                                                        @endif
                                                    </th>
                                                </tr>
                                            @endif
                                            <tr
                                                style="{{ is_null($order->orderCoupons) || !empty($order->orderCoupons->products) ? 'border-top: 2px solid #d6dae0;' : '' }}">
                                                <th class="text-left bold">
                                                    {{ __('order::dashboard.orders.show.order.shipping') }}
                                                </th>
                                                <th></th>
                                                <th></th>
                                                <th class="text-left bold">{{ $order->shipping }}</th>
                                            </tr>
                                            <tr>
                                                <th class="text-left bold">
                                                    {{ __('order::dashboard.orders.show.order.total') }}
                                                </th>
                                                <th></th>
                                                <th></th>
                                                <th class="text-left bold">{{ $order->total }}</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 col-xs-12">
                                        <div style="margin: 10px;">
                                            <b>{{ __('order::dashboard.orders.show.notes') }}
                                                : </b>
                                            <span>{{ $order->notes ?? '---' }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 col-xs-12">
                                        <div style="margin: 10px;">
                                            <b>
                                                <i class="font-red-sunglo fa fa-file-text-o"></i>
                                                {{ __('order::dashboard.orders.show.admin_note') }}
                                                :

                                                <i class="fa fa-edit show_admin_tag no-print"
                                                    style="color:#32c5d2; cursor: pointer;"
                                                    onclick="toggleAdminTag()"></i>
                                                <span class="hide_admin_tag no-print">
                                                    <i class="fa fa-close" style="color:#fa5661; cursor: pointer;"
                                                        onclick="toggleAdminTag()"></i>
                                                </span>
                                            </b>
                                            <span id="admin_note">{{ $order->admin_note ?? '---' }}</span>
                                            <div style="padding: 20px 74px;" class="hide_admin_tag no-print">

                                                {!! Form::open([
                                                    'url' => route('vendor.orders.admin.note', $order->id),
                                                    'role' => 'form',
                                                    'page' => 'form',
                                                    'class' => 'form-horizontal form-row-seperated updateForm',
                                                    'method' => 'PUT',
                                                    'files' => true,
                                                ]) !!}

                                                <div class="form-group">
                                                    <textarea class="form-control" name="admin_note" rows="8" cols="6">{{ $order->admin_note }}</textarea>
                                                </div>

                                                <div class="form-group">
                                                    <button type="submit" class="submit btn green btn-lg">
                                                        {{ __('apps::dashboard.general.edit_btn') }}
                                                    </button>
                                                </div>
                                                {!! Form::close() !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @if (!is_null($order->delivery_time))
                                    <div class="row">
                                        @if (isset($order->delivery_time['date']) && !empty($order->delivery_time['date']))
                                            <div class="col-md-6 col-xs-12">
                                                <div style="margin: 10px;">
                                                    <b>{{ __('order::dashboard.orders.show.delivery_time.day') }}
                                                        : </b>
                                                    <span>{{ $order->delivery_time['date'] ?? '---' }}</span>
                                                </div>
                                            </div>
                                        @endif

                                        @if (isset($order->delivery_time['time_from']) && !empty($order->delivery_time['time_from']))
                                            <div class="col-md-6 col-xs-12">
                                                <div style="margin: 10px;">
                                                    <b>{{ __('order::dashboard.orders.show.delivery_time.time') }}
                                                        : </b>
                                                    <span>From:
                                                        {{ $order->delivery_time['time_from'] ?? '---' }}</span>
                                                    <span>To: {{ $order->delivery_time['time_to'] ?? '---' }}</span>
                                                </div>
                                            </div>
                                        @endif

                                        @if (isset($order->delivery_time['type']) && $order->delivery_time['type'] == 'direct')
                                            <div class="col-md-6 col-xs-12">
                                                <div style="margin: 10px;">
                                                    <b>{{ __('order::dashboard.orders.show.delivery_time.type') }}
                                                        : </b>
                                                    <span>{{ __('order::dashboard.orders.show.delivery_time.direct') ?? '---' }}</span>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-xs-12">
                                                <div style="margin: 10px;">
                                                    <b>{{ __('order::dashboard.orders.show.delivery_time.message') }}
                                                        : </b>
                                                    <span>{{ $order->delivery_time['message'] ?? '---' }}</span>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-md-4 no-print">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    <div class="portlet light bordered" style="border: 1px solid #e7ecf1!important">

                        <div class="portlet-body">
                            <div class="row">
                                <div class="col-xs-2">
                                    <a class="btn btn-lg blue hidden-print margin-bottom-5"
                                        onclick="javascript:window.print();">
                                        {{ __('apps::dashboard.general.print_btn') }}
                                        <i class="fa fa-print"></i>
                                    </a>
                                </div>

                                @if (in_array(optional($order->paymentStatus)->flag, ['pending', 'cash']))
                                    @permission('confirm_payment_order')
                                        <a class="btn btn-lg btn-success hidden-print margin-bottom-5" href="#confirm_payment"
                                            data-toggle="modal" style="margin: 0px 77px;">
                                            {{ __('order::dashboard.orders.show.confirm_payment') }}
                                        </a>
                                        <div class="modal fade" id="confirm_payment" tabindex="-1" role="basic"
                                            aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-hidden="true"></button>

                                                    </div>
                                                    <div class="modal-body">
                                                        {{ __('order::dashboard.orders.show.confirm_payment_dec') }}

                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn dark btn-outline"
                                                            data-dismiss="modal">

                                                            {{ __('order::dashboard.orders.show.close') }}
                                                        </button>
                                                        <a href={{ route('vendor.orders.confirm.payment', $order->id) }}
                                                            class="btn green">
                                                            {{ __('order::dashboard.orders.show.confirm_payment') }}
                                                        </a>
                                                    </div>
                                                </div>
                                                <!-- /.modal-content -->
                                            </div>
                                            <!-- /.modal-dialog -->
                                        </div>
                                    @endpermission
                                @elseif(in_array(optional($order->paymentStatus)->flag, ['success']))
                                    @permission('refund_order')
                                        @if (!$order->is_refund)
                                            <div class="col-xs-2">
                                                <a class="btn btn-lg btn-warning hidden-print margin-bottom-5"
                                                    data-toggle="modal" href="#refund_modal" style="margin: 0px 77px;">
                                                    {{ __('order::dashboard.orders.show.refund_btn') }}
                                                </a>
                                            </div>

                                            <div class="modal fade bs-modal-lg" id="refund_modal" tabindex="-1"
                                                role="dialog" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-hidden="true"></button>
                                                            <h4 class="modal-title">
                                                                {{ __('order::dashboard.orders.show.refund_btn') }}</h4>
                                                        </div>
                                                        {!! Form::open([
                                                            'url' => route('vendor.orders.refund', $order->id),
                                                            'role' => 'form',
                                                            'page' => 'form',
                                                            'class' => 'form-horizontal form-row-seperated updateForm',
                                                            'method' => 'PUT',
                                                            'files' => true,
                                                        ]) !!}

                                                        <div class="modal-body">

                                                            <table class="table table-hover">
                                                                <thead>
                                                                    <tr>
                                                                        <th class="invoice-title uppercase text-left">
                                                                            {{ __('order::dashboard.orders.show.items.title') }}
                                                                        </th>
                                                                        <th class="invoice-title uppercase text-left">
                                                                            {{ __('order::dashboard.orders.show.items.price') }}
                                                                        </th>
                                                                        <th class="invoice-title uppercase text-left">
                                                                            {{ __('order::dashboard.orders.show.items.qty') }}
                                                                        </th>
                                                                        <th class="invoice-title uppercase text-left"
                                                                            style="width: 116px;">
                                                                            {{ __('order::dashboard.orders.show.items.refund_qty') }}
                                                                        </th>
                                                                        <th class="invoice-title uppercase text-left"
                                                                            style="width: 116px;">
                                                                            {{ __('order::dashboard.orders.show.items.remain') }}
                                                                        </th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @php
                                                                        $customSubTotal = 0;
                                                                        $totalQty = 0;
                                                                    @endphp
                                                                    @foreach ($order->allProducts as $product)
                                                                        @php
                                                                            $totalQty += $product->qty;
                                                                        @endphp
                                                                        @if (isset($product->product_variant_id) || $product->product_variant_title)
                                                                            <tr>
                                                                                <td class="text-left sbold">
                                                                                    @if ($product->product_variant_id)
                                                                                        <a
                                                                                            href="{{ route('vendor.products.edit', $product->variant->product->id) }}">
                                                                                            {{ generateVariantProductData($product->variant->product, $product->product_variant_id, $product->variant->productValues->pluck('option_value_id')->toArray())['name'] }}
                                                                                        </a>
                                                                                    @else
                                                                                        {{ $product->product_variant_title }}
                                                                                    @endif

                                                                                    @if ($product->notes)
                                                                                        <h5>
                                                                                            <b>#
                                                                                                {{ __('order::dashboard.orders.show.items.notes') }}</b>
                                                                                            : {{ $product->notes }}
                                                                                        </h5>
                                                                                    @endif
                                                                                </td>
                                                                                <td class="text-left sbold">
                                                                                    {{ $product->sale_price }}
                                                                                </td>
                                                                                <td class="text-left sbold">
                                                                                    {{ $product->qty }}
                                                                                </td>
                                                                                <td class="text-left sbold">
                                                                                    <input type="number"
                                                                                        max="{{ $product->qty }}"
                                                                                        min="0" value="0"
                                                                                        class="form-control refund_qty"
                                                                                        data-id="{{ $product->id }}"
                                                                                        data-fexedqty="{{ $product->qty }}">
                                                                                </td>
                                                                                <td class="text-left sbold">
                                                                                    <span
                                                                                        id="remaining_qty_{{ $product->id }}">{{ $product->qty }}</span>
                                                                                    <input type="hidden"
                                                                                        name="items[{{ $product->id }}][qty]"
                                                                                        value="{{ $product->qty }}"
                                                                                        id="remaining_qty_input_{{ $product->id }}">
                                                                                    <input type="hidden"
                                                                                        name="items[{{ $product->id }}][type]"
                                                                                        value="variant">
                                                                                </td>
                                                                            </tr>
                                                                        @else
                                                                            @php
                                                                                if ($order->orderCoupons && empty($order->orderCoupons->products)) {
                                                                                    if (!empty($product->add_ons_option_ids)) {
                                                                                        $customSubTotal += (floatval(json_decode($product->add_ons_option_ids)->total_amount) + floatval($product->sale_price)) * intval($product->qty);
                                                                                    } else {
                                                                                        $customSubTotal += $product->total;
                                                                                    }
                                                                                }
                                                                            @endphp
                                                                            <tr>
                                                                                <td class="notbold text-left">

                                                                                    @if ($product->product_id)
                                                                                        <a
                                                                                            href="{{ route('vendor.products.edit', $product->product->id) }}">
                                                                                            {{ $product->product->title }}
                                                                                            <br>
                                                                                            {{ $product->product->sku }}
                                                                                        </a>
                                                                                    @else
                                                                                        {{ $product->product_title }}
                                                                                    @endif


                                                                                    @if ($product->notes)
                                                                                        <h5>
                                                                                            <b>#
                                                                                                {{ __('order::dashboard.orders.show.items.notes') }}</b>
                                                                                            : {{ $product->notes }}
                                                                                        </h5>
                                                                                    @endif
                                                                                </td>
                                                                                <td class="text-left notbold">
                                                                                    {{ $product->sale_price }}
                                                                                </td>
                                                                                <td class="text-left notbold">
                                                                                    {{ $product->qty }}
                                                                                </td>
                                                                                <td class="text-left sbold">
                                                                                    <input type="number"
                                                                                        max="{{ $product->qty }}"
                                                                                        min="0" value="0"
                                                                                        class="form-control refund_qty"
                                                                                        data-id="{{ $product->id }}"
                                                                                        data-fexedqty="{{ $product->qty }}">
                                                                                </td>
                                                                                <td class="text-left sbold">
                                                                                    <span
                                                                                        id="remaining_qty_{{ $product->id }}">{{ $product->qty }}</span>
                                                                                    <input type="hidden"
                                                                                        name="items[{{ $product->id }}][qty]"
                                                                                        value="{{ $product->qty }}"
                                                                                        id="remaining_qty_input_{{ $product->id }}">
                                                                                    <input type="hidden"
                                                                                        name="items[{{ $product->id }}][type]"
                                                                                        value="product">
                                                                                </td>
                                                                            </tr>
                                                                        @endif
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                            <div class="row">
                                                                <div class="form-group col-md-9 col-xs-6">
                                                                </div>
                                                                <div class="form-group col-md-3 col-xs-6"
                                                                    style="text-align:center">
                                                                    <label>
                                                                        {{ __('order::dashboard.orders.show.return') }} <span
                                                                            id="return_qty">{{ $totalQty }}</span>
                                                                        {{ __('order::dashboard.orders.show.product') }}
                                                                    </label>
                                                                    <input type="checkbox" checked style="margin: 0px 10px;"
                                                                        name="increment_stock" value="1">
                                                                </div>
                                                            </div>
                                                            <div class="row" style="border-bottom: 1px solid #9e9e9e54;">
                                                                <div class="form-group col-md-6 col-xs-2">
                                                                </div>
                                                                <div class="form-group col-md-3 col-xs-5"
                                                                    style="text-align:center">
                                                                    {{ __('order::dashboard.orders.show.order.shipping') }}
                                                                </div>
                                                                <div class="form-group col-md-3 col-xs-5"
                                                                    style="text-align:center">
                                                                    {{ $order->shipping }}
                                                                </div>
                                                                <div class="form-group col-md-6 col-xs-2">
                                                                </div>
                                                                <div class="form-group col-md-3 col-xs-5"
                                                                    style="text-align:center">
                                                                    {{ __('order::dashboard.orders.show.order.total') }}
                                                                </div>
                                                                <div class="form-group col-md-3 col-xs-5"
                                                                    style="text-align:center">
                                                                    {{ $order->total }}
                                                                </div>
                                                            </div>
                                                            <div class="row" style="margin:17px 0px">
                                                                <div class="form-group col-md-9 col-xs-6">


                                                                    <span class="bold">
                                                                        {{ __('transaction::dashboard.orders.show.transaction.method') }}
                                                                        :
                                                                    </span>
                                                                    {{ ucfirst($order->transactions->method) }}
                                                                </div>
                                                                <div class="form-group col-md-3 col-xs-6"
                                                                    style="text-align:center">
                                                                    <input type="number" value="{{ $order->total }}"
                                                                        class="form-control">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <div class="form-actions">
                                                                @include('apps::dashboard.layouts._ajax-msg')
                                                                <div>
                                                                    <button type="button" class="btn btn-warning btn-outline"
                                                                        data-dismiss="modal">
                                                                        {{ __('order::dashboard.orders.show.close') }}
                                                                    </button>
                                                                    <button type="submit"
                                                                        class="btn green submit">{{ __('order::dashboard.orders.show.refund') }}</button>

                                                                </div>
                                                            </div>
                                                        </div>
                                                        {!! Form::close() !!}
                                                    </div>
                                                    <!-- /.modal-content -->
                                                </div>
                                                <!-- /.modal-dialog -->
                                            </div>
                                        @endif
                                    @endpermission
                                @endif
                            </div>
                        </div>
                    </div>

                    @permission('show_order_change_status_tab')
                        <div class="portlet light bordered" style="    border: 1px solid #e7ecf1!important">
                            <div class="portlet-title">
                                <div class="caption font-red-sunglo">
                                    <i class="fa fa-shopping-cart font-red-sunglo"></i>
                                    <span class="caption-subject bold uppercase">
                                        {{ __('order::dashboard.orders.show.change_order_status') }}
                                    </span>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <div class="no-print">
                                    <div class="row">
                                        <div class="col-md-12">

                                            <form id="updateForm" method="POST"
                                                action="{{ url(route('vendor.orders.update', $order['id'])) }}"
                                                enctype="multipart/form-data" class="horizontal-form">
                                                @csrf
                                                <input name="_method" type="hidden" value="PUT">

                                                <div class="form-group">
                                                    <label>
                                                        {{ __('order::dashboard.orders.show.drivers.title') }}
                                                    </label>
                                                    <select name="user_id" class="form-control">
                                                        <option value="">
                                                            --- {{ __('order::dashboard.orders.show.drivers.title') }}
                                                            ---
                                                        </option>
                                                        @foreach ($drivers as $driver)
                                                            <option value="{{ $driver->id }}"
                                                                @if ($order->driver) {{ $order->driver->user_id == $driver->id ? 'selected' : '' }} @endif>

                                                                {{ $driver->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label>
                                                        {{ __('order::dashboard.orders.show.status') }}
                                                    </label>
                                                    <select name="order_status" id="single" class="form-control">
                                                        <option value="">--- Select ---</option>
                                                        @foreach ($statuses as $status)
                                                            <option value="{{ $status->id }}"
                                                                {{ $order->order_status_id == $status->id ? 'selected' : '' }}>

                                                                {{ $status->title }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label>
                                                        {{ __('order::dashboard.orders.show.order_notes') }}
                                                    </label>
                                                    <textarea class="form-control" name="order_notes" rows="8" cols="80">{{ $order->order_notes }}</textarea>
                                                </div>


                                                <div id="result" style="display: none"></div>
                                                <div class="progress-info" style="display: none">
                                                    <div class="progress">
                                                        <span class="progress-bar progress-bar-warning"></span>
                                                    </div>
                                                    <div class="status" id="progress-status"></div>
                                                </div>
                                                <div class="form-group">
                                                    <button type="submit" id="submit" class="btn green btn-lg">
                                                        {{ __('apps::dashboard.general.edit_btn') }}
                                                    </button>
                                                </div>
                                            </form>

                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                    @endpermission

                    <div class="note note-success">
                        <div class="company-address">
                            <span class="bold">
                                {{ __('transaction::dashboard.orders.show.transaction.payment_id') }} :
                            </span>
                            {{ $order->transactions->payment_id ?? '---' }}
                            <br />
                            <span class="bold">
                                {{ __('transaction::dashboard.orders.show.transaction.track_id') }} :
                            </span>
                            {{ $order->transactions->track_id ?? '---' }}
                            <br />
                            <span class="bold">
                                {{ __('transaction::dashboard.orders.show.transaction.method') }} :
                            </span>{{ $order->transactions->method ?? '---' }}
                            <br />
                            <span class="bold">
                                {{ __('transaction::dashboard.orders.show.transaction.result') }} :
                            </span>{{ $order->transactions->result ?? '---' }}
                            <br />
                            <span class="bold">
                                {{ __('transaction::dashboard.orders.show.transaction.ref') }} :
                            </span>{{ $order->transactions->ref ?? '---' }}
                            <br />
                            <span class="bold">
                                {{ __('transaction::dashboard.orders.show.transaction.tran_id') }} :
                            </span>
                            {{ $order->transactions->tran_id ?? '---' }}
                            <br />
                        </div>

                        @if (optional($order->paymentStatus)->flag == 'success')
                            <hr>
                            <div class="row">
                                <div class="col-md-12">
                                    <ul class="list-group">
                                        <li class="list-group-item">
                                            {{ __('order::dashboard.orders.show.payment_confirmed_at') }} :
                                            {{ $order->payment_confirmed_at ? date('Y-m-d / H:i:s', strtotime($order->payment_confirmed_at)) : '---' }}
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        @endif

                        {{-- @if (!empty($order->payment_commissions))
                            <hr>
                            <div class="row">
                                <div class="col-md-12">
                                    <ul class="list-group">
                                        <li class="list-group-item">
                                            {{ __('apps::dashboard.general.knet_commission') }} :
                                            {{ $order->payment_commissions['knet'] }}</li>
                                        <li class="list-group-item">
                                            {{ __('apps::dashboard.general.cc_commission') }} :
                                            {{ $order->payment_commissions['cc'] }}
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        @endif --}}
                    </div>
                    @permission('show_order_change_status_tab')

                        <!-- BEGIN SAMPLE FORM PORTLET-->
                        <div class="portlet light bordered" style="    border: 1px solid #e7ecf1!important">
                            <div class="portlet-title">
                                <div class="caption font-red-sunglo">
                                    <i class="fa fa-archive font-red-sunglo"></i>
                                    <span class="caption-subject bold uppercase">
                                        {{ __('order::dashboard.orders.show.order_history_log') }}
                                    </span>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <div class="no-print row">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-hover">
                                                <thead>
                                                    <tr>
                                                        <th class="invoice-title uppercase text-center">
                                                            {{ __('order::dashboard.orders.show.order_history.order_status') }}
                                                        </th>
                                                        <th class="invoice-title uppercase text-center">
                                                            {{ __('order::dashboard.orders.show.order_history.updated_by') }}
                                                        </th>
                                                        <th class="invoice-title uppercase text-center">
                                                            {{ __('order::dashboard.orders.show.order_history.date') }}
                                                        </th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($order->orderStatusesHistory()->orderBy('pivot_created_at', 'desc')->get() as $k => $history)
                                                        <tr id="orderHistory-{{ optional($history->pivot)->id }}">
                                                            <td class="text-center sbold">
                                                                {{ $history->title ?? '' }}
                                                            </td>
                                                            <td class="text-center sbold">
                                                                {{ is_null(optional($history->pivot)->user_id) ? '---' : \Modules\User\Entities\User::find(optional($history->pivot)->user_id)->name ?? null }}
                                                            </td>
                                                            <td class="text-center sbold">
                                                                {{ optional($history->pivot)->created_at }}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endpermission
                </div>
            </div>
        </div>
    </div>

@stop

@section('scripts')
    <script>
        $(".refund_qty").bind('keyup mouseup', function() {
            var newQty = 0;
            $('.refund_qty').each(function() {
                let productId = $(this).attr('data-id');
                let fexedqty = $(this).attr('data-fexedqty');
                let newItemQty = $(this).val();
                let outputQty = parseInt(fexedqty) - parseInt(newItemQty);
                $(`#remaining_qty_${productId}`).text('').html(outputQty);
                $(`#remaining_qty_input_${productId}`).val(outputQty);

                newQty += parseInt($(this).val());
            });

            $('#return_qty').text('').append(newQty);
        });

        function toggleAdminTag() {
            $('.hide_admin_tag').toggle();
            $('.show_admin_tag').toggle();
        }

        function requestUpdating(status, data) {

            if (status == 'success') {

                $('#admin_note').text("").append(data.note);
                toggleAdminTag();
            }
        }
    </script>


@endsection
