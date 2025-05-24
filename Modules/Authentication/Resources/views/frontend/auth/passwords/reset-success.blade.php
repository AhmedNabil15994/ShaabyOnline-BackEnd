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

                                @if ($status)
                                    <div class="alert alert-success" role="alert">
                                        <center>
                                            {{ $status }}
                                        </center>
                                    </div>
                                @endif
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
