@props(['withWordmark' => true, 'markSize' => 28, 'wordmarkClassName' => ''])

<a href="{{ route('home') }}" aria-label="Azenion — home" data-no-translate translate="no" dir="ltr" class="group inline-flex items-center gap-2.5 transition-opacity duration-200 hover:opacity-90">
    <svg viewBox="0 0 512 512" width="{{ $markSize }}" height="{{ $markSize }}" role="img" aria-hidden="true" class="shrink-0">
        <path d="M96 256C96 170 192 170 256 256C320 342 416 342 416 256C416 170 320 170 256 256C192 342 96 342 96 256Z" fill="none" stroke="#2828ff" stroke-width="32" stroke-linecap="round" stroke-linejoin="round" style="fill:none;stroke:#2828ff;stroke-opacity:1;" />
    </svg>
    @if ($withWordmark)
        <span data-no-translate translate="no" dir="ltr" class="font-semibold tracking-tight text-ink-50 {{ $wordmarkClassName }}" style="font-family: 'Proxima Nova', 'Inter', ui-sans-serif, system-ui, sans-serif;">AZENION</span>
    @endif
</a>
