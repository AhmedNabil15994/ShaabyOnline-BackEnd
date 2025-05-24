@extends('apps::frontend.layouts.master')
@section('title', __('authentication::frontend.password.title') )
@section('content')

    <div class="second-header d-flex align-items-center">
        <div class="container">
            <h1>{{ __('authentication::frontend.password.title') }}</h1>
        </div>
    </div>
    <div class="inner-page">
        <div class="container">
            <div class="row" style="justify-content: center !important;">
                <div class="col-md-6">
                    <div class="login-form">
                        {{--<h5 class="title-login"></h5>
                        <p class="p-title-login"></p>--}}

                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                <center>
                                    {{ session('status') }}
                                </center>
                            </div>
                        @endif
                        
                        <form class="login mt-30" method="POST"
                              action="{{ route('frontend.password.email') }}">
                            @csrf

                            <div class="form-group">
                                <input type="email"
                                       name="email"
                                       id="email"
                                       value="{{ old('email') }}"
                                       autocomplete="off"
                                       placeholder="{{ __('authentication::frontend.password.form.email')}}">

                                @error('email')
                                <p class="text-danger m-2" role="alert">
                                    <strong>{{ $message }}</strong>
                                </p>
                                @enderror

                            </div>

                            <div class="form-group mt-30">
                                <button class="btn btn-them btn-block"
                                        type="submit">{{  __('authentication::frontend.password.form.btn.password') }}</button>
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