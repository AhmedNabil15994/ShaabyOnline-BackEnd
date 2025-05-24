<div class="process-content">
    <div class="process-icon text-center">
        <img src="{{ url('frontend/images/contact-info.png') }}" class="img-fluid" alt=""/>
    </div>

    <div class="item-block-dec mt-30">
        <h2 class="block-title">{{ __('catalog::frontend.cart.contact_info') }}</h2>
        <form class="checkout-form mt-30" method="post"
              action="{{ url(route('frontend.order.address.guest.delivery_charge')) }}">
            @csrf
            <input type="hidden" name="state_id" id="stateID"
                   value="{{ get_cookie_value(config('core.config.constants.ORDER_STATE_ID')) !== null ? get_cookie_value(config('core.config.constants.ORDER_STATE_ID')) : '' }}">

            @include('apps::frontend.layouts._alerts')

            <div class="delivery-options border-top">

                <div class="d-flex delivey-option">
                    <span class="d-inline-block flex-1">{{ __('apps::frontend.master.area') }}</span>
                    <a href="{{ route('frontend.order.address.choose_address') }}"
                       id="selectedArea" class="d-inline-block justify-content-end theme-color-hover">
                        @if (get_cookie_value(config('core.config.constants.ORDER_STATE_NAME')) !== null)
                            {{ get_cookie_value(config('core.config.constants.ORDER_STATE_NAME')) }}
                        @else
                            {{ __('apps::frontend.master.area_not_selected') }}
                        @endif
                        <i class="fa fa-angle-left"></i>
                    </a>
                </div>

                <input type="text" name="username" autocomplete="off"
                       value="{{ old('username') ? old('username') : (isset($savedContactInfo['username']) ? $savedContactInfo['username'] : '') }}"
                       placeholder="{{ __('catalog::frontend.checkout.address.form.username') }}"/>

                <input type="email" name="email" autocomplete="off"
                       value="{{ old('email') ? old('email') : (isset($savedContactInfo['email']) ? $savedContactInfo['email'] : '') }}"
                       placeholder="{{ __('catalog::frontend.checkout.address.form.email') }}"/>

                <input type="text" name="mobile" autocomplete="off"
                       value="{{ old('mobile') ? old('mobile') : (isset($savedContactInfo['mobile']) ? $savedContactInfo['mobile'] : '') }}"
                       placeholder="{{ __('catalog::frontend.checkout.address.form.mobile') }}"/>

                <input type="text" name="block" autocomplete="off"
                       value="{{ old('block') ? old('block') : (isset($savedContactInfo['block']) ? $savedContactInfo['block'] : '') }}"
                       placeholder="{{ __('catalog::frontend.address.form.block') }}"/>

                <input type="text" name="street" autocomplete="off"
                       value="{{ old('street') ? old('street') : (isset($savedContactInfo['street']) ? $savedContactInfo['street'] : '') }}"
                       placeholder="{{ __('catalog::frontend.address.form.street') }}"/>

                <input type="text" name="building" autocomplete="off"
                       value="{{ old('building') ? old('building') : (isset($savedContactInfo['building']) ? $savedContactInfo['building'] : '') }}"
                       placeholder="{{ __('catalog::frontend.address.form.building') }}"/>

                <textarea placeholder="{{ __('catalog::frontend.address.form.address_details') }}"
                          name="address" rows="4"
                          cols="40">{{ old('address') ? old('address') : (isset($savedContactInfo['address']) ? $savedContactInfo['address'] : '') }}</textarea>

                <div class="btn-container mt-20 mb-20">
                    <button type="submit"
                            class="btn btn-block btn-theme">{{ __('apps::frontend.master.continue') }}</button>
                </div>

            </div>


        </form>
    </div>
</div>

@section('externalJs')

    <script>
        $(document).ready(function () {

            {{--if ($.cookie("{{ config('core.config.constants.ORDER_STATE_NAME') }}") !== null && $.cookie("{{ config('core.config.constants.ORDER_STATE_NAME') }}") !== undefined) {
                $('#stateID').val($.cookie("{{ config('core.config.constants.ORDER_STATE_ID') }}"));
                $('#selectedArea').text($.cookie("{{ config('core.config.constants.ORDER_STATE_NAME') }}"));
            }--}}

        });
    </script>

@endsection
