@inject('appHomeDisplayType', 'Modules\Apps\Enums\AppHomeDisplayType')

@if (count($records) > 0)
    <div class="container">

        @if ($home->display_type == $appHomeDisplayType::__default)
            <div class="home-products">
                <h3 class="slider-title"> {{ $home->title }}</h3>
                <div class="owl-carousel products-slider">
                    @foreach ($records as $k => $record)
                        <div class="product-grid text-center">
                            <a href="{{ route('frontend.categories.products', ['vendor' => $record->slug]) }}">
                                <div class="product-image img-block d-flex align-items-center">
                                    <img src="{{ asset($record->image) }}" class="img-fluid" alt="{{ $record->title }}" />
                                </div>
                                <h4 style="padding: 7px 0px 18px 0px;">
                                    {{ $record->title }}
                                </h4>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <h3 class="slider-title"> {{ $home->title }}</h3>
            @php
                $numOfColumns = $home->grid_columns_count ?? 4;
                $bootstrapColWidth = 12 / $numOfColumns;
            @endphp
            <div class="list-products">
                <div class="row">
                    @foreach ($records as $k => $record)
                        <div class="col-md-{{ $bootstrapColWidth ?? '3' }} col-6">
                            <div class="product-grid text-center">
                                <a href="{{ route('frontend.categories.products', ['vendor' => $record->slug]) }}">
                                    <div class="product-image img-block d-flex align-items-center">
                                        <img src="{{ asset($record->image) }}" class="img-fluid"
                                            alt="{{ $record->title }}" />
                                    </div>
                                    <h4 style="padding: 7px 0px 18px 0px;">
                                        {{ $record->title }}
                                    </h4>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

    </div>
@endif
