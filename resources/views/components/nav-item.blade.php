@props([
    'route' => null,
    'url_pattern' => null,
])

<a
    href="{{ route($route) }}"
    class="{{
        Request::is($url_pattern)
            ? 'font-semibold text-blue-400 hover:cursor-pointer'
            : 'font-medium text-gray-400 hover:font-semibold hover:text-gray-50'
    }}"
>
    {{ $slot }}
</a>
