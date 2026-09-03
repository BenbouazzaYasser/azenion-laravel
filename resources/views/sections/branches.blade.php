<x-layout :title="'Branches | Azenion'">
    <main class="relative overflow-hidden pt-[120px]">
        <x-page-atmosphere />
        <div class="relative mx-auto max-w-[1320px] px-5 pb-24 sm:px-8 lg:px-12">
            <x-reveal class="mx-auto max-w-3xl text-center">
                <x-eyebrow class="justify-center">Global Presence</x-eyebrow>
                <h1 class="mt-6 text-[2.5rem] font-semibold leading-[1.08] tracking-tight text-ink-50 sm:text-[3.25rem]">
                    Azenion Chapters <span class="text-accent-400">Around the World.</span>
                </h1>
                <p class="mt-5 text-[1.05rem] leading-8 text-ink-400">
                    Connect with local innovators, attend in-person meetups, and build regional impact through our official university and city branches.
                </p>
            </x-reveal>

            <div class="mt-16 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @forelse ($branches ?? [] as $branch)
                    <x-reveal class="h-full">
                        <div class="h-full flex flex-col justify-between rounded-[1.6rem] card-surface-soft p-7 shadow-card backdrop-blur-xl transition-all duration-500 hover:-translate-y-1.5 hover:border-[rgba(109,109,255,0.4)] hover:shadow-glow-sm">
                            <div>
                                <span class="rounded-full bg-accent/10 px-3 py-1 text-xs font-medium text-accent-300">{{ $branch->city ?? 'Global' }}</span>
                                <h3 class="mt-4 text-xl font-semibold text-ink-50">{{ $branch->name }}</h3>
                                <p class="mt-2 text-sm leading-relaxed text-ink-400 line-clamp-3">{{ $branch->description ?? 'Official Azenion branch.' }}</p>
                            </div>
                            <div class="mt-6 pt-4 border-t border-ink-800 flex items-center justify-between">
                                <span class="text-xs text-ink-450">{{ $branch->members_count ?? 0 }} members</span>
                                <a href="{{ route('branches.show', $branch->id) }}" class="inline-flex items-center text-sm font-medium text-accent-300 hover:text-accent-400">View Branch &rarr;</a>
                            </div>
                        </div>
                    </x-reveal>
                @empty
                    <div class="col-span-full py-16 text-center text-ink-400">
                        No branches currently listed.
                    </div>
                @endforelse
            </div>
        </div>
    </main>
</x-layout>
