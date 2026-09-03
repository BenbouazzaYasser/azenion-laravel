<x-layout :title="'Servers | Azenion'">
    <main class="relative overflow-hidden pt-[120px]">
        <x-page-atmosphere />
        <div class="relative mx-auto max-w-[1320px] px-5 pb-24 sm:px-8 lg:px-12">
            <x-reveal class="mx-auto max-w-3xl text-center">
                <x-eyebrow class="justify-center">Real-Time Community</x-eyebrow>
                <h1 class="mt-6 text-[2.5rem] font-semibold leading-[1.08] tracking-tight text-ink-50 sm:text-[3.25rem]">
                    Servers & <span class="text-accent-400">Voice Channels.</span>
                </h1>
                <p class="mt-5 text-[1.05rem] leading-8 text-ink-400">
                    Jump into topic-based servers, collaborative study rooms, and voice channels to connect with peers in real-time.
                </p>
                @auth
                    <div x-data="{ open: false }" class="mt-8">
                        <button @click="open = true" class="inline-flex items-center justify-center h-12 rounded-full px-6 text-[15px] font-semibold text-white bg-accent transition-all duration-300 hover:bg-accent-400 hover:shadow-glow">Create Server</button>
                        
                        <template x-teleport="body">
                            <div x-show="open" class="fixed inset-0 z-50 flex items-center justify-center bg-black/80 p-4" style="display: none;">
                                <div @click.outside="open = false" style="background-color: #050507;" class="w-full max-w-lg rounded-[2rem] p-8 text-left shadow-2xl border border-ink-800">
                                    <h3 class="text-xl font-semibold text-ink-50">Create a New Server</h3>
                                    <form action="{{ route('servers.store') }}" method="POST" class="mt-6 space-y-4">
                                        @csrf
                                        <div>
                                            <label class="block text-sm font-medium text-ink-300">Server Name</label>
                                            <input type="text" name="name" required class="mt-1 w-full rounded-xl bg-ink-900/50 border-2 border-ink-700 px-4 py-3 text-ink-50 placeholder-ink-600 transition-all focus:border-accent-400 focus:shadow-[0_0_0_2px_rgba(109,109,255,0.25)] focus:outline-none">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-ink-300">Description</label>
                                            <textarea name="description" rows="3" class="mt-1 w-full rounded-xl bg-ink-900/50 border-2 border-ink-700 px-4 py-3 text-ink-50 placeholder-ink-600 transition-all focus:border-accent-400 focus:shadow-[0_0_0_2px_rgba(109,109,255,0.25)] focus:outline-none"></textarea>
                                        </div>
                                        <div class="flex justify-end gap-3 pt-4">
                                            <button type="button" @click="open = false" class="rounded-xl px-5 py-2.5 text-sm font-medium text-ink-300 hover:bg-ink-800">Cancel</button>
                                            <button type="submit" class="rounded-xl bg-accent px-5 py-2.5 text-sm font-semibold text-white hover:bg-accent-400">Create</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </template>
                    </div>
                @endauth
            </x-reveal>

            <div class="mt-16 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @forelse ($servers ?? [] as $server)
                    <x-reveal class="h-full">
                        <div class="h-full flex flex-col justify-between rounded-[1.6rem] card-surface-soft p-7 shadow-card backdrop-blur-xl transition-all duration-500 hover:-translate-y-1.5 hover:border-[rgba(109,109,255,0.4)] hover:shadow-glow-sm">
                            <div>
                                <span class="rounded-full bg-accent/10 px-3 py-1 text-xs font-medium text-accent-300">{{ ucfirst($server->category) }}</span>
                                <h3 class="mt-4 text-xl font-semibold text-ink-50">{{ $server->name }}</h3>
                                <p class="mt-2 text-sm leading-relaxed text-ink-400 line-clamp-3">{{ $server->description ?? 'No description provided.' }}</p>
                            </div>
                            <div class="mt-6 pt-4 border-t border-ink-800 flex items-center justify-between">
                                <span class="text-xs text-ink-450">{{ $server->members_count ?? $server->members->count() }} members</span>
                                <a href="{{ route('servers.show', $server->id) }}" class="inline-flex items-center text-sm font-medium text-accent-300 hover:text-accent-400">Open Server &rarr;</a>
                            </div>
                        </div>
                    </x-reveal>
                @empty
                    <div class="col-span-full py-16 text-center text-ink-400">
                        No servers found. Create one to get started!
                    </div>
                @endforelse
            </div>
        </div>
    </main>
</x-layout>
