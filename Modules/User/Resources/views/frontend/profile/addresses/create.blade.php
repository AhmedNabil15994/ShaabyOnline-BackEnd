@extends('apps::frontend.layouts.master')
@section('title', __('user::frontend.addresses.create.title'))
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
                        aria-current="page"> {{ __('user::frontend.addresses.create.title') }}</li>
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
                        <form action="{{ url(route('frontend.profile.address.store')) }}"
                              method="post">
                            @csrf

                            <div class="previous-address">

                                @include('apps::frontend.layouts._alerts')

                                <h2 class="cart-title">{{ __('user::frontend.addresses.create.title') }}</h2>

                                @include('area::frontend.shared._area_tree')

                                <div class="row">
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <input type="text" name="username" value="{{ old('username') }}"
                                                   autocomplete="off"
                                                   placeholder="{{__('user::frontend.addresses.form.username')}}"/>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <input type="text" name="mobile" value="{{ old('mobile') }}"
                                                   autocomplete="off"
                                                   placeholder="{{__('user::frontend.addresses.form.mobile')}}"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <input type="text" name="block" value="{{ old('block') }}"
                                                   autocomplete="off"
                                                   placeholder="{{__('user::frontend.addresses.form.block')}}"/>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <input type="text" name="building" value="{{ old('building') }}"
                                                   autocomplete="off"
                                                   placeholder="{{__('user::frontend.addresses.form.building')}}"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <input type="text" name="avenue" value="{{ old('avenue') }}"
                                                   autocomplete="off"
                                                   placeholder="{{__('user::frontend.addresses.form.avenue')}}"/>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <input type="text" name="floor" value="{{ old('floor') }}"
                                                   autocomplete="off"
                                                   placeholder="{{__('user::frontend.addresses.form.floor')}}"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <input type="text" name="flat" value="{{ old('flat') }}"
                                                   autocomplete="off"
                                                   placeholder="{{__('user::frontend.addresses.form.flat')}}"/>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <input type="text" name="automated_number"
                                                   value="{{ old('automated_number') }}"
                                                   autocomplete="off"
                                                   placeholder="{{__('user::frontend.addresses.form.automated_number')}}"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <input type="text" name="street" value="{{ old('street') }}" autocomplete="off"
                                           placeholder="{{__('user::frontend.addresses.form.street')}}"/>
                                </div>

                                <div class="form-group">
                                    <textarea name="address" rows="4" class="form-control" autocomplete="off"
                                              placeholder="{{__('user::frontend.addresses.form.address_details')}}">{{ old('address') }}</textarea>
                                </div>

                            </div>
                            <div class="pt-40 mb-20 mt-20 text-left">
                                <button type="submit"
                                        class="btn btn-them"> {{ __('user::frontend.profile.index.btn_add_new_address') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


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
