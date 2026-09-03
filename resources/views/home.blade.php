<x-layout>
    <main id="main" class="relative overflow-hidden">
        <x-page-atmosphere />

        {{-- Hero --}}
        <section class="relative pt-[88px] sm:pt-[104px] lg:pt-[120px]">
            <div class="pointer-events-none absolute inset-x-0 top-0 h-[640px] opacity-40 lg:hidden">
                <div class="absolute inset-0 bg-[radial-gradient(circle_at_30%_20%,rgba(40,40,255,0.20),transparent_36%),radial-gradient(circle_at_75%_25%,rgba(255,255,255,0.08),transparent_28%)]"></div>
                <div class="absolute inset-0 bg-gradient-to-b from-transparent via-void-950/40 to-void-950"></div>
            </div>

            <div class="relative mx-auto grid w-full max-w-[1320px] grid-cols-1 items-center gap-16 px-5 pb-24 pt-6 sm:px-8 sm:pt-10 lg:pb-32 lg:px-12 lg:pt-10">
                <div class="relative z-10 max-w-xl">
                    <x-reveal>
                        <x-eyebrow>
                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-accent-400"><circle cx="12" cy="12" r="10"/><path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"/><path d="M2 12h20"/></svg>
                            The Limitless Network
                        </x-eyebrow>
                    </x-reveal>

                    <x-reveal :delay="80">
                        <h1 class="mt-6 text-[2.75rem] font-semibold leading-[1.08] tracking-tight text-ink-50 text-balance sm:text-[3.4rem] lg:text-[3.75rem]">
                            Infinite minds.<br />
                            Limitless<span class="text-accent-400"> impact.</span>
                        </h1>
                    </x-reveal>

                    <x-reveal :delay="160">
                        <p class="mt-6 text-[1.05rem] leading-relaxed text-ink-400">
                            The Limitless Network brings ambitious minds together through learning, collaboration and innovation.<br class="hidden sm:block" />
                            Together, we build. Together, we elevate.
                        </p>
                    </x-reveal>

                    <x-reveal :delay="240">
                        <div class="mt-8 flex flex-col gap-3 sm:flex-row sm:items-center">
                            <a href="{{ route('join') }}" class="inline-flex items-center justify-center h-12 rounded-full px-6 text-[15px] font-semibold text-white bg-accent transition-all duration-300 hover:bg-accent-400 hover:shadow-glow">
                                Join the Network
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="ml-2"><path d="M7 17 17 7"/><path d="M7 7h10v10"/></svg>
                            </a>
                            <a href="{{ route('projects') }}" class="inline-flex items-center justify-center h-12 rounded-full px-6 text-[15px] font-medium text-ink-200 border border-border bg-[rgba(255,255,255,0.04)] transition-all duration-300 hover:bg-surface-hover hover:text-ink-50">
                                Explore Projects
                            </a>
                        </div>
                    </x-reveal>

                    <x-reveal :delay="320">
                        <div class="relative mt-6">
                            <div aria-hidden class="absolute -inset-x-4 -inset-y-6 rounded-[2rem] bg-[rgba(40,40,255,0.14)] blur-[60px]"></div>
                            <div class="relative rounded-[1.6rem] card-surface-soft p-5 shadow-card backdrop-blur-xl">
                                <p class="text-sm font-medium text-ink-50">Quick overview</p>
                                <p class="mt-2 text-sm leading-6 text-ink-400">Azenion connects learners, builders, and innovators in one global community to create opportunities and grow together.</p>
                            </div>
                        </div>
                    </x-reveal>

                    <div class="mt-12 hidden items-center gap-3 sm:flex">
                        <span class="flex h-8 w-5 items-start justify-center rounded-full p-1.5">
                            <span class="h-1.5 w-1.5 animate-scroll-dot rounded-full bg-accent-400"></span>
                        </span>
                        <span class="text-xs font-medium uppercase tracking-[0.14em] text-ink-600">Scroll to explore</span>
                    </div>
                </div>

                <div class="pointer-events-none absolute inset-0 hidden lg:block overflow-visible">
                    <div class="absolute end-[2%] top-[0%] aspect-[800/520] w-[44rem] translate-y-[10%] opacity-95">
                        <x-infinity-art class="absolute inset-0 h-full w-full" />
                    </div>
                </div>
            </div>
        </section>

        {{-- Why Azenion --}}
        <section class="relative py-20 sm:py-24 lg:py-28" aria-labelledby="why-azenion-heading">
            <div class="mx-auto max-w-[1320px] px-5 sm:px-8 lg:px-12">
                <div class="grid gap-12 lg:grid-cols-[1fr_1.05fr] lg:gap-16">
                    <x-reveal>
                        <div class="lg:sticky lg:top-32">
                            <x-eyebrow>
                                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="16" y="16" width="6" height="6" rx="1"/><rect x="2" y="16" width="6" height="6" rx="1"/><rect x="9" y="2" width="6" height="6" rx="1"/><path d="M5 16v-3a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3"/></svg>
                                Why Azenion
                            </x-eyebrow>
                            <h2 id="why-azenion-heading" class="mt-6 text-[2rem] font-semibold leading-[1.08] tracking-tight text-ink-50 text-balance sm:text-[2.5rem] lg:text-[2.9rem]">
                                Not just another learning platform.<span class="text-accent-400"> A network.</span>
                            </h2>
                            <p class="mt-5 max-w-xl text-[1.02rem] leading-8 text-ink-400">
                                Most platforms give you content and leave you alone. Azenion gives you a community — ambitious students connecting through branches, teams and projects, pushing each other to build meaningful work.
                            </p>
                            <p class="mt-4 max-w-xl text-[1.02rem] leading-8 text-ink-400">
                                The belief is simple: collaboration beats competition, and talent grows fastest when it is connected to other talent.
                            </p>
                            <a href="{{ route('join') }}" class="inline-flex items-center mt-8 h-12 rounded-full px-6 text-[15px] font-semibold text-white bg-accent transition-all duration-300 hover:bg-accent-400 hover:shadow-glow">Join the movement</a>
                        </div>
                    </x-reveal>

                    <div class="grid gap-5 sm:grid-cols-2">
                        @foreach ([
                            ['🌐', 'A network, not a platform', 'Azenion is a living community. When you join, you plug into a web of ambitious people across branches, teams and projects — not a catalog of courses.'],
                            ['🤝', 'Collaboration over competition', 'We believe exceptional people are built together. Azenion rewards sharing, mentoring and building in the open instead of competing in silence.'],
                            ['🚀', 'For ambitious students', 'Built for students who refuse to wait to be discovered. The network exists to connect you with the people and opportunities that accelerate your growth.'],
                            ['⛓️', 'One continuous journey', 'Learn a skill, find your community, collaborate on a project, and turn it into impact. Every part of Azenion feeds the next.'],
                        ] as $i => [$icon, $title, $desc])
                            <x-reveal :delay="$i * 80" class="h-full">
                                <div class="group relative h-full overflow-hidden rounded-[1.6rem] card-surface-soft p-6 shadow-card backdrop-blur-xl transition-all duration-500 hover:-translate-y-1.5 hover:border-[rgba(109,109,255,0.4)] hover:shadow-glow-sm sm:p-7">
                                    <div class="pointer-events-none absolute -inset-x-4 -inset-y-4 rounded-[1.6rem] bg-[radial-gradient(circle_at_50%_0%,rgba(40,40,255,0.07),transparent_60%)] opacity-0 transition-opacity duration-500 group-hover:opacity-100"></div>
                                    <div class="relative flex h-11 w-11 items-center justify-center rounded-xl border border-[rgba(109,109,255,0.25)] bg-[rgba(40,40,255,0.08)] text-base text-accent-300 transition-all duration-300 group-hover:-translate-y-1 group-hover:shadow-glow-sm">{{ $icon }}</div>
                                    <h3 class="relative mt-5 text-[1.05rem] font-semibold text-ink-50">{{ $title }}</h3>
                                    <p class="relative mt-2.5 text-sm leading-relaxed text-ink-400">{{ $desc }}</p>
                                </div>
                            </x-reveal>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="mx-auto mt-[0.875rem] max-w-[1320px] px-5 sm:px-8 lg:mt-[1.5rem] lg:px-12">
                <x-reveal>
                    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                        @foreach ([
                            ['🎓', 'Learn', 'Grow through courses, sessions and shared knowledge.'],
                            ['👥', 'Collaborate', 'Build with people who push your work further.'],
                            ['💡', 'Innovate', 'Turn ideas into real products and lasting projects.'],
                            ['📈', 'Elevate', 'Rise together and carry the network forward.'],
                        ] as [$icon, $title, $desc])
                            <div class="group relative overflow-hidden rounded-[1.4rem] card-surface-soft p-5 shadow-card backdrop-blur-xl transition-all duration-500 hover:-translate-y-1.5 hover:shadow-glow-sm">
                                <div class="pointer-events-none absolute -inset-x-4 -inset-y-4 rounded-[1.6rem] bg-[radial-gradient(circle_at_50%_0%,rgba(40,40,255,0.07),transparent_60%)] opacity-0 transition-opacity duration-500 group-hover:opacity-100"></div>
                                <div aria-hidden class="pointer-events-none absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-accent-300/50 to-transparent opacity-0 transition-opacity duration-500 group-hover:opacity-100"></div>
                                <div class="relative flex items-center gap-4">
                                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl border border-[rgba(109,109,255,0.25)] bg-[rgba(40,40,255,0.08)] text-sm text-accent-300 transition-all duration-300 group-hover:-translate-y-0.5 group-hover:shadow-glow-sm">{{ $icon }}</span>
                                    <div class="min-w-0">
                                        <p class="text-[15px] font-semibold text-ink-50">{{ $title }}</p>
                                        <p class="mt-0.5 line-clamp-2 text-xs leading-relaxed text-ink-500">{{ $desc }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </x-reveal>
            </div>
        </section>

        {{-- About --}}
        <section class="relative py-20 sm:py-24 lg:py-28" aria-labelledby="about-heading">
            <div class="mx-auto max-w-[1320px] px-5 sm:px-8 lg:px-12">
                <x-reveal class="mx-auto max-w-5xl rounded-[2rem] card-surface-soft p-8 shadow-card backdrop-blur-xl sm:p-10 lg:p-14">
                    <div class="grid gap-10 lg:grid-cols-[1.15fr_0.85fr] lg:gap-12">
                        <div>
                            <x-eyebrow>
                                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3v2"/><path d="m5.05 5 1.41 1.41"/><path d="M3 12h2"/><path d="m7.5 4.5-1.41 1.41"/><path d="M12 21c-4 0-6-2-6-6 0-3 2-5 4-6 0-1 1-2 2-2s2 1 2 2c2 1 4 3 4 6"/></svg>
                                About Azenion
                            </x-eyebrow>
                            <h2 id="about-heading" class="mt-6 text-balance text-[2rem] font-semibold leading-[1.08] tracking-tight text-ink-50 sm:text-[2.5rem] lg:text-[2.9rem]">We are building a place where ambition can become movement.</h2>
                            <p class="mt-5 max-w-2xl text-[1.02rem] leading-8 text-ink-400">Azenion exists to give exceptional people a stronger way to grow. We connect learning, collaboration, and opportunity in one network so talent is not left waiting for chance to find it.</p>
                            <p class="mt-4 max-w-2xl text-[1.02rem] leading-8 text-ink-400">Our mission is simple: make it easier for ambitious minds to build meaningful work, shape lasting communities, and contribute to a future that is larger than any one individual.</p>
                        </div>
                        <div class="flex flex-col justify-between rounded-[1.4rem] bg-void-950/70 p-6 sm:p-7">
                            <div>
                                <p class="text-sm font-medium uppercase tracking-[0.16em] text-ink-600">Why join</p>
                                <ul class="mt-5 space-y-3 text-sm leading-7 text-ink-400">
                                    @foreach ([
                                        'Find a community that values depth, initiative, and long-term growth.',
                                        'Access opportunities shaped by people who are building with intention.',
                                        'Help define the next era of global connection and collective progress.',
                                    ] as $item)
                                        <li class="flex gap-3">
                                            <span class="mt-2 h-1.5 w-1.5 shrink-0 rounded-full bg-accent-400"></span>
                                            {{ $item }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <a href="{{ route('join') }}" class="inline-flex items-center justify-center mt-6 h-12 rounded-full px-6 text-[15px] font-semibold text-white bg-accent transition-all duration-300 hover:bg-accent-400 hover:shadow-glow sm:w-auto">Join the movement</a>
                        </div>
                    </div>
                </x-reveal>
            </div>
        </section>

        {{-- Ecosystem --}}
        @include('partials.home-ecosystem')

        {{-- How It Works --}}
        @include('partials.home-how-it-works')

        {{-- Features --}}
        <section class="relative py-16 sm:py-20 lg:py-24" aria-labelledby="features-heading">
            <h2 id="features-heading" class="sr-only">What Azenion gives you</h2>
            <div class="mx-auto max-w-[1320px] px-5 sm:px-8 lg:px-12">
                <div class="grid grid-cols-1 divide-y divide-border sm:grid-cols-2 sm:divide-y-0 lg:grid-cols-4 lg:divide-x">
                    @foreach ([
                        ['👥', 'Connect', 'Join a global network of students, builders, and innovators from diverse institutions.'],
                        ['⛓️', 'Collaborate', 'Form teams, share ideas, and build projects that solve real problems together.'],
                        ['🚀', 'Innovate', 'Access resources, events, and opportunities that fuel your growth and ambition.'],
                        ['✨', 'Elevate', 'Showcase your work, celebrate milestones, and inspire the next generation of builders.'],
                    ] as $i => [$icon, $title, $desc])
                        <div class="group relative px-1 py-10 transition-colors duration-300 sm:px-7 sm:py-12 lg:first:pl-0 lg:last:pr-0">
                            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-[rgba(255,255,255,0.04)] text-lg text-accent-400 transition-all duration-300 group-hover:-translate-y-1 group-hover:scale-[1.02] group-hover:border-[rgba(109,109,255,0.4)] group-hover:bg-[rgba(40,40,255,0.06)] group-hover:shadow-glow-sm">{{ $icon }}</div>
                            <h3 class="mt-5 text-[1.05rem] font-semibold text-ink-50">{{ $title }}</h3>
                            <p class="mt-2.5 max-w-[24ch] text-[0.9rem] leading-relaxed text-ink-400">{{ $desc }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- Community Numbers --}}
        @include('partials.home-numbers')

        {{-- Roadmap --}}
        @include('partials.home-roadmap')

        {{-- FAQ --}}
        @include('partials.home-faq')

        {{-- Final CTA --}}
        @include('partials.home-final-cta')
    </main>
</x-layout>
