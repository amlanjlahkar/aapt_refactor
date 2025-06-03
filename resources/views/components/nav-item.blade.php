@props([
    'route' => null,
    'params' => [],
    'url_pattern' => null,
    /*
     * The active property can be used to create non-functional placeholder links.
     * Currently it's also being used to prevent regeneration of resources which
     * may cause issues in certain scenarios, e.g. when a user is in the middle of
     * form filling process, in which case a retrigger will present them with a
     * new view
     */
    'active' => true,
])

@php
    if (Request::is($url_pattern)) {
        $active = false;
        $class = 'font-semibold text-blue-400 hover:cursor-pointer';
    } else {
        $class = 'font-medium text-gray-400 hover:font-semibold hover:text-gray-50';
    }
@endphp

<a href="{{ $active ? route($route, $params) : '#' }}" class="{{ $class }}">
    {{ $slot }}
</a>
