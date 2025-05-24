<html>
@section('title', __('authentication::frontend.reset.title'))
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

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form class="login-form" action="{{ route('dashboard.password.update') }}" method="POST">
            {{ csrf_field() }}
            <input type="hidden" name="token" value="{{ $token ?? '' }}">

            <h3 class="form-title font-green">{{ __('authentication::frontend.reset.title') }}</h3>

            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <label class="control-label">
                    {{ __('authentication::dashboard.login.form.email') }}
                </label>
                <input class="form-control form-control-solid placeholder-no-fix" type="text"
                    value="{{ old('email') ?? request()->get('email') }}" name="email" />
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

            <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                <label class="control-label">
                    {{ __('authentication::dashboard.login.form.password_confirmation') }}
                </label>
                <input class="form-control form-control-solid placeholder-no-fix" type="password"
                    name="password_confirmation" />
                @if ($errors->has('password_confirmation'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password_confirmation') }}</strong>
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
