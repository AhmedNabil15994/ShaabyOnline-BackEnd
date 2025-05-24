@component('mail::message')

  <h2> <center> {{ __('authentication::api.reset.mail.header') }} </center> </h2>

  @component('mail::button', [
    'url' => url(route('frontend.password.reset',$token['token']). '?email=' . $token['user']->email)
  ])

    {{ __('authentication::api.reset.mail.button_content') }}

  @endcomponent

@endcomponent
