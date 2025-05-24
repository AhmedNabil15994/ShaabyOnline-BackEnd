<ul class="submenu dropdown-menu nsted">

    @foreach ($children as $k => $category)
        @php $children = $category->children; @endphp

        <li class="menu-item menu-item-has-children {{ count($children) > 0 ? 'arrowleft' : '' }}">
            <a href="{{ route('frontend.categories.products', $category->slug) }}" class="dropdown-toggle">
                {{ $category->title }} </a>
            <span class="toggle-submenu hidden-mobile"></span>

            @if (count($children))
                @include('apps::frontend.layouts._nested_categories', [
                    'children' => $children,
                ])
            @endif

        </li>
    @endforeach

</ul>
