<div id="prdModal-{{ $index }}" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">{{ $modalTitle }}</h4>
            </div>
            <div class="modal-body">
                {!! $content !!}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    {{ __('apps::dashboard.general.close_btn') }}
                </button>
            </div>
        </div>

    </div>
</div>
