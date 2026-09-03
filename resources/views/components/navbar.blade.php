@props(['navbar' => 'default'])

@php
    $navLinks = [
        ['label' => 'Home', 'href' => route('home')],
        ['label' => 'Teams', 'href' => route('teams')],
        ['label' => 'Projects', 'href' => route('projects')],
        ['label' => 'Branches', 'href' => route('branches')],
        ['label' => 'Servers', 'href' => route('servers')],
        [
            'label' => 'Community',
            'href' => route('community'),
            'children' => [
                ['label' => 'Feed', 'href' => route('feed'), 'description' => 'Updates across the network'],
                ['label' => 'Showcase', 'href' => route('showcase'), 'description' => 'Community highlights'],
                ['label' => 'Announcements', 'href' => route('announcements'), 'description' => 'Platform updates and milestones'],
            ],
        ],
        ['label' => 'Chat', 'href' => route('chat')],
        [
            'label' => 'Academy',
            'href' => route('academy'),
            'children' => [
                ['label' => 'Courses', 'href' => route('academy.courses'), 'description' => 'Self-paced learning paths'],
                ['label' => 'Live Sessions', 'href' => route('academy.live-sessions'), 'description' => 'Workshops and lectures'],
                ['label' => 'Labs', 'href' => route('academy.labs'), 'description' => 'Build and experiment'],
            ],
        ],
    ];
@endphp

<header class="fixed inset-x-0 top-0 z-50 flex justify-center px-4 pt-4 sm:px-6 sm:pt-5">
    <div class="w-full max-w-[1320px] xl:w-fit xl:max-w-none rounded-full border border-border bg-[rgba(10,11,16,0.18)] backdrop-blur-2xl shadow-[0_8px_30px_-25px_rgba(255,255,255,0.05)]">
        <div class="flex h-16 items-center justify-between gap-3 px-4 sm:h-[70px] sm:px-6">
            <div class="flex shrink-0 items-center pr-1">
                <x-logo :with-wordmark="false" :mark-size="32" />
            </div>

            <nav class="hidden xl:flex items-center" aria-label="Primary">
                <ul class="flex items-center gap-4">
                    @foreach ($navLinks as $link)
                        @php
                            $active = request()->url() === $link['href'];
                        @endphp
                        <li class="flex">
                            @if (!empty($link['children']))
                                <div class="relative" data-dropdown>
                                    <a href="{{ $link['href'] }}"
                                       class="relative inline-flex items-center rounded-full px-4 py-2 text-[13.5px] font-medium leading-none text-ink-400 transition-all duration-300 whitespace-nowrap hover:bg-surface-hover hover:text-ink-50">
                                        {{ $link['label'] }}
                                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="ml-1 opacity-60"><path d="m6 9 6 6 6-6"/></svg>
                                    </a>
                                    <div class="absolute left-1/2 top-full mt-3 w-64 -translate-x-1/2 opacity-0 invisible transition-all duration-200 pointer-events-none" data-dropdown-menu>
                                        <div class="relative overflow-hidden rounded-2xl bg-[rgba(9,10,15,0.94)] shadow-dropdown backdrop-blur-2xl backdrop-saturate-150">
                                            <div class="pointer-events-none absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-accent-300/80 to-transparent"></div>
                                            <div class="px-2.5 pb-3 pt-2">
                                                <p class="px-2 pb-1 text-[10px] font-semibold uppercase tracking-[0.14em] text-ink-600">{{ $link['label'] }}</p>
                                                @foreach ($link['children'] as $child)
                                                    <a href="{{ $child['href'] }}" class="group flex items-center gap-3 rounded-xl px-3 py-2.5 transition-all duration-200 hover:bg-surface-hover">
                                                        <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-[rgba(255,255,255,0.04)] text-accent-400">{{ substr($child['label'], 0, 1) }}</span>
                                                        <span class="min-w-0">
                                                            <span class="block text-[13.5px] font-medium text-ink-200 group-hover:text-ink-50">{{ $child['label'] }}</span>
                                                            @if (!empty($child['description']))
                                                                <span class="block truncate text-xs text-ink-600">{{ $child['description'] }}</span>
                                                            @endif
                                                        </span>
                                                    </a>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <a href="{{ $link['href'] }}"
                                   class="relative inline-flex items-center rounded-full px-4 py-2 text-[13.5px] font-medium leading-none whitespace-nowrap transition-all duration-300 hover:bg-surface-hover hover:text-ink-50 {{ $active ? 'bg-surface-hover text-ink-50' : 'text-ink-400' }}">
                                    {{ $link['label'] }}
                                </a>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </nav>

            <div class="flex items-center gap-2">
                <div class="hidden items-center gap-2 xl:flex">
                    @auth
                        <div class="relative" data-dropdown>
                            <button class="inline-flex items-center rounded-full border border-border bg-[rgba(255,255,255,0.04)] px-4 h-10 text-[13.5px] font-medium text-ink-200 transition-all hover:border-accent-400/40 hover:text-ink-50">
                                {{ Auth::user()->name }}
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="ml-1 opacity-60"><path d="m6 9 6 6 6-6"/></svg>
                            </button>
                            <div class="absolute right-0 top-full mt-3 w-48 opacity-0 invisible transition-all duration-200 pointer-events-none" data-dropdown-menu>
                                <div class="relative overflow-hidden rounded-2xl bg-[rgba(9,10,15,0.94)] shadow-dropdown backdrop-blur-2xl backdrop-saturate-150">
                                    <div class="pointer-events-none absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-accent-300/80 to-transparent"></div>
                                    <div class="px-2.5 pb-3 pt-2">
                                        <a href="{{ route('profile') }}" class="group flex items-center gap-3 rounded-xl px-3 py-2.5 transition-all duration-200 hover:bg-surface-hover">
                                            <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-[rgba(255,255,255,0.04)] text-accent-400">👤</span>
                                            <span class="text-[13.5px] font-medium text-ink-200 group-hover:text-ink-50">Profile</span>
                                        </a>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="w-full text-left group flex items-center gap-3 rounded-xl px-3 py-2.5 transition-all duration-200 hover:bg-surface-hover">
                                                <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-[rgba(255,255,255,0.04)] text-red-400">🚪</span>
                                                <span class="text-[13.5px] font-medium text-red-400 group-hover:text-red-300">Sign Out</span>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="inline-flex items-center rounded-full border border-border bg-[rgba(255,255,255,0.04)] px-4 h-10 text-[13.5px] font-medium text-ink-200 transition-all hover:border-accent-400/40 hover:text-ink-50">Log in</a>
                        <a href="{{ route('join') }}" class="inline-flex items-center rounded-full px-4 h-10 text-[13.5px] font-semibold text-white bg-accent transition-all hover:bg-accent-400 hover:shadow-glow-sm">Join Azenion</a>
                    @endauth
                </div>

                <div class="xl:hidden">
                    @auth
                        <a href="{{ route('profile') }}" class="inline-flex items-center justify-center rounded-full border border-border h-10 px-3 text-xs font-medium text-ink-300">{{ substr(Auth::user()->name, 0, 1) }}</a>
                    @else
                        <a href="{{ route('login') }}" class="inline-flex items-center justify-center rounded-full border border-border h-10 px-3 text-xs font-medium text-ink-300">Log in</a>
                    @endauth
                </div>

                <button type="button" data-mobile-menu-toggle aria-expanded="false" aria-label="Open menu" class="flex h-11 w-11 items-center justify-center rounded-full text-ink-50 transition-all duration-300 hover:bg-surface-hover xl:hidden">
                    <svg data-icon-open xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><line x1="4" x2="20" y1="6" y2="6"/><line x1="4" x2="20" y1="12" y2="12"/><line x1="4" x2="20" y1="18" y2="18"/></svg>
                    <svg data-icon-close class="hidden" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                </button>
            </div>
        </div>
    </div>

    <div data-mobile-menu class="absolute left-4 right-4 top-[78px] hidden overflow-hidden rounded-[1.5rem] border border-border bg-[rgba(9,10,15,0.96)] shadow-dropdown backdrop-blur-2xl xl:hidden">
        <div class="max-h-[calc(100dvh_-_112px)] overflow-y-auto">
            <div class="flex flex-col gap-1 p-5">
                @foreach ($navLinks as $link)
                    <a href="{{ $link['href'] }}" class="rounded-xl px-4 py-3 text-[15px] font-medium text-ink-400 hover:bg-surface-hover hover:text-ink-200">{{ $link['label'] }}</a>
                    @if (!empty($link['children']))
                        @foreach ($link['children'] as $child)
                            <a href="{{ $child['href'] }}" class="ml-4 rounded-xl px-4 py-2.5 text-sm font-medium text-ink-500 hover:bg-surface-hover hover:text-ink-200">{{ $child['label'] }}</a>
                        @endforeach
                    @endif
                @endforeach

                <div class="mt-4 flex flex-col gap-3 border-t border-border pt-5">
                    @auth
                        <a href="{{ route('profile') }}" class="inline-flex items-center justify-center rounded-full bg-[rgba(255,255,255,0.06)] px-4 py-2.5 text-sm font-medium text-ink-200 hover:text-ink-50">Profile</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full rounded-full px-4 py-2.5 text-sm font-medium text-red-400 hover:text-red-300">Sign Out</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="inline-flex items-center justify-center rounded-full bg-[rgba(255,255,255,0.06)] px-4 py-2.5 text-sm font-medium text-ink-200 hover:text-ink-50">Log in</a>
                        <a href="{{ route('join') }}" class="inline-flex items-center justify-center rounded-full bg-accent px-4 py-2.5 text-sm font-semibold text-white hover:bg-accent-400">Join Azenion</a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</header>
