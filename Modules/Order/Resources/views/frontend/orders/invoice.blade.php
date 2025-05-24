@extends('apps::frontend.layouts.master')
@section('title', __('order::frontend.orders.invoice.title') )
@section('content')

    <div class="container d-flex align-items-center">
        <div class="inner-page w100">
            <div class="align-items-center">
                <div class="order-approved mt-20 mb-20 text-center">
                    <img src="{{ url('frontend/images/order-approved.png') }}" alt=""/>
                    <h1>{{ session('status') }}</h1>
                    <div class="order-det">
                        <p><b>{{ __('order::frontend.orders.invoice.order_id') }}</b>: # {{ $order->id }}</p>
                        <p><b>{{ __('order::frontend.orders.invoice.status') }}</b>:
                            <span class="order-status under-processing">{{ $order->orderStatus->title }}</span>
                        </p>
                        <p><b>{{ __('order::frontend.orders.invoice.total') }}</b>{{ $order->total }}</p>
                        {{--<p><b>وقت التسليم</b>: خلال 48 ساعة</p>--}}
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('externalJs')

    <script></script>

@endsection