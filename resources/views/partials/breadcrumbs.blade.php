<link rel="stylesheet" href="{{ asset('css/breadcrumbs.css')}}"/>
@unless ($breadcrumbs->isEmpty())
<div id="crumbs">
    <ul>
        @foreach ($breadcrumbs as $breadcrumb)
            @if (!is_null($breadcrumb->url) && !$loop->last)
                <li><a href="{{ $breadcrumb->url }}">{{ $breadcrumb->title }}</a></li>
            @else
                <li><a></i> {{ $breadcrumb->title }}</a></li>
            @endif
        @endforeach
    </ul>
</div>
@endunless
