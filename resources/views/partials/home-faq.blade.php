<section class="relative py-20 sm:py-24 lg:py-28" aria-labelledby="faq-heading">
    <div class="mx-auto max-w-3xl px-5 sm:px-8 lg:px-12">
        <x-reveal class="text-center">
            <x-eyebrow class="justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><path d="M12 17h.01"/></svg>
                FAQ
            </x-eyebrow>
            <h2 id="faq-heading" class="mt-6 text-[2rem] font-semibold leading-[1.08] tracking-tight text-ink-50 sm:text-[2.5rem] lg:text-[2.9rem]">
                Questions, <span class="text-accent-400">answered.</span>
            </h2>
        </x-reveal>

        @php
            $faqs = [
                ['What is Azenion?', 'Azenion is a network for students, builders and creators. It brings together branches, teams, projects, learning and live sessions so ambitious people can find each other and build together.'],
                ['Who can join?', 'Anyone who wants to learn, collaborate and build. Create a free account, pick a branch or team that fits you, and start contributing at your own pace.'],
                ['Is Azenion free?', 'Yes. Joining, browsing teams and projects, and taking part in the community is free. Academy sessions are open to members of the network.'],
                ['Can I create a team or project?', 'Absolutely. Once you\'re in, you can start your own team, spin up a project, list open roles and start recruiting the right people.'],
                ['How do branches work?', 'Branches are local communities within Azenion. They gather members around a region or a focus area and act as the hub for events, announcements and collaborations.'],
                ['What can I build with Azenion?', 'Almost anything — a study group, an open-source tool, a startup, a creative project or a research team. If you can describe it, you can start it.'],
            ];
        @endphp

        <div class="mt-12 space-y-4">
            @foreach ($faqs as $i => [$q, $a])
                <x-reveal :delay="$i * 40">
                    <details class="group rounded-2xl card-surface-soft overflow-hidden shadow-card backdrop-blur-xl transition-all duration-300 hover:border-[rgba(109,109,255,0.3)]">
                        <summary class="flex cursor-pointer list-none items-center justify-between gap-4 px-6 py-5 text-[15px] font-semibold text-ink-50 selection:bg-transparent">
                            {{ $q }}
                            <span class="shrink-0 text-ink-500 transition-transform duration-300 group-open:rotate-45">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                            </span>
                        </summary>
                        <div class="px-6 pb-5 text-sm leading-7 text-ink-400">{{ $a }}</div>
                    </details>
                </x-reveal>
            @endforeach
        </div>
    </div>
</section>
