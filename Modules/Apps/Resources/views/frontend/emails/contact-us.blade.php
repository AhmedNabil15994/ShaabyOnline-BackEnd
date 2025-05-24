@component('mail::message')

<h2> <center> {{ __('apps::frontend.contact_us.mail.header') }} </center> </h2>


<ul>
  <li>Username : {{ $request['username'] }}</li>
  <li>Mobile : {{ $request['mobile'] }}</li>
  <li>Email : {{ $request['email'] }}</li>
  <li>Message : {{ $request['message'] }}</li>
</ul>


@endcomponent
