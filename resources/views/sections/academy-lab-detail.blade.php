<x-layout :title="$lab->title . ' | Azenion Academy Labs'">
    <main class="relative overflow-hidden pt-[120px]">
        <x-page-atmosphere />
        <div class="relative mx-auto max-w-[1000px] px-5 pb-24 sm:px-8">
            <x-reveal class="rounded-[2rem] card-surface-soft p-8 sm:p-12 shadow-card backdrop-blur-xl">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6">
                    <div>
                        <span class="rounded-full bg-accent/10 px-3 py-1 text-xs font-medium text-accent-300">{{ ucfirst($lab->difficulty) }}</span>
                        <h1 class="mt-4 text-3xl font-semibold text-ink-50 sm:text-4xl">{{ $lab->title }}</h1>
                        <p class="mt-2 text-sm text-ink-400">Category: {{ ucfirst($lab->category) }}</p>
                    </div>
                </div>

                <div class="mt-8 border-t border-ink-800 pt-8">
                    <h2 class="text-lg font-semibold text-ink-50">Lab Instructions</h2>
                    <p class="mt-3 text-base leading-relaxed text-ink-300">{{ $lab->description }}</p>
                </div>

                @auth
                    <div class="mt-10 border-t border-ink-800 pt-8">
                        <h2 class="text-lg font-semibold text-ink-50">Your Solution</h2>
                        @if($submission)
                            <div class="mt-4 rounded-xl bg-ink-900/60 p-4 border border-ink-800">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-xs font-semibold uppercase {{ $submission->status === 'passed' ? 'text-green-400' : 'text-red-400' }}">Status: {{ $submission->status }}</span>
                                    <span class="text-xs text-ink-400">Score: {{ $submission->score }}/100</span>
                                </div>
                                <p class="text-sm text-ink-300">{{ $submission->feedback }}</p>
                            </div>
                        @endif

                        <form action="{{ route('academy.labs.submit', $lab->id) }}" method="POST" class="mt-6 space-y-4">
                            @csrf
                            <div>
                                <label class="block text-sm font-medium text-ink-300 mb-2">Code Editor</label>
                                <textarea name="code" rows="8" required placeholder="Write your code here..." class="w-full font-mono rounded-xl bg-ink-900/80 border border-ink-800 p-4 text-sm text-ink-50 focus:border-accent focus:outline-none">{{ $lab->starter_code ?? '// Write solution here' }}</textarea>
                            </div>
                            <div class="flex justify-end">
                                <button type="submit" class="rounded-full bg-accent px-6 py-3 text-sm font-semibold text-white hover:bg-accent-400 shadow-glow">Submit Solution</button>
                            </div>
                        </form>
                    </div>
                @else
                    <div class="mt-10 text-center py-6 border-t border-ink-800">
                        <a href="{{ route('join') }}" class="text-sm font-semibold text-accent-300 hover:underline">Join or login to submit solutions and test your code.</a>
                    </div>
                @endauth
            </x-reveal>
        </div>
    </main>
</x-layout>
