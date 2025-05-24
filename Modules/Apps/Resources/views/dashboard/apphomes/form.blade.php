@inject('appHomeDisplayType', 'Modules\Apps\Enums\AppHomeDisplayType')

{!! field()->langNavTabs() !!}

<div class="tab-content">
    @foreach (config('laravellocalization.supportedLocales') as $code => $lang)
        <div class="tab-pane fade in {{ $code == locale() ? 'active' : '' }}" id="first_{{ $code }}">
            {!! field()->text(
                'title[' . $code . ']',
                __('apps::dashboard.app_homes.form.title') . '-' . $code,
                $model->getTranslation('title', $code),
                ['data-name' => 'title.' . $code],
            ) !!}
        </div>
    @endforeach
</div>

<hr>

<div class="form-group">
    <label class="col-md-2">
        {{ __('apps::dashboard.app_homes.form.type') }}
    </label>

    <div class="col-md-9">
        <div class="md-radio-inline">
            @foreach (Modules\Apps\Entities\AppHome::typesForSelect() as $type => $display_name)
                <label class="mt-radio" style="margin-right: 5px;margin-left: 5px;">
                    <input type="radio" name="type" data-name="type" id="type" value="{{ $type }}"
                        {{ $model->type == $type ? 'checked="checked"' : '' }}>
                    {{ $display_name }}
                    <span></span>
                </label>
            @endforeach
            <div class="help-block" style="color: red"></div>
        </div>
    </div>
</div>

@foreach (Modules\Apps\Entities\AppHome::typesForSelect('placeholders') as $type => $display_name)
    <div class=" hide-inputs" id="{{ $type }}-input"
        style="display: {{ $model->type == $type ? 'block' : 'none' }}">
        @if ($type == 'description')
            <ul class="nav nav-tabs">
                @foreach (config('translatable.locales') as $code)
                    <li class="@if ($loop->first) active @endif">
                        <a data-toggle="tab" href="#{{ $model->type }}_{{ $model->id }}_{{ $code }}">
                            {{ __('catalog::dashboard.products.form.tabs.input_lang', ['lang' => $code]) }}
                        </a>
                    </li>
                @endforeach
            </ul>

            <div class="tab-content">
                @foreach (config('translatable.locales') as $code)
                    <div id="{{ $model->type }}_{{ $model->id }}_{{ $code }}"
                        class="tab-pane fade @if ($loop->first) in active @endif">
                        {!! field()->ckEditor5(
                            'description[' . $code . ']',
                            __('page::dashboard.pages.form.description') . '-' . $code,
                            $model->getTranslation('description', $code),
                            ['data-name' => 'description.' . $code],
                        ) !!}
                    </div>
                @endforeach
            </div>
        @else
            {!! field()->multiSelect(
                $type,
                $display_name,
                \Modules\Apps\Entities\AppHome::getClassByType($type)->pluck('title', 'id')->toArray(),
                $model->$type->count() ? $model->$type->pluck('id')->toArray() : [],
            ) !!}
        @endif
    </div>
@endforeach

<div class="form-group">
    <label class="col-md-2">
        {{ __('apps::dashboard.app_homes.form.display_type.label') }}
    </label>

    <div class="col-md-9">
        <div class="md-radio-inline">
            @foreach ($appHomeDisplayType::getConstList() as $type)
                <label class="mt-radio" style="margin-right: 5px;margin-left: 5px;">
                    <input type="radio" name="display_type" data-name="display_type" id="displayTypeInput"
                        value="{{ $type }}"
                        {{ $model->display_type == $type || (!isset($model->display_type) && $type == $appHomeDisplayType::__default) ? 'checked="checked"' : '' }}>
                    {{ __('apps::dashboard.app_homes.form.display_type.' . $type) }}
                    <span></span>
                </label>
            @endforeach
            <div class="help-block" style="color: red"></div>
        </div>
    </div>

</div>

<div class="form-group" id="gridColumnsCountSection"
    style="display: {{ isset($model->display_type) && $model->display_type != $appHomeDisplayType::__default ? 'block' : 'none' }}">
    <label class="col-md-2">
        {{ __('apps::dashboard.app_homes.form.display_type.grid_columns_count') }}
    </label>

    <div class="col-md-9">

        <select name="grid_columns_count" data-name="grid_columns_count" id="gridColumnsCountInput"
            class="form-control">
            <option value="1" {{ $model->grid_columns_count == '1' ? 'selected' : '' }}>1</option>
            <option value="2" {{ $model->grid_columns_count == '2' ? 'selected' : '' }}>2</option>
            <option value="3" {{ $model->grid_columns_count == '3' ? 'selected' : '' }}>3</option>
            <option value="4" {{ $model->grid_columns_count == '4' ? 'selected' : '' }}>4</option>
            <option value="6" {{ $model->grid_columns_count == '6' ? 'selected' : '' }}>6</option>
            <option value="12" {{ $model->grid_columns_count == '12' ? 'selected' : '' }}>12</option>
        </select>

        <div class="help-block" style="color: red"></div>
    </div>
</div>

<hr>
{!! field()->checkBox('add_dates', __('apps::dashboard.app_homes.form.add_dates'), null, [
    'onchange' => 'toggleBooleanSwitch(this,"#dates_container")',
]) !!}

<div id="dates_container" style="display: none;">
    {!! field()->date(
        'start_at',
        __('apps::dashboard.app_homes.form.start_at'),
        $model->start_at ? \Carbon\Carbon::parse($model->start_at)->format('Y-m-d') : null,
    ) !!}
    {!! field()->date(
        'end_at',
        __('apps::dashboard.app_homes.form.end_at'),
        $model->end_at ? \Carbon\Carbon::parse($model->end_at)->format('Y-m-d') : null,
    ) !!}
</div>

<hr>

{!! field()->number('order', __('apps::dashboard.app_homes.form.order')) !!}

{!! field()->checkBox('status', __('apps::dashboard.app_homes.form.status')) !!}
@if ($model->trashed())
    {!! field()->checkBox('trash_restore', __('apps::dashboard.app_homes.form.restore')) !!}
@endif

@push('scripts')
    <script>
        $('input[name=type]').change(function() {
            $('.hide-inputs').hide();
            $('#' + this.value + '-input').show();
        });

        $('input[name=display_type]').change(function() {
            let carousel = '{{ $appHomeDisplayType::__default }}';
            if (this.value == carousel)
                $('#gridColumnsCountSection').hide();
            else
                $('#gridColumnsCountSection').show();

        });
    </script>
@endpush
