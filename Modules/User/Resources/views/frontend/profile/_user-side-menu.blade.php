<div class="user-side-menu">
    <h4>{{ __('user::frontend.profile.index.my_account') }}</h4>
    <ul>

        @if(auth()->user())
            <li class="{{ url()->current() == route('frontend.profile.index') ? 'active' : '' }}">
                <a href="{{ route('frontend.profile.index') }}">
                    <i class="ti-user"></i> {{ __('user::frontend.profile.index.title') }}
                </a>
            </li>
            <li class="{{ url()->current() == route('frontend.orders.index') ? 'active' : '' }}">
                <a href="{{ route('frontend.orders.index') }}">
                    <i class="ti-truck"></i> {{ __('user::frontend.profile.index.my_orders') }}
                </a>
            </li>
            <li class="{{ url()->current() == route('frontend.profile.favourites.index') ? 'active' : '' }}">
                <a href="{{ route('frontend.profile.favourites.index') }}">
                    <i class="ti-heart"></i> {{ __('user::frontend.profile.index.favourites') }}
                </a>
            </li>
            <li class="{{ url()->current() == route('frontend.profile.address.index') || url()->current() == route('frontend.profile.address.create') ? 'active' : '' }}">
                <a href="{{ route('frontend.profile.address.index') }}">
                    <i class="ti-map-alt"></i> {{ __('user::frontend.profile.index.addresses') }}
                </a>
            </li>
            <li class="">
                <a onclick="event.preventDefault();document.getElementById('logout').submit();"
                   href="javascript:;">
                    <i class="ti-lock"></i> {{ __('user::frontend.profile.index.logout') }}
                </a>
                <form id="logout" action="{{ route('frontend.logout') }}" method="POST">
                    @csrf
                </form>
            </li>
        @else
            @if(env('LOGIN'))
                <li class="{{ url()->current() == route('frontend.login') ? 'active' : '' }}">
                    <a href="{{ route('frontend.login') }}">
                        <i class="ti-user"></i> {{ __('authentication::frontend.login.title') }}
                    </a>
                </li>
            @endif
            <li class="{{ url()->current() == route('frontend.orders.index') ? 'active' : '' }}">
                <a href="{{ route('frontend.orders.index') }}">
                    <i class="ti-truck"></i> {{ __('user::frontend.profile.index.my_orders') }}
                </a>
            </li>
        @endif
    </ul>
</div>
