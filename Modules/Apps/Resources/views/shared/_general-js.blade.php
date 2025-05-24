<script>

    function readURL(input, id, type = 'multi') {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            var label = input.files[0].name;
            reader.onload = function (e) {
                var imgUpload = type === 'multi' ? $('#img-upload-preview-' + id) : $('#' + id);
                imgUpload.show();
                imgUpload.attr('src', e.target.result);
                if (type === 'multi')
                    $('#uploadInputName-' + id).val(label);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

</script>
