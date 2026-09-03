<x-layout :title="'Announcements | Azenion'">
    <main class="relative overflow-hidden pt-[120px]">
        <x-page-atmosphere />
        <div class="relative mx-auto max-w-[1000px] px-5 pb-24 sm:px-8">
            <x-reveal class="text-center">
                <x-eyebrow class="justify-center">Network News</x-eyebrow>
                <h1 class="mt-6 text-[2.5rem] font-semibold leading-[1.08] tracking-tight text-ink-50 sm:text-[3.25rem]">
                    Official <span class="text-accent-400">Announcements.</span>
                </h1>
                <p class="mt-4 text-[1.05rem] text-ink-400">Stay up to date with platform releases, events, and community milestones.</p>
            </x-reveal>

            <div class="mt-12 space-y-6">
                @forelse ($announcements ?? [] as $announcement)
                    <x-reveal>
                        <div class="rounded-[1.6rem] card-surface-soft p-8 shadow-card backdrop-blur-xl">
                            <div class="flex items-center justify-between">
                                <span class="rounded-full bg-accent/10 px-3 py-1 text-xs font-medium text-accent-300">{{ ucfirst($announcement->category) }}</span>
                                <span class="text-xs text-ink-400">{{ $announcement->created_at->format('M d, Y') }}</span>
                            </div>
                            <h2 class="mt-4 text-2xl font-semibold text-ink-50">{{ $announcement->title }}</h2>
                            <p class="mt-4 text-base leading-relaxed text-ink-300 whitespace-pre-line">{{ $announcement->body }}</p>
                        </div>
                    </x-reveal>
                @empty
                    <div class="py-16 text-center text-ink-400">
                        No announcements published yet.
                    </div>
                @endforelse
            </div>
        </div>
    </main>
</x-layout>
