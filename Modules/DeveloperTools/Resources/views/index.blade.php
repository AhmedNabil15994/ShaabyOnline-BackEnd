@extends('developertools::layouts.app')
@section('title', __('developertools::developer.home.title') )
@section('content')

    <div class="page-content-wrapper">
        <div class="page-content">

            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <a href="{{ url(route('developer.home')) }}">{{ __('developertools::developer.home.title') }}</a>
                    </li>
                </ul>
            </div>

            <h1 class="page-title"> {{ __('developertools::developer.home.welcome_message') }} ,
                <small><b style="color:red">{{ Auth::user()->name }} </b></small>
            </h1>

        </div>
    </div>
@stop