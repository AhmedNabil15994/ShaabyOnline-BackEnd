@extends('apps::driver.layouts.app')
@section('title', __('order::driver.orders.show.title'))
@section('content')
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
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <a href="{{ url(route('driver.home')) }}">{{ __('apps::driver.home.title') }}</a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <a href="{{ url(route('driver.orders.index')) }}">
                            {{ __('order::driver.orders.index.title') }}
                        </a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <a href="#">{{ __('order::driver.orders.show.title') }}</a>
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
                                    <a data-toggle="tab" href="#order">
                                        <i class="fa fa-cog"></i> {{ __('order::driver.orders.show.invoice') }}
                                    </a>
                                    <span class="after"></span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-9 contentPrint">
                        <div class="tab-content">
                            <div class="tab-pane active" id="order">
                                <div class="invoice">

                                    <div class="row invoice-logo">
                                        <div class="col-xs-6">
                                            <p>
                                                <img src="{{ url(config('setting.images.logo')) }}" class="img-responsive"
                                                    style="width:40%" />
                                            </p>
                                        </div>
                                        <div class="col-xs-6">
                                            <p> #{{ $order['id'] }} /
                                                {{ date('Y-m-d', strtotime($order->created_at)) }}
                                            </p>
                                        </div>
                                    </div>

                                    <hr />

                                    <div class="row">
                                        <h3>{{ __('order::driver.orders.show.user.data') }}</h3>
                                        <div class="col-xs-12 table-responsive">
                                            <table class="table table-striped table-hover">
                                                <thead>
                                                    <tr>
                                                        <th class="invoice-title uppercase text-center">
                                                            {{ __('order::driver.orders.show.user.username') }}
                                                        </th>
                                                        <th class="invoice-title uppercase text-center">
                                                            {{ __('order::driver.orders.show.user.email') }}
                                                        </th>
                                                        <th class="invoice-title uppercase text-center">
                                                            {{ __('order::driver.orders.show.user.mobile') }}
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="text-center sbold"> {{ $order->orderAddress->username }}
                                                        </td>
                                                        <td class="text-center sbold"> {{ $order->orderAddress->email }}
                                                        </td>
                                                        <td class="text-center sbold"> {{ $order->orderAddress->mobile }}
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <h3>{{ __('order::driver.orders.show.address.data') }}</h3>
                                        <div class="col-xs-12 table-responsive">
                                            <table class="table table-striped table-hover">
                                                <thead>
                                                    <tr>
                                                        <th class="invoice-title uppercase text-center">
                                                            {{ __('order::driver.orders.show.address.city') }}
                                                        </th>
                                                        <th class="invoice-title uppercase text-center">
                                                            {{ __('order::driver.orders.show.address.state') }}
                                                        </th>
                                                        <th class="invoice-title uppercase text-center">
                                                            {{ __('order::driver.orders.show.address.block') }}
                                                        </th>
                                                        <th class="invoice-title uppercase text-center">
                                                            {{ __('order::driver.orders.show.address.street') }}
                                                        </th>
                                                        <th class="invoice-title uppercase text-center">
                                                            {{ __('order::driver.orders.show.address.building') }}
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="text-center sbold">
                                                            {{ $order->orderAddress->state->city->title }}
                                                        </td>
                                                        <td class="text-center sbold">
                                                            {{ $order->orderAddress->state->title }}
                                                        </td>
                                                        <td class="text-center sbold">
                                                            {{ $order->orderAddress->block }}
                                                        </td>
                                                        <td class="text-center sbold">
                                                            {{ $order->orderAddress->street }}
                                                        </td>
                                                        <td class="text-center sbold">
                                                            {{ $order->orderAddress->building }}
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <hr />

                                    <div class="row">
                                        <h3>{{ __('order::driver.orders.show.order.data') }}</h3>
                                        <div class="col-xs-12 table-responsive">
                                            <table class="table table-striped table-hover">
                                                <thead>
                                                    <tr>
                                                        <th class="invoice-title uppercase text-center">
                                                            {{ __('order::driver.orders.show.order.subtotal') }}
                                                        </th>
                                                        <th class="invoice-title uppercase text-center">
                                                            {{ __('order::driver.orders.show.order.shipping') }}
                                                        </th>
                                                        <th class="invoice-title uppercase text-center">
                                                            {{ __('order::driver.orders.show.order.off') }}
                                                        </th>
                                                        <th class="invoice-title uppercase text-center">
                                                            {{ __('order::driver.orders.show.order.total') }}
                                                        </th>
                                                        <th class="invoice-title uppercase text-center">
                                                            {{ __('order::driver.orders.show.other.vendor') }}
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="text-center sbold"> {{ $order->subtotal }} </td>
                                                        <td class="text-center sbold"> {{ $order->shipping }} </td>
                                                        <td class="text-center sbold"> {{ $order->off }}</td>
                                                        <td class="text-center sbold"> {{ $order->total }}</td>
                                                        <td class="text-center sbold">
                                                            <ul>
                                                                @foreach ($order->vendors as $key => $vendor)
                                                                    <li style="list-style: none">{{ $vendor->title }}</li>
                                                                @endforeach
                                                            </ul>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <hr />
                                    <div class="row">
                                        <h3>{{ __('order::driver.orders.show.items.data') }}</h3>
                                        <div class="col-xs-12 table-responsive">
                                            <table class="table table-striped table-hover">
                                                <thead>
                                                    <tr>
                                                        <th class="invoice-title uppercase text-center">
                                                            {{ __('order::driver.orders.show.items.title') }}
                                                        </th>
                                                        <th class="invoice-title uppercase text-center">
                                                            {{ __('order::driver.orders.show.items.options') }}
                                                        </th>
                                                        <th class="invoice-title uppercase text-center">
                                                            {{ __('order::driver.orders.show.items.price') }}
                                                        </th>
                                                        <th class="invoice-title uppercase text-center">
                                                            {{ __('order::driver.orders.show.items.qty') }}
                                                        </th>
                                                        <th class="invoice-title uppercase text-center">
                                                            {{ __('order::driver.orders.show.items.total') }}
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($order->orderProducts as $product)
                                                        <tr>
                                                            <td class="text-center sbold">
                                                                {{ $product->product->title }}
                                                            </td>
                                                            <td class="text-center sbold">
                                                                @if (!is_null($product->orderVariant))
                                                                    @foreach ($product->orderVariant->orderVariantValues as $value)
                                                                        <i>
                                                                            {{ $value->variantValue->optionValue->option->title }}
                                                                            :
                                                                            {{ $value->variantValue->optionValue->title }}
                                                                        </i>

                                                                        @if (!$loop->last)
                                                                            <br>
                                                                        @endif
                                                                    @endforeach
                                                                @endif
                                                            </td>
                                                            <td class="text-center sbold"> {{ $product->sale_price }} </td>
                                                            <td class="text-center sbold"> {{ $product->qty }} </td>
                                                            <td class="text-center sbold"> {{ $product->total }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-4">
                            <a class="btn btn-lg blue hidden-print margin-bottom-5" onclick="javascript:window.print();">
                                {{ __('apps::driver.general.print_btn') }}
                                <i class="fa fa-print"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop
