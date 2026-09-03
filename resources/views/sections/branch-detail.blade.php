<x-layout :title="$branch->name . ' | Azenion Branches'">
    <main class="relative overflow-hidden pt-[120px]">
        <x-page-atmosphere />
        <div class="relative mx-auto max-w-[1000px] px-5 pb-24 sm:px-8">
            <x-reveal class="rounded-[2rem] card-surface-soft p-8 sm:p-12 shadow-card backdrop-blur-xl">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6">
                    <div>
                        <span class="rounded-full bg-accent/10 px-3 py-1 text-xs font-medium text-accent-300">{{ $branch->city ?? 'Branch' }}</span>
                        <h1 class="mt-4 text-3xl font-semibold text-ink-50 sm:text-4xl">{{ $branch->name }}</h1>
                        <p class="mt-2 text-sm text-ink-400">{{ $branch->full_name ?? $branch->name }}</p>
                    </div>
                    @auth
                        @php $isMember = $branch->members->contains('user_id', auth()->id()); @endphp
                        @if($isMember)
                            <form action="{{ route('branches.leave', $branch->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="rounded-full bg-red-500/10 border border-red-500/30 px-6 py-2.5 text-sm font-semibold text-red-400 hover:bg-red-500/20">Leave Branch</button>
                            </form>
                        @else
                            <form action="{{ route('branches.join', $branch->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="rounded-full bg-accent px-6 py-2.5 text-sm font-semibold text-white hover:bg-accent-400 shadow-glow">Join Branch</button>
                            </form>
                        @endif
                    @endauth
                </div>

                <div class="mt-8 border-t border-ink-800 pt-8">
                    <h2 class="text-lg font-semibold text-ink-50">About Branch</h2>
                    <p class="mt-3 text-base leading-relaxed text-ink-300">{{ $branch->description ?? 'No description provided.' }}</p>
                </div>

                <div class="mt-10 border-t border-ink-800 pt-8">
                    <h2 class="text-lg font-semibold text-ink-50">Branch Members ({{ $branch->members->count() }})</h2>
                    <div class="mt-4 grid gap-3 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach($branch->members as $member)
                            <div class="flex items-center gap-3 rounded-xl bg-ink-900/40 p-3 border border-ink-800">
                                <div class="h-10 w-10 rounded-full bg-accent/20 flex items-center justify-center text-accent-300 font-bold">
                                    {{ substr($member->user->profile->full_name ?? $member->user->name, 0, 1) }}
                                </div>
                                <div>
                                    <div class="text-sm font-semibold text-ink-50">{{ $member->user->profile->full_name ?? $member->user->name }}</div>
                                    <div class="text-xs text-ink-400 capitalize">{{ $member->role }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </x-reveal>
        </div>
    </main>
</x-layout>
