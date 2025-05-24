<button type="submit" id="submit" class="btn sbold btn-primary" data-toggle="modal" data-target="#import_multi_photo">
    <i class="fa fa-file-image-o"></i>
    {{__('catalog::dashboard.products.form.import_photos')}}
</button>
<div class="modal fade bs-modal-lg" id="import_multi_photo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">
                {{__('catalog::dashboard.products.form.import_photos')}}
                </h4>
            </div>
            <div class="modal-body" style="    margin: 0px 32px;">
                {!! Form::open([
                 'role'=>'form',
                 'id'=>'form',
                 'method'=>'POST',
                 'url'=> route('dashboard.products.store.multi.photo'),
                 'class'=>'form-horizontal form-row-seperated',
                 'files' => true
                 ])!!}

                <div id="selectors_container">
                    {!! field('frontend_no_label')->multiFileUpload('images' , __('catalog::dashboard.products.form.image')) !!}
                </div>
                <div class="col-md-12">
                    <div class="form-actions">
                        @include('apps::dashboard.layouts._ajax-msg')
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-file-image-o"></i>
                    {{__('apps::dashboard.general.import')}}
                </button>
            </div>
            {!! Form::close()!!}
        </div>
    </div>
</div>