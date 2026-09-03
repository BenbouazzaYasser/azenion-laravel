@props(['className' => ''])

<div class="pointer-events-none absolute inset-0 overflow-hidden {{ $className }}" aria-hidden>
    <div class="absolute inset-0 bg-[radial-gradient(circle_at_50%_0%,rgba(40,40,255,0.10),transparent_60%)]"></div>
    <div class="absolute -top-24 left-1/2 -translate-x-1/2 opacity-[0.06] animate-[drift-slow_240s_linear_infinite]">
        <svg width="1200" height="1200" viewBox="0 0 200 200" fill="none" class="text-accent-400" style="animation: bg-infinity-scale 120s ease-in-out infinite;">
            <path d="M100 20C63 20 33 50 33 87c0 20 10 37 25 48C153 71 175 118 175 87c0-37-30-67-75-67Z" stroke="currentColor" stroke-width="0.6"/>
            <path d="M100 180C137 180 167 150 167 113c0-20-10-37-25-48C47 129 25 82 25 113c0 37 30 67 75 67Z" stroke="currentColor" stroke-width="0.6"/>
        </svg>
    </div>
    <div class="absolute inset-0 bg-gradient-to-b from-transparent via-void-950/40 to-void-950"></div>
</div>
