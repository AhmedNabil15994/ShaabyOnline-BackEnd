<html>
@section('title', __('authentication::frontend.password.title'))
<link rel="stylesheet" href="{{ url('admin/assets/pages/css/login.min.css') }}">
@include('apps::dashboard.layouts._head_ltr')

<body class="login">
    <div class="content">

        @if (session('status'))
            <div class="alert alert-success" role="alert">
                <center>
                    {{ session('status') }}
                </center>
            </div>
        @endif

        <form class="login-form" action="{{ route('dashboard.password.email') }}" method="POST">
            {{ csrf_field() }}

            <h3 class="form-title font-green">{{ __('authentication::frontend.password.title') }}</h3>
            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <label class="control-label">
                    {{ __('authentication::dashboard.login.form.email') }}
                </label>
                <input class="form-control form-control-solid placeholder-no-fix" type="text"
                    value="{{ old('email') }}" name="email" />
                @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group mt-30">
                <button class="btn btn-them btn-block"
                    type="submit">{{ __('authentication::frontend.password.form.btn.password') }}</button>
            </div>
        </form>
    </div>
    @include('apps::dashboard.layouts._footer')
    @include('apps::dashboard.layouts._jquery')
</body>

</html>
