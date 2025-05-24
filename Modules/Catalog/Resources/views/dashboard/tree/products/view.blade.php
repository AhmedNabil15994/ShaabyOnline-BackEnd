@foreach ($mainCategories as $category)
    <ul>
        @if($category->id != 1)
            <li id="{{$category->id}}" data-jstree='{"opened":true}'>
                {{$category->title}}
                @if($category->children->count() > 0)
                    @include('catalog::dashboard.tree.products.view',['mainCategories' => $category->children])
                @endif
            </li>
        @endif
    </ul>
@endforeach
