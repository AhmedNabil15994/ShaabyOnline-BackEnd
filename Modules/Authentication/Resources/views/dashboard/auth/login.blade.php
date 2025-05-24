<html>
@section('title', __('authentication::dashboard.login.routes.index'))
<link rel="stylesheet" href="{{ url('admin/assets/pages/css/login.min.css') }}">
@include('apps::dashboard.layouts._head_ltr')

<body class="login">

    <div class="content">
        @if (session('status'))
            <div class="alert alert-{{ session('alert') }}" role="alert">
                <center>
                    {{ session('status') }}
                </center>
            </div>
        @endif
        <form class="login-form" action="{{ route('dashboard.login_post') }}" method="POST">
            {{ csrf_field() }}

            <h3 class="form-title font-green">{{ __('authentication::dashboard.login.routes.index') }}</h3>
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
            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                <label class="control-label">
                    {{ __('authentication::dashboard.login.form.password') }}
                </label>
                <input class="form-control form-control-solid placeholder-no-fix" type="password" name="password" />
                @if ($errors->has('password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>
            <a class="link-muted" href="{{ route('dashboard.password.request') }}">
                {{ __('authentication::dashboard.login.form.forget_password') }}
            </a>

            <div class="form-actions">
                <button type="submit" class="btn green uppercase">
                    {{ __('authentication::dashboard.login.form.btn.login') }}
                </button>
            </div>
        </form>
    </div>
    @include('apps::dashboard.layouts._footer')
    @include('apps::dashboard.layouts._jquery')
</body>

</html>
