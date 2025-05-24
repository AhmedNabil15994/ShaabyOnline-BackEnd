<div class="tab-pane fade" id="logo">

    {{-- <h3 class="page-title">{{ __('setting::dashboard.settings.form.tabs.logo') }}</h3> --}}

    <div class="col-md-10">

        {{-- <div class="form-group">
            <label class="col-md-2">
                {{ __('setting::dashboard.settings.form.logo') }}
            </label>
            <div class="col-md-9">
                <div class="input-group">
                    <span class="input-group-btn">
                        <a data-input="logo" data-preview="holder" class="btn btn-primary lfm">
                            <i class="fa fa-picture-o"></i>
                            {{__('apps::dashboard.general.upload_btn')}}
                        </a>
                    </span>
                    <input name="images[logo]" class="form-control logo" type="text" readonly
                           value="{{ config('setting.images.logo') ? url(config('setting.images.logo')) : ''}}">
                </div>
                <span class="holder" style="margin-top:15px;max-height:100px;">
                    <img src="{{ config('setting.images.logo') ? url(config('setting.images.logo')) : ''}}" style="height: 15rem;">
                </span>
            </div>
        </div> --}}

        <div class="form-group">
            <label class="col-md-2">
                {{ __('setting::dashboard.settings.form.logo') }}
            </label>
            <div class="col-md-9">
                @include('core::dashboard.shared.file_upload', [
                    'name' => 'images[logo]',
                    'imgUploadPreviewID' => 'settingLogo',
                    'image' => config('setting.images.logo') ?? null,
                ])
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-2">
                {{ __('setting::dashboard.settings.form.white_logo') }}
            </label>
            <div class="col-md-9">
                @include('core::dashboard.shared.file_upload', [
                    'name' => 'images[white_logo]',
                    'imgUploadPreviewID' => 'settingWhiteLogo',
                    'image' => config('setting.images.white_logo') ?? null,
                ])
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-2">
                {{ __('setting::dashboard.settings.form.favicon') }}
            </label>
            <div class="col-md-9">
                @include('core::dashboard.shared.file_upload', [
                    'name' => 'images[favicon]',
                    'imgUploadPreviewID' => 'settingFavicon',
                    'image' => config('setting.images.favicon') ?? null,
                ])
            </div>
        </div>

    </div>
</div>
