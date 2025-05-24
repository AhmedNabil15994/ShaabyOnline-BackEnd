@extends('apps::frontend.layouts.master')
@section('title', __('apps::frontend.choose_address.title') )
@section('content')

    <div class="right-side d-flex">
        <div class="right-side-content">
            <div class='inner-page'>
                <div class="page-head d-flex align-items-center border-bottom pb-20 mb-20">
                    <a href="{{ url()->previous() == url()->current() ? route('frontend.shopping-cart.index') : url()->previous() }}"
                       class="go-back theme-color-hover flex-1"><i
                            class="ti-arrow-right"></i></a>
                    <div class="head-search">
                        <input type="search" class="form-control"
                               placeholder="{{ __('catalog::frontend.address.form.search_by_area') }}"/>
                    </div>
                </div>
                <div class="choose-item">

                    <div class="list-group" id="allStates">
                        @if(count($states) > 0)
                            @foreach ($states as $state)
                                <a href="javascript:;"
                                   id="state-{{$state->id}}"
                                   onclick="saveArea('{{ $state->id }}', '{{ $state->title }}', '{{ $state->deliveryCharge->delivery_time }}', '{{ $state->deliveryCharge->delivery }}')"
                                   class="list-group-item list-group-item-action {{ get_cookie_value(config('core.config.constants.ORDER_STATE_ID')) == $state->id ? 'list-group-item-secondary active' : '' }}">
                                    {{ $state->title }}
                                </a>
                            @endforeach
                        @endif
                    </div>

                    {{--<p class="collapsed" data-toggle="collapse" data-target="#collapse1" aria-expanded="false"
                       aria-controls="collapseExample">
                        {{ __('catalog::frontend.address.index.areas') }}
                    </p>

                    <div class="collapse" id="collapse1">
                        <div class="card card-body">
                            <ul>
                                @if(count($states) > 0)
                                    @foreach ($states as $state)
                                        <li id="state-{{ $state->id }}" class="state"
                                            data-id="{{ $state->id }}"
                                            data-time="{{ $state->deliveryCharge->delivery_time }}"
                                            data-price="{{ $state->deliveryCharge->delivery }}"
                                            data-name="{{ $state->title }}">{{ $state->title }}</li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                    </div>--}}

                </div>

            </div>
        </div>
    </div>

@endsection

@section('externalJs')

    <script>
        $(document).ready(function () {

            {{--if ($.cookie("{{ config('core.config.constants.ORDER_STATE_ID') }}") !== null && $.cookie("{{ config('core.config.constants.ORDER_STATE_ID') }}") !== undefined) {
                $('#state-' + $.cookie("{{ config('core.config.constants.ORDER_STATE_ID') }}")).addClass('active');
            }--}}

        });

        function saveArea(stateId, sateName, deliveryTime, deliveryPrice) {

            $.removeCookie("{{ config('core.config.constants.ORDER_STATE_ID') }}");
            $.removeCookie("{{ config('core.config.constants.ORDER_STATE_NAME') }}");
            $.removeCookie("{{ config('core.config.constants.ORDER_DELIVERY_TIME') }}");
            $.removeCookie("{{ config('core.config.constants.ORDER_DELIVERY_PRICE') }}");

            $.cookie("{{ config('core.config.constants.ORDER_STATE_ID') }}", stateId, {path: '/'});
            $.cookie("{{ config('core.config.constants.ORDER_STATE_NAME') }}", sateName, {path: '/'});
            $.cookie("{{ config('core.config.constants.ORDER_DELIVERY_TIME') }}", deliveryTime ? deliveryTime : null, {path: '/'});
            $.cookie("{{ config('core.config.constants.ORDER_DELIVERY_PRICE') }}", deliveryPrice ? deliveryPrice : null, {path: '/'});

            $("#allStates .list-group-item-secondary").removeClass("list-group-item-secondary active");
            $('#state-' + stateId).addClass('list-group-item-secondary active');

            window.location.href = "{{ route('frontend.home') }}";
            {{--window.location.href = "{{ route('frontend.order.address.save_delivery_charge') }}?state_id=" + stateId;--}}
        }
    </script>

@endsection
