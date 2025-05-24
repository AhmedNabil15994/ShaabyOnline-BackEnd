@if(count($products))
    @foreach($products as $product)
        <div class="col-md-4 col-6">
            @include('catalog::frontend.products.components.single-product',compact('product'))
        </div>
    @endforeach

    <div class="clearfix"></div>
    <div class="col-lg-12">
        @include('apps::frontend.components.paginator.paginator',
        ['paginator' => $products , 'getMoreRoute' => route('frontend.categories.products' , !empty($category) ? $category->slug : null)])
    </div>
@else
    <div class="alert alert-danger col-lg-12 text-center" role="alert" style="margin-top: 10rem">
        {{isset($error_message) ? $error_message : 'no results to show'}}
    </div>
@endif
