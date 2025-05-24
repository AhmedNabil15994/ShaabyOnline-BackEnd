<div class="tab-pane fade" id="custom_codes">
    <div class="form-body">
{{--        <h3 class="page-title">{{ __('setting::dashboard.settings.form.tabs.custom_codes') }}</h3>--}}
        <div class="col-md-10">

            <div class="form-group">
                <label class="col-md-2">
                    {{ __('setting::dashboard.settings.form.custom_codes.css_in_head') }}
                </label>
                <div class="col-md-9">
                    <textarea class="form-control" name="custom_codes[css_in_head]"
                        rows="10">{{ config('setting.custom_codes.css_in_head') }}</textarea>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-2">
                    {{ __('setting::dashboard.settings.form.custom_codes.js_before_head') }}
                </label>
                <div class="col-md-9">
                    <textarea class="form-control" name="custom_codes[js_before_head]"
                        rows="10">{{ config('setting.custom_codes.js_before_head') }}</textarea>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-2">
                    {{ __('setting::dashboard.settings.form.custom_codes.js_before_body') }}
                </label>
                <div class="col-md-9">
                    <textarea class="form-control" name="custom_codes[js_before_body]"
                        rows="10">{{ config('setting.custom_codes.js_before_body') }}</textarea>
                </div>
            </div>

        </div>
    </div>
</div>
