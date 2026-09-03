<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">

    <title>{{ $title ?? 'Azenion — Infinite minds. Limitless impact.' }}</title>
    <meta name="description" content="Azenion is a global network connecting ambitious students, developers, designers, entrepreneurs and innovators through learning, collaboration and building impactful projects.">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="overflow-x-hidden">
    <div aria-hidden class="pointer-events-none fixed inset-0 z-[60] bg-[url('/noise.svg')] opacity-[0.025] mix-blend-overlay"></div>

    @isset($navbar)
        @if ($navbar)
            <x-navbar />
        @endif
    @else
        <x-navbar />
    @endisset

    {{ $slot }}

    @isset($footer)
        @if ($footer)
            <x-footer />
        @endif
    @else
        <x-footer />
    @endisset

    @stack('scripts')
</body>
</html>
