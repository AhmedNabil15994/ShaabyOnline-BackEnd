@extends('apps::dashboard.layouts.app')
@section('title', __('user::dashboard.admins.update.title'))
@section('content')
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <a href="{{ url(route('dashboard.home')) }}">{{ __('apps::dashboard.home.title') }}</a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <a href="{{ url(route('dashboard.admins.index')) }}">
                            {{ __('user::dashboard.admins.index.title') }}
                        </a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <a href="#">{{ __('user::dashboard.admins.update.title') }}</a>
                    </li>
                </ul>
            </div>

            <h1 class="page-title"></h1>

            <div class="row">
                <form id="updateForm" user="form" class="form-horizontal form-row-seperated" method="post"
                    enctype="multipart/form-data" action="{{ route('dashboard.admins.update', $user->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="col-md-12">

                        {{-- RIGHT SIDE --}}
                        <div class="col-md-3">
                            <div class="panel-group accordion scrollable" id="accordion2">
                                <div class="panel panel-default">
                                    {{-- <div class="panel-heading">
                                        <h4 class="panel-title"><a class="accordion-toggle"></a></h4>
                                    </div> --}}
                                    <div id="collapse_2_1" class="panel-collapse in">
                                        <div class="panel-body">
                                            <ul class="nav nav-pills nav-stacked">
                                                <li class="active">
                                                    <a href="#global_setting" data-toggle="tab">
                                                        {{ __('user::dashboard.admins.update.form.general') }}
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- PAGE CONTENT --}}
                        <div class="col-md-9">
                            <div class="tab-content">

                                {{-- UPDATE FORM --}}
                                <div class="tab-pane active fade in" id="global_setting">
                                    {{-- <h3 class="page-title">{{ __('user::dashboard.admins.update.form.general') }}</h3> --}}
                                    <div class="col-md-10">
                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{ __('user::dashboard.admins.update.form.name') }}
                                            </label>
                                            <div class="col-md-9">
                                                <input type="text" name="name" class="form-control" data-name="name"
                                                    value="{{ $user->name }}">
                                                <div class="help-block"></div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{ __('user::dashboard.admins.update.form.email') }}
                                            </label>
                                            <div class="col-md-9">
                                                <input type="email" name="email" class="form-control" data-name="email"
                                                    value="{{ $user->email }}">
                                                <div class="help-block"></div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{ __('user::dashboard.admins.update.form.mobile') }}
                                            </label>
                                            <div class="col-md-9">
                                                <input type="text" name="mobile" class="form-control" data-name="mobile"
                                                    value="{{ $user->mobile }}">
                                                <div class="help-block"></div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{ __('user::dashboard.admins.update.form.password') }}
                                            </label>
                                            <div class="col-md-9">
                                                <input type="password" name="password" class="form-control"
                                                    data-name="password">
                                                <div class="help-block"></div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{ __('user::dashboard.admins.update.form.confirm_password') }}
                                            </label>
                                            <div class="col-md-9">
                                                <input type="password" name="confirm_password" class="form-control"
                                                    data-name="confirm_password">
                                                <div class="help-block"></div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{ __('user::dashboard.admins.update.form.image') }}
                                            </label>
                                            <div class="col-md-9">
                                                @include('core::dashboard.shared.file_upload', [
                                                    'image' => $user->image,
                                                ])
                                                <div class="help-block"></div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{ __('user::dashboard.users.is_verified') }}
                                            </label>
                                            <div class="col-md-9">
                                                <input type="checkbox" class="make-switch" id="is_verified"
                                                    data-size="small" name="is_verified"
                                                    {{ $user->is_verified == 1 ? 'checked' : '' }}>
                                                <div class="help-block"></div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{ __('user::dashboard.admins.update.form.roles') }}
                                            </label>
                                            <div class="col-md-9">
                                                <div class="mt-checkbox-list">

                                                    @foreach ($roles as $role)
                                                        <label class="mt-checkbox">
                                                            <input type="checkbox" name="roles[]"
                                                                value="{{ $role->id }}"
                                                                {{ $user->roles->contains($role->id) ? 'checked=""' : '' }}>
                                                            {{ $role->display_name }}
                                                            <span></span>
                                                        </label>
                                                    @endforeach

                                                    @if (auth()->user()->tocaan_perm)
                                                        <label class="mt-checkbox">
                                                            <input type="checkbox" name="tocaan_perm"
                                                                {{ $user->tocaan_perm ? 'checked' : '' }} value="1">
                                                            Tocaan Role
                                                            <span></span>
                                                        </label>
                                                    @endif

                                                </div>
                                            </div>
                                        </div>

                                        @if ($user->trashed())
                                            <div class="form-group">
                                                <label class="col-md-2">
                                                    {{ __('apps::dashboard.general.restore') }}
                                                </label>
                                                <div class="col-md-9">
                                                    <input type="checkbox" class="make-switch" id="test"
                                                        data-size="small" name="restore">
                                                    <div class="help-block"></div>
                                                </div>
                                            </div>
                                        @endif

                                    </div>
                                </div>
                                {{-- END UPDATE FORM --}}

                            </div>
                        </div>

                        {{-- PAGE ACTION --}}
                        <div class="col-md-12">
                            <div class="form-actions">
                                @include('apps::dashboard.layouts._ajax-msg')
                                <div class="form-group">
                                    <button type="submit" id="submit" class="btn btn-lg green">
                                        {{ __('apps::dashboard.general.edit_btn') }}
                                    </button>
                                    <a href="{{ url(route('dashboard.admins.index')) }}" class="btn btn-lg red">
                                        {{ __('apps::dashboard.general.back_btn') }}
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
@stop
