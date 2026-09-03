@props(['delay' => 0])

<div
    {{ $attributes->merge(['class' => 'reveal']) }}
    @if ($delay) data-delay="{{ $delay }}" @endif
>
    {{ $slot }}
</div>
