@extends('apps::frontend.layouts.master')
@section('title', __('user::frontend.profile.index.title'))
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
                        aria-current="page">{{ __('user::frontend.profile.index.update') }}</li>
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
                        <form method="post" action="{{ url(route('frontend.profile.update')) }}">
                            @csrf
                            <input type="hidden" name="type" value="profile">

                            <div class="previous-address">

                                @include('apps::frontend.layouts._alerts')

                                <h2 class="cart-title">{{ __('user::frontend.profile.index.form.form_title') }}</h2>
                                <div class="row">
                                    <div class="col-md-12 col-12">
                                        <div class="form-group">
                                            <input type="text" value="{{ auth()->user()->name }}" name="name"
                                                   placeholder="{{ __('user::frontend.profile.index.form.name') }}"/>
                                        </div>
                                    </div>

                                </div>
                                <div class="row">

                                    {{--<div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <select class="select-detail" name="الدولة">
                                                <optgroup label="Egypt">
                                                    <option>Alexandria</option>
                                                    <option>Cairo</option>
                                                    <option>Aswan</option>
                                                </optgroup>
                                                <optgroup label="Kwuit">
                                                    <option>State name</option>
                                                    <option>State name</option>
                                                    <option>State name</option>
                                                    <option>State name</option>
                                                </optgroup>
                                                <optgroup label="Jurdan">
                                                    <option>State name</option>
                                                    <option>State name</option>
                                                    <option>State name</option>
                                                    <option>State name</option>
                                                </optgroup>

                                            </select>
                                        </div>
                                    </div>--}}

                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <input type="email" name="email" value="{{ auth()->user()->email }}"
                                                   placeholder="{{ __('user::frontend.profile.index.form.email') }}"/>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <input type="text" name="mobile"
                                                   value="{{ auth()->user()->mobile }}"
                                                   placeholder="{{ __('user::frontend.profile.index.form.mobile') }}"/>
                                            @if(!is_null(auth()->user()->mobile) && is_null(auth()->user()->mobile_verified_at) && is_null(auth()->user()->firebase_id))
                                                <code>{{ __('authentication::frontend.verification_code.mobile_code_is_not_confirmed') }}
                                                    <a
                                                        href="{{ route('frontend.get_verification_code', ['mobile' => auth()->user()->mobile, 'type' => 'profile']) }}">
                                                        {{ __('authentication::frontend.verification_code.click_here_to_confirm') }}
                                                    </a>
                                                </code>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <input type="password" name="password"
                                                   placeholder="{{ __('user::frontend.profile.index.form.password') }}"/>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <input type="password" name="password_confirmation"
                                                   placeholder="{{ __('user::frontend.profile.index.form.password_confirmation') }}"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-20 mt-20 text-left">
                                <button type="submit"
                                        class="btn btn-them">{{ __('user::frontend.profile.index.form.btn.update') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('pageJs')
    <script>
        {{--var mobile = window.intlTelInput(document.querySelector("#mobile"), {--}}
        {{--    initialCountry: '{{ auth()->user()->country_code }}',--}}
        {{--    separateDialCode: true--}}
        {{--});--}}

        {{--function setCode() {--}}
        {{--    $("#country_code").val(mobile.getSelectedCountryData().iso2.toUpperCase());--}}
        {{--}--}}
    </script>
@endsection
