@extends('apps::frontend.layouts.master')
@section('title', $page->title)
@section('content')

    <div class="container">
        <div class="page-crumb mt-30">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('frontend.home') }}">
                            <i class="ti-home"></i> {{ __('apps::frontend.master.home') }}</a>
                    </li>
                    <li class="breadcrumb-item active text-muted"
                        aria-current="page">{{ $page->title }}</li>
                </ol>
            </nav>
        </div>
        <div class="inner-page">
            <div class="single-page">
                <h1>{{ $page->title }}</h1>
                {!! $page->description !!}
            </div>

        </div>
    </div>

@endsection

@section('externalJs')

    <script></script>

@endsection