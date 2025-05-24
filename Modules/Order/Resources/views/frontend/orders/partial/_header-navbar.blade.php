<div class="process-links user-links text-center d-flex mb-40 mt-30">

    @if(auth()->user())

        <a href="{{ route('frontend.profile.index') }}"
           class="d-inline-block {{ url()->current() == route('frontend.profile.index') ? 'active' : '' }}"
           data-toggle="tooltip"
           data-placement="top" title="{{ __('user::frontend.profile.index.update') }}"><i
                    class="ti-user"></i>
        </a>

        <a href="{{ route('frontend.profile.address.index') }}"
           class="d-inline-block {{ url()->current() == route('frontend.profile.address.index') ? 'active' : '' }}"
           data-toggle="tooltip"
           data-placement="top" title=" عناويني"><i class="ti-map-alt"></i>
        </a>

    @endif

    <a href="{{ route('frontend.orders.index') }}"
       class="d-inline-block {{ url()->current() == route('frontend.orders.index') ? 'active' : '' }}"
       data-toggle="tooltip"
       data-placement="top" title="{{ __('apps::frontend.master.my_orders') }}">
        <i class="ti-truck"></i>
    </a>

</div>