<x-layout :title="'Azenion — About us'">
    <main class="relative overflow-hidden pt-[120px]">
        <x-page-atmosphere />

        <div class="relative mx-auto max-w-[1320px] px-5 pb-24 sm:px-8 lg:px-12">
            <x-reveal class="mx-auto max-w-3xl text-center">
                <x-eyebrow class="justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="2" x2="22" y1="12" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
                    About Azenion
                </x-eyebrow>
                <h1 class="mt-6 text-[2.5rem] font-semibold leading-[1.08] tracking-tight text-ink-50 sm:text-[3.25rem]">
                    A global network of <span class="text-accent-400">ambitious minds.</span>
                </h1>
                <p class="mt-5 text-[1.05rem] leading-8 text-ink-400">
                    We're building the place where learning, collaboration, and opportunity meet — so the next generation of builders can find each other and create impact that outlasts any single person.
                </p>
            </x-reveal>

            {{-- Mission --}}
            <section class="mt-20" aria-labelledby="mission-heading">
                <x-reveal class="text-center">
                    <h2 id="mission-heading" class="text-[2rem] font-semibold text-ink-50">Our Mission</h2>
                </x-reveal>
                <div class="mt-10 grid gap-5 sm:grid-cols-3">
                    @foreach ([
                        ['👥', 'Connect', 'Bring ambitious people together across institutions, disciplines, and borders.'],
                        ['💻', 'Build', 'Transform ideas into real projects that solve meaningful problems.'],
                        ['🚀', 'Elevate', 'Help members grow personally and professionally through mentorship and opportunity.'],
                    ] as $i => [$icon, $title, $desc])
                        <x-reveal :delay="$i * 80" class="h-full">
                            <div class="group h-full rounded-[1.6rem] card-surface-soft p-7 shadow-card backdrop-blur-xl transition-all duration-500 hover:-translate-y-1.5 hover:border-[rgba(109,109,255,0.4)] hover:shadow-glow-sm">
                                <div class="flex h-12 w-12 items-center justify-center rounded-xl border border-[rgba(109,109,255,0.25)] bg-[rgba(40,40,255,0.08)] text-lg text-accent-300">{{ $icon }}</div>
                                <h3 class="mt-5 text-[1.15rem] font-semibold text-ink-50">{{ $title }}</h3>
                                <p class="mt-2.5 text-sm leading-relaxed text-ink-400">{{ $desc }}</p>
                            </div>
                        </x-reveal>
                    @endforeach
                </div>
            </section>

            {{-- Core values --}}
            <section class="mt-24" aria-labelledby="values-heading">
                <x-reveal class="text-center">
                    <h2 id="values-heading" class="text-[2rem] font-semibold text-ink-50">Core Values</h2>
                    <p class="mx-auto mt-3 max-w-xl text-[1.02rem] text-ink-400">These six values guide every decision we make and every community we build.</p>
                </x-reveal>
                <div class="mt-10 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ([
                        ['🔍', 'Curiosity', 'We ask why, explore deeply, and never stop questioning how things could be better.'],
                        ['👥', 'Collaboration', 'The best work happens when diverse minds come together around a shared purpose.'],
                        ['💡', 'Innovation', 'We challenge convention and create new paths where none existed before.'],
                        ['🏆', 'Excellence', 'We hold ourselves to high standards and take pride in the quality of what we build.'],
                        ['❤️', 'Inclusivity', 'Every voice matters. We build a space where anyone with drive can belong.'],
                        ['📚', 'Continuous Learning', 'Growth is a journey, not a destination. We learn, share, and grow together.'],
                    ] as $i => [$icon, $title, $desc])
                        <x-reveal :delay="$i * 60" class="h-full">
                            <div class="h-full rounded-[1.6rem] card-surface-soft p-7 shadow-card backdrop-blur-xl transition-all duration-500 hover:border-[rgba(109,109,255,0.4)] hover:shadow-glow-sm">
                                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-[rgba(255,255,255,0.04)] text-lg text-accent-400">{{ $icon }}</div>
                                <h3 class="mt-5 text-[1.05rem] font-semibold text-ink-50">{{ $title }}</h3>
                                <p class="mt-2 text-sm leading-relaxed text-ink-400">{{ $desc }}</p>
                            </div>
                        </x-reveal>
                    @endforeach
                </div>
            </section>

            {{-- Who it's for --}}
            <section class="mt-24" aria-labelledby="roles-heading">
                <x-reveal class="text-center">
                    <x-eyebrow class="justify-center">Who it's for</x-eyebrow>
                    <h2 id="roles-heading" class="mt-6 text-[2rem] font-semibold text-ink-50">Built for the builders</h2>
                </x-reveal>
                <div class="mt-10 flex flex-wrap justify-center gap-3">
                    @foreach (['Developers', 'Designers', 'Engineers', 'Entrepreneurs', 'Researchers', 'Students', 'Creators', 'Innovators'] as $role)
                        <span class="rounded-full border border-[rgba(109,109,255,0.25)] bg-[rgba(40,40,255,0.08)] px-4 py-2 text-sm font-medium text-accent-300 transition-all duration-300 hover:shadow-glow-sm">{{ $role }}</span>
                    @endforeach
                </div>
            </section>

            {{-- Ecosystem --}}
            <section class="mt-24" aria-labelledby="ecosystem-about-heading">
                <x-reveal class="text-center">
                    <x-eyebrow class="justify-center">The ecosystem</x-eyebrow>
                    <h2 id="ecosystem-about-heading" class="mt-6 text-[2rem] font-semibold text-ink-50">One network, many ways in</h2>
                </x-reveal>
                <div class="mt-10 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ([
                        ['🌿', 'Branches', 'Local chapters at institutions worldwide — your home base for connection and events.'],
                        ['👥', 'Teams', 'Cross-disciplinary squads formed around projects, ideas, and shared goals.'],
                        ['🧱', 'Projects', 'Hands-on work that matters — from open-source tools to real-world solutions.'],
                        ['📅', 'Events', 'Hackathons, talks, workshops and meetups that spark collaboration and growth.'],
                        ['✨', 'Showcase', 'A platform to share your work, celebrate wins, and inspire the next builder.'],
                        ['📈', 'Growth', 'Resources, mentorship, and pathways that turn potential into lasting impact.'],
                    ] as $i => [$icon, $title, $desc])
                        <x-reveal :delay="$i * 60" class="h-full">
                            <div class="h-full rounded-[1.6rem] card-surface-soft p-7 shadow-card backdrop-blur-xl transition-all duration-500 hover:border-[rgba(109,109,255,0.4)] hover:shadow-glow-sm">
                                <div class="flex h-12 w-12 items-center justify-center rounded-xl border border-[rgba(109,109,255,0.25)] bg-[rgba(40,40,255,0.08)] text-lg text-accent-300">{{ $icon }}</div>
                                <h3 class="mt-5 text-[1.05rem] font-semibold text-ink-50">{{ $title }}</h3>
                                <p class="mt-2 text-sm leading-relaxed text-ink-400">{{ $desc }}</p>
                            </div>
                        </x-reveal>
                    @endforeach
                </div>
            </section>

            <x-reveal class="mt-20 text-center">
                <a href="{{ route('join') }}" class="inline-flex items-center justify-center h-14 rounded-full px-8 text-[16px] font-semibold text-white bg-accent transition-all duration-300 hover:bg-accent-400 hover:shadow-glow">Join the movement</a>
            </x-reveal>
        </div>
    </main>
</x-layout>
