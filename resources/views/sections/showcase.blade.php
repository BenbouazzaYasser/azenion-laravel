<x-layout :title="'Showcase | Azenion'">
    <main class="relative overflow-hidden pt-[120px]">
        <x-page-atmosphere />
        <div class="relative mx-auto max-w-[1320px] px-5 pb-24 sm:px-8 lg:px-12">
            <x-reveal class="mx-auto max-w-3xl text-center">
                <x-eyebrow class="justify-center">Project Showcase</x-eyebrow>
                <h1 class="mt-6 text-[2.5rem] font-semibold leading-[1.08] tracking-tight text-ink-50 sm:text-[3.25rem]">
                    Built by <span class="text-accent-400">Azenion Innovators.</span>
                </h1>
                <p class="mt-5 text-[1.05rem] leading-8 text-ink-400">
                    Explore real-world apps, tools, and creations built by members of the Limitless Network.
                </p>
                @auth
                    <div x-data="{ open: false }" class="mt-8">
                        <button @click="open = true" class="inline-flex items-center justify-center h-12 rounded-full px-6 text-[15px] font-semibold text-white bg-accent transition-all duration-300 hover:bg-accent-400 hover:shadow-glow">Submit Project</button>
                        
                        <template x-teleport="body">
                            <div x-show="open" class="fixed inset-0 z-50 flex items-center justify-center bg-black/80 p-4" style="display: none;">
                                <div @click.outside="open = false" style="background-color: #050507;" class="w-full max-w-lg rounded-[2rem] p-8 text-left shadow-2xl border border-ink-800">
                                    <h3 class="text-xl font-semibold text-ink-50">Submit to Showcase</h3>
                                    <form action="{{ route('showcase.store') }}" method="POST" class="mt-6 space-y-4">
                                        @csrf
                                        <div>
                                            <label class="block text-sm font-medium text-ink-300">Title</label>
                                            <input type="text" name="title" required class="mt-1 w-full rounded-xl bg-ink-900/50 border-2 border-ink-700 px-4 py-3 text-ink-50 placeholder-ink-600 transition-all focus:border-accent-400 focus:shadow-[0_0_0_2px_rgba(109,109,255,0.25)] focus:outline-none">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-ink-300">Description</label>
                                            <textarea name="description" rows="3" required class="mt-1 w-full rounded-xl bg-ink-900/50 border-2 border-ink-700 px-4 py-3 text-ink-50 placeholder-ink-600 transition-all focus:border-accent-400 focus:shadow-[0_0_0_2px_rgba(109,109,255,0.25)] focus:outline-none"></textarea>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-ink-300">Live URL</label>
                                            <input type="url" name="live_url" class="mt-1 w-full rounded-xl bg-ink-900/50 border-2 border-ink-700 px-4 py-3 text-ink-50 placeholder-ink-600 transition-all focus:border-accent-400 focus:shadow-[0_0_0_2px_rgba(109,109,255,0.25)] focus:outline-none">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-ink-300">GitHub URL</label>
                                            <input type="url" name="github_url" class="mt-1 w-full rounded-xl bg-ink-900/50 border-2 border-ink-700 px-4 py-3 text-ink-50 placeholder-ink-600 transition-all focus:border-accent-400 focus:shadow-[0_0_0_2px_rgba(109,109,255,0.25)] focus:outline-none">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-ink-300">Tags (comma separated)</label>
                                            <input type="text" name="tags" placeholder="React, Laravel, AI" class="mt-1 w-full rounded-xl bg-ink-900/50 border-2 border-ink-700 px-4 py-3 text-ink-50 placeholder-ink-600 transition-all focus:border-accent-400 focus:shadow-[0_0_0_2px_rgba(109,109,255,0.25)] focus:outline-none">
                                        </div>
                                        <div class="flex justify-end gap-3 pt-4">
                                            <button type="button" @click="open = false" class="rounded-xl px-5 py-2.5 text-sm font-medium text-ink-300 hover:bg-ink-800">Cancel</button>
                                            <button type="submit" class="rounded-xl bg-accent px-5 py-2.5 text-sm font-semibold text-white hover:bg-accent-400">Submit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </template>
                    </div>
                @endauth
            </x-reveal>

            <div class="mt-16 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @forelse ($showcases ?? [] as $item)
                    <x-reveal class="h-full">
                        <div class="h-full flex flex-col justify-between rounded-[1.6rem] card-surface-soft p-7 shadow-card backdrop-blur-xl transition-all duration-500 hover:-translate-y-1.5 hover:border-[rgba(109,109,255,0.4)] hover:shadow-glow-sm">
                            <div>
                                <h3 class="text-xl font-semibold text-ink-50">{{ $item->title }}</h3>
                                <p class="mt-2 text-sm leading-relaxed text-ink-400 line-clamp-3">{{ $item->description }}</p>
                                @if($item->tags)
                                    <div class="mt-4 flex flex-wrap gap-1.5">
                                        @foreach($item->tags as $tag)
                                            <span class="rounded-full bg-accent/10 px-2.5 py-0.5 text-xs text-accent-300">{{ $tag }}</span>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                            <div class="mt-6 pt-4 border-t border-ink-800 flex items-center justify-between">
                                <span class="text-xs text-ink-450">By {{ $item->user->profile->full_name ?? $item->user->name }}</span>
                                <div class="flex items-center gap-3">
                                    @if($item->live_url)
                                        <a href="{{ $item->live_url }}" target="_blank" class="text-xs font-semibold text-accent-300 hover:underline">Live ↗</a>
                                    @endif
                                    @auth
                                        <form action="{{ route('showcase.like', $item->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="text-xs text-ink-400 hover:text-accent-300">❤️ {{ $item->likes_count }}</button>
                                        </form>
                                    @else
                                        <span class="text-xs text-ink-400">❤️ {{ $item->likes_count }}</span>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    </x-reveal>
                @empty
                    <div class="col-span-full py-16 text-center text-ink-400">
                        No showcase projects yet.
                    </div>
                @endforelse
            </div>
        </div>
    </main>
</x-layout>
