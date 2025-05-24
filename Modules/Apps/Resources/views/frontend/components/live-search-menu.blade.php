@if (count($results))
    @foreach ($results as $record)
        <div onclick="redirectToUrl('{{ $record['url'] }}')">{{ $record['title'] }}</div>
    @endforeach
@else
    <center>{{ __('apps::frontend.home.no_results') }}</center>
@endif
