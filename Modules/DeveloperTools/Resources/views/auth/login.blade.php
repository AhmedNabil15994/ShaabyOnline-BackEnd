<html>
    @section('title',__('developertools::developer.login.routes.index'))
    <link rel="stylesheet" href="{{ url('admin/assets/pages/css/login.min.css') }}">
    @include('apps::dashboard.layouts._head_ltr')
    <body class="login">
        <div class="content">
            <form class="login-form" action="{{ route('developer.login') }}" method="POST">
                {{ csrf_field() }}

                <h3 class="form-title font-green">{{ __('developertools::developer.login.routes.index') }}</h3>
                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <label class="control-label">
                      {{ __('developertools::developer.login.form.email') }}
                    </label>
                    <input class="form-control form-control-solid placeholder-no-fix" type="text" value="{{ old('email') }}" name="email"/>
                    @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group{{$errors->has('password') ? ' has-error' : ''}}">
                    <label class="control-label">
                      {{ __('developertools::developer.login.form.password') }}
                    </label>
                    <input class="form-control form-control-solid placeholder-no-fix" type="password" name="password"/>
                    @if ($errors->has('password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn green uppercase">
                      {{ __('developertools::developer.login.form.btn.login') }}
                    </button>
                </div>
            </form>
        </div>
        @include('apps::dashboard.layouts._footer')
        @include('apps::dashboard.layouts._jquery')
    </body>
</html>
