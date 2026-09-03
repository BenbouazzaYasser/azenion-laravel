<section class="relative py-20 sm:py-24 lg:py-28" aria-labelledby="how-heading">
    <div class="mx-auto max-w-[1320px] px-5 sm:px-8 lg:px-12">
        <x-reveal class="mx-auto max-w-2xl text-center">
            <x-eyebrow class="justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/></svg>
                How it works
            </x-eyebrow>
            <h2 id="how-heading" class="mt-6 text-[2rem] font-semibold leading-[1.08] tracking-tight text-ink-50 sm:text-[2.5rem] lg:text-[2.9rem]">
                Four steps from <span class="text-accent-400">newcomer to builder.</span>
            </h2>
            <p class="mt-4 text-[1.02rem] text-ink-400">The path into Azenion is simple. Once you start, the network does the heavy lifting.</p>
        </x-reveal>

        <div class="mt-14 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
            @php
                $steps = [
                    ['01', 'Join', 'Create your free account and step into the network. Your profile is your entry point.'],
                    ['02', 'Find your community', 'Browse branches, teams and projects until you find the people and missions that match you.'],
                    ['03', 'Collaborate', 'Join a team or project, share updates, and build alongside people who push you further.'],
                    ['04', 'Build impact', 'Ship real work, grow your reputation, and help the network build something larger than any one person.'],
                ];
            @endphp
            @foreach ($steps as $i => [$num, $title, $desc])
                <x-reveal :delay="$i * 80" class="h-full">
                    <div class="group relative h-full overflow-hidden rounded-[1.6rem] card-surface-soft p-6 shadow-card backdrop-blur-xl transition-all duration-500 hover:-translate-y-1.5 hover:border-[rgba(109,109,255,0.4)] hover:shadow-glow-sm">
                        <div class="relative flex items-center justify-between">
                            <span class="text-4xl font-bold tracking-tight text-[rgba(255,255,255,0.06)] transition-colors duration-500 group-hover:text-[rgba(109,109,255,0.15)]">{{ $num }}</span>
                            <span class="flex h-9 w-9 items-center justify-center rounded-full border border-[rgba(109,109,255,0.3)] bg-[rgba(40,40,255,0.08)] text-sm font-semibold text-accent-300">{{ $i + 1 }}</span>
                        </div>
                        <h3 class="relative mt-5 text-[1.1rem] font-semibold text-ink-50">{{ $title }}</h3>
                        <p class="relative mt-2.5 text-sm leading-relaxed text-ink-400">{{ $desc }}</p>
                    </div>
                </x-reveal>
            @endforeach
        </div>
    </div>
</section>
