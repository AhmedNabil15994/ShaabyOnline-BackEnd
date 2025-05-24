<div class="process-content">
    <div class="process-icon text-center">
        <img src="{{ url('frontend/images/payment.png') }}" class="img-fluid" alt=""/>
    </div>

    <form action="{{ url(route('frontend.orders.create_order')) }}" method="post">
        @csrf

        <br>
        @include('apps::frontend.layouts._alerts')

        <div class="item-block-dec mt-30">
            <h2 class="block-title">{{ __('catalog::frontend.checkout.index.payments') }}</h2>
            <div class="choose-time mt-30">

                @if($vendor)
                    @foreach($vendor->payments as $payment)
                        <div class="checkboxes radios mb-20">
                            <input id="check-{{$payment->code}}" type="radio" name="payment"
                                   value="{{$payment->code}}">
                            <label for="check-{{$payment->code}}">
                                {{ $payment->title}}
                            </label>
                        </div>
                    @endforeach
                @endif

            </div>
        </div>
        <div class="btn-container mt-40 mb-20">
            <button type="submit"
                    class="btn btn-block btn-theme">{{ __('catalog::frontend.checkout.index.go_to_payment') }}</button>
        </div>

    </form>

</div>

@section('externalJs')

    <script></script>

@endsection