<div class="tab-pane fade" id="order_status">
    <h3 class="page-title">{{ __('setting::dashboard.settings.form.tabs.order_status_colors') }}</h3>
    <div class="col-md-10">

        @foreach ($orderStatuses as $item)
        <div class="form-group">
            <label class="col-md-2">
                {{ $item->title }}
            </label>
            <div class="col-md-3">
                <input type="color" name="order_status[{{$item->flag}}]"
                    value="{{ config('setting.order_status.'. $item->flag) }}" class="form-control" />
            </div>
        </div>
        @endforeach

    </div>
</div>
