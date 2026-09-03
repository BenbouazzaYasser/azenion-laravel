<x-layout :title="'Join Azenion | The Limitless Network'" :footer="true">
    <main class="relative flex min-h-screen items-center justify-center overflow-hidden px-5 py-24 sm:px-8">
        <x-page-atmosphere />

        <div class="relative w-full max-w-md">
            <div aria-hidden class="pointer-events-none absolute -inset-8 rounded-[3rem] bg-[rgba(40,40,255,0.12)] blur-[80px]"></div>
            <div class="relative rounded-[2rem] card-surface-soft p-8 shadow-card backdrop-blur-xl sm:p-10">
                <div class="text-center">
                    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl border border-[rgba(109,109,255,0.25)] bg-[rgba(40,40,255,0.1)] shadow-glow-sm">
                        <svg width="28" height="28" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M16 2C11 2 7 6 7 11c0 2.8 1.4 5.2 3.5 6.7C20.5 12.5 26 18 26 11c0-5-4-9-10-9Z" stroke="#6D6DFF" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M16 30C21 30 25 26 25 21c0-2.8-1.4-5.2-3.5-6.7C11.5 19.5 6 14 6 21c0 5 4 9 10 9Z" stroke="#6D6DFF" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/>
                            <circle cx="16" cy="16" r="3.2" fill="#6D6DFF"/>
                        </svg>
                    </div>
                    <h1 class="mt-6 text-[1.75rem] font-semibold tracking-tight text-ink-50">Join Azenion</h1>
                    <p class="mt-2 text-sm text-ink-400">Become part of The Limitless Network and start building alongside ambitious minds.</p>
                </div>

                @if (session('status'))
                    <div class="mt-6 rounded-xl border border-emerald-400/25 bg-emerald-400/10 px-4 py-3 text-sm text-emerald-300">{{ session('status') }}</div>
                @endif

                <form method="POST" action="{{ route('register') }}" class="mt-8 space-y-5">
                    @csrf

                    <div>
                        <label for="name" class="block text-sm font-medium text-ink-200">Full name</label>
                        <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus
                               class="mt-2 block w-full rounded-xl border border-border bg-[rgba(255,255,255,0.04)] px-4 py-3 text-sm text-ink-50 placeholder-ink-600 transition-all focus:border-accent-400/60 focus:shadow-[0_0_0_1px_rgba(109,109,255,0.2)] focus:outline-none">
                        @error('name') <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-ink-200">Email</label>
                        <input id="email" name="email" type="email" value="{{ old('email') }}" required
                               class="mt-2 block w-full rounded-xl border border-border bg-[rgba(255,255,255,0.04)] px-4 py-3 text-sm text-ink-50 placeholder-ink-600 transition-all focus:border-accent-400/60 focus:shadow-[0_0_0_1px_rgba(109,109,255,0.2)] focus:outline-none">
                        @error('email') <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-ink-200">Password</label>
                        <input id="password" name="password" type="password" required
                               class="mt-2 block w-full rounded-xl border border-border bg-[rgba(255,255,255,0.04)] px-4 py-3 text-sm text-ink-50 placeholder-ink-600 transition-all focus:border-accent-400/60 focus:shadow-[0_0_0_1px_rgba(109,109,255,0.2)] focus:outline-none">
                        @error('password') <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-ink-200">Confirm password</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" required
                               class="mt-2 block w-full rounded-xl border border-border bg-[rgba(255,255,255,0.04)] px-4 py-3 text-sm text-ink-50 placeholder-ink-600 transition-all focus:border-accent-400/60 focus:shadow-[0_0_0_1px_rgba(109,109,255,0.2)] focus:outline-none">
                    </div>

                    <button type="submit" class="inline-flex w-full items-center justify-center h-12 rounded-full bg-accent text-[15px] font-semibold text-white transition-all duration-300 hover:bg-accent-400 hover:shadow-glow">
                        Create Account
                    </button>
                </form>

                <p class="mt-6 text-center text-sm text-ink-500">
                    Already have an account?
                    <a href="{{ route('login') }}" class="font-medium text-accent-300 hover:underline">Log in</a>
                </p>
            </div>
        </div>
    </main>
</x-layout>
