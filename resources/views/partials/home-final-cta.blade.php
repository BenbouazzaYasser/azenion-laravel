<section class="relative py-20 sm:py-24 lg:py-28" aria-labelledby="final-cta-heading">
    <div class="mx-auto max-w-[1320px] px-5 sm:px-8 lg:px-12">
        <x-reveal>
            <div class="relative overflow-hidden rounded-[2rem] card-surface-soft p-10 text-center shadow-card backdrop-blur-xl sm:p-14 lg:p-20">
                <div aria-hidden class="pointer-events-none absolute inset-0 bg-[radial-gradient(circle_at_50%_0%,rgba(40,40,255,0.12),transparent_60%)]"></div>
                <div aria-hidden class="pointer-events-none absolute -top-16 left-1/2 h-56 w-56 -translate-x-1/2 rounded-full bg-[rgba(40,40,255,0.25)] blur-[80px]"></div>

                <div class="relative">
                    <x-eyebrow class="justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/></svg>
                        Join the network
                    </x-eyebrow>
                    <h2 id="final-cta-heading" class="mt-6 text-[2rem] font-semibold leading-[1.08] tracking-tight text-ink-50 sm:text-[2.5rem] lg:text-[3.25rem]">
                        Ready to build something <span class="text-accent-400">limitless?</span>
                    </h2>
                    <p class="mx-auto mt-5 max-w-xl text-[1.02rem] leading-8 text-ink-400">
                        Your community, your teams, your projects are waiting. Join Azenion and start building alongside people who push you further.
                    </p>
                    <div class="mt-9 flex flex-col items-center justify-center gap-3 sm:flex-row">
                        <a href="{{ route('join') }}" class="inline-flex items-center justify-center h-14 rounded-full px-8 text-[16px] font-semibold text-white bg-accent transition-all duration-300 hover:bg-accent-400 hover:shadow-glow">Join Now</a>
                        <a href="{{ route('feed') }}" class="inline-flex items-center justify-center h-14 rounded-full px-8 text-[16px] font-medium text-ink-200 border border-border bg-[rgba(255,255,255,0.04)] transition-all duration-300 hover:bg-surface-hover hover:text-ink-50">Explore the Platform</a>
                    </div>
                </div>
            </div>
        </x-reveal>
    </div>
</section>
