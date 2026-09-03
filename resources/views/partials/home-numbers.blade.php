<section class="relative py-16 sm:py-20 lg:py-24" aria-labelledby="numbers-heading">
    <div class="mx-auto max-w-[1320px] px-5 sm:px-8 lg:px-12">
        <x-reveal class="mx-auto max-w-2xl text-center">
            <x-eyebrow class="justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                The numbers
            </x-eyebrow>
            <h2 id="numbers-heading" class="mt-6 text-[2rem] font-semibold leading-[1.08] tracking-tight text-ink-50 sm:text-[2.5rem] lg:text-[2.9rem]">
                A network that keeps <span class="text-accent-400">growing.</span>
            </h2>
        </x-reveal>

        <div class="mt-12 grid grid-cols-2 gap-4 lg:grid-cols-4">
            @php
                $stats = [
                    ['Members', 0],
                    ['Teams', 0],
                    ['Projects', 0],
                    ['Branches', 0],
                ];
            @endphp
            @foreach ($stats as $i => [$label, $value])
                <x-reveal :delay="$i * 60" class="h-full">
                    <div class="group rounded-[1.6rem] card-surface-soft p-8 text-center shadow-card backdrop-blur-xl transition-all duration-500 hover:border-[rgba(109,109,255,0.4)] hover:shadow-glow-sm">
                        <p class="text-[2.5rem] font-semibold tracking-tight text-ink-50 transition-colors duration-300 group-hover:text-accent-300">{{ number_format($value) }}</p>
                        <p class="mt-2 text-sm font-medium uppercase tracking-[0.14em] text-ink-600 group-hover:text-ink-400">{{ $label }}</p>
                    </div>
                </x-reveal>
            @endforeach
        </div>
    </div>
</section>
