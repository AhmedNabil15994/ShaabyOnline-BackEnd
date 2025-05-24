@section('title', __('authentication::frontend.reset.title'))
<!DOCTYPE html>
<html dir="{{ locale() == 'ar' ? 'rtl' : 'ltr' }}" lang="{{ locale() == 'ar' ? 'ar' : 'en' }}">

@include('apps::frontend.layouts._header')

<body>
    <div class="main-content">

        <div class="site-main">
            {{-- <div class="second-header d-flex align-items-center">
                    <div class="container">
                        <h1>{{ __('authentication::frontend.reset.title') }}</h1>
                    </div>
                </div> --}}

            <div class="inner-page">
                <div class="container">
                    <div class="row" style="justify-content: center !important;">
                        <div class="col-md-6">
                            <div class="login-form">
                                <h5 class="title-login">{{ __('authentication::frontend.reset.title') }}</h5>

                                @if (session('status'))
                                    <div class="alert alert-success" role="alert">
                                        <center>
                                            {{ session('status') }}
                                        </center>
                                    </div>
                                @endif

                                <form class="login" method="POST" action="{{ route('frontend.password.update') }}">
                                    @csrf
                                    <input type="hidden" name="token" value="{{ $token ?? '' }}">

                                    <p class="form-row form-row-wide">
                                        <input type="email" name="email" autocomplete="off"
                                            value="{{ old('email') }}"
                                            placeholder="{{ __('authentication::frontend.register.form.email') }}"
                                            class="input-text">
                                        @error('email')
                                        <p class="text-danger m-2" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </p>
                                    @enderror
                                    </p>

                                    <p class="form-row form-row-wide">
                                        <input type="password" name="password"
                                            placeholder="{{ __('authentication::frontend.register.form.password') }}"
                                            class="input-text">
                                        @error('password')
                                        <p class="text-danger m-2" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </p>
                                    @enderror
                                    </p>

                                    <p class="form-row form-row-wide">
                                        <input type="password" name="password_confirmation"
                                            placeholder="{{ __('authentication::frontend.register.form.password_confirmation') }}"
                                            class="input-text">
                                        @error('token')
                                        <p class="text-danger m-2" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </p>
                                    @enderror
                                    </p>

                                    <p class="form-row">
                                        <input type="submit"
                                            value="{{ __('authentication::frontend.reset.form.btn.reset') }}"
                                            name="save" class="button-submit btn-block">
                                    </p>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

    @include('apps::frontend.layouts.scripts')

</body>

</html>
