<script>

    function submitForm(btn) {

        tinyMCE.triggerSave();

        var
            btn = $(btn),
            form = $('#import_form'),
            method = form.attr('method'),
            url = btn.attr('submit_type') === 'get_rows' ? '{{route('dashboard.excel.header.row')}}' : '{{$route}}'
        ;

        $.ajax({

            xhr: function () {
                var xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener("progress", function (evt) {
                    if (evt.lengthComputable) {
                        var percentComplete = evt.loaded / evt.total;
                        percentComplete = parseInt(percentComplete * 100);
                        $('.progress-bar').width(percentComplete + '%');
                        $('#progress-status').html(percentComplete + '%');
                    }
                }, false);
                return xhr;
            },

            url: url,
            type: method,
            dataType: 'JSON',
            data: new FormData(form[0]),
            contentType: false,
            cache: false,
            processData: false,

            beforeSend: function () {
                if( btn.attr('submit_type') === 'get_rows'){

                    $('#selectors_container').text('');
                }
                btn.prop('disabled', true);
                $('.progress-info').show();
                $('.progress-bar').width('0%');
                resetErrors();
                formSubmiting();
            },
            success: function (data) {

                btn.prop('disabled', false);
                btn.text();

                if (data[0] == true) {
                    successSubmit(data);
                    if (data['ignore_success']) {
                        $('#selectors_container').text('').append(data['selectors']);
                        $('.select2').select2();
                        $(".file_upload_preview").fileinput({
                            showUpload: false,
                            showRemove: false,
                            showCaption: false
                        });
                    }
                } else {
                    displayMissing(data);
                }

            },
            error: function (data) {

                btn.prop('disabled', false);
                displayErrors(data);

            },
        });
    }
</script>