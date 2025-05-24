<div class="tab-pane fade" id="mail">
    {{--  <h3 class="page-title">{{ __('setting::dashboard.settings.form.tabs.mail') }}</h3>  --}}
    <div class="col-md-10">
        <div class="form-group">
            <label class="col-md-2">
                {{ __('setting::dashboard.settings.form.mail_driver') }}
            </label>
            <div class="col-md-9">
                <input type="text" class="form-control" name="env[MAIL_DRIVER]" value="{{env('MAIL_DRIVER')}}"
                       autocomplete="off"/>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2">
                {{ __('setting::dashboard.settings.form.mail_encryption') }}
            </label>
            <div class="col-md-9">
                <input type="text" class="form-control" name="env[MAIL_ENCRYPTION]" value="{{env('MAIL_ENCRYPTION')}}"
                       autocomplete="off"/>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2">
                {{ __('setting::dashboard.settings.form.mail_host') }}
            </label>
            <div class="col-md-9">
                <input type="text" class="form-control" name="env[MAIL_HOST]" value="{{env('MAIL_HOST')}}"
                       autocomplete="off"/>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2">
                {{ __('setting::dashboard.settings.form.mail_port') }}
            </label>
            <div class="col-md-9">
                <input type="text" class="form-control" name="env[MAIL_PORT]" value="{{env('MAIL_PORT')}}"
                       autocomplete="off"/>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2">
                {{ __('setting::dashboard.settings.form.mail_from') }}
            </label>
            <div class="col-md-9">
                <input type="email" class="form-control" name="env[MAIL_FROM_ADDRESS]"
                       value="{{env('MAIL_FROM_ADDRESS')}}" autocomplete="off"/>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-2">
                {{ __('setting::dashboard.settings.form.mail_name_from') }}
            </label>
            <div class="col-md-9">
                <input type="text" class="form-control" name="env[MAIL_FROM_NAME]" value="{{env('MAIL_FROM_NAME')}}"
                       autocomplete="off"/>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-2">
                {{ __('setting::dashboard.settings.form.mail_username') }}
            </label>
            <div class="col-md-9">
                <input type="text" class="form-control" name="env[MAIL_USERNAME]" value="{{env('MAIL_USERNAME')}}"
                       autocomplete="off"/>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2">
                {{ __('setting::dashboard.settings.form.mail_password') }}
            </label>
            <div class="col-md-9">
                <input type="text" class="form-control" name="env[MAIL_PASSWORD]" value="{{env('MAIL_PASSWORD')}}"
                       autocomplete="off"/>
            </div>
        </div>
    </div>
</div>
