<div class="portlet-body variation-add " style="margin-top: 20px">
    <div class="table-container">
        <table class="table table-striped table-bordered table-hover table-checkable" id="datatable_ajax">
            {{-- <thead>
                <tr role="row" class="heading">
                    <th width="10%"> # </th>
                    <th width="75"> Price </th>
                    <th width="75"> Qty </th>
                    <th width="100"> Status </th>
                    <th width="10%"> SKU </th>
                    <th width="10%"> Image </th>
                    <th width="200"> Offer </th>
                    <th width="10%"> Delete </th>
                </tr>
            </thead> --}}
            <tbody>
            @forelse ($res as $key2 => $value2)

                @if (is_array($value2))
                    <tr>
                        <td colspan="6" style="padding: 15px;">
                            @foreach ($value2 as $optionValue)
                                <input type="hidden" name="option_values_id[{{ $key2 }}][]" value="{{ $optionValue }}">
                                <span>
                                    {{ $optionValues->findOptionValueById($optionValue, ["option"])->option->title }} :
                                </span>
                                <b>{{ $optionValues->findOptionValueById($optionValue, [])->title }}</b>
                                @if (!$loop->last)
                                    /
                                @endif
                            @endforeach
                        </td>
                    </tr>
                    <tr role="row" class="filter " data-key="{{$key2}}">
                        <td>
                            <label>
                                {{__('catalog::dashboard.products.form.price')}}
                            </label>
                            <input type="text" placeholder="Price" data-name="variation_price.{{$key2}}"
                                   class="form-control form-filter input-sm" name="variation_price[{{$key2}}]">
                            <div class="help-block"></div>
                        </td>
                        <td>
                            <label>
                                {{__('catalog::dashboard.products.form.qty')}}
                            </label>
                            <input type="text" placeholder="Qty" data-name="variation_qty.{{$key2}}"
                                   class="form-control form-filter input-sm" name="variation_qty[{{$key2}}]">
                            <div class="help-block"></div>
                        </td>
                        <td>
                            {{--<select name="variation_status[]" data-name="variation_status.{{$key2}}"
                                        class="form-control form-filter input-sm">
                                    <option value="">Status</option>
                                    <option value="1">Active</option>
                                    <option value="0">Unactive</option>
                                </select>
                                <div class="help-block"></div>--}}

                            <label>
                                {{__('catalog::dashboard.products.form.status')}}
                            </label>
                            <div>
                                <input type="checkbox" class="make-switch"
                                       data-size="small"
                                       name="variation_status[]">
                                <div class="help-block"></div>
                            </div>
                        </td>
                        <td>
                            <label>
                                {{__('catalog::dashboard.products.form.sku')}}
                            </label>
                            <input type="text"
                                   placeholder="SKU"
                                   data-name="variation_sku.{{$key2}}"
                                   class="form-control form-filter input-sm"
                                   value="{{ generateRandomCode() }}"
                                   name="variation_sku[{{$key2}}]">
                            <div class="help-block"></div>
                        </td>
                        <td>
                            <div class="form-group" style="margin-left: -4px; float: left; margin-top: 23px;">

                                {{--<a data-input="v_images" data-preview="holder" class="btn btn-sm blue lfm ">
                                    <i class="fa fa-picture-o"></i>
                                </a>
                                <input name="v_images[{{$key2}}]" data-name="v_images.{{$key2}}"
                                       class="form-control form-filter input-sm v_images" type="text" readonly
                                       style="display:none;">
                                <span class="holder" style="margin-top:15px;max-height:100px;"></span>--}}

                                <input name="v_images[{{$key2}}]" data-name="v_images.{{$key2}}"
                                       class="form-control form-filter input-sm v_images" type="file"
                                       onchange="readURL(this, 'imgUploadPreview-{{ $key2.'-var-'.($key2+1) }}', 'single');">

                                <span class="holder" style="margin-top:15px;max-height:100px;">
                                    <img id="imgUploadPreview-{{ $key2.'-var-'.($key2+1) }}" src="#" alt=""
                                         class="img-thumbnail"
                                         style="display: none; width:100px; height: auto;">
                                </span>

                                <div class="help-block"></div>
                            </div>
                        </td>

                        <td rowspan="3">
                            <button type="button" class="btn btn-sm red btn-outline variants-delete">
                                <i class="fa fa-times"></i>
                            </button>
                        </td>
                    </tr>

                    <tr class="variation_options_{{$key2}}">
                        <td colspan="4">

                            <div class="form-group">

                                <div class="col-md-3 text-left">
                                    <input type="text" placeholder="{{__('catalog::dashboard.products.form.weight')}}"
                                           class="form-control" data-name="vshipment.{{$key2}}.weight"
                                           name="vshipment[{{$key2}}][weight]">
                                    <div class="help-block"></div>
                                </div>

                                <div class="col-md-3 text-left">
                                    <input type="text" placeholder="{{__('catalog::dashboard.products.form.width')}}"
                                           data-name="vshipment.{{$key2}}.width" class="form-control"
                                           name="vshipment[{{$key2}}][width]">
                                    <div class="help-block"></div>
                                </div>

                                <div class="col-md-3 text-left">
                                    <input type="text" placeholder="{{__('catalog::dashboard.products.form.length')}}"
                                           data-name="vshipment.{{$key2}}.length" class="form-control"
                                           name="vshipment[{{$key2}}][length]">
                                    <div class="help-block"></div>
                                </div>

                                <div class="col-md-3 text-left">
                                    <input type="text" placeholder="{{__('catalog::dashboard.products.form.height')}}"
                                           class="form-control" data-name="vshipment.{{$key2}}.height"
                                           name="vshipment[{{$key2}}][height]">
                                    <div class="help-block"></div>
                                </div>

                            </div>
                        </td>
                    </tr>

                    <tr class="variation_options_{{$key2}}">
                        <td colspan="4">

                            <div class="form-group">
                                <label class="col-md-2">
                                    {{__('catalog::dashboard.products.form.offer_status')}}
                                </label>
                                <div class="col-md-9 text-left">
                                    <input type="checkbox" class="offer-status" data-index="{{$key2}}"
                                           name="v_offers[{{ $key2 }}][status]" data-name="v_offers.{{ $key2 }}.status">
                                    <div class="help-block"></div>
                                </div>
                            </div>


                            <div class="offer-form_{{$key2}} variation_offer" style="display:none;">

                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <input type="text"
                                                       placeholder="{{__('catalog::dashboard.products.form.offer_price')}}"
                                                       id="offer-form_v" data-name="v_offers.{{ $key2 }}.offer_price"
                                                       class="form-control" name="v_offers[{{ $key2 }}][offer_price]"
                                                       disabled>
                                                <div class="help-block"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label class="col-md-4">
                                                {{__('catalog::dashboard.products.form.start_at')}}
                                            </label>
                                            <div class="col-md-8">
                                                <div class="input-group input-medium date date-picker"
                                                     data-date-format="yyyy-mm-dd" data-date-start-date="+0d">
                                                    <input type="text" id="offer-form_v" class="form-control"
                                                           name="v_offers[{{ $key2 }}][start_at]"
                                                           data-name="v_offers.{{ $key2 }}.start_at" disabled>
                                                    <span class="input-group-btn">
                                                        <button class="btn default" type="button">
                                                            <i class="fa fa-calendar"></i>
                                                        </button>
                                                    </span>
                                                </div>
                                                <div class="help-block" style="color: #e73d4a"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-5">


                                        <div class="form-group">
                                            <label class="col-md-4">
                                                {{__('catalog::dashboard.products.form.end_at')}}
                                            </label>
                                            <div class="col-md-8">
                                                <div class="input-group input-medium date date-picker"
                                                     data-date-format="yyyy-mm-dd" data-date-start-date="+0d">
                                                    <input type="text" id="offer-form_v" class="form-control"
                                                           name="v_offers[{{ $key2 }}][end_at]" disabled
                                                           data-name="v_offers.{{ $key2 }}.end_at">
                                                    <span class="input-group-btn">
                                                            <button class="btn default" type="button">
                                                                <i class="fa fa-calendar"></i>
                                                            </button>
                                                        </span>
                                                </div>
                                                <div class="help-block" style="color: #e73d4a"></div>
                                            </div>
                                        </div>

                                    </div>


                                </div>
                            </div>
                        </td>
                    </tr>

                @else
                    <td colspan="6" style="padding: 15px;">
                        {{--@foreach ($value2 as $optionValue)
                            <input type="hidden" name="option_values_id[{{ $key2 }}][]" value="{{ $optionValue }}">
                            <span>
                                {{ $optionValues->findOptionValueById($optionValue, ["translations","option.translations"])->option->title }}
                                 : </span>
                            <b>{{ $optionValues->findOptionValueById($optionValue, ["translations"])->title }}</b>
                            @if (!$loop->last)
                                /
                            @endif
                        @endforeach--}}

                        <input type="hidden" name="option_values_id[{{ $key2 }}][]" value="{{ $value2 }}">
                        <span>
                                    {{ $optionValues->findOptionValueById($value2, ["option"])->option->title }}
                                     : </span>
                        <b>{{ $optionValues->findOptionValueById($value2, [])->title }}</b>

                    </td>
                    <tr role="row" class="filter " data-key="{{$key2}}">
                        <td>
                            <div class="form-group" style="margin: 0;">
                                <label>
                                    {{__('catalog::dashboard.products.form.price')}}
                                </label>
                                <input type="text" placeholder="Price" data-name="variation_price.{{$key2}}"
                                       class="form-control form-filter input-sm" name="variation_price[{{$key2}}]">
                                <div class="help-block"></div>
                            </div>
                        </td>
                        <td>
                            <div class="form-group" style="margin: 0">
                                <label>
                                    {{__('catalog::dashboard.products.form.qty')}}
                                </label>
                                <input type="text" placeholder="Qty" data-name="variation_qty.{{$key2}}"
                                       class="form-control form-filter input-sm" name="variation_qty[{{$key2}}]">
                                <div class="help-block"></div>
                            </div>
                        </td>
                        <td>
                            {{--<div class="form-group" style="margin: 0">
                                    <select name="variation_status[]" data-name="variation_status.{{$key2}}"
                                            class="form-control form-filter input-sm">
                                        <option value="">Status</option>
                                        <option value="1">Active</option>
                                        <option value="0">Unactive</option>
                                    </select>
                                    <div class="help-block"></div>
                                </div>--}}

                            <label>
                                {{__('catalog::dashboard.products.form.status')}}
                            </label>
                            <div>
                                <input type="checkbox" class="make-switch"
                                       data-size="small"
                                       name="variation_status[]">
                                <div class="help-block"></div>
                            </div>

                        </td>
                        <td>
                            <div class="form-group" style="margin: 0">
                                <label>
                                    {{__('catalog::dashboard.products.form.sku')}}
                                </label>
                                <input type="text"
                                       placeholder="SKU"
                                       data-name="variation_sku.{{$key2}}"
                                       value="{{ generateRandomCode() }}"
                                       class="form-control form-filter input-sm"
                                       name="variation_sku[{{$key2}}]">
                                <div class="help-block"></div>
                            </div>
                        </td>
                        <td>
                            <div class="form-group" style="margin-left: -4px; float: left;">

                                {{--<a data-input="v_images" data-preview="holder" class="btn btn-sm blue lfm ">
                                    <i class="fa fa-picture-o"></i>
                                </a>
                                <input name="v_images[{{$key2}}]" data-name="v_images.{{$key2}}"
                                       class="form-control form-filter input-sm v_images" type="text" readonly
                                       style="display:none;">
                                <span class="holder" style="margin-top:15px;max-height:100px;"></span>--}}

                                <input name="v_images[{{$key2}}]" data-name="v_images.{{$key2}}"
                                       class="form-control form-filter input-sm v_images" type="file"
                                       onchange="readURL(this, 'imgUploadPreview-{{ $key2.'-var-'.($key2+1) }}', 'single');">

                                <span class="holder" style="margin-top:15px;max-height:100px;">
                                    <img id="imgUploadPreview-{{ $key2.'-var-'.($key2+1) }}" src="#" alt=""
                                         class="img-thumbnail"
                                         style="display: none; width:100px; height: auto;">
                                </span>

                                <div class="help-block"></div>
                            </div>
                        </td>

                        <td rowspan="3">
                            <button type="button" class="btn btn-sm red btn-outline variants-delete">
                                <i class="fa fa-times"></i>
                            </button>
                        </td>
                    </tr>

                    <tr class="variation_options_{{$key2}}">
                        <td colspan="4">

                            <div class="form-group">

                                <div class="col-md-3 text-left">
                                    <input type="text" placeholder="{{__('catalog::dashboard.products.form.weight')}}"
                                           class="form-control" data-name="vshipment.{{$key2}}.weight"
                                           name="vshipment[{{$key2}}][weight]">
                                    <div class="help-block"></div>
                                </div>

                                <div class="col-md-3 text-left">
                                    <input type="text" placeholder="{{__('catalog::dashboard.products.form.width')}}"
                                           data-name="vshipment.{{$key2}}.width" class="form-control"
                                           name="vshipment[{{$key2}}][width]">
                                    <div class="help-block"></div>
                                </div>

                                <div class="col-md-3 text-left">
                                    <input type="text" placeholder="{{__('catalog::dashboard.products.form.length')}}"
                                           data-name="vshipment.{{$key2}}.length" class="form-control"
                                           name="vshipment[{{$key2}}][length]">
                                    <div class="help-block"></div>
                                </div>

                                <div class="col-md-3 text-left">
                                    <input type="text" placeholder="{{__('catalog::dashboard.products.form.height')}}"
                                           class="form-control" data-name="vshipment.{{$key2}}.height"
                                           name="vshipment[{{$key2}}][height]">
                                    <div class="help-block"></div>
                                </div>

                            </div>
                        </td>
                    </tr>

                    <tr class="variation_options_{{$key2}}">
                        <td colspan="4">

                            <div class="form-group">
                                <label class="col-md-2">
                                    {{__('catalog::dashboard.products.form.offer_status')}}
                                </label>
                                <div class="col-md-9 text-left">
                                    <input type="checkbox" class="offer-status" data-index="{{$key2}}"
                                           name="v_offers[{{ $key2 }}][status]" data-name="v_offers.{{ $key2 }}.status">
                                    <div class="help-block"></div>
                                </div>
                            </div>


                            <div class="offer-form_{{$key2}} variation_offer" style="display:none;">

                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <input type="text"
                                                       placeholder="{{__('catalog::dashboard.products.form.offer_price')}}"
                                                       id="offer-form_v" data-name="v_offers.{{ $key2 }}.offer_price"
                                                       class="form-control" name="v_offers[{{ $key2 }}][offer_price]"
                                                       disabled>
                                                <div class="help-block"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label class="col-md-4">
                                                {{__('catalog::dashboard.products.form.start_at')}}
                                            </label>
                                            <div class="col-md-8">
                                                <div class="input-group input-medium date date-picker"
                                                     data-date-format="yyyy-mm-dd" data-date-start-date="+0d">
                                                    <input type="text" id="offer-form_v" class="form-control"
                                                           name="v_offers[{{ $key2 }}][start_at]"
                                                           data-name="v_offers.{{ $key2 }}.start_at" disabled>
                                                    <span class="input-group-btn">
                                                        <button class="btn default" type="button">
                                                            <i class="fa fa-calendar"></i>
                                                        </button>
                                                    </span>
                                                </div>
                                                <div class="help-block" style="color: #e73d4a"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-5">


                                        <div class="form-group">
                                            <label class="col-md-4">
                                                {{__('catalog::dashboard.products.form.end_at')}}
                                            </label>
                                            <div class="col-md-8">
                                                <div class="input-group input-medium date date-picker"
                                                     data-date-format="yyyy-mm-dd" data-date-start-date="+0d">
                                                    <input type="text" id="offer-form_v" class="form-control"
                                                           name="v_offers[{{ $key2 }}][end_at]" disabled
                                                           data-name="v_offers.{{ $key2 }}.end_at">
                                                    <span class="input-group-btn">
                                                            <button class="btn default" type="button">
                                                                <i class="fa fa-calendar"></i>
                                                            </button>
                                                        </span>
                                                </div>
                                                <div class="help-block" style="color: #e73d4a"></div>
                                            </div>
                                        </div>

                                    </div>


                                </div>
                            </div>
                        </td>
                    </tr>

                @endif

            @empty
                <td>
                <td colspan="7">
                    <div class="alert alert-info" role="alert">
                        {{__('catalog::dashboard.products.form.empty_options')}}
                    </div>
                </td>
                </td>
            @endforelse
            </tbody>
        </table>
    </div>
</div>


<script>
    $('.lfm').filemanager('image');

    $('.variants-delete').click(function () {
        var delterow = $(this).closest('.filter');
        $(`.variation_options_${delterow.data('key')}`).remove();
        delterow.prev("tr").remove();
        delterow.remove();
    });


</script>
