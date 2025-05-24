@foreach ($mainVendorCategories as $cat)
@if ($category->id != $cat->id)
<ul>
    <li id="{{$cat->id}}"
        data-jstree='{"opened":true @if ($category->vendor_category_id == $cat->id),"selected":true @endif }'>
        {{$cat->getTranslation('title', locale())}}
        @if($cat->children->count() > 0)
        @include('vendor::dashboard.tree.categories.edit',['mainVendorCategories' => $cat->children])
        @endif
    </li>
</ul>
@endif
@endforeach