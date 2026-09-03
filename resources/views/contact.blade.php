<x-layout :title="'Azenion — Contact'">
    <main class="relative overflow-hidden pt-[120px]">
        <x-page-atmosphere />

        <div class="relative mx-auto max-w-[1320px] px-5 pb-24 sm:px-8 lg:px-12">
            <x-reveal class="mx-auto max-w-2xl text-center">
                <x-eyebrow class="justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                    Contact
                </x-eyebrow>
                <h1 class="mt-6 text-[2.5rem] font-semibold leading-[1.08] tracking-tight text-ink-50 sm:text-[3.25rem]">
                    Let's <span class="text-accent-400">connect.</span>
                </h1>
                <p class="mt-5 text-[1.05rem] leading-8 text-ink-400">
                    Reach out directly — we read every message. Whether you have a question, an idea, or want to bring Azenion to your campus, we'd love to hear from you.
                </p>
            </x-reveal>

            <div class="mx-auto mt-14 grid max-w-5xl gap-5 sm:grid-cols-2">
                @foreach ([
                    ['✉️', 'Email', 'Reach out directly — we read every message.', 'Azenion@outlook.com', 'mailto:Azenion@outlook.com', 'Email us'],
                    ['💬', 'Discord', 'Join the conversation in our community server.', 'discord.gg/3As5ndwwh', 'https://discord.gg/3As5ndwwh', 'Join Discord'],
                    ['in', 'LinkedIn', 'Follow us for updates, stories, and opportunities.', 'linkedin.com/company/azenion', 'https://www.linkedin.com/company/azenion', 'Follow'],
                    ['GH', 'GitHub', 'Explore our open-source projects and contribute.', 'github.com/azenion', 'https://github.com/azenion', 'Contribute'],
                ] as $i => [$icon, $title, $desc, $detail, $href, $cta])
                    <x-reveal :delay="$i * 60" class="h-full">
                        <a href="{{ $href }}" target="{{ Str::startsWith($href, 'mailto') ? '' : '_blank' }}" class="group flex h-full flex-col rounded-[1.6rem] card-surface-soft p-7 shadow-card backdrop-blur-xl transition-all duration-500 hover:-translate-y-1.5 hover:border-[rgba(109,109,255,0.4)] hover:shadow-glow-sm">
                            <div class="flex h-12 w-12 items-center justify-center rounded-xl border border-[rgba(109,109,255,0.25)] bg-[rgba(40,40,255,0.08)] text-base font-semibold text-accent-300">{{ $icon }}</div>
                            <h3 class="mt-5 text-[1.1rem] font-semibold text-ink-50">{{ $title }}</h3>
                            <p class="mt-2 text-sm leading-relaxed text-ink-400">{{ $desc }}</p>
                            <p class="mt-2 truncate text-xs text-ink-600">{{ $detail }}</p>
                            <span class="mt-6 inline-flex items-center gap-1.5 text-sm font-medium text-accent-300 transition-all duration-300 group-hover:gap-2.5">
                                {{ $cta }}
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M7 17 17 7"/><path d="M7 7h10v10"/></svg>
                            </span>
                        </a>
                    </x-reveal>
                @endforeach
            </div>
        </div>
    </main>
</x-layout>
