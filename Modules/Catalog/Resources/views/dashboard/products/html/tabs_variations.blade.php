<div class="portlet-body variation-edit">
    <div class="table-container">
        <table class="table table-striped table-bordered table-hover table-checkable" id="datatable_ajax">
            <thead>
            {{-- <tr role="row" class="heading">
                <th width="15%"> # </th>
                <th width="15%"> Price </th>
                <th width="200"> Qty </th>
                <th width="200"> Status </th>
                <th width="10%"> SKU </th>
                <th width="10%"> Image </th>
                <th width="10%"> Delete </th>
            </tr> --}}
            </thead>
            <tbody>
            <input type="hidden" name="removed_variants" value="">
            @foreach ($product->variants as $key => $data)
                <tr>
                    <td colspan="6" style="padding: 15px;">
                        @foreach ($data->productValues as $key2 => $value)
                            {{-- <input type="hidden" name="option_values_id[{{ $data['id'] }}][]" value="{{ $value->optionValue->id }}"> --}}
                            <span>{{$value->optionValue->option->title}} : </span>
                            <b>{{$value->optionValue->title}}</b>
                            @if(!$loop->last)
                                /
                            @endif
                        @endforeach
                        <input type="hidden" name="upateds_option_values_id[{{ $data['id'] }}]" value="{{ $data->id }}">
                    </td>
                </tr>
                <tr role="row" class="filter" data-key="{{$data['id']}}">
                    {{-- <input type="hidden" name="variants_ids[]" value="{{ $data->id }}"> --}}
                    <input type="hidden" name="variants[_old][{{ $data['id'] }}]" value="{{ $product->id }}">

                    <td>
                        <label>
                            {{__('catalog::dashboard.products.form.price')}}
                        </label>
                        <input type="text" placeholder="Price" class="form-control form-filter input-sm"
                               name="_variation_price[{{ $data['id'] }}]" value="{{ $data->price }}">
                    </td>
                    <td>
                        <label>
                            {{__('catalog::dashboard.products.form.qty')}}
                        </label>
                        <input type="text" placeholder="Qty" class="form-control form-filter input-sm"
                               name="_variation_qty[{{ $data['id'] }}]" value="{{ $data->qty }}">
                    </td>
                    <td>
                        {{--<select name="_variation_status[{{ $data['id'] }}]" class="form-control form-filter input-sm">
                            <option value="">Status</option>
                            <option value="1" {{ $data->status ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ $data->status ? '' : 'selected' }}>Unactive</option>
                        </select>--}}

                        <label>
                            {{__('catalog::dashboard.products.form.status')}}
                        </label>
                        <div>
                            <input type="checkbox" class="make-switch"
                                   data-size="small"
                                   {{$data->status ? 'checked' : ''}}
                                   name="_variation_status[{{ $data['id'] }}]">
                            <div class="help-block"></div>
                        </div>

                    </td>
                    <td>
                        <label>
                            {{__('catalog::dashboard.products.form.sku')}}
                        </label>
                        <input type="text"
                               placeholder="SKU"
                               class="form-control form-filter input-sm"
                               name="_variation_sku[{{ $data['id'] }}]"
                               value="{{ $data->sku ?? generateRandomCode() }}">
                    </td>
                    <td rowspan="3">
                        <div class="form-group" style="margin-left: -4px; float: left; margin-top: 23px;">

                            {{--<a data-input="_v_images" data-preview="holder" class="btn btn-sm blue lfm ">
                                 <i class="fa fa-picture-o"></i>
                             </a>
                             <input name="_v_images[{{ $data['id'] }}]"
                                    class="form-control form-filter input-sm _v_images" type="text" readonly
                                    style="display:none;">

                             <span class="holder" style="margin-top:15px;max-height:100px;">
                                <img src="{{ url($data->image) }}" alt=""
                                     class="img-thumbnail"
                                     style="width:100px; height: auto;">
                            </span>--}}

                            <input name="_v_images[{{ $data['id'] }}]"
                                   class="form-control form-filter input-sm _v_images" type="file"
                                   onchange="readURL(this, 'imgUploadPreview-{{ $data['id'] }}', 'single');">

                            <span class="holder" style="margin-top:15px;max-height:100px;">
                                <img id="imgUploadPreview-{{ $data['id'] }}" src="{{ url($data->image) }}" alt=""
                                     class="img-thumbnail"
                                     style="width:100px; height: auto;">
                            </span>

                        </div>
                    </td>
                    <td rowspan="3">
                        <button type="button" class="btn btn-sm red btn-outline variants-delete"
                                data-index="{{$loop->index}}">
                            <i class="fa fa-times"></i>
                        </button>
                    </td>
                </tr>

                <tr class="variation_options_update_{{$data['id']}}">
                    <td colspan="4">

                        <div class="form-group">

                            <div class="col-md-3 text-left">
                                <input type="text" value="{{optional($data->shipment)['weight']}}"
                                       placeholder="{{__('catalog::dashboard.products.form.weight')}}"
                                       class="form-control" data-name="_vshipment.{{$data['id']}}.weight"
                                       name="_vshipment[{{$data['id']}}][weight]">
                                <div class="help-block"></div>
                            </div>

                            <div class="col-md-3 text-left">
                                <input type="text" value="{{optional($data->shipment)['width']}}"
                                       placeholder="{{__('catalog::dashboard.products.form.width')}}"
                                       data-name="_vshipment.{{$data['id']}}.width" class="form-control"
                                       name="_vshipment[{{$data['id']}}][width]">
                                <div class="help-block"></div>
                            </div>

                            <div class="col-md-3 text-left">
                                <input type="text" value="{{optional($data->shipment)['length']}}"
                                       placeholder="{{__('catalog::dashboard.products.form.length')}}"
                                       data-name="_vshipment.{{$data['id']}}.length" class="form-control"
                                       name="_vshipment[{{$data['id']}}][length]">
                                <div class="help-block"></div>
                            </div>

                            <div class="col-md-3 text-left">
                                <input type="text" value="{{optional($data->shipment)['height']}}"
                                       placeholder="{{__('catalog::dashboard.products.form.height')}}"
                                       class="form-control" data-name="_vshipment.{{$data['id']}}.height"
                                       name="_vshipment[{{$data['id']}}][height]">
                                <div class="help-block"></div>
                            </div>

                        </div>
                    </td>
                </tr>

                <tr class="variation_options_update_{{$data['id']}}">
                    <td colspan="4">

                        <div class="form-group">
                            <label class="col-md-2">
                                {{__('catalog::dashboard.products.form.offer_status')}}
                            </label>
                            <div class="col-md-9 text-left">
                                <input type="checkbox"
                                       @if ($data->offer)
                                       {{($data->offer->status == 1) ? ' checked="" ' : ''}}
                                       @endif
                                       class="offer-status" data-index="update{{$data['id']}}"
                                       name="_v_offers[{{ $data['id'] }}][status]"
                                       data-name="_v_offers.{{ $data['id'] }}.status">
                                <div class="help-block"></div>
                            </div>
                        </div>


                        <div class="offer-form_update{{$data['id']}} variation_offer" style="display:none;">

                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <input type="text"
                                                   value="{{optional($data->offer)->offer_price}}"
                                                   placeholder="{{__('catalog::dashboard.products.form.offer_price')}}"
                                                   id="offer-form_v" data-name="_v_offers.{{$data['id'] }}.offer_price"
                                                   class="form-control" name="_v_offers[{{ $data['id'] }}][offer_price]"
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
                                                <input type="text"
                                                       value="{{optional($data->offer)->start_at}}"
                                                       id="offer-form_v" class="form-control"
                                                       name="_v_offers[{{ $data['id'] }}][start_at]"
                                                       data-name="_v_offers.{{ $data['id'] }}.start_at" disabled>
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
                                                <input type="text"
                                                       value="{{optional($data->offer)->end_at}}"
                                                       id="offer-form_v" class="form-control"
                                                       name="_v_offers[{{ $data['id'] }}][end_at]" disabled
                                                       data-name="_v_offers.{{ $data['id'] }}.end_at">
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

            @endforeach
            </tbody>
        </table>
    </div>
</div>
