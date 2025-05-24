<!DOCTYPE html>
<html dir="{{ locale() == 'ar' ? 'rtl' : 'ltr' }}" lang="{{ locale() == 'ar' ? 'ar' : 'en' }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{__('apps::dashboard.general.print_orders')}} || {{ config('app.name') }} </title>
    <meta name="description" content="">

    <link rel="stylesheet" href="{{ url('frontend/css/bootstrap.min.css') }}">

    <style>
        @media print {
            .hidden-print {
                display: none !important;
            }
        }
    </style>

    <script>
        window.print();
    </script>

</head>

<body>

    <div class="container mt-4 mb-4">

        <div class="row hidden-print">
            <div class="col-md-12 text-center mb-3">
                <button type="button" class="btn btn-info btn-sm" onclick="window.print();">
                    {{__('apps::dashboard.general.print_btn')}}
                </button>

                @if(isset(request()->page) && request()->page == 'orders')
                <a href="{{ route('dashboard.current_orders.index') }}" class="btn btn-danger btn-sm">
                    {{__('apps::dashboard.general.back_btn')}}
                </a>
                @else
                <a href="{{ route('dashboard.all_orders.index') }}" class="btn btn-danger btn-sm">
                    {{__('apps::dashboard.general.back_btn')}}
                </a>
                @endif
            </div>
            <hr width="50%">
        </div>

        @foreach ($orders as $order)

        <div class="row">
            <div class="col-md-5">
                <address class="norm">
                    <p class="d-flex">
                        <b class="flex-1">
                            {{ __('order::frontend.orders.invoice.order_id') }} : </b> {{ $order->id }}
                    </p>
                    <p class="d-flex">
                        <b class="flex-1">
                            {{ __('order::frontend.orders.invoice.date') }} : </b> {{ $order->created_at }}
                        <p>
                            <p class="d-flex">
                                <b class="flex-1">{{ __('order::frontend.orders.invoice.method') }} : </b>
                                @if($order->transactions->method == 'cash')
                                {{ __('order::frontend.orders.invoice.cash') }}
                                @else
                                {{ __('order::frontend.orders.invoice.online') }}
                                @endif
                            </p>
                </address>
            </div>
            <div class="col-md-2 text-right">
                <img src="{{ config('setting.images.white_logo') ? url(config('setting.images.white_logo')) : url('frontend/images/footer-logo.png') }}"
                    class="img-fluid" style="width: 130px; height: 130px;">
            </div>
            <div class="col-md-5 text-left">
                @if($order->unknownOrderAddress)
                <address class="norm">
                    <p class="d-flex">
                        <b class="flex-1">{{ __('order::frontend.orders.invoice.client_address.name') }}
                            : </b>{{ $order->unknownOrderAddress->receiver_name }}
                    </p>
                    <p class="d-flex">
                        <b class="flex-1">{{ __('order::frontend.orders.invoice.client_address.state') }}
                            :</b>{{ $order->unknownOrderAddress->state->title }}
                        <p>
                            <p class="d-flex">
                                <b class="flex-1">{{ __('order::frontend.orders.invoice.client_address.mobile') }}
                                    :</b>{{ $order->unknownOrderAddress->receiver_mobile }}
                            </p>
                </address>
                @else
                <address class="norm">
                    <p class="d-flex">
                        <b class="flex-1">{{ __('order::frontend.orders.invoice.client_address.state') }}
                            : </b>{{ $order->orderAddress->state->title }}
                    </p>
                    <p class="d-flex">
                        <b class="flex-1">{{ __('order::frontend.orders.invoice.client_address.block') }}
                            :</b>{{ $order->orderAddress->block }}
                        <p>
                            <p class="d-flex">
                                <b class="flex-1">{{ __('order::frontend.orders.invoice.client_address.building') }}
                                    :</b>{{ $order->orderAddress->building }}
                            </p>

                            @if(!empty($order->orderAddress->address))
                            <p class="d-flex">
                                <b class="flex-1">{{ __('order::frontend.orders.invoice.client_address.details') }}
                                    :</b>{{ $order->orderAddress->address }}
                            </p>
                            @endif

                </address>
                @endif
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-12">

                <table class="table">
                    <thead>
                        <tr>
                            <th><span> #</span></th>
                            <th><span>{{ __('order::frontend.orders.invoice.product_title') }}</span></th>
                            <th><span>{{ __('order::frontend.orders.invoice.product_qty') }}</span></th>
                            <th><span>{{ __('order::frontend.orders.invoice.product_price') }}</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($order->orderProducts->mergeRecursive($order->orderVariations)) > 0)
                        @foreach ($order->orderProducts->mergeRecursive($order->orderVariations) as $key => $orderProduct)
                        <tr class="{{ ++$key % 2 == 0 ? 'even' : '' }}">
                            <td><span>{{ $key }}</span></td>
                            @if(isset($orderProduct->product_variant_id) && !empty($orderProduct->product_variant_id))
                            <td>
                                <span>{{ generateVariantProductData($orderProduct->variant->product, $orderProduct->product_variant_id, $orderProduct->variant->productValues->pluck('option_value_id')->toArray())['name'] }}</span>
                            </td>
                            @else
                            <td><span>{{ $orderProduct->product->title }}</span></td>
                            @endif
                            <td><span>{{ $orderProduct->qty }}</span></td>
                            <td><span>{{ $orderProduct->price }}</span>
                                <span data-prefix>{{ __('apps::frontend.master.kwd') }}</span>
                            </td>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>

                <table class="table table-bordered mt-4 text-center">
                    <tr>
                        <th><span>{{ __('order::frontend.orders.invoice.subtotal') }}</span></th>
                        <td>
                            <span>{{ $order->subtotal }}</span>
                            <span data-prefix>{{ __('apps::frontend.master.kwd') }}</span>
                        </td>
                    </tr>
                    <tr>
                        <th><span>{{ __('order::frontend.orders.invoice.shipping') }}</span></th>
                        <td>
                            <span>{{ $order->shipping }}</span>
                            <span data-prefix>{{ __('apps::frontend.master.kwd') }}</span>
                        </td>
                    </tr>
                    <tr class="price">
                        <th><span>{{ __('order::frontend.orders.invoice.total') }}</span></th>
                        <td>
                            <span>{{ $order->total }}</span>
                            <span data-prefix>{{ __('apps::frontend.master.kwd') }}</span>
                        </td>
                    </tr>
                </table>

            </div>
        </div>

        @if(!$loop->last)
        <hr style="border: 1px dashed black;">
        @endif
        @endforeach

    </div>

</body>

</html>