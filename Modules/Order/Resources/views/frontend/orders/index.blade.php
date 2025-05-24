@extends('apps::frontend.layouts.master')
@section('title', __('apps::frontend.master.my_orders') )
@section('content')

    <div class="container">
        <div class="page-crumb mt-30">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('frontend.home') }}">
                            <i class="ti-home"></i> {{ __('apps::frontend.nav.home_page') }}
                        </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('frontend.profile.index') }}">{{ __('user::frontend.profile.index.my_account') }}</a>
                    </li>
                    <li class="breadcrumb-item active text-muted"
                        aria-current="page"> {{ __('user::frontend.profile.index.my_orders') }}</li>
                </ol>
            </nav>
        </div>
        <div class="inner-page">
            <div class="row">
                <div class="col-md-3">
                    @include('user::frontend.profile._user-side-menu')
                </div>
                <div class="col-md-9">
                    <div class="cart-inner order-page">
                        <div class="cart-items">

                            @if(count($orders) > 0)
                                @foreach($orders as $k => $order)
                                    <div class="order-item">
                                        <div class="d-block">
                                            <p><b>{{ __('order::frontend.orders.invoice.order_id') }}: </b>
                                                # {{ $order->id }}
                                            </p>
                                        </div>
                                        <div class="cart-item media align-items-center">
                                            <div class="pro-det d-flex align-items-center">
                                                <div class="pro-img">
                                                    <img class="img-fluid"
                                                         src="{{ url('frontend/images/logo.png') }}"
                                                         alt="Author">
                                                </div>
                                                <div class="media-body">
                                                    {{--<span class="product-name">
                                                        <a href="#"> سلة الاسترخاء</a>
                                                    </span>--}}
                                                    <span class="date d-block">
                                                    {{ $order->created_at }}
                                                </span>
                                                    <span class="price d-block">
                                                    {{ $order->total }} {{ __('apps::frontend.master.kwd') }}
                                                </span>
                                                    <span class="order-status loading d-block">
                                                    {{ $order->orderStatus->title }}
                                                </span>
                                                </div>
                                            </div>
                                            <div class="text-left">
                                                <a href="{{ route('frontend.orders.invoice', $order->id) }}"
                                                   class="btn btn-them">
                                                    <i class="ti-bag"></i> {{ __('order::frontend.orders.index.btn.details') }}
                                                </a>
                                                {{--<button class="btn remove"><i class="ti-trash"></i></button>--}}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <b>{{ __('order::frontend.orders.invoice.no_data') }}</b>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('externalJs')

    <script></script>

@endsection
