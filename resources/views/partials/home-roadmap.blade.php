<section class="relative py-20 sm:py-24 lg:py-28" aria-labelledby="roadmap-heading">
    <div class="mx-auto max-w-[1320px] px-5 sm:px-8 lg:px-12">
        <x-reveal class="mx-auto max-w-2xl text-center">
            <x-eyebrow class="justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="4"/><line x1="21" x2="15.09" y1="12" y2="12"/><line x1="3" x2="8.91" y1="12" y2="12"/></svg>
                Roadmap
            </x-eyebrow>
            <h2 id="roadmap-heading" class="mt-6 text-[2rem] font-semibold leading-[1.08] tracking-tight text-ink-50 sm:text-[2.5rem] lg:text-[2.9rem]">
                Where Azenion is <span class="text-accent-400">heading.</span>
            </h2>
            <p class="mt-4 text-[1.02rem] text-ink-400">A look at what we've shipped and what's coming next.</p>
        </x-reveal>

        <div class="mt-14 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
            @php
                $items = [
                    ['Platform foundation', 'Profiles, authentication and the core building blocks that make Azenion feel like home.', 'Shipped', 'emerald'],
                    ['Community system', 'Branches, teams, projects and the shared feed that keep the network connected.', 'Shipped', 'emerald'],
                    ['Teams & projects', 'Memberships, open roles, recruitment and the collaboration layer between builders.', 'Shipped', 'emerald'],
                    ['Academy expansion', 'Courses, labs and a richer learning experience built around the community.', 'Up next', 'accent'],
                    ['Mobile app', 'Take the network anywhere with a native Azenion experience on your phone.', 'Planned', 'ink'],
                    ['Global community', 'More branches, more regions and a truly limitless network across the world.', 'Planned', 'ink'],
                ];

                $statusColors = [
                    'emerald' => 'bg-emerald-400/15 text-emerald-300 border-emerald-400/25',
                    'accent' => 'bg-accent/15 text-accent-300 border-accent-400/25',
                    'ink' => 'bg-white/5 text-ink-400 border-white/10',
                ];
            @endphp
            @foreach ($items as $i => [$title, $desc, $status, $color])
                <x-reveal :delay="$i * 60" class="h-full">
                    <div class="group relative h-full overflow-hidden rounded-[1.6rem] card-surface-soft p-7 shadow-card backdrop-blur-xl transition-all duration-500 hover:-translate-y-1.5 hover:border-[rgba(109,109,255,0.4)] hover:shadow-glow-sm">
                        <span class="inline-flex items-center rounded-full border px-2.5 py-1 text-[11px] font-semibold uppercase tracking-wider {{ $statusColors[$color] }}">{{ $status }}</span>
                        <h3 class="relative mt-4 text-[1.1rem] font-semibold text-ink-50">{{ $title }}</h3>
                        <p class="relative mt-2.5 text-sm leading-relaxed text-ink-400">{{ $desc }}</p>
                    </div>
                </x-reveal>
            @endforeach
        </div>

        <x-reveal class="mt-10 text-center">
            <p class="text-sm text-ink-500">This roadmap evolves with the community. Have an idea? Share it in a team or branch.</p>
        </x-reveal>
    </div>
</section>
