@foreach ($mainVendorCategories as $category)
<ul>
    <li id="{{$category->id}}" data-jstree='{"opened":true}'>
        {{$category->getTranslation('title', locale())}}
        @if($category->children->count() > 0)
        @include('vendor::dashboard.tree.categories.view',['mainVendorCategories' => $category->children])
        @endif
    </li>
</ul>
@endforeach