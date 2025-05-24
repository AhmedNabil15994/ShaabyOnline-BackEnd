@foreach ($mainCategories as $category)
<ul>
		<li id="{{$category->id}}" data-jstree='{"opened":true}'>
				{{$category->title}}
				@if($category->children->count() > 0)
						@include('catalog::vendor.tree.products.view',['mainCategories' => $category->children])
				@endif
		</li>
</ul>
@endforeach
