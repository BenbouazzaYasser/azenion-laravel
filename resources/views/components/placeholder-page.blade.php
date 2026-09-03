@props(['eyebrow', 'title', 'titleAccent' => '', 'description' => '', 'icon' => '🚀'])

<main class="relative overflow-hidden pt-[120px]">
    <x-page-atmosphere />
    <div class="relative mx-auto max-w-[1320px] px-5 pb-24 sm:px-8 lg:px-12">
        <x-reveal class="mx-auto max-w-3xl text-center">
            <x-eyebrow class="justify-center">{{ $eyebrow }}</x-eyebrow>
            <h1 class="mt-6 text-[2.5rem] font-semibold leading-[1.08] tracking-tight text-ink-50 sm:text-[3.25rem]">
                {{ $title }} @if($titleAccent)<span class="text-accent-400">{{ $titleAccent }}</span>@endif
            </h1>
            @if ($description)
                <p class="mt-5 text-[1.05rem] leading-8 text-ink-400">{{ $description }}</p>
            @endif
        </x-reveal>

        <x-reveal class="mt-20">
            <div class="rounded-[2rem] card-surface-soft p-12 text-center shadow-card backdrop-blur-xl">
                <div aria-hidden class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl border border-[rgba(109,109,255,0.25)] bg-[rgba(40,40,255,0.1)] text-2xl text-accent-300">{{ $icon }}</div>
                <h3 class="mt-6 text-xl font-semibold text-ink-50">{{ $slot }}</h3>
            </div>
        </x-reveal>
    </div>
</main>
