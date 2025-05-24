@extends('apps::frontend.layouts.master')
@section('title', __('user::frontend.addresses.index.title'))
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
                        aria-current="page"> {{ __('user::frontend.profile.index.addresses') }}</li>
                </ol>
            </nav>
        </div>
        <div class="inner-page">
            <div class="row">
                <div class="col-md-3">
                    @include('user::frontend.profile._user-side-menu')
                </div>
                <div class="col-md-9">
                    <div class="cart-inner">
                        <div class="previous-address">

                            @include('apps::frontend.layouts._alerts')

                            <h2 class="cart-title">{{ __('user::frontend.profile.index.addresses') }}</h2>

                            @if(count($addresses) > 0)
                                @foreach($addresses as $k => $address)
                                    <div class="cart-item media align-items-center">
                                        <div class="product-summ-det">
                                            <p class="d-flex">
                                                <span
                                                    class="d-inline-block right-side">{{__('user::frontend.addresses.form.state_name')}}</span>
                                                <span
                                                    class="d-inline-block left-side">{{ $address->state->title }}</span>
                                            </p>
                                            <p class="d-flex">
                                                <span
                                                    class="d-inline-block right-side">{{__('user::frontend.addresses.form.address_details')}}</span>
                                                <span
                                                    class="d-inline-block left-side">{{ $address->address ?? '---' }}</span>
                                            </p>
                                            <p class="d-flex">
                                                <span
                                                    class="d-inline-block right-side">{{__('user::frontend.addresses.form.mobile')}}</span>
                                                <span class="d-inline-block left-side">{{ $address->mobile }}</span>
                                            </p>
                                        </div>
                                        <div class="text-left address-operations">
                                            <a class="btn edit-address" data-toggle="modal"
                                               data-target="#addressEditModal-{{$address->id}}"><i
                                                    class="ti-pencil-alt"></i> {{ __('user::frontend.addresses.index.btn.edit') }}
                                            </a>
                                            <a href="{{ url(route('frontend.profile.address.delete', $address->id)) }}"
                                               class="btn delete-address">
                                                <i class="ti-trash"></i> {{ __('user::frontend.addresses.index.btn.delete') }}
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <b>{{ __('user::frontend.addresses.index.alert.no_addresses') }}</b>
                            @endif

                        </div>
                        <div class="cart-footer pt-40 mb-20 mt-20 text-left">
                            <a href="{{ route('frontend.profile.address.create') }}" class="btn btn-them">
                                {{ __('user::frontend.addresses.create.title') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(count($addresses) > 0)
        @foreach($addresses as $k => $address)
            <div class="modal fade" id="addressEditModal-{{$address->id}}" tabindex="-1" role="dialog"
                 aria-labelledby=""
                 aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title"
                                id="exampleModalLongTitle">{{ __('user::frontend.addresses.edit.title') }}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form class="mt-20"
                                  action="{{ url(route('frontend.profile.address.update', $address)) }}"
                                  method="post">
                                @csrf

                                <div class="form-group">
                                    <label>{{__('user::frontend.addresses.form.country')}}</label>
                                    <input type="text" name="country_id"
                                           value="{{ $address->state->city->country->title }}"
                                           disabled>
                                </div>
                                <div class="form-group">
                                    <label>{{__('user::frontend.addresses.form.city')}}</label>
                                    <input type="text" name="city_id"
                                           value="{{ $address->state->city->title }}" disabled>
                                </div>
                                <div class="form-group">
                                    <label>{{__('user::frontend.addresses.form.state_name')}}</label>
                                    <input type="text" name="state_id"
                                           value="{{ $address->state->title }}" disabled>
                                    <input type="hidden" name="state" value="{{ $address->state_id }}">
                                </div>

                                {{--<div class="form-group">
                                    <select class="select-detail stateSelectBox" name="state">
                                        <option>{{ __('user::frontend.addresses.form.states') }}</option>
                                        @if(isset($states) && count($states) > 0)
                                            @foreach ($states as $state)

                                                <option
                                                    value="{{$state->id}}" {{ $state->id == $address->state_id ? 'selected' : '' }}>
                                                    {{ $state->title }}
                                                </option>

                                            @endforeach
                                        @endif
                                    </select>
                                    <input type="hidden" class="stateName" name="order_state_name"
                                           value="{{ get_cookie_value(config('core.config.constants.ORDER_STATE_NAME')) ? get_cookie_value(config('core.config.constants.ORDER_STATE_NAME')) : ''}}">
                                </div>--}}

                                <div class="row">
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <input type="text" name="username" value="{{ $address->username }}"
                                                   autocomplete="off"
                                                   placeholder="{{__('user::frontend.addresses.form.username')}}"/>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <input type="text" name="mobile" value="{{ $address->mobile }}"
                                                   autocomplete="off"
                                                   placeholder="{{__('user::frontend.addresses.form.mobile')}}"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <input type="text" name="block" value="{{ $address->block }}"
                                                   autocomplete="off"
                                                   placeholder="{{__('user::frontend.addresses.form.block')}}"/>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <input type="text" name="building" value="{{ $address->building }}"
                                                   autocomplete="off"
                                                   placeholder="{{__('user::frontend.addresses.form.building')}}"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <input type="text" name="avenue" value="{{ $address->avenue }}"
                                                   autocomplete="off"
                                                   placeholder="{{__('user::frontend.addresses.form.avenue')}}"/>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <input type="text" name="floor" value="{{ $address->floor }}"
                                                   autocomplete="off"
                                                   placeholder="{{__('user::frontend.addresses.form.floor')}}"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <input type="text" name="flat" value="{{ $address->flat }}"
                                                   autocomplete="off"
                                                   placeholder="{{__('user::frontend.addresses.form.flat')}}"/>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <input type="text" name="automated_number" value="{{ $address->automated_number }}"
                                                   autocomplete="off"
                                                   placeholder="{{__('user::frontend.addresses.form.automated_number')}}"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <input type="text" name="street" value="{{ $address->street }}" autocomplete="off"
                                           placeholder="{{__('user::frontend.addresses.form.street')}}"/>
                                </div>

                                <div class="form-group">
                                    <textarea name="address" rows="4" class="form-control" autocomplete="off"
                                              placeholder="{{__('user::frontend.addresses.form.address_details')}}">{{ $address->address }}</textarea>
                                </div>

                                <div class="mb-20 mt-20 text-left">
                                    <button type="submit"
                                            class="btn btn-them">{{ __('user::frontend.addresses.btn.edit') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif

@endsection

@section('externalJs')

    <script>
        $(document).ready(function () {

            /*$('.stateSelectBox').on("change", function () {
                var stateName = $("option:selected", this).text();
                $('.stateName').val(stateName);
            });*/

        });

    </script>

@endsection
