 <ul class="list-unstyled list-inline col-sm-6" id="legal">
    @foreach ($footerMenu['items'] as $item)
        @if (isset($item['action']))
            @if ($item['type'] === 'link')
                <li><a href="{{ $item['action'] }}">{{ $item['label'] }}</a></li> |
            @elseif ($item['type'] === 'route')
                <li><a href="{{ route($item['action']) }}">{{ $item['label'] }}</a></li> |
            @elseif ($item['type'] === 'page')
                <li><a href="{{ url($item['action']) }}">{{ $item['label'] }}</a></li> |
            @endif
        @endif
    @endforeach
    <li><a href="{{ route('contact') }}">{{ trans('main.contact') }}</a></li>
</ul>