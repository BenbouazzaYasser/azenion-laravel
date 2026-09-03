@props(['className' => '', 'idPrefix' => 'hero'])
@php
    $path = "M80 260C80 88 272 88 400 260C528 432 720 432 720 260C720 88 528 88 400 260C272 432 80 432 80 260Z";
    $gradId = "{$idPrefix}-core-glow";
    $fadeId = "{$idPrefix}-field-fade";
    $maskId = "{$idPrefix}-field-mask";
    $blurLg = "{$idPrefix}-blur-lg";
    $blurMd = "{$idPrefix}-blur-md";
    $blurSm = "{$idPrefix}-blur-sm";

    // Deterministic particle points
    $stars = [
        [147.5, 98.8, 1.45, 0.5, 0], [304.8, 273.8, 1.11, 0.45, 0], [528.4, 99.2, 0.99, 0.37, 0],
        [638.5, 293.9, 1.61, 0.5, 0], [159.3, 108.6, 0.99, 0.31, 0], [585.3, 377.9, 0.65, 0.22, 0],
        [145.9, 387.1, 0.66, 0.59, 1], [451.4, 226.7, 0.9, 0.3, 1], [114, 131.3, 0.82, 0.46, 0],
        [456.9, 230.8, 1.01, 0.62, 0], [548.4, 22.7, 0.61, 0.29, 0], [104.2, 135, 0.83, 0.28, 0],
        [126.5, 381.4, 1.1, 0.44, 0], [456.3, 27.8, 0.63, 0.3, 0], [179.4, 146.8, 1.08, 0.48, 0],
        [598.7, 444.3, 0.58, 0.63, 0], [250.9, 205.8, 1.41, 0.61, 0], [514.6, 302.9, 1.03, 0.34, 1],
        [301.1, 329.8, 1.57, 0.34, 0], [148.5, 94.8, 1.04, 0.6, 0], [47.8, 16.1, 1.03, 0.51, 0],
        [548.1, 191.6, 1.31, 0.41, 0], [540.9, 55.1, 1.35, 0.18, 0], [333.9, 358.1, 1.18, 0.47, 0],
        [554, 242.6, 1.4, 0.29, 0], [339.9, 458.6, 0.55, 0.27, 0], [557.4, 464.5, 0.91, 0.62, 0],
        [302.9, 468.3, 1.45, 0.35, 0], [408.4, 58.1, 0.78, 0.53, 0], [394.3, 46.4, 1.16, 0.32, 1]
    ];
@endphp

<svg
   viewBox="0 0 800 520"
   fill="none"
   xmlns="http://www.w3.org/2000/svg"
   overflow="visible"
   class="{{ $className }}"
   role="img"
   aria-label="A giant infinity symbol formed from glowing light and cosmic dust"
>
    <defs>
        <radialGradient
           id="{{ $gradId }}"
           cx="400"
           cy="260"
           r="340"
           gradientUnits="userSpaceOnUse"
        >
            <stop offset="0%" stop-color="#FFFFFF" />
            <stop offset="16%" stop-color="#C7CCFF" />
            <stop offset="42%" stop-color="#6D6DFF" />
            <stop offset="78%" stop-color="#2828FF" />
            <stop offset="100%" stop-color="#2828FF" stop-opacity="0.35" />
        </radialGradient>

        <radialGradient id="{{ $fadeId }}" cx="50%" cy="50%" r="62%">
            <stop offset="0%" stop-color="#FFFFFF" />
            <stop offset="100%" stop-color="#FFFFFF" stop-opacity="0" />
        </radialGradient>
        <mask id="{{ $maskId }}">
            <rect width="800" height="520" fill="url(#{{ $fadeId }})" />
        </mask>

        <filter id="{{ $blurLg }}" x="-60%" y="-60%" width="220%" height="220%">
            <feGaussianBlur stdDeviation="30" />
        </filter>
        <filter id="{{ $blurMd }}" x="-60%" y="-60%" width="220%" height="220%">
            <feGaussianBlur stdDeviation="14" />
        </filter>
        <filter id="{{ $blurSm }}" x="-60%" y="-60%" width="220%" height="220%">
            <feGaussianBlur stdDeviation="4" />
        </filter>
    </defs>

    {{-- Ambient nebula wash --}}
    <ellipse cx="250" cy="290" rx="260" ry="170" fill="#2828FF" opacity="0.07" filter="url(#{{ $blurLg }})" />
    <ellipse cx="210" cy="310" rx="130" ry="90" fill="#FFD9B3" opacity="0.035" filter="url(#{{ $blurLg }})" />

    {{-- Drifting star field --}}
    <g mask="url(#{{ $maskId }})" class="animate-drift-slow" style="transform-origin: 400px 260px;">
        @foreach ($stars as $i => [$x, $y, $r, $o, $warm])
            <circle
               cx="{{ $x }}"
               cy="{{ $y }}"
               r="{{ $r }}"
               fill="{{ $warm ? '#FFD9B3' : '#EAF0FF' }}"
               opacity="{{ $o }}"
               class="origin-center animate-twinkle"
               style="animation-delay: {{ ($i % 7) * 0.6 }}s; animation-duration: {{ 5 + ($i % 5) }}s;"
            />
        @endforeach
    </g>

    {{-- Soft volumetric glow --}}
    <path
       d="{{ $path }}"
       stroke="#2828FF"
       stroke-width="48"
       stroke-linecap="round"
       stroke-linejoin="round"
       opacity="0.12"
       filter="url(#{{ $blurLg }})"
       class="animate-pulse-glow"
       style="animation-delay: 0s;"
    />
    <path
       d="{{ $path }}"
       stroke="#4747FF"
       stroke-width="26"
       stroke-linecap="round"
       stroke-linejoin="round"
       opacity="0.2"
       filter="url(#{{ $blurMd }})"
       class="animate-pulse-glow"
       style="animation-delay: 1.5s;"
    />

    {{-- Crisp core line --}}
    <path
       d="{{ $path }}"
       stroke="url(#{{ $gradId }})"
       stroke-width="5"
       stroke-linecap="round"
       stroke-linejoin="round"
       filter="url(#{{ $blurSm }})"
       class="animate-pulse-glow"
       style="animation-delay: 0.8s;"
    />
    <path
       d="{{ $path }}"
       stroke="url(#{{ $gradId }})"
       stroke-width="2"
       stroke-linecap="round"
       stroke-linejoin="round"
    />
</svg>
