@if (isset($withoutGrid) && $withoutGrid == true)
    {{ __('apps::dashboard.datatable.show_all_deleted') }}
    <input type="checkbox" class="make-switch" id="showAllDeleted" data-size="small"
        data-on-text="{{ __('apps::dashboard.datatable.yes') }}"
        data-off-text="{{ __('apps::dashboard.datatable.no') }}" name="show_all_deleted">
@else
    <div class="form-group">
        <div class="col-md-3">
            {{ __('apps::dashboard.datatable.show_all_deleted') }}
            <input type="checkbox" class="make-switch" id="showAllDeleted" data-size="small"
                data-on-text="{{ __('apps::dashboard.datatable.yes') }}"
                data-off-text="{{ __('apps::dashboard.datatable.no') }}" name="show_all_deleted">
        </div>
    </div>
@endif
