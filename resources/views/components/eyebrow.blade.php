@props(['className' => ''])

<span class="inline-flex items-center gap-2 rounded-full border border-[rgba(40,40,255,0.25)] bg-[rgba(40,40,255,0.08)] px-3 py-1.5 text-[12px] font-medium uppercase tracking-[0.18em] text-accent-300 {{ $className }}">
    {{ $slot }}
</span>
