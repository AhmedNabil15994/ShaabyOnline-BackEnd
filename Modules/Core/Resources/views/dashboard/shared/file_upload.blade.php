<input type="file" class="form-control" name="{{ $name ?? 'image' }}"
       onchange="readURL(this, '{{ $imgUploadPreviewID ?? 'imgUploadPreview' }}', 'single');">
<img id='{{ $imgUploadPreviewID ?? 'imgUploadPreview' }}'
     @if(is_null($image))
     style="display: none; height: 100px;"
     @else
     style="height: 100px; {{ isset($backgroundPreview) ? 'background-color: '.$backgroundPreview : '' }}"
     @endif
     src="{{ !is_null($image) ? url($image) : '' }}"
     class="img-preview img-thumbnail"
     alt="image preview"/>
