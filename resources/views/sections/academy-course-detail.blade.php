<x-layout :title="$course->title . ' | Azenion Academy'">
    <main class="relative overflow-hidden pt-[120px]">
        <x-page-atmosphere />
        <div class="relative mx-auto max-w-[1000px] px-5 pb-24 sm:px-8">
            <x-reveal class="rounded-[2rem] card-surface-soft p-8 sm:p-12 shadow-card backdrop-blur-xl">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6">
                    <div>
                        <span class="rounded-full bg-accent/10 px-3 py-1 text-xs font-medium text-accent-300">{{ ucfirst($course->category) }}</span>
                        <h1 class="mt-4 text-3xl font-semibold text-ink-50 sm:text-4xl">{{ $course->title }}</h1>
                        <p class="mt-2 text-sm text-ink-400">Level: {{ ucfirst($course->level) }}</p>
                    </div>
                    @auth
                        @if($isEnrolled)
                            <span class="rounded-full bg-green-500/15 border border-green-500/30 px-6 py-2.5 text-sm font-semibold text-green-400">Enrolled</span>
                        @else
                            <form action="{{ route('academy.courses.enroll', $course->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="rounded-full bg-accent px-6 py-2.5 text-sm font-semibold text-white hover:bg-accent-400 shadow-glow">Enroll Now</button>
                            </form>
                        @endif
                    @endauth
                </div>

                <div class="mt-8 border-t border-ink-800 pt-8">
                    <h2 class="text-lg font-semibold text-ink-50">Course Description</h2>
                    <p class="mt-3 text-base leading-relaxed text-ink-300">{{ $course->description }}</p>
                </div>

                <div class="mt-10 border-t border-ink-800 pt-8">
                    <h2 class="text-lg font-semibold text-ink-50">Lessons ({{ $course->lessons->count() }})</h2>
                    <div class="mt-4 space-y-3">
                        @foreach($course->lessons as $lesson)
                            <div class="flex items-center justify-between rounded-xl bg-ink-900/40 p-4 border border-ink-800">
                                <div class="flex items-center gap-3">
                                    <span class="h-8 w-8 rounded-full bg-accent/10 flex items-center justify-center text-accent-300 text-xs font-bold">{{ $lesson->order }}</span>
                                    <span class="text-sm font-semibold text-ink-50">{{ $lesson->title }}</span>
                                </div>
                                <span class="text-xs text-ink-400">{{ $lesson->duration ?? '10m' }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </x-reveal>
        </div>
    </main>
</x-layout>
