
@if(count($records))
    <div class="home-slider-container">
        <div class="owl-carousel home-slides">
            @foreach($records as $k => $record)
                @foreach($record->adverts()->active()->Started()->Unexpired()->orderBy('sort')->get() as $k => $advert)
                    <div class="item">
                        <a href="{{$advert->url}}">
                            <img src="{{ asset($advert->image) }}" alt="" />
                        </a>
                    </div>
                @endforeach
            @endforeach
        </div>
    </div>
@endif