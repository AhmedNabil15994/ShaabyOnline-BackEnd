@extends('apps::frontend.layouts.master')
@section('title', __('authentication::frontend.verification_code.title') )
@section('content')

    <div class="second-header d-flex align-items-center">
        <div class="container">
            <h1>{{ __('authentication::frontend.verification_code.title') }}</h1>
        </div>
    </div>
    <div class="inner-page">
        <div class="container">

            <div class="row justify-content-center">
                <div class="col-md-5">
                    <div class="login-form">
                        <h5 class="title-login">{{ __('authentication::frontend.verification_code.title') }}</h5>
                        <p class="p-title-login">{{ __('authentication::frontend.verification_code.enter_your_verification_code') }}</p>
                        <form class="login mt-30" method="POST" action="{{ route('frontend.check_verification_code') }}"
                              enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="mobile" value="{{ request()->get('mobile') ?? '' }}">
                            <input type="hidden" name="type" value="{{ request()->get('type') ?? '' }}">
                            <div class="form-group">
                                <input type="text"
                                       name="verification_code"
                                       id="verification_code"
                                       value="{{ old('verification_code') }}"
                                       autocomplete="off"
                                       placeholder="{{ __('authentication::frontend.verification_code.form.code')}}">

                                @error('verification_code')
                                <p class="text-danger m-2" role="alert">
                                    <strong>{{ $message }}</strong>
                                </p>
                                @enderror

                                @error('mobile')
                                <p class="text-danger m-2" role="alert">
                                    <strong>{{ $message }}</strong>
                                </p>
                                @enderror
                            </div>

                            <div class="form-group mt-30">
                                <button class="btn btn-them btn-block" name="btnSubmit"
                                        type="submit">{{  __('authentication::frontend.verification_code.form.btn.send') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection

@section('externalJs')

    <script></script>

@endsection
