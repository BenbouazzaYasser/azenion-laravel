<footer class="relative">
    <div class="absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-[rgba(40,40,255,0.3)] to-transparent"></div>
    <div class="absolute inset-x-0 top-0 h-56 bg-[radial-gradient(ellipse_80%_100%_at_50%_0%,rgba(40,40,255,0.08),transparent_70%)]"></div>

    <div class="relative mx-auto max-w-[1320px] px-5 py-14 sm:px-8 lg:px-12 lg:py-16">
        <div class="grid gap-10 lg:grid-cols-[1.3fr_1fr_1fr_1.2fr]">
            <div>
                <x-logo />
                <p class="mt-4 max-w-xs text-sm leading-relaxed text-ink-400">
                    United by purpose.<br />
                    <span class="text-accent-400">Driven by impact.</span>
                </p>
                <p class="mt-4 text-sm leading-relaxed text-ink-400">
                    A global network where ambitious minds connect, collaborate, and create the future together.
                </p>
            </div>

            <div>
                <h3 class="text-sm font-semibold uppercase tracking-wider text-ink-200">Quick Links</h3>
                <ul class="mt-5 space-y-3">
                    @foreach ([
                        ['Teams', route('teams')],
                        ['Projects', route('projects')],
                        ['Branches', route('branches')],
                        ['Feed', route('feed')],
                        ['Chat', route('chat')],
                    ] as [$label, $href])
                        <li><a href="{{ $href }}" class="text-sm text-ink-400 transition-colors hover:text-ink-50">{{ $label }}</a></li>
                    @endforeach
                </ul>
            </div>

            <div>
                <h3 class="text-sm font-semibold uppercase tracking-wider text-ink-200">Legal</h3>
                <ul class="mt-5 space-y-3">
                    @foreach (['about' => 'About', 'contact' => 'Contact', 'terms' => 'Terms of Service', 'privacy' => 'Privacy Policy'] as $route => $label)
                        <li><a href="{{ route($route) }}" class="text-sm text-ink-400 transition-colors hover:text-ink-50">{{ $label }}</a></li>
                    @endforeach
                </ul>
            </div>

            <div>
                <h3 class="text-sm font-semibold uppercase tracking-wider text-ink-200">Connect</h3>
                <div class="mt-5 flex flex-wrap gap-2">
                    @foreach ([
                        ['X (Twitter)', 'https://x.com/azenion', 'M'],
                        ['LinkedIn', 'https://www.linkedin.com/company/azenion', 'in'],
                        ['Instagram', 'https://instagram.com/Azenion8', 'IG'],
                        ['GitHub', 'https://github.com/azenion', 'GH'],
                        ['Discord', 'https://discord.gg/3As5ndwwh', 'DC'],
                    ] as [$label, $href, $mono])
                        <a href="{{ $href }}" target="_blank" rel="noreferrer noopener" aria-label="{{ $label }}" title="{{ $label }}" class="flex h-10 w-10 items-center justify-center rounded-xl bg-[rgba(255,255,255,0.04)] text-[11px] font-semibold text-ink-400 shadow-card backdrop-blur-xl transition-all duration-300 hover:-translate-y-0.5 hover:text-accent-400 hover:shadow-glow-sm">{{ $mono }}</a>
                    @endforeach
                </div>

                <div class="mt-6 space-y-3">
                    @foreach ([
                        ['Email', 'Reach out directly — we read every message.', 'Azenion@outlook.com', 'mailto:Azenion@outlook.com'],
                        ['Discord', 'Join the conversation in our community server.', 'discord.gg/3As5ndwwh', 'https://discord.gg/3As5ndwwh'],
                    ] as [$label, $desc, $detail, $href])
                        <a href="{{ $href }}" class="group flex items-center gap-3 rounded-xl bg-[rgba(255,255,255,0.04)] px-4 py-3 shadow-card backdrop-blur-xl transition-all duration-300 hover:-translate-y-0.5 hover:bg-surface-hover hover:shadow-glow-sm">
                            <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-[rgba(255,255,255,0.04)] text-xs font-semibold text-accent-400">{{ substr($label, 0, 1) }}</div>
                            <div class="min-w-0">
                                <p class="text-[0.82rem] font-medium text-ink-200 group-hover:text-accent-400">{{ $label }}</p>
                                <p class="truncate text-[0.75rem] text-ink-600">{{ $detail }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="relative">
        <div class="mx-auto max-w-[1320px] px-5 py-6 sm:px-8 lg:px-12">
            <p class="text-center text-xs text-ink-600 sm:text-left">&copy; {{ date('Y') }} Azenion. All rights reserved.</p>
            <p class="mt-2 text-center text-xs text-ink-600/80 sm:text-left">Founded by Ziyad</p>
        </div>
    </div>
</footer>
