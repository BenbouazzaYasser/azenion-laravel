<x-layout :title="'Feed | Azenion'">
    <main class="relative overflow-hidden pt-[120px]">
        <x-page-atmosphere />
        <div class="relative mx-auto max-w-[900px] px-5 pb-24 sm:px-8">
            <x-reveal class="text-center">
                <x-eyebrow class="justify-center">Activity Stream</x-eyebrow>
                <h1 class="mt-6 text-[2.5rem] font-semibold leading-[1.08] tracking-tight text-ink-50 sm:text-[3.25rem]">
                    Network <span class="text-accent-400">Feed.</span>
                </h1>
                <p class="mt-4 text-[1.05rem] text-ink-400">See what builders, innovators, and teams are shipping across Azenion.</p>
            </x-reveal>

            @auth
                <x-reveal class="mt-10">
                    <div class="rounded-[1.6rem] card-surface-soft p-6 shadow-card backdrop-blur-xl">
                        <form action="{{ route('feed.store') }}" method="POST" class="space-y-4">
                            @csrf
                            <textarea name="body" rows="3" placeholder="What are you building or sharing today?" required class="w-full rounded-xl bg-ink-900/50 border-2 border-ink-700 p-4 text-ink-50 placeholder-ink-600 transition-all focus:border-accent-400 focus:shadow-[0_0_0_2px_rgba(109,109,255,0.25)] focus:outline-none"></textarea>
                            <div class="flex justify-end">
                                <button type="submit" class="rounded-full bg-accent px-6 py-2.5 text-sm font-semibold text-white hover:bg-accent-400 shadow-glow">Publish Post</button>
                            </div>
                        </form>
                    </div>
                </x-reveal>
            @endauth

            <div class="mt-12 space-y-6">
                @forelse ($posts ?? [] as $post)
                    @php
                        $hasLiked = auth()->check() && $post->likes->where('user_id', auth()->id())->count() > 0;
                        $hasSaved = auth()->check() && $post->saves->where('user_id', auth()->id())->count() > 0;
                        $likeCount = $post->likes->count();
                    @endphp
                    <x-reveal>
                        <div class="rounded-[1.6rem] card-surface-soft p-7 shadow-card backdrop-blur-xl">
                            <div class="flex items-center gap-3">
                                <div class="h-10 w-10 rounded-full bg-accent/20 flex items-center justify-center text-accent-300 font-bold">
                                    {{ substr($post->author->profile->full_name ?? $post->author->name, 0, 1) }}
                                </div>
                                <div>
                                    <h3 class="text-sm font-semibold text-ink-50">{{ $post->author->profile->full_name ?? $post->author->name }}</h3>
                                    <p class="text-xs text-ink-400">{{ $post->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            <p class="mt-4 text-base leading-relaxed text-ink-200">{{ $post->body }}</p>
                            @auth
                                <div class="mt-6 pt-4 border-t border-ink-800 flex items-center gap-6">
                                    <form action="{{ route('feed.like', $post->id) }}" method="POST" class="feed-like-form inline-flex items-center gap-2" data-post-id="{{ $post->id }}" data-liked="{{ $hasLiked ? 'true' : 'false' }}">
                                        @csrf
                                        <button type="submit" class="inline-flex items-center gap-2 text-sm {{ $hasLiked ? 'text-red-400' : 'text-ink-400 hover:text-red-400' }}">
                                            <span>{{ $hasLiked ? '❤️' : '🤍' }}</span> <span class="like-count">{{ $likeCount }}</span>
                                        </button>
                                    </form>

                                    <form action="{{ route('feed.save', $post->id) }}" method="POST" class="feed-save-form inline-flex items-center gap-2" data-post-id="{{ $post->id }}" data-saved="{{ $hasSaved ? 'true' : 'false' }}">
                                        @csrf
                                        <button type="submit" class="inline-flex items-center gap-2 text-sm {{ $hasSaved ? 'text-accent-400' : 'text-ink-400 hover:text-accent-400' }}">
                                            <span>{{ $hasSaved ? '🔖' : '📌' }}</span> Save
                                        </button>
                                    </form>

                                    <button type="button" class="feed-share-btn inline-flex items-center gap-2 text-sm text-ink-400 hover:text-accent-400" data-post-id="{{ $post->id }}" data-url="{{ url()->current() }}">
                                        <span>🔗</span> Share
                                    </button>
                                </div>
                            @endauth
                        </div>
                    </x-reveal>
                @empty
                    <div class="py-16 text-center text-ink-400">
                        No feed posts yet. Be the first to share an update!
                    </div>
                @endforelse
            </div>

            @if(isset($posts) && method_exists($posts, 'links'))
                <div class="mt-10">
                    {{ $posts->links() }}
                </div>
            @endif
        </div>
    </main>
</x-layout>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    // Like functionality with AJAX
    document.querySelectorAll('.feed-like-form').forEach(form => {
        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            const postId = form.dataset.postId;
            const button = form.querySelector('button');
            const icon = button.querySelector('span:first-child');
            const countSpan = button.querySelector('.like-count');
            const isLiked = form.dataset.liked === 'true';

            try {
                const response = await fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({})
                });

                const data = await response.json();
                if (data.success) {
                    const newLiked = !isLiked;
                    form.dataset.liked = newLiked ? 'true' : 'false';
                    icon.textContent = newLiked ? '❤️' : '🤍';
                    button.classList.toggle('text-red-400', newLiked);
                    button.classList.toggle('text-ink-400', !newLiked);
                    button.classList.toggle('hover:text-red-400', !newLiked);
                    if (countSpan) {
                        countSpan.textContent = data.likes_count ?? (newLiked ? parseInt(countSpan.textContent) + 1 : parseInt(countSpan.textContent) - 1);
                    }
                }
            } catch (err) {
                console.error('Like failed:', err);
            }
        });
    });

    // Save functionality with AJAX
    document.querySelectorAll('.feed-save-form').forEach(form => {
        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            const postId = form.dataset.postId;
            const button = form.querySelector('button');
            const icon = button.querySelector('span:first-child');
            const isSaved = form.dataset.saved === 'true';

            try {
                const response = await fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({})
                });

                const data = await response.json();
                if (data.success) {
                    const newSaved = !isSaved;
                    form.dataset.saved = newSaved ? 'true' : 'false';
                    icon.textContent = newSaved ? '🔖' : '📌';
                    button.classList.toggle('text-accent-400', newSaved);
                    button.classList.toggle('text-ink-400', !newSaved);
                    button.classList.toggle('hover:text-accent-400', !newSaved);
                    button.querySelector('span:last-child').textContent = newSaved ? 'Saved' : 'Save';
                }
            } catch (err) {
                console.error('Save failed:', err);
            }
        });
    });

    // Share functionality
    document.querySelectorAll('.feed-share-btn').forEach(btn => {
        btn.addEventListener('click', async () => {
            const url = btn.dataset.url || window.location.href;
            const postId = btn.dataset.postId;

            if (navigator.share) {
                try {
                    await navigator.share({
                        title: 'Azenion Feed Post',
                        text: 'Check out this post on Azenion!',
                        url: url
                    });
                } catch (err) {
                    if (err.name !== 'AbortError') {
                        fallbackCopy(url);
                    }
                }
            } else {
                fallbackCopy(url);
            }
        });
    });

    function fallbackCopy(url) {
        navigator.clipboard.writeText(url).then(() => {
            const originalText = btn.innerHTML;
            btn.innerHTML = '<span>✅</span> Copied!';
            btn.classList.add('text-green-400');
            setTimeout(() => {
                btn.innerHTML = originalText;
                btn.classList.remove('text-green-400');
            }, 2000);
        });
    }
});
</script>
@endpush