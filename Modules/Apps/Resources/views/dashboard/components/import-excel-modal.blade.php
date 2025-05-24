<button type="submit" id="submit" class="btn sbold btn-warning" data-toggle="modal" data-target="#import_excel">
    <i class="fa fa-file-excel-o"></i>
    {{__('apps::dashboard.general.import')}}
</button>
<div class="modal fade" id="import_excel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">


                {!! Form::open([
                 'role'=>'form',
                 'id'=>'import_form',
                 'method'=>'POST',
                 'class'=>'form-horizontal form-row-seperated',
                 'files' => true
                 ])!!}
                <div id="file_input_container">
                    {!! field()->file('excel_file' , __('apps::dashboard.general.excel_file')) !!}
                    <input type="hidden" name="module" value="{{$module_name}}">
                    <input type="hidden" name="view_path" value="{{$view_path}}">

                </div>

                <div class="modal-footer">
                    <button type="button" onclick="submitForm(this)" submit_type="get_rows" class="btn btn-success">
                        {{__('apps::dashboard.general.use_file')}}
                    </button>
                </div>

                <div id="selectors_container">
                </div>
                <div class="col-md-12">
                    <div class="form-actions">
                        @include('apps::dashboard.layouts._ajax-msg')
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="submitForm(this)" submit_type="submit" class="btn btn-warning">
                    <i class="fa fa-file-excel-o"></i>
                    {{__('apps::dashboard.general.import')}}
                </button>
            </div>
            {!! Form::close()!!}
        </div>
    </div>
</div>