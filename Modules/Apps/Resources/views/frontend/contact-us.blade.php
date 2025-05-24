@extends('apps::frontend.layouts.master')
@section('title', __('apps::frontend.contact_us.title') )
@section('content')

    {{--<div class="second-header contact-header d-flex align-items-center">
        <div class="container">
            <h1>{{ __('apps::frontend.contact_us.header_title') }}</h1>
        </div>
    </div>--}}
    <div class="inner-page">
        <div class="container">
            <div class="row">
                <div class="col-md-6 contact-details">
                    <ul class="contact-details">

                        @if(config('setting.contact_us.mobile'))
                            <li>
                                <i class="ti-mobile"></i> <strong>{{ __('apps::frontend.contact_us.info.mobile')}}
                                    :</strong>
                                <span>{{ config('setting.contact_us.mobile') }} </span>
                            </li>
                        @endif

                        @if(config('setting.contact_us.technical_support'))
                            <li>
                                <i class="ti-headphone-alt"></i>
                                <strong>{{ __('apps::frontend.contact_us.info.technical_support')}}:</strong>
                                <span>{{ config('setting.contact_us.technical_support') }} </span>
                            </li>
                        @endif

                        <li>
                            <i class="ti-world"></i> <strong>{{ __('apps::frontend.contact_us.info.our_site')}}
                                :</strong>
                            <span><a href="{{ route('frontend.home') }}">{{ env('APP_URL') }}</a></span>
                        </li>
                        <li>
                            <i class="ti-email"></i> <strong>{{ __('apps::frontend.contact_us.info.email')}}:</strong>
                            <span><a href="mailto:{{ config('setting.contact_us.email') }}">{{ config('setting.contact_us.email') }}</a></span>
                        </li>
                    </ul>
                    <div class="footer-social mt-30 pt-30">
                        <a href="{{ config('setting.social.facebook') ?? '#' }}" target="_blank" class="social-icon">
                            <i class="ti-facebook"></i>
                        </a>
                        <a href="{{ config('setting.social.instagram') ?? '#' }}" target="_blank" class="social-icon">
                            <i class="ti-instagram"></i>
                        </a>
                        <a href="{{ config('setting.social.linkedin') ?? '#' }}" target="_blank" class="social-icon">
                            <i class="ti-linkedin"></i>
                        </a>
                        <a href="{{ config('setting.social.twitter') ?? '#' }}" target="_blank" class="social-icon">
                            <i class="ti-twitter-alt"></i>
                        </a>
                    </div>
                </div>
                <div class="col-md-6">

                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            <center>
                                {{ session('status') }}
                            </center>
                        </div>
                    @endif

                    <form class="form-contact" action="{{ url(route('frontend.send-contact-us')) }}" method="post">
                        @csrf

                        <div class="form-group">
                            <input type="text" name="username" value="{{ old('username') }}"
                                   placeholder="{{ __('apps::frontend.contact_us.form.username')}}">

                            @error('username')
                            <p class="text-danger m-2" role="alert">
                                <strong>{{ $message }}</strong>
                            </p>
                            @enderror

                        </div>
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <input type="email" value="{{ old('email') }}"
                                           placeholder="{{ __('apps::frontend.contact_us.form.email')}}" name="email">

                                    @error('email')
                                    <p class="text-danger m-2" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </p>
                                    @enderror

                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <input type="text" value="{{ old('mobile') }}"
                                           placeholder="{{ __('apps::frontend.contact_us.form.mobile')}}" name="mobile">

                                    @error('mobile')
                                    <p class="text-danger m-2" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </p>
                                    @enderror

                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <textarea aria-invalid="false" class="textarea-control" name="message"
                                      placeholder="{{ __('apps::frontend.contact_us.form.message')}}">{{ old('message') }}</textarea>

                            @error('message')
                            <p class="text-danger m-2" role="alert">
                                <strong>{{ $message }}</strong>
                            </p>
                            @enderror

                        </div>
                        <div class="form-group">
                            <button class="btn btn-them btn-block"
                                    type="submit">{{ __('apps::frontend.contact_us.form.btn.send')}}</button>
                        </div>
                    </form>
                </div>

            </div>

            <div id="google-map" class="mt-40"></div>
        </div>
    </div>


@endsection

@section('externalJs')

    <script>
        $(document).ready(function () {

        });
    </script>

@endsection