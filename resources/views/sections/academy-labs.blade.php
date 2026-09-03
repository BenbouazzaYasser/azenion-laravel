<x-layout :title="'Labs | Azenion Academy'">
    <main class="relative overflow-hidden pt-[120px]">
        <x-page-atmosphere />
        <div class="relative mx-auto max-w-[1320px] px-5 pb-24 sm:px-8 lg:px-12">
            <x-reveal class="mx-auto max-w-3xl text-center">
                <x-eyebrow class="justify-center">Hands-on Practice</x-eyebrow>
                <h1 class="mt-6 text-[2.5rem] font-semibold leading-[1.08] tracking-tight text-ink-50 sm:text-[3.25rem]">
                    Coding <span class="text-accent-400">Labs.</span>
                </h1>
                <p class="mt-5 text-[1.05rem] leading-8 text-ink-400">Test your skills with real coding challenges, algorithms, and system design exercises.</p>
            </x-reveal>

            <div class="mt-16 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @forelse($labs ?? [] as $lab)
                    <x-reveal class="h-full">
                        <div class="h-full flex flex-col justify-between rounded-[1.6rem] card-surface-soft p-7 shadow-card backdrop-blur-xl">
                            <div>
                                <div class="flex items-center justify-between">
                                    <span class="rounded-full bg-accent/10 px-3 py-1 text-xs font-medium text-accent-300">{{ ucfirst($lab->difficulty) }}</span>
                                    <span class="text-xs text-ink-400">{{ ucfirst($lab->category) }}</span>
                                </div>
                                <h3 class="mt-4 text-xl font-semibold text-ink-50">{{ $lab->title }}</h3>
                                <p class="mt-2 text-sm leading-relaxed text-ink-400 line-clamp-3">{{ $lab->description }}</p>
                            </div>
                            <div class="mt-6 pt-4 border-t border-ink-800 flex items-center justify-between">
                                <span class="text-xs text-ink-450">{{ $lab->submissions_count ?? 0 }} submissions</span>
                                <a href="{{ route('academy.labs.show', $lab->id) }}" class="text-sm font-semibold text-accent-300 hover:underline">Start Lab &rarr;</a>
                            </div>
                        </div>
                    </x-reveal>
                @empty
                    <div class="col-span-full py-16 text-center text-ink-400">No coding labs available.</div>
                @endforelse
            </div>
        </div>
    </main>
</x-layout>
