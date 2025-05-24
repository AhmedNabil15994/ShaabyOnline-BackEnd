@foreach ($mainCategories as $category)
<ul>
	<li id="{{$category->id}}" data-jstree='{"opened":true
		{{ ($product->categories->contains($category->id)) ? ',"selected":true' : ''  }} }'>
		{{$category->title}}
		@if($category->children->count() > 0)
			@include('catalog::dashboard.tree.products.edit',['mainCategories' => $category->children])
		@endif
	</li>
</ul>
@endforeach
