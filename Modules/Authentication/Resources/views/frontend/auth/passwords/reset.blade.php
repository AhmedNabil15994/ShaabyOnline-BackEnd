@extends('apps::frontend.layouts.master')
@section('title', __('authentication::frontend.reset.title'))
@section('content')

    <div class="second-header d-flex align-items-center">
        <div class="container">
            <h1>{{ __('authentication::frontend.reset.title') }}</h1>
        </div>
    </div>
    <div class="inner-page">
        <div class="container">
            <div class="row" style="justify-content: center !important;">
                <div class="col-md-6">
                    <div class="login-form">
                        {{-- <h5 class="title-login"></h5>
                        <p class="p-title-login"></p> --}}

                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                <center>
                                    {{ session('status') }}
                                </center>
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form class="login mt-30" method="POST" action="{{ route('frontend.password.update') }}">
                            @csrf
                            <input type="hidden" name="token" value="{{ $token ?? '' }}">

                            <div class="form-group">
                                <input type="email" name="email" autocomplete="off" value="{{ old('email') }}"
                                    placeholder="{{ __('authentication::frontend.register.form.email') }}">

                                @error('email')
                                    <p class="text-danger m-2" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </p>
                                @enderror

                            </div>

                            <div class="form-group">
                                <input type="password" name="password"
                                    placeholder="{{ __('authentication::frontend.register.form.password') }}">

                                @error('password')
                                    <p class="text-danger m-2" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </p>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input type="password" name="password_confirmation"
                                    placeholder="{{ __('authentication::frontend.register.form.password_confirmation') }}">

                                @error('token')
                                    <p class="text-danger m-2" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </p>
                                @enderror

                            </div>

                            <div class="form-group mt-30">
                                <button class="btn btn-them btn-block"
                                    type="submit">{{ __('authentication::frontend.reset.form.btn.reset') }}</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

@stop
