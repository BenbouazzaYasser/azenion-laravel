<section class="relative py-20 sm:py-24 lg:py-28" aria-labelledby="ecosystem-heading">
    <div class="mx-auto max-w-[1320px] px-5 sm:px-8 lg:px-12">
        <x-reveal class="mx-auto max-w-2xl text-center">
            <x-eyebrow class="justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18"/><path d="M9 21V9"/></svg>
                The Ecosystem
            </x-eyebrow>
            <h2 id="ecosystem-heading" class="mt-6 text-[2rem] font-semibold leading-[1.08] tracking-tight text-ink-50 sm:text-[2.5rem] lg:text-[2.9rem]">
                Six ways to <span class="text-accent-400">go further.</span>
            </h2>
            <p class="mt-4 text-[1.02rem] text-ink-400">Every part of Azenion is designed to move you forward — explore the ecosystem and find where you belong.</p>
        </x-reveal>

        <div class="mt-14 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
            @php
                $items = [
                    ['branch', 'Branches', 'Campus hubs that anchor the network — events, mentorship and a home for every region.', 'Explore branches', route('branches')],
                    ['team', 'Teams', 'Small, focused crews building products, startups and research together.', 'Explore teams', route('teams')],
                    ['project', 'Projects', 'Real-world builds with clear goals, collaborators and momentum.', 'Explore projects', route('projects')],
                    ['academy', 'Academy', 'Courses, live sessions and labs that turn curiosity into capability.', 'Visit academy', route('academy')],
                    ['feed', 'Feed', 'The pulse of the network — updates, announcements and moments from every community.', 'Open feed', route('feed')],
                    ['showcase', 'Showcase', 'A curated stage for the best work the community is proud to share.', 'View showcase', route('showcase')],
                ];
            @endphp
            @foreach ($items as $i => [$key, $title, $desc, $cta, $href])
                <a href="{{ $href }}" class="group relative overflow-hidden rounded-[1.6rem] card-surface-soft p-7 shadow-card backdrop-blur-xl transition-all duration-500 hover:-translate-y-1.5 hover:border-[rgba(109,109,255,0.4)] hover:shadow-glow-sm">
                    <div class="pointer-events-none absolute -inset-x-4 -inset-y-4 rounded-[1.6rem] bg-[radial-gradient(circle_at_50%_0%,rgba(40,40,255,0.07),transparent_60%)] opacity-0 transition-opacity duration-500 group-hover:opacity-100"></div>
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl border border-[rgba(109,109,255,0.25)] bg-[rgba(40,40,255,0.08)] text-accent-300 transition-all duration-300 group-hover:shadow-glow-sm">
                        <span class="text-lg">{{ substr($key, 0, 1) }}</span>
                    </div>
                    <h3 class="relative mt-5 text-[1.15rem] font-semibold text-ink-50">{{ $title }}</h3>
                    <p class="relative mt-2.5 text-sm leading-relaxed text-ink-400">{{ $desc }}</p>
                    <span class="relative mt-5 inline-flex items-center gap-1.5 text-sm font-medium text-accent-300 transition-all duration-300 group-hover:gap-2.5">
                        {{ $cta }}
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M7 17 17 7"/><path d="M7 7h10v10"/></svg>
                    </span>
                </a>
            @endforeach
        </div>
    </div>
</section>
