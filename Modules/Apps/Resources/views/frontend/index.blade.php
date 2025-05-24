@extends('apps::frontend.layouts.master')
@section('title', __('apps::frontend.home.title'))
@section('meta_description', config('setting.app_description.' . locale()) ?? '')
@section('meta_keywords', '')
@section('content')
    <div id="home-content">
        {!! $home_sections !!}
    </div>
@endsection
