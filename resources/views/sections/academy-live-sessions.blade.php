<x-layout :title="'Live Sessions | Azenion Academy'">
    <main class="relative overflow-hidden pt-[120px]">
        <x-page-atmosphere />
        <div class="relative mx-auto max-w-[1320px] px-5 pb-24 sm:px-8 lg:px-12">
            <x-reveal class="mx-auto max-w-3xl text-center">
                <x-eyebrow class="justify-center">Interactive Learning</x-eyebrow>
                <h1 class="mt-6 text-[2.5rem] font-semibold leading-[1.08] tracking-tight text-ink-50 sm:text-[3.25rem]">
                    Live <span class="text-accent-400">Sessions.</span>
                </h1>
                <p class="mt-5 text-[1.05rem] leading-8 text-ink-400">Join live workshops, Q&A sessions, and masterclasses hosted by expert engineers and founders.</p>
            </x-reveal>

            <div class="mt-16 grid gap-6 sm:grid-cols-2 lg:grid-cols-2">
                @forelse($sessions ?? [] as $session)
                    <x-reveal class="h-full">
                        <div class="h-full flex flex-col justify-between rounded-[1.6rem] card-surface-soft p-8 shadow-card backdrop-blur-xl">
                            <div>
                                <span class="rounded-full bg-accent/10 px-3 py-1 text-xs font-medium text-accent-300">{{ $session->scheduled_at->format('M d, Y - H:i') }}</span>
                                <h3 class="mt-4 text-xl font-semibold text-ink-50">{{ $session->title }}</h3>
                                <p class="mt-2 text-sm leading-relaxed text-ink-400">{{ $session->description }}</p>
                            </div>
                            <div class="mt-6 pt-4 border-t border-ink-800 flex items-center justify-between">
                                <span class="text-xs text-ink-450">{{ $session->registered_count }} registered</span>
                                @auth
                                    <form action="{{ route('academy.live-sessions.register', $session->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="rounded-full bg-accent px-5 py-2 text-xs font-semibold text-white hover:bg-accent-400 shadow-glow">Register</button>
                                    </form>
                                @else
                                    <a href="{{ route('join') }}" class="text-xs font-semibold text-accent-300 hover:underline">Join to Register</a>
                                @endauth
                            </div>
                        </div>
                    </x-reveal>
                @empty
                    <div class="col-span-full py-16 text-center text-ink-400">No upcoming live sessions scheduled.</div>
                @endforelse
            </div>
        </div>
    </main>
</x-layout>
