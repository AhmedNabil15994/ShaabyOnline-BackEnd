<form id="updatePhotoForm" page="form" class="form-horizontal form-row-seperated" method="post"
    enctype="multipart/form-data" action="{{$uploading_route}}" style="display: none">
    @csrf

    <input type="file" name="image" id="imgupload" onchange="submitUploadingPhoto(event)">
    <input type="hidden" name="photo_id" id="photo_id">
</form>

<script>
    function browseFile(id){
        $('#photo_id').val(id);
        $('#imgupload').trigger('click'); return false;
    }

    function submitUploadingPhoto(event){
        
        var id = $('#photo_id').val();
        var form = $('#updatePhotoForm');

        var url = form.attr('action');
        var method = form.attr('method');
        var formData = new FormData(form[0]);
        
        formData.append('image', $('#imgupload')[0].files[0]); 

        $.ajax({

            url: url,
            type: 'POST',
            dataType: 'JSON',
            data:  formData,
            contentType: false,
            cache: false,
            processData: false,

            beforeSend: function () {
                uploadingPhoto(id);
            },
            success: function (data) {
                if (data[0] == true) {
                    photoUploadedSuccess(id , data.imagePath);
                } else {
                    photoUploadedField(id , data.message);
                }

            },
            error: function (data) {
                var getJSON = $.parseJSON(data.responseText);
                
                photoUploadedField(id , getJSON.errors['image'][0]);
            },
        });

    }

    function uploadingPhoto(id){

        var content = $('#photo_content_'+id);
        var photo_content = content.find('.photo');
        photo_content.hide();
        content.append(`<span class="loader-photo"></span>`);
    }

    function photoUploadedSuccess(id,image_path){
        var content = $('#photo_content_'+id);
        var photo_content = content.find('.photo');
        var loader = content.find('.loader-photo');
        photo = photo_content.find('.product_photo');
        photo.attr('src', image_path);
        $('<img src="{{asset('images/icons/check.png')}}" class="check-icons">').load(function() {
            $(this).appendTo('#photo_content_'+id);
            loader.remove();
            photo_content.show();

            setTimeout(function() {
                $('.check-icons').fadeOut(500);
            }, 4000);
        });
    }

    function photoUploadedField(id,message){
        var content = $('#photo_content_'+id);
        var photo_content = content.find('.photo');
        var loader = content.find('.loader-photo');

        $('<img src="{{asset('images/icons/delete.png')}}" class="check-icons">').load(function() {
            $(this).appendTo('#photo_content_'+id);
            loader.remove();
            photo_content.show();
            toastr["error"](message);
            setTimeout(function() {
                $('.check-icons').fadeOut(500);
            }, 6000);
        });
    }
</script>