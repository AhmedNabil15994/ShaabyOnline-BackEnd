@if(count($records) > 0)
    @foreach($records as $k => $record)
        <div class="section articles-home">
            <div class="container">
                <div class="sectio-title text-center wow fadeInUp">

                    <p>{{$home->short_title}}</p>
                    <h2>{{ $home->title }}</h2>
                </div>
                <div class="home-article">
                    <div class="article-block2 wow fadeInLeft">
                        <div class="img-block">
                            <img class="img-fluid" src="{{asset($record->image)}}" alt=""/>
                        </div>
                    </div>
                    <div class="article-content wow fadeInRight">
                        <div class="article-desc">
                            <h3 class="article-title"><a href="{{route('frontend.articles.show',$record->slug)}}">{{$record->title}}</a>
                            </h3>
                            <p>
                                {!! $record->short_description !!}
                            </p>
                            <a class="btn btn-theme main-custom-btn" href="{{route('frontend.articles.show',$record->slug)}}">{{__('apps::frontend.Learn more')}}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endif
