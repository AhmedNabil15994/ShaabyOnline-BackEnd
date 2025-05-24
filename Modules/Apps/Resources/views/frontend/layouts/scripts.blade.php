<!-- Start JS FILES -->
<!-- JQuery -->
<script src="{{ url('frontend/js/jquery.min.js') }}"></script>
<script src="{{ url('frontend/js/jquery-ui.min.js') }}"></script>
<script src="{{ url('frontend/js/popper.min.js') }}"></script>
<!-- Bootstrap -->
<script src="{{ url('frontend/js/bootstrap.min.js') }}"></script>
<!-- Wow Animation -->
<script src="{{ url('frontend/js/wow.min.js') }}"></script>
<!-- Owl Coursel -->
<script src="{{ url('frontend/js/owl.carousel.min.js') }}"></script>
<!-- Smooth Product -->
<script src="{{ url('frontend/js/smoothproducts.min.js') }}"></script>
<!-- Select 2 -->
<script src="{{ url('frontend/js/select2.min.js') }}"></script>

<script src="{{ url('frontend/plugins/live-search/jquery.autocomplete.js') }}"></script>

<!-- Google map -->
<script src="https://maps.google.com/maps/api/js?key=AIzaSyBkdsK7PWcojsO-o_q2tmFOLBfPGL8k8Vg&amp;language=en"></script>
<!-- Main Script -->

<script type="text/javascript" src="{{ url('frontend/custom/scripts/jquery.noty.packaged.min.js') }}"></script>

@if (locale() == 'ar')
    <script src="{{ url('frontend/js/script-ar.js') }}"></script>
@else
    <script src="{{ url('frontend/js/script-en.js') }}"></script>
@endif

{{-- <script src="{{ url('frontend/js/main-actions.js') }}"></script> --}}

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

@include('apps::frontend.layouts._js')

{{-- Start - Bind Js Code From Dashboard Daynamic --}}
{!! config('setting.custom_codes.js_before_body') ?? null !!}
{{-- End - Bind Js Code From Dashboard Daynamic --}}

@yield('externalJs')
