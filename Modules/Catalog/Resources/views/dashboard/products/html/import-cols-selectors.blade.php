@if(!in_array('category',$excel_cols))
{!! field()->multiSelect('category_id' , __('catalog::dashboard.products.form.tabs.categories') , $allCategories->pluck('title','id')->toArray()) !!}
@endif

@foreach (\Modules\Catalog\Constants\Product::IMPORT_PRODUCT_COLS as $value)
    @if(($value == 'category' && in_array('category',$excel_cols)) || $value != 'category')
        <div class="form-group">
            <label class="col-md-2">
                {{__('catalog::dashboard.products.form.import_selects.'.$value)}}
            </label>
            <div class="col-md-9">
                <select name="{{$value}}"
                        class="form-control select2"
                        data-name="{{$value}}">
                    <option value=""></option>
                    @foreach ($excel_cols as $col)
                        <option value="{{ $col }}" {{$col == $value ? 'selected' : ''}}>
                            {{ $col }}
                        </option>
                    @endforeach
                </select>
                <div class="help-block"></div>
            </div>
        </div>
    @endif
@endforeach