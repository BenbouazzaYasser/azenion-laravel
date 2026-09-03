<x-layout :title="'Projects | Azenion'">
    <main class="relative overflow-hidden pt-[120px]">
        <x-page-atmosphere />
        <div class="relative mx-auto max-w-[1320px] px-5 pb-24 sm:px-8 lg:px-12">
            <x-reveal class="mx-auto max-w-3xl text-center">
                <x-eyebrow class="justify-center">The Limitless Network</x-eyebrow>
                <h1 class="mt-6 text-[2.5rem] font-semibold leading-[1.08] tracking-tight text-ink-50 sm:text-[3.25rem]">
                    Build the Future, <span class="text-accent-400">One Project at a Time.</span>
                </h1>
                <p class="mt-5 text-[1.05rem] leading-8 text-ink-400">
                    Azenion empowers ambitious builders to discover, create, and contribute to meaningful projects alongside talented collaborators.
                </p>
                @auth
                    <div x-data="{ open: false }" class="mt-8">
                        <button @click="open = true" class="inline-flex items-center justify-center h-12 rounded-full px-6 text-[15px] font-semibold text-white bg-accent transition-all duration-300 hover:bg-accent-400 hover:shadow-glow">Create Project</button>
                        
                        <template x-teleport="body">
                            <div x-show="open" class="fixed inset-0 z-50 flex items-center justify-center bg-black/80 p-4" style="display: none;">
                                <div @click.outside="open = false" style="background-color: #050507;" class="w-full max-w-lg rounded-[2rem] p-8 text-left shadow-2xl border border-ink-800">
                                    <h3 class="text-xl font-semibold text-ink-50">Create a New Project</h3>
                                    <form action="{{ route('projects.store') }}" method="POST" class="mt-6 space-y-4">
                                        @csrf
                                        <div>
                                            <label class="block text-sm font-medium text-ink-300">Project Name</label>
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
                @else
                    <div class="mt-8">
                        <a href="{{ route('join') }}" class="inline-flex items-center justify-center h-12 rounded-full px-6 text-[15px] font-semibold text-white bg-accent transition-all duration-300 hover:bg-accent-400 hover:shadow-glow">Join to Create Project</a>
                    </div>
                @endauth
            </x-reveal>

            <div class="mt-16">
                <form method="GET" action="{{ route('projects') }}" class="flex gap-4 items-center max-w-md mx-auto">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search projects..." class="w-full rounded-full bg-ink-900/50 border border-ink-800 px-5 py-3 text-sm text-ink-50 focus:border-accent focus:outline-none">
                    <button type="submit" class="rounded-full bg-accent px-6 py-3 text-sm font-semibold text-white hover:bg-accent-400">Search</button>
                </form>
            </div>

            <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @forelse ($projects ?? [] as $project)
                    <x-reveal class="h-full">
                        <div class="h-full flex flex-col justify-between rounded-[1.6rem] card-surface-soft p-7 shadow-card backdrop-blur-xl transition-all duration-500 hover:-translate-y-1.5 hover:border-[rgba(109,109,255,0.4)] hover:shadow-glow-sm">
                            <div>
                                <div class="flex items-center justify-between">
                                    <span class="rounded-full bg-accent/10 px-3 py-1 text-xs font-medium text-accent-300">Project</span>
                                    <span class="text-xs text-ink-400">{{ $project->members->count() }} members</span>
                                </div>
                                <h3 class="mt-4 text-xl font-semibold text-ink-50">{{ $project->name }}</h3>
                                <p class="mt-2 text-sm leading-relaxed text-ink-400 line-clamp-3">{{ $project->description ?? 'No description provided.' }}</p>
                            </div>
                            <div class="mt-6 pt-4 border-t border-ink-800 flex items-center justify-between">
                                <span class="text-xs text-ink-450">Owner: {{ $project->owner->profile->full_name ?? $project->owner->name }}</span>
                                <a href="{{ route('projects.show', $project->id) }}" class="inline-flex items-center text-sm font-medium text-accent-300 hover:text-accent-400">View Project &rarr;</a>
                            </div>
                        </div>
                    </x-reveal>
                @empty
                    <div class="col-span-full py-16 text-center text-ink-400">
                        No projects found. Be the first to publish one!
                    </div>
                @endforelse
            </div>

            @if(isset($projects) && method_exists($projects, 'links'))
                <div class="mt-10">
                    {{ $projects->links() }}
                </div>
            @endif
        </div>
    </main>
</x-layout>
