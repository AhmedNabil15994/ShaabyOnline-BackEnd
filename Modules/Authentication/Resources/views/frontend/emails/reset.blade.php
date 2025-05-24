@component('mail::message')

<h2> <center> {{ __('authentication::frontend.reset.mail.header') }} </center> </h2>

@component('mail::button', [
  'url' => $customUrl
])

  {{ __('authentication::frontend.reset.mail.button_content') }}

@endcomponent


@endcomponent
