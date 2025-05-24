@extends('apps::dashboard.layouts.app')
@section('title', __('catalog::dashboard.products.routes.show'))

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
                        <a href="{{ url(route('dashboard.products.index')) }}">
                            {{__('catalog::dashboard.products.routes.index')}}
                        </a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <a href="#">{{__('catalog::dashboard.products.routes.show')}}</a>
                    </li>
                </ul>
            </div>

            <h1 class="page-title"></h1>

            @permission(['review_products', 'pending_products_for_approval'])
            <div class="row">
                <form id="updateForm" page="form" class="form-horizontal form-row-seperated" method="post"
                      enctype="multipart/form-data"
                      action="{{ route('dashboard.review_products.approve_product', $product->id) }}">
                    @csrf
                    @method('POST')

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="col-md-5">
                                {{__('catalog::dashboard.products.form.pending_for_approval')}}
                            </label>
                            <div class="col-md-7">
                                <input type="checkbox" class="make-switch"
                                       data-size="small"
                                       name="pending_for_approval" {{($product->pending_for_approval == 1) ? ' checked="" ' : ''}}>
                                <div class="help-block"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-actions">
                            @include('apps::dashboard.layouts._ajax-msg')
                            <div class="form-group">
                                <button type="submit" id="submit" class="btn btn-lg green">
                                    {{__('apps::dashboard.general.edit_btn')}}
                                </button>
                                <a href="{{url(route('dashboard.products.index')) }}"
                                   class="btn btn-lg red">
                                    {{__('apps::dashboard.general.back_btn')}}
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            @endpermission

            <div class="row">
                <div class="col-md-8">

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <td class="bold">{{__('catalog::dashboard.products.form.sku')}}</td>
                                <td>{{ $product->sku ?? '---' }}</td>
                            </tr>
                            <tr>
                                <td class="bold">{{__('catalog::dashboard.products.form.vendor')}}</td>
                                <td>{{ $product->vendor->title }}</td>
                            </tr>
                            <tr>
                                <td class="bold">{{__('catalog::dashboard.products.form.price')}}</td>
                                <td>{{ $product->price ?? '---' }}</td>
                            </tr>
                            <tr>
                                <td class="bold">{{__('catalog::dashboard.products.form.qty')}}</td>
                                <td>{{ $product->qty ?? '---' }}</td>
                            </tr>
                            <tr>
                                <td class="bold">{{__('catalog::dashboard.products.form.status')}}</td>
                                <td>{{ $product->status == 1 ? __('apps::dashboard.general.active') : __('apps::dashboard.general.not_active') }}</td>
                            </tr>
                            <tr>
                                <td class="bold">{{__('catalog::dashboard.products.form.featured')}}</td>
                                <td>{{ $product->featured == 1 ? __('apps::dashboard.general.yes_btn') : __('apps::dashboard.general.no_btn') }}</td>
                            </tr>
                            <tr>
                                <td class="bold">{{__('catalog::dashboard.products.form.created_at')}}</td>
                                <td>{{ $product->created_at }}</td>
                            </tr>
                        </table>
                    </div>

                </div>

                @if($product->image)
                    <div class="col-md-4">
                        <div style="height: 255px; width: 100%;">
                            <img class="img-thumbnail"
                                 src="{{ url($product->image) }}"
                                 alt="Product Image"
                                 style="height: inherit; width: inherit;">
                        </div>
                    </div>
                @endif

            </div>

            <div class="row">
                <div class="col-md-12">

                    <div class="table-responsive">
                        <table class="table table-bordered">

                            @foreach($product->translations as $k => $item)
                                <tr>
                                    <td class="bold">{{__('catalog::dashboard.products.form.title') . '-' . $item->locale}}</td>
                                    <td>{{ $item->title }}</td>
                                </tr>
                                <tr>
                                    <td class="bold">{{__('catalog::dashboard.products.form.description') . '-' . $item->locale}}</td>
                                    <td>
                                        <a href="javascript:;" data-toggle="modal"
                                           data-target="#prdModal-{{ $k .'-'. $item->locale. '-desc' }}">{{ limitString(strip_tags($item->description)) }}</a>
                                        @include('catalog::dashboard.products._show_modal', ['index' => $k .'-'. $item->locale. '-desc', 'modalTitle' => __('catalog::dashboard.products.form.description') . '-' . $item->locale, 'content' => $item->description])
                                    </td>
                                </tr>
                                <tr>
                                    <td class="bold">{{__('catalog::dashboard.products.form.short_description') . '-' . $item->locale}}</td>
                                    <td>
                                        <a href="javascript:;" data-toggle="modal"
                                           data-target="#prdModal-{{ $k .'-'. $item->locale. '-short_desc' }}">{{ limitString(strip_tags($item->short_description)) }}</a>
                                        @include('catalog::dashboard.products._show_modal', ['index' => $k .'-'. $item->locale. '-short_desc', 'modalTitle' => __('catalog::dashboard.products.form.short_description') . '-' . $item->locale, 'content' => $item->short_description])
                                    </td>
                                </tr>
                            @endforeach

                        </table>
                    </div>

                </div>
            </div>

            @if($product->offer)
                <div class="row">
                    <h4># {{ __('catalog::dashboard.products.form.offer') }}</h4>

                    <div class="col-md-4">
                        <div style="margin: 10px;">
                            <span class="bold">{{__('catalog::dashboard.products.form.offer_price')}} : </span>
                            <span>{{ $product->offer->offer_price }}</span>
                        </div>
                        <div style="margin: 10px;">
                            <span class="bold">{{__('catalog::dashboard.products.form.status')}} : </span>
                            <span>{{ $product->offer->status == 1 ? __('apps::dashboard.general.active') : __('apps::dashboard.general.not_active') }}</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div style="margin: 10px;">
                            <span class="bold">{{__('catalog::dashboard.products.form.start_at')}} : </span>
                            <span>{{ $product->offer->start_at }}</span>
                        </div>
                        <div style="margin: 10px;">
                            <span class="bold">{{__('catalog::dashboard.products.form.end_at')}} : </span>
                            <span>{{ $product->offer->end_at }}</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div style="margin: 10px;">
                            <span class="bold">{{__('catalog::dashboard.products.form.created_at')}} : </span>
                            <span>{{ $product->offer->created_at }}</span>
                        </div>
                    </div>
                </div>
                <hr>
            @endif

            @if($product->shipment)
                <div class="row">
                    <h4># {{ __('catalog::dashboard.products.form.shipment') }}</h4>
                    <div class="col-md-4">
                        <div style="margin: 10px;">
                            <span class="bold">{{__('catalog::dashboard.products.form.width')}} : </span>
                            <span>{{ $product->shipment['width'] ?? '---' }}</span>
                        </div>
                        <div style="margin: 10px;">
                            <span class="bold">{{__('catalog::dashboard.products.form.length')}} : </span>
                            <span>{{ $product->shipment['length'] ?? '---' }}</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div style="margin: 10px;">
                            <span class="bold">{{__('catalog::dashboard.products.form.height')}} : </span>
                            <span>{{ $product->shipment['height'] ?? '---' }}</span>
                        </div>
                        <div style="margin: 10px;">
                            <span class="bold">{{__('catalog::dashboard.products.form.weight')}} : </span>
                            <span>{{ $product->shipment['weight'] ?? '---' }}</span>
                        </div>
                    </div>
                </div>
                <hr>
            @endif

            <div class="row">

                @if(count($product->categories) > 0)
                    <div class="col-md-4">
                        <h4># {{ __('catalog::dashboard.products.form.tabs.categories') }}</h4>
                        <ul>
                            @foreach($product->categories as $k => $item)
                                <li>{{ $item->title }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if(count($product->tags) > 0)
                    <div class="col-md-4">
                        <h4># {{ __('catalog::dashboard.products.form.tabs.tags') }}</h4>
                        <ul>
                            @foreach($product->tags as $k => $item)
                                <li>{{ $item->title }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if(count($product->addOns) > 0)
                    <div class="col-md-4">
                        <h4># {{ __('catalog::dashboard.products.form.tabs.add_ons') }}</h4>
                        <ul>
                            @foreach($product->addOns as $k => $item)
                                <li>
                                    <a href="javascript:;"
                                       data-toggle="modal"
                                       data-target="#modal-{{ $item->id }}">{{ $item->name }}</a>
                                    @include('catalog::dashboard.products._show_addons_modal', ['item' => $item])
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

            </div>

            @if(count($product->images) > 0)
                <div class="row">
                    <h4># {{ __('catalog::dashboard.products.form.tabs.images') }}</h4>
                    @foreach($product->images as $k => $item)
                        <div class="col-md-2">
                            <div style="height: 190px; width: 100%;">
                                <img class="img-thumbnail"
                                     src="{{ url('uploads/products/' . $item->image) }}"
                                     alt="Product Image"
                                     style="height: inherit; width: inherit;">
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            @if(count($product->variants) > 0)
                <h4># {{ __('catalog::dashboard.products.form.tabs.variations') }}</h4>
                @foreach($product->variants as $k => $item)
                    <div class="row">
                        <div class="col-md-8">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tr>
                                        <td class="bold">{{__('catalog::dashboard.products.form.sku')}}</td>
                                        <td>{{ $item->sku ?? '---' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="bold">{{__('catalog::dashboard.products.form.price')}}</td>
                                        <td>{{ $item->price ?? '---' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="bold">{{__('catalog::dashboard.products.form.qty')}}</td>
                                        <td>{{ $item->qty ?? '---' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="bold">{{__('catalog::dashboard.products.form.status')}}</td>
                                        <td>{{ $item->status == 1 ? __('apps::dashboard.general.active') : __('apps::dashboard.general.not_active') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="bold">{{__('catalog::dashboard.products.form.created_at')}}</td>
                                        <td>{{ $item->created_at }}</td>
                                    </tr>
                                    <tr>
                                        <td class="bold">{{__('catalog::dashboard.products.form.options')}}</td>
                                        <td>
                                            <ul>
                                                @foreach($item->productValues as $value)
                                                    <li>
                                                        {{ $value->productOption->option->title }}
                                                        / {{ $value->optionValue->title }}
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </td>
                                    </tr>

                                    @if($item->offer)
                                        <tr>
                                            <td class="bold">{{ __('catalog::dashboard.products.form.offer') }}</td>
                                            <td>
                                                <ul>
                                                    <li>
                                                        <b>{{__('catalog::dashboard.products.form.offer_price')}} : </b>
                                                        <span>{{ $item->offer->offer_price }}</span>
                                                    </li>
                                                    <li>
                                                        <b>{{__('catalog::dashboard.products.form.status')}} : </b>
                                                        <span>{{ $item->offer->status == 1 ? __('apps::dashboard.general.active') : __('apps::dashboard.general.not_active') }}</span>
                                                    </li>
                                                    <li>
                                                        <b>{{__('catalog::dashboard.products.form.start_at')}} : </b>
                                                        <span>{{ $item->offer->start_at }}</span>
                                                    </li>
                                                    <li>
                                                        <b>{{__('catalog::dashboard.products.form.end_at')}} : </b>
                                                        <span>{{ $item->offer->end_at }}</span>
                                                    </li>
                                                    <li>
                                                        <b>{{__('catalog::dashboard.products.form.created_at')}} : </b>
                                                        <span>{{ $item->offer->created_at }}</span>
                                                    </li>
                                                </ul>
                                            </td>
                                        </tr>
                                    @endif

                                    <tr>
                                        <td class="bold">{{ __('catalog::dashboard.products.form.shipment') }}</td>
                                        <td>
                                            <ul>
                                                <li>
                                                    <b>{{__('catalog::dashboard.products.form.width')}} : </b>
                                                    <span>{{ $item->shipment['width'] ?? '---' }}</span>
                                                </li>
                                                <li>
                                                    <b>{{__('catalog::dashboard.products.form.length')}} : </b>
                                                    <span>{{ $item->shipment['length'] ?? '---' }}</span>
                                                </li>
                                                <li>
                                                    <b>{{__('catalog::dashboard.products.form.height')}} : </b>
                                                    <span>{{ $item->shipment['height'] ?? '---' }}</span>
                                                </li>
                                                <li>
                                                    <b>{{__('catalog::dashboard.products.form.weight')}} : </b>
                                                    <span>{{ $item->shipment['weight'] ?? '---' }}</span>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>

                                </table>
                            </div>
                        </div>

                        @if($item->image)
                            <div class="col-md-4">
                                <div style="height: 190px; width: 100%;">
                                    <img class="img-thumbnail"
                                         src="{{ url($item->image) }}"
                                         alt="Product Image"
                                         style="height: inherit; width: inherit;">
                                </div>
                            </div>
                        @endif
                    </div>
                @endforeach
            @endif

        </div>
    </div>

@stop

@section('scripts')
    <script></script>
@endsection
