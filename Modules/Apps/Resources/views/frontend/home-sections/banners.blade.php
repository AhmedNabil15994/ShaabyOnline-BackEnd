@if(count($records) > 0)
    @foreach($records as $k => $record)
        <div class="container">
            <div class="home-banner mb-20">
                <a href="{{$record->url}}"><img src="{{asset($record->image)}}" class="img-fluid" alt="" /></a>
            </div>
        </div>
    @endforeach
@endif
