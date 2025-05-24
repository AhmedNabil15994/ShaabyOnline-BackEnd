@foreach ($mainVendorCategories as $category)
<ul>
    <li id="{{$category->id}}" data-jstree='{"opened":true
		{{ ($vendor->categories->contains($category->id)) ? ',"selected":true' : ''  }} }'>
        {{$category->getTranslation('title', locale())}}
        @if($category->children->count() > 0)
        @include('vendor::dashboard.tree.vendors.edit',['mainVendorCategories' => $category->children])
        @endif
    </li>
</ul>
@endforeach