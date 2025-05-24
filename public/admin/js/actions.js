// ADD FORM
$('#form').on('submit', function (e) {

    e.preventDefault();

    tinyMCE.triggerSave();

    var url = $(this).attr('action');
    var method = $(this).attr('method');
    var dataName = $(this).data('name') ? $(this).data('name') : null;

    if (window.editors == undefined) {
        $.each(editors, function (index, editor) {
            editor.updateSourceElement()
        });
    }

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
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData: false,

        beforeSend: function () {
            $('#submit').prop('disabled', true);
            $('.progress-info').show();
            $('.progress-bar').width('0%');
            formSubmiting();
            resetErrors();
        },
        success: function (data) {

            $('#submit').prop('disabled', false);
            $('#submit').text();

            if (data[0] == true) {
                successSubmit(data);
                successfully(data);
                resetForm();
                resetErrors();
                $('input[name=sku]').val(generateRandomCode(6));

                if (dataName == 'addressesForm') {
                    $('#addressesDataTable').DataTable().ajax.reload();
                    $('.select2Input').val(null).trigger('change');
                    $('#userCreateAddressModal').modal('hide');
                }
            } else {
                displayMissing(data);
            }


        },
        error: function (data) {

            $('#submit').prop('disabled', false);
            displayErrors(data);

        },
    });

});

// Update
$('#updateForm').on('submit', function (e) {

    e.preventDefault();
    tinyMCE.triggerSave();

    var url = $(this).attr('action');
    var method = $(this).attr('method');
    var dataName = $(this).data('name') ? $(this).data('name') : null;

    if (window.editors == undefined) {
        $.each(editors, function (index, editor) {
            editor.updateSourceElement()
        });
    }

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
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData: false,

        beforeSend: function () {
            $('#submit').prop('disabled', true);
            $('.progress-info').show();
            $('.progress-bar').width('0%');
            resetErrors();
        },
        success: function (data) {
            $('#submit').prop('disabled', false);
            $('#submit').text();

            if (data[0] == true) {
                redirect(data);
                successfully(data);
            } else {
                displayMissing(data);
            }

            if (dataName == 'addressesForm') {
                $('#addressesDataTable').DataTable().ajax.reload();
                $('.select2Input').val(null).trigger('change');
                $('#userCreateAddressModal').modal('hide');
            }
        },
        error: function (data) {
            $('#submit').prop('disabled', false);
            displayErrors(data);
        },
    });

});

// Update
$('.updateForm').on('submit', function (e) {

    e.preventDefault();
    tinyMCE.triggerSave();

    var url = $(this).attr('action');
    var method = $(this).attr('method');

    if (window.editors == undefined) {
        $.each(editors, function (index, editor) {
            editor.updateSourceElement();
        });
    }

    $.ajax({

        // xhr: function () {
        //     var xhr = new window.XMLHttpRequest();
        //     xhr.upload.addEventListener("progress", function (evt) {
        //         if (evt.lengthComputable) {
        //             var percentComplete = evt.loaded / evt.total;
        //             percentComplete = parseInt(percentComplete * 100);
        //             $('.progress-bar').width(percentComplete + '%');
        //             $('#progress-status').html(percentComplete + '%');
        //         }
        //     }, false);
        //     return xhr;
        // },

        url: url,
        type: method,
        dataType: 'JSON',
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData: false,

        beforeSend: function () {
            $('.submit').prop('disabled', true);
            $('.progress-info').show();
            $('.progress-bar').width('0%');
            resetErrors();
        },
        success: function (data) {
            $('.submit').prop('disabled', false);
            $('.submit').text();

            if (data[0] == true) {
                redirect(data);
                successfully(data);
                requestUpdating('success', data);
            } else {
                displayMissing(data);
            }
        },
        error: function (data) {
            $('.submit').prop('disabled', false);
            displayErrors(data);
            requestUpdating('error', data);
        },
    });

});

function requestUpdating(status, data) {}

function redirect(data) {
    if (data['url']) {
        var url = data['url'];

        if (url) {
            if (data['blank'] && data['blank'] == true) {

                window.open(url, '_blank');
            } else {
                window.location.replace(url);
            }
        }
    }
}



function successSubmit(data) {

    if (!data['ignore_success']) {

        successfully(data);
        resetForm();
        resetErrors();
        $('input[name=sku]').val(generateRandomCode(6));
    }else{
        $('.progress-info').hide();
        $('.progress-bar').width('0%');
        $('#img-upload-preview-0').hide();
    }
    handlingSuccessSubmit(data);
}

function handlingSuccessSubmit(data) {

}

function formSubmiting() {

}
// Alerts & Others
function displayErrors(data) {
    console.log($.parseJSON(data.responseText));

    var getJSON = $.parseJSON(data.responseText);

    jQuery.each(getJSON.errors, function (index, value) {
        if (value.length !== 0) {
            $('[data-name="' + index + '"]').parent().addClass('has-error');
            $('[data-name="' + index + '"]').closest('.form-group').find('.help-block').html(value);
        }
    });

    var output = "<div class='alert alert-danger'><ul>";
    for (var error in getJSON.errors) {
        output += "<li>" + getJSON.errors[error] + "</li>";
    }
    output += "</ul></div>";

    $('#result').slideDown('fast', function () {
        $('#result').html(output);
        $('.progress-info').hide();
        $('.progress-bar').width('0%');
    }).delay(5000).slideUp('slow');

    $('.progress-info').hide();
    $('.progress-bar').width('0%');
}

function displayMissing(data) {
    console.log(data);
    toastr["error"](data[1]);
    $('.progress-info').hide();
    $('.progress-bar').width('0%');
    $('#kt_table_1').DataTable().ajax.reload();
}

function successfully(data) {
    toastr["success"](data[1]);
    $('.progress-info').hide();
    $('.progress-bar').width('0%');
    $('#dataTable').DataTable().ajax.reload();

}

function resetForm() {
    $('.form-control').each(function () {
        $(this).val('');
    });
    $('#prd-image-0').prevAll().remove();
    $('#img-upload-preview-0').hide();
}

function resetErrors() {
    $('.has-error').each(function () {
        $(this).removeClass('has-error');
    });
    $('.help-block').each(function () {
        $(this).text('');
    });
}

// DATATABLE
function CheckAll() {
    var isChecked = $('input[name=ids]').first().prop('checked');
    $('input[name=ids]').prop('checked', !isChecked);
}

function CheckAllArray() {
    var ids = $("input[name='ids[]']");
    var statusCheckbox = $(".status-checkbox");
    var isChecked = ids.first().prop('checked');
    ids.prop('checked', !isChecked);
    statusCheckbox.prop('checked', !isChecked);
}

function CheckAllStates(stateId) {
    var statesCheckbox = $(".states-checkbox-" + stateId);
    var isChecked = statesCheckbox.first().prop('checked');
    statesCheckbox.prop('checked', !isChecked);
}

function getFormData($form) {
    var unindexed_array = $form.serializeArray();
    var indexed_array = {};

    $.map(unindexed_array, function (n, i) {
        indexed_array[n['name']] = n['value'];
    });

    return indexed_array;
}

function generateRandomCode(length = 6) {
    var result = '';
    var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    var charactersLength = characters.length;
    for (var i = 0; i < length; i++) {
        result += characters.charAt(Math.floor(Math.random() *
            charactersLength));
    }
    return result;
}

$(document).ready(function () {

    $('#search').click(function () {

        var $form = $("#formFilter");
        var data = getFormData($form);

        console.log(data);
        $('#dataTable').DataTable().destroy();

        tableGenerate(data);

    });

    $('.filter-cancel').click(function () {

        document.getElementById("formFilter").reset();

        $('#dataTable').DataTable().destroy();

        tableGenerate();

    });
});
