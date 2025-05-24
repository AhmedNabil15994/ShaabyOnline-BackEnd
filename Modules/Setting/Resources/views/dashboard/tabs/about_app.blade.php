<div class="tab-pane fade" id="about_app">
    <div class="col-md-10">

        <div class="form-group">
            <label class="col-md-2">
                {{ __('setting::dashboard.settings.form.landing_background') }}
            </label>
            <div class="col-md-9">
                @include('core::dashboard.shared.file_upload', [
                    'name' => 'images[landing_background]',
                    'imgUploadPreviewID' => 'settingLandingBackground',
                    'image' => config('setting.images.landing_background') ?? null,
                ])
            </div>
        </div>

        <hr>

        <div class="form-group">
            <label class="col-md-2">
                {{ __('setting::dashboard.settings.form.app_gallery') }}
            </label>
            <div class="col-md-10">
                <button type="button" onclick="addMoreImages()" class="btn btn-success btnAddMore">
                    {{ __('catalog::dashboard.products.form.btn_add_more') }} <i class="fa fa-plus-circle"></i>
                </button>

                <div id="product-images">

                    @if (count(config('setting.app_gallery') ?? []) > 0)
                        @foreach (config('setting.app_gallery') as $k => $img)
                            <div id="prd-image-{{ $k }}" class="prd-image-section">
                                <input type="hidden" name="hidden_app_gallery[{{ $k }}]"
                                    value="{{ $img }}" />

                                <div class="input-group">
                                    <span class="input-group-btn">
                                        <span class="btn btn-default btn-file-upload">
                                            {{ __('catalog::dashboard.products.form.browse_image') }}
                                            <input type="file" name="app_gallery[{{ $k }}]"
                                                onchange="readURL(this, {{ $k }});">
                                        </span>
                                    </span>
                                    <input type="text" id="uploadInputName-{{ $k }}"
                                        class="form-control upload-input-name" readonly>
                                    <button type="button" class="btn btn-danger btnRemoveMore"
                                        onclick="removeMoreImage('{{ $k }}', '{{ $k }}', 'row')">
                                        X
                                    </button>
                                </div>

                                <img id='img-upload-preview-{{ $k }}' class="img-preview img-thumbnail"
                                    src="{{ url('uploads/app_gallery/' . $img) }}" alt="image preview" />
                            </div>
                        @endforeach
                    @else
                        <div id="prd-image-0" class="prd-image-section">
                            <div class="input-group">
                                <span class="input-group-btn">
                                    <span class="btn btn-default btn-file-upload">
                                        {{ __('catalog::dashboard.products.form.browse_image') }}
                                        <input type="file" name="app_gallery[]" onchange="readURL(this, 0);">
                                    </span>
                                </span>
                                <input type="text" id="uploadInputName-0" class="form-control upload-input-name"
                                    readonly>
                                <button type="button" class="btn btn-danger btnRemoveMore"
                                    onclick="removeMoreImage(0, 0, 'row')">X
                                </button>
                            </div>

                            <img id='img-upload-preview-0' class="img-preview img-thumbnail" alt="image preview"
                                style="display: none;" />
                        </div>
                    @endif

                </div>

            </div>
        </div>

    </div>
</div>
