<div class="content-sidebar">
    <h4 class="widget-title filter-res">{{ __('catalog::frontend.category_products.filter.filter_products') }}</h4>
    <div class="panel-group filter-options" id="accordionNo">

        {{--<div class="btn-save-filter text-left">
            <button class="btn btn-them">حفظ</button>
        </div>--}}

        <form method="get"
              action="{{ route('frontend.categories.products', $category ? $category->slug : null) }}">

            <input type="hidden" name="s" value="{{ request()->get('s') }}">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" href="#collapseCategory" class="collapseWill">
                            <span class="colles-block"></span>
                            {{ __('catalog::frontend.category_products.filter.situation') }}
                        </a>
                    </h4>
                </div>
                <div id="collapseCategory" class="panel-collapse collapse show">
                    <div class="panel-body">
                        <div class="checkboxes radios one-in-row">

                            @foreach($tags as $k => $tag)
                                <input id="check-{{ $tag->id }}"
                                       type="radio"
                                       value="{{ $tag->slug }}"
                                       name="tags"
                                    {{ request()->get('tags') == $tag->slug ? 'checked': '' }}>
                                <label for="check-{{ $tag->id }}"> {{ $tag->title }}</label>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" href="#collapseColor"
                           class="collapseWill">
                            {{ __('catalog::frontend.category_products.filter.categories') }}
                            <span class="colles-block"></span>
                        </a>
                    </h4>
                </div>
                <div id="collapseColor" class="panel-collapse collapse show">
                    <div class="panel-body">
                        <div class="checkboxes one-in-row">

                            @foreach($categories as $k => $cat)
                                <input id="check-category-{{ $cat->id }}"
                                       value="{{ $cat->slug }}"
                                       type="checkbox"
                                       name="categories[{{ $cat->id }}]"
                                    {{ (isset(request()->get('categories')[$cat->id]) && request()->get('categories')[$cat->id] == $cat->slug) || ($category && $category->id == $cat->id) ? 'checked': '' }}>
                                <label
                                    for="check-category-{{ $cat->id }}"> {{ $cat->title }}</label>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>


            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a class="collapseWill" data-toggle="collapse"
                           href="#collapsePrice">
                            {{ __('catalog::frontend.category_products.filter.price') }}
                            <span class="colles-block"></span>
                        </a>
                    </h4>
                </div>
                <div id="collapsePrice" class="panel-collapse collapse show">
                    <div class="panel-body">
                        <div class="filter-price">
                            <div class="filter-options-content">
                                <div class="price_slider_wrapper">
                                    <div data-label-reasult="" data-min="0" data-max="5000"
                                         data-unit="KD " class="{{--slider-range-price--}} custom-slider-range-price"
                                         data-value-min="1000" data-value-max="2500">
                                    </div>
                                    <div class="price_slider_amount">
                                        <div style="" class="price_label">
                                            <span
                                                class="from">{{ __('apps::frontend.master.kwd') }} {{ !empty(request()->get('price_from')) ? request()->get('price_from') : '111.00' }} </span>-<span
                                                class="to">{{ __('apps::frontend.master.kwd') }} {{ !empty(request()->get('price_to')) ? request()->get('price_to') : '299.00' }}</span>
                                        </div>
                                    </div>
                                    <div id="hiddenPriceSliderAmount">
                                        <input type="hidden" id="priceFrom" name="price_from"
                                               value="{{ !empty(request()->get('price_from')) ? request()->get('price_from') : '111.00' }}">
                                        <input type="hidden" id="priceTo" name="price_to"
                                               value="{{ !empty(request()->get('price_to')) ? request()->get('price_to') : '299.00' }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <hr>
            <div class="text-left mt-3">
                <button
                    class="btn btn-them btn-block">{{ __('catalog::frontend.category_products.filter.btn.search') }}</button>
            </div>

        </form>

    </div>
</div>
