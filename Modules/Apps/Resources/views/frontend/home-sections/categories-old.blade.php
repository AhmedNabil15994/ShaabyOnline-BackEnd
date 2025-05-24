@if(count($records) > 0)
    <div class="categories mb-40">
        <div class="container">
            <div class="row">
                @php $row_created = false;@endphp
                @foreach($records as $k => $record)
                    @if($loop->first || count($records) == 2)
                        <div class="{{count($records) == 1 ? 'col-md-12' : 'col-md-6'}} text-center cat-block">
                            <a href="{{route('frontend.categories.products', $record->slug)}}">
                                <img src="{{asset($record->image)}}" class="img-fluid" alt=""/>
                                <h4>
                                    {{ $record->title }}
                                </h4>
                            </a>
                        </div>
                    @endif

                    @if(!$loop->first && count($records) > 2)
                        @if(!$row_created)
                            @php $row_created = true;@endphp
                            <div class="col-md-6">
                                <div class="row">
                                    @endif
                                    <div class="col-md-6 col-6 text-center cat-block">
                                        <a href="{{route('frontend.categories.products', $record->slug)}}">
                                            <img src="{{asset($record->image)}}" class="img-fluid" alt=""/>
                                            <h4>
                                                {{ $record->title }}
                                            </h4>
                                        </a>
                                    </div>
                                    @if($loop->last)
                                </div>
                            </div>
                        @endif
                    @endif
                @endforeach
            </div>
        </div>
    </div>
@endif
