@extends('apps::frontend.layouts.master')
@section('title', __('apps::frontend.categories.title') )
@section('content')

    @php
        $requestCategory = request()->has('category') && !empty(request()->get('category')) ? request()->get('category') : null;
    @endphp

    <div class="right-side d-flex">
        <div class="right-side-content">
            <div class='inner-page bg-white categories-page'>

                <div class="page-head d-flex align-items-center mb-20">
                    <a href="{{ route('frontend.home') }}" class="go-back theme-color-hover"><i
                                class="ti-arrow-right"></i></a>

                    <div class="head-search">
                        <form method="get"
                              action="{{ route('frontend.vendors.show', $vendorObject->slug) }}">
                            <input type="hidden" name="category" value="{{ $requestCategory ? $requestCategory : '' }}">
                            <input type="search" class="form-control" name="search"
                                   value="{{ request()->get('search') }}" autocomplete="off"
                                   placeholder="{{ __('vendor::frontend.vendors.filter.search_here') }}"/>
                        </form>
                    </div>

                </div>

                @if(count($categories) > 0)
                    <div class="menu-items">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">

                            @foreach($categories as $k => $category)
                                <li class="nav-item">
                                    <a class="nav-link {{ activeCategoryTab($category, $k, 'active') }}"
                                       data-toggle="tab" href="#tab{{$k}}" role="tab"
                                       aria-controls="tab{{$k}}"
                                       aria-selected="{{ activeCategoryTab($category, $k, true) }}">{{ $category->title }}</a>
                                </li>
                            @endforeach

                        </ul>
                        <div class="tab-content" id="myTabContent">

                            @foreach($categories as $k => $category)
                                <div class="tab-pane fade {{ activeCategoryTab($category, $k, 'show active') }}"
                                     id="tab{{$k}}" role="tabpanel" aria-labelledby="home-tab">
                                    <div class="category-items">

                                        @if(count($category->products) > 0)
                                            @foreach($category->products as $k => $product)
                                                <div class="product d-flex align-items-center">
                                                    <div class="media-body">
                                                        <a class="product-name theme-color-hover"
                                                           href="{{ url(route('frontend.products.index', [$vendorObject->slug, $product->slug,])) }}">{{ $product->title }}</a>
                                                        <p>{{ $product->short_description }}</p>
                                                        <button class="btn add-cart-btn d-flex align-items-center">
                                                            <span class="price">{{ $product->price }} {{ __('apps::frontend.master.kwd') }}</span>
                                                            <i class="im im-icon-Add-Bag"></i>
                                                        </button>
                                                    </div>
                                                    <div class="pro-img">
                                                        <img class="img-fluid" src="{{ url($product->image) }}"
                                                             alt="{{ $product->title }}">
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif

                                    </div>
                                </div>
                            @endforeach

                        </div>

                        {{--<div class="btn-container mt-30">
                            <a href="{{ route('frontend.shopping-cart.index') }}"
                               class="btn btn-block btn-theme">{{ __('apps::frontend.master.start_order') }}</a>
                        </div>--}}

                    </div>
                @else
                    <h2 class="text-center block-title">{{ __('vendor::frontend.vendors.filter.no_search_result') }}</h2>
                @endif

            </div>
        </div>
    </div>

@endsection