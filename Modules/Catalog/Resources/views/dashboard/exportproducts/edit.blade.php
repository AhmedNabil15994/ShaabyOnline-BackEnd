@extends('apps::dashboard.layouts.app')
@section('title', __('catalog::dashboard.products.routes.update'))
@section('content')
<div class="page-content-wrapper">
    <div class="page-content">
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <a href="{{ url(route('dashboard.home')) }}">{{ __('apps::dashboard.home.title') }}</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <a href="{{ url(route('dashboard.exportproducts.index')) }}">
                        {{__('catalog::dashboard.products.routes.index')}}
                    </a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <a href="#">{{__('catalog::dashboard.products.routes.update')}}</a>
                </li>
            </ul>
        </div>

        <h1 class="page-title"></h1>

        <div class="row">

            <div class="col-md-12">

                {{-- RIGHT SIDE --}}
                <div class="col-md-3">
                    <div class="panel-group accordion scrollable" id="accordion2">
                        <div class="panel panel-default">
                            {{-- <div class="panel-heading">
                                <h4 class="panel-title"><a class="accordion-toggle"></a></h4>
                            </div> --}}
                            <div id="collapse_2_1" class="panel-collapse in">
                                <div class="panel-body">
                                    <ul class="nav nav-pills nav-stacked">
                                        <li class="active">
                                            <a href="#global_setting" data-toggle="tab">
                                                {{ __('catalog::dashboard.products.form.tabs.general') }}
                                            </a>
                                        </li>

                                        <li class="">
                                            <a href="#export" data-toggle="tab">
                                                {{ __('catalog::dashboard.products.form.tabs.export') }}
                                            </a>
                                        </li>

                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- PAGE CONTENT --}}
                <div class="col-md-9">
                    <div class="tab-content">

                      <div class="tab-pane fade in active" id="global_setting">

                          <form id="updateForm" page="form" class="form-horizontal form-row-seperated" method="post" enctype="multipart/form-data" action="{{route('dashboard.exportproducts.update',$id)}}">
                              @csrf
                              @method('PUT')
                              <div class="col-md-10">
                                <div class="vendor-products">
                                    @foreach ($products as $product)
                                      <div class="form-group">
                                        <input type="hidden" name="product_id[]" value="{{ $product['id'] }}">
                                          <div class="col-md-8">
                                              <div class="form-group">
                                                  <label class="col-md-2">
                                                      {{__('catalog::dashboard.products.form.main_products')}}
                                                  </label>
                                                  <div class="col-md-9">
                                                      <select name="main_products[]" id="single" class="form-control select2" data-name="main_products">
                                                          <option value="">Select</option>
                                                          @foreach ($main_products as $main_product)
                                                          <option value="{{ $main_product['id'] }}"
                                                          @if ($product->main_product_id == $main_product->id)
                                                            selected
                                                          @endif>
                                                              {{ $main_product->title }}
                                                          </option>
                                                          @endforeach
                                                      </select>
                                                      <div class="help-block"></div>
                                                  </div>
                                              </div>
                                              <div class="form-group">
                                                  <label class="col-md-2">
                                                      {{__('catalog::dashboard.products.form.price')}}
                                                  </label>
                                                  <div class="col-md-9">
                                                      <input type="text" name="price[]" class="form-control" data-name="price" value="{{ $product->price }}">
                                                      <div class="help-block"></div>
                                                  </div>
                                              </div>
                                              <div class="form-group">
                                                  <label class="col-md-2">
                                                      {{__('catalog::dashboard.products.form.qty')}}
                                                  </label>
                                                  <div class="col-md-9">
                                                      <input type="number" name="qty[]" class="form-control" data-name="qty" value="{{ $product->qty }}">
                                                      <div class="help-block"></div>
                                                  </div>
                                              </div>
                                              <div class="offer-form">
                                                  <div class="form-group">
                                                      <label class="col-md-2">
                                                          {{__('catalog::dashboard.products.form.offer_price')}}
                                                      </label>
                                                      <div class="col-md-9">
                                                          <input type="text" name="offer_price[]" class="form-control" data-name="offer_price" value="{{ $product->offer ? $product->offer->offer_price : ''}}">
                                                          <div class="help-block"></div>
                                                      </div>
                                                  </div>
                                                  <div class="form-group">
                                                      <label class="col-md-2">
                                                          {{__('catalog::dashboard.products.form.start_at')}}
                                                      </label>
                                                      <div class="col-md-9">
                                                          <input type="date" class="form-control" name="start_at[]" data-name="start_at" value="{{ $product->offer ? $product->offer->start_at : ''}}">
                                                          <div class="help-block"></div>
                                                      </div>
                                                  </div>
                                                  <div class="form-group">
                                                      <label class="col-md-2">
                                                          {{__('catalog::dashboard.products.form.end_at')}}
                                                      </label>
                                                      <div class="col-md-9">
                                                          <input type="date" class="form-control" name="end_at[]" data-name="end_at" value="{{ $product->offer ? $product->offer->end_at : '' }}">
                                                          <div class="help-block"></div>
                                                      </div>
                                                  </div>
                                              </div>
                                              <hr>
                                          </div>
                                          <div class="col-md-2">
                                              <a href="javascript:;" class="remove_vendor_product btn red">
                                                  <i class="fa fa-times"></i>
                                              </a>
                                          </div>
                                      </div>
                                    @endforeach
                                </div>
                              </div>
                              <br>
                              <div class="row">
                                  {{-- PAGE ACTION --}}
                                  <div class="col-md-12">
                                      <div class="form-actions">
                                          @include('apps::dashboard.layouts._ajax-msg')
                                          <div class="form-group">
                                              <button type="submit" id="submit" class="btn btn-lg green">
                                                  {{__('apps::dashboard.general.edit_btn')}}
                                              </button>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </form>
                      </div>

                        <div class="tab-pane fade in" id="export">

                            <form id="form" page="form" class="form-horizontal form-row-seperated" method="post" enctype="multipart/form-data" action="{{route('dashboard.exportproducts.store')}}">
                                @csrf
                                <input type="hidden" name="vendor_id" value="{{ $id }}">

                                <h3 class="page-title">{{__('catalog::dashboard.products.form.tabs.stock')}}</h3>
                                <div class="col-md-10">
                                    <div class="export-product">

                                        <div class="export-product-new-content"></div>

                                        <div class="export-product-content" style="display:none">
                                            <div class="form-group">
                                                <div class="col-md-8">
                                                    <div class="form-group">
                                                        <label class="col-md-2">
                                                            {{__('catalog::dashboard.products.form.main_products')}}
                                                        </label>
                                                        <div class="col-md-9">
                                                            <select name="main_products[]" id="single" class="form-control" data-name="main_products">
                                                                <option value="">Select</option>
                                                                @foreach ($main_products as $main_product)
                                                                <option value="{{ $main_product['id'] }}">
                                                                    {{ $main_product->title }}
                                                                </option>
                                                                @endforeach
                                                            </select>
                                                            <div class="help-block"></div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-2">
                                                            {{__('catalog::dashboard.products.form.price')}}
                                                        </label>
                                                        <div class="col-md-9">
                                                            <input type="text" name="price[]" class="form-control" data-name="price">
                                                            <div class="help-block"></div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-2">
                                                            {{__('catalog::dashboard.products.form.qty')}}
                                                        </label>
                                                        <div class="col-md-9">
                                                            <input type="number" name="qty[]" class="form-control" data-name="qty">
                                                            <div class="help-block"></div>
                                                        </div>
                                                    </div>
                                                    <div class="offer-form">
                                                        <div class="form-group">
                                                            <label class="col-md-2">
                                                                {{__('catalog::dashboard.products.form.offer_price')}}
                                                            </label>
                                                            <div class="col-md-9">
                                                                <input type="text" name="offer_price[]" class="form-control" data-name="offer_price" disabled>
                                                                <div class="help-block"></div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-md-2">
                                                                {{__('catalog::dashboard.products.form.start_at')}}
                                                            </label>
                                                            <div class="col-md-9">
                                                                <input type="date" class="form-control" name="start_at[]" data-name="start_at" disabled>
                                                                <div class="help-block"></div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-md-2">
                                                                {{__('catalog::dashboard.products.form.end_at')}}
                                                            </label>
                                                            <div class="col-md-9">
                                                                <input type="date" class="form-control" name="end_at[]" data-name="end_at" disabled>
                                                                <div class="help-block"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                </div>
                                                <div class="col-md-2">
                                                    <a href="javascript:;" class="remove_html btn red">
                                                        <i class="fa fa-times"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row" style="margin-bottom: 50px;">
                                            <button id="copy" type="button" class="btn green btn-lg mt-ladda-btn ladda-button btn-circle btn-outline" data-style="slide-down" data-spinner-color="#333">
                                                <span class="ladda-label">
                                                    <i class="icon-plus"></i>
                                                </span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    {{-- PAGE ACTION --}}
                                    <div class="col-md-12">
                                        <div class="form-actions">
                                            @include('apps::dashboard.layouts._ajax-msg')
                                            <div class="form-group">
                                                <button type="submit" id="submit" class="btn btn-lg green">
                                                    {{__('apps::dashboard.general.export')}}
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('scripts')

<script>
    $(function() {

        $(".export-product-content :input").attr("disabled", true);

        $("#copy").click(function() {
            var html = $(this).closest(".export-product").find('.export-product-content').html();
            $(this).closest(".export-product").find(".export-product-new-content").append(html);
            $(this).closest(".export-product").find(".export-product-new-content").find('select').select2();
            $(".export-product-new-content :input").attr("disabled", false);
        });

        $(".export-product-new-content").on("click", ".remove_html", function(e) {
            e.preventDefault();
            $(this).closest('.form-group').remove();
        });

        $(".vendor-products").on("click", ".remove_vendor_product", function(e) {
            e.preventDefault();
            $(this).closest('.form-group').remove();
        });
    });
</script>

@endsection
