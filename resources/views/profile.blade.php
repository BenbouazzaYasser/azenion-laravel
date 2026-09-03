<x-layout :title="'Profile | Azenion'">
    <main class="relative overflow-hidden pt-[120px]">
        <x-page-atmosphere />

        <div class="relative mx-auto max-w-[900px] px-5 pb-24 sm:px-8 lg:px-12">
            <x-reveal>
                <div class="rounded-[2rem] card-surface-soft p-8 shadow-card backdrop-blur-xl sm:p-10">
                    <div class="flex flex-col items-center gap-6 sm:flex-row sm:items-start">
                        <div class="relative shrink-0">
                            <div aria-hidden class="absolute -inset-2 rounded-full bg-[rgba(40,40,255,0.35)] blur-xl"></div>
                            <div class="relative flex h-24 w-24 items-center justify-center overflow-hidden rounded-full bg-gradient-to-br from-accent-500 to-accent-400 text-3xl font-semibold text-white shadow-[0_0_24px_-8px_rgba(109,109,255,0.5)]">
                                {{ strtoupper(substr($user->profile?->full_name ?? $user->name, 0, 1)) }}
                            </div>
                            <span class="absolute -bottom-0.5 -right-0.5 flex h-4 w-4 items-center justify-center rounded-full border border-void-900 bg-emerald-400 shadow-[0_0_8px_rgba(52,211,153,0.6)]"></span>
                        </div>

                        <div class="min-w-0 text-center sm:text-left">
                            <h1 class="text-2xl font-semibold tracking-tight text-ink-50">
                                {{ $user->profile?->full_name ?? $user->name }}
                            </h1>
                            <p class="mt-1 text-sm text-ink-500">
                                @if ($user->profile?->username)
                                    @username
                                @else
                                    {{ $user->email }}
                                @endif
                            </p>
                            @if ($user->profile?->institution)
                                <p class="mt-2 inline-flex items-center gap-1.5 text-sm text-ink-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 10 12 5 2 10l10 5 10-5z"/><path d="M6 12v5c0 1.7 2.7 3 6 3s6-1.3 6-3v-5"/></svg>
                                    {{ $user->profile->institution }}
                                </p>
                            @endif
                            @if ($user->profile?->bio)
                                <p class="mt-3 max-w-lg text-sm leading-6 text-ink-400">{{ $user->profile->bio }}</p>
                            @endif
                        </div>
                    </div>

                    @if ($user->profile?->skills)
                        <div class="mt-8 border-t border-border pt-6">
                            <h3 class="text-xs font-semibold uppercase tracking-[0.16em] text-ink-600">Skills</h3>
                            <div class="mt-3 flex flex-wrap gap-2">
                                @foreach ((array) $user->profile->skills as $skill)
                                    <span class="rounded-full border border-[rgba(109,109,255,0.25)] bg-[rgba(40,40,255,0.08)] px-3 py-1 text-xs font-medium text-accent-300">{{ $skill }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <div class="mt-8 border-t border-border pt-6">
                        <h3 class="text-xs font-semibold uppercase tracking-[0.16em] text-ink-600">Member of Azenion</h3>
                        <p class="mt-2 text-sm text-ink-500">Member since {{ $user->created_at->format('F Y') }}</p>
                    </div>
                </div>
            </x-reveal>
        </div>
    </main>
</x-layout>
