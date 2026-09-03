<x-layout :title="$server->name . ' | Azenion Servers'">
    <main class="relative overflow-hidden pt-[120px]">
        <x-page-atmosphere />
        <div class="relative mx-auto max-w-[1200px] px-5 pb-24 sm:px-8">
            <x-reveal class="rounded-[2rem] card-surface-soft p-8 sm:p-12 shadow-card backdrop-blur-xl">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6">
                    <div>
                        <span class="rounded-full bg-accent/10 px-3 py-1 text-xs font-medium text-accent-300">{{ ucfirst($server->category) }}</span>
                        <h1 class="mt-4 text-3xl font-semibold text-ink-50 sm:text-4xl">{{ $server->name }}</h1>
                        <p class="mt-2 text-sm text-ink-400">Owner: {{ $server->owner->profile->full_name ?? $server->owner->name }}</p>
                    </div>
                    @auth
                        @if($server->owner_id !== auth()->id())
                            @php $isMember = $server->members->contains('user_id', auth()->id()); @endphp
                            @if($isMember)
                                <form action="{{ route('servers.leave', $server->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="rounded-full bg-red-500/10 border border-red-500/30 px-6 py-2.5 text-sm font-semibold text-red-400 hover:bg-red-500/20">Leave Server</button>
                                </form>
                            @else
                                <form action="{{ route('servers.join', $server->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="rounded-full bg-accent px-6 py-2.5 text-sm font-semibold text-white hover:bg-accent-400 shadow-glow">Join Server</button>
                                </form>
                            @endif
                        @endif
                    @endauth
                </div>

                <div class="mt-8 grid gap-8 lg:grid-cols-3">
                    <!-- Channels Sidebar -->
                    <div class="lg:col-span-1 rounded-xl bg-ink-900/40 p-5 border border-ink-800">
                        <h3 class="text-sm font-semibold text-ink-300 uppercase tracking-wider">Channels</h3>
                        <div class="mt-4 space-y-2">
                            @foreach($server->channels as $channel)
                                @php $isCurrent = isset($currentChannel) && $currentChannel->id === $channel->id; @endphp
                                <a href="{{ route('servers.show', [$server->id, 'channel' => $channel->id]) }}" class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm transition-all {{ $isCurrent ? 'bg-accent/20 text-accent-300 border border-accent/40 font-semibold' : 'text-ink-50 bg-ink-900/50 hover:bg-accent/10 border border-ink-800' }}">
                                    <span>#</span>
                                    <span>{{ $channel->name }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <!-- Chat Area -->
                    @isset($currentChannel)
                        <div x-data="{
                            messages: @js($currentChannel->messages->map(fn($m) => [
                                'id' => $m->id,
                                'content' => $m->content,
                                'user_name' => $m->user->profile->full_name ?? $m->user->name,
                                'is_me' => $m->user_id === auth()->id(),
                            ])),
                            newMessage: '',
                            init() {
                                if (window.Echo) {
                                    window.Echo.private('server.{{ $server->id }}.channel.{{ $currentChannel->id }}')
                                        .listen('ChannelMessageSent', (e) => {
                                            if (e.user_id !== {{ auth()->id() }}) {
                                                this.messages.push({
                                                    id: e.id,
                                                    content: e.content,
                                                    user_name: e.user_name,
                                                    is_me: false,
                                                });
                                                this.$nextTick(() => {
                                                    let container = this.$refs.messagesContainer;
                                                    container.scrollTop = container.scrollHeight;
                                                });
                                            }
                                        });
                                }
                            },
                            sendMessage() {
                                if (!this.newMessage.trim()) return;
                                fetch('{{ route('servers.channels.messages.store', [$server->id, $currentChannel->id]) }}', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                        'Accept': 'application/json'
                                    },
                                    body: JSON.stringify({ content: this.newMessage })
                                })
                                .then(res => res.json())
                                .then(data => {
                                    if (data.success) {
                                        this.messages.push(data.message);
                                        this.newMessage = '';
                                        this.$nextTick(() => {
                                            let container = this.$refs.messagesContainer;
                                            container.scrollTop = container.scrollHeight;
                                        });
                                    }
                                });
                            }
                        }" class="lg:col-span-2 rounded-xl bg-ink-900/40 p-6 border border-ink-800 flex flex-col h-[500px]">
                            <div class="border-b border-ink-800 pb-3 mb-4">
                                <h3 class="text-base font-semibold text-ink-50"># {{ $currentChannel->name }}</h3>
                                @if($currentChannel->description)
                                    <p class="text-xs text-ink-400 mt-0.5">{{ $currentChannel->description }}</p>
                                @endif
                            </div>

                            <div x-ref="messagesContainer" class="flex-1 overflow-y-auto space-y-4 p-3 rounded-xl bg-ink-900/50 border border-ink-800">
                                <template x-for="msg in messages" :key="msg.id">
                                    <div class="flex flex-col" :class="msg.is_me ? 'items-end' : 'items-start'">
                                        <div class="text-[11px] text-ink-400 mb-1" x-text="msg.is_me ? 'You' : msg.user_name"></div>
                                        <div class="rounded-2xl px-4 py-3 max-w-md text-sm" :class="msg.is_me ? 'bg-accent text-white' : 'bg-ink-800 text-ink-100'" x-text="msg.content"></div>
                                    </div>
                                </template>
                            </div>

                            @auth
                                @php
                                    $isMember = $server->owner_id === auth()->id() || $server->members->contains('user_id', auth()->id());
                                @endphp
                                @if($isMember)
                                    <form @submit.prevent="sendMessage()" class="mt-4 flex gap-3">
                                        <input type="text" x-model="newMessage" required autocomplete="off" placeholder="Message #{{ $currentChannel->name }}..." class="flex-1 rounded-xl bg-ink-900/50 border border-ink-800 px-4 py-3 text-sm text-ink-50 focus:border-accent focus:outline-none">
                                        <button type="submit" class="rounded-xl bg-accent px-6 py-3 text-sm font-semibold text-white hover:bg-accent-400">Send</button>
                                    </form>
                                @else
                                    <div class="mt-4 text-center text-xs text-ink-400 p-3 rounded-xl bg-ink-900/50 border border-ink-800">
                                        You must join this server to send messages.
                                    </div>
                                @endif
                            @else
                                <div class="mt-4 text-center text-xs text-ink-400 p-3 rounded-xl bg-ink-900/50 border border-ink-800">
                                    Please <a href="{{ route('login') }}" class="text-accent-300 underline">login</a> to send messages.
                                </div>
                            @endauth
                        </div>
                    @else
                        <div class="lg:col-span-2 rounded-xl bg-ink-900/40 p-6 border border-ink-800 flex items-center justify-center text-ink-400 h-[500px]">
                            Select a channel to start messaging.
                        </div>
                    @endisset
                </div>
            </x-reveal>
        </div>
    </main>
</x-layout>
