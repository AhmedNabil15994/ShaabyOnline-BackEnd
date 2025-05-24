@if(count($records) > 0)

    <div class="section">
        <div class="container">
            <div class="sectio-title text-center wow fadeInUp">

                <p>{{$home->short_title}}</p>
                <h2>{{ $home->title }}</h2>
            </div>
            <div class="slider-container position-relative">
                <div class="instagram-gallery owl-carousel">
                    @php $counter = 1; @endphp
                    @foreach($records as $k => $record)
                        @if($counter == 1)
                            <div class="row">
                                @endif
                                <div class="col-md-2 col-6">
                                    <a class="gallery-item text-center wow fadeInUp" href="{{$record->link}}">
                                        <div class="pro-img">
                                            <span class="insta-type"><i class="{{$record->type == 'video' ? 'fas fa-video' : 'ti-layers'}}"></i></span>
                                            <img src="{{asset($record->image)}}"/>
                                        </div>
                                        <ul class="gallery-react">
                                            <li><i class="fas fa-heart"></i> {{$record->likes_count}}</li>
                                            <li><i class="fas fa-comment"></i> {{$record->comments_count}}</li>
                                        </ul>
                                    </a>
                                </div>
                                @if($counter == 6 || $loop->last)
                            </div>
                        @endif

                        @if($counter == 6)
                            @php $counter = 0; @endphp
                        @endif
                        @php $counter++; @endphp
                    @endforeach
                </div>

                <div class="text-center mt-40 wow fadeInUp">
                    <a class="btn btn-theme main-custom-btn" href="{{config('setting.social')['instagram']}}">{{__('apps::frontend.Follow us')}}</a>
                </div>
            </div>
        </div>
    </div>
@endif
