@extends('apps::dashboard.layouts.app')
@section('title', __('vendor::dashboard.vendors.products.title'))
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
                        <a href="{{ url(route('dashboard.vendors.index')) }}">
                            {{__('vendor::dashboard.vendors.index.title')}}
                        </a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <a href="#">{{__('vendor::dashboard.vendors.products.title')}}</a>
                    </li>
                </ul>
            </div>

            <h1 class="page-title"></h1>

            <form method="get" action="{{ route('dashboard.vendors.get_assigned_products', $vendor->id) }}">
                <div class="form-row align-items-center">
                    <div class="col-sm-4 my-1">
                        <label class="sr-only">{{__('catalog::dashboard.products.form.tabs.categories')}}</label>
                        <select name="category" id="categoriesSelect"
                                class="form-control select2" style="width: 300px;">
                            <option value="">
                                {{__('catalog::dashboard.products.form.tabs.categories')}}
                            </option>
                            @foreach ($prodCategories as $category)
                                <option value="{{ $category->id }}" {{ request()->has('category') && request()->get('category') ==  $category->id ? 'selected' : '' }}>
                                    {{ $category->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-auto my-1">
                        <button type="submit" class="btn btn-sm green btn-outline filter-submit margin-bottom">
                            <i class="fa fa-search"></i>
                            {{__('apps::dashboard.datatable.search')}}
                        </button>
                        <button type="button" id="btnResetSelectBox"
                                class="btn btn-sm yellow btn-outline margin-bottom">
                            <i class="fa fa-remove"></i>
                            {{__('apps::dashboard.datatable.reset')}}
                        </button>
                    </div>
                </div>
            </form>


            <div class="row">
                <form class="form-horizontal form-row-seperated" method="post" enctype="multipart/form-data"
                      action="{{route('dashboard.vendors.assign_products', $vendor->id)}}">
                    @csrf

                    <div class="col-md-12">

                        {{-- PAGE CONTENT --}}
                        <div class="col-md-12">

                            {{--  <h3 class="page-title">{{__('vendor::dashboard.vendors.products.title')}}</h3>  --}}
                            <div class="col-md-10">

                                @include('apps::dashboard.layouts._msg')

                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th>
                                            <a href="javascript:;" onclick="CheckAllArray()">
                                                {{__('apps::dashboard.general.select_all_btn')}}
                                            </a>
                                        </th>
                                        <th>#</th>
                                        <th>{{__('vendor::dashboard.vendors.products.table.title')}}</th>
                                        <th>{{__('vendor::dashboard.vendors.products.table.quantity')}}</th>
                                        <th>{{__('vendor::dashboard.vendors.products.table.price')}}</th>
                                        <th>{{__('vendor::dashboard.vendors.products.table.status')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @if(count($allProducts) > 0)

                                        @foreach($allProducts as $k => $product)
                                            @php
                                                $vendorProduct = $vendor->products()->where('product_id', $product->id)->first();
                                            @endphp

                                            <tr>
                                                <td>
                                                    <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                                        <input type="checkbox" value="{{ $product->id }}"
                                                               class="group-checkable"
                                                               name="ids[]" {{ $vendorProduct ? 'checked' : '' }}>
                                                        <span></span>
                                                    </label>
                                                </td>
                                                <td>{{ $product->id }}</td>
                                                <td>{{ $product->title }}</td>
                                                <td>
                                                    <input type="number" class="form-control"
                                                           value="{{ $vendorProduct ? $vendorProduct->pivot->qty : $product->qty }}"
                                                           name="qty[{{ $product->id }}]">
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control"
                                                           value="{{ $vendorProduct ? $vendorProduct->pivot->price : $product->price }}"
                                                           name="price[{{ $product->id }}]">
                                                </td>
                                                <td>
                                                    <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                                        <input type="checkbox" class="group-checkable status-checkbox"
                                                               name="status[{{ $product->id }}]" {{ $vendorProduct && $vendorProduct->pivot->status == 1 ? 'checked' : ''  }}>
                                                        <span></span>
                                                    </label>
                                                </td>
                                            </tr>
                                        @endforeach

                                    @else
                                        <tr>
                                            <td colspan="6"
                                                class="text-center">{{__('vendor::dashboard.vendors.datatable.no_products_data')}}</td>
                                        </tr>
                                    @endif

                                    </tbody>
                                </table>

                                <div>{{ $allProducts->links() }}</div>

                                <div class="row" style="margin: 15px">
                                    <div class="col-md-4">
                                        <b>{{__('vendor::dashboard.vendors.datatable.total')}}
                                            : </b> {{ $allProducts->total() }}
                                    </div>
                                    <div class="col-md-4">
                                        <b>{{__('vendor::dashboard.vendors.datatable.per_page')}}
                                            : </b> {{ $allProducts->count() }}
                                    </div>
                                </div>

                            </div>

                        </div>

                        {{-- PAGE ACTION --}}
                        <div class="col-md-12">
                            <div class="form-actions">
                                <div class="form-group">
                                    <button type="submit" id="submit" class="btn btn-lg green">
                                        {{__('apps::dashboard.general.add_btn')}}
                                    </button>
                                    <a href="{{url(route('dashboard.vendors.index')) }}" class="btn btn-lg red">
                                        {{__('apps::dashboard.general.back_btn')}}
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
@stop
@section('scripts')

    <script>
        $('#btnResetSelectBox').on('click', function (e) {
            $('#categoriesSelect').val(null).trigger('change');
        });
    </script>

@endsection