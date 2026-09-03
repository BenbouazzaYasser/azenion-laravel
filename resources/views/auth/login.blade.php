<x-layout :title="'Log in | Azenion'" :footer="true">
    <main class="relative flex min-h-screen items-center justify-center overflow-hidden px-5 py-24 sm:px-8">
        <x-page-atmosphere />

        <div class="relative w-full max-w-md">
            <div aria-hidden class="pointer-events-none absolute -inset-8 rounded-[3rem] bg-[rgba(40,40,255,0.12)] blur-[80px]"></div>
            <div class="relative rounded-[2rem] card-surface-soft p-8 shadow-card backdrop-blur-xl sm:p-10">
                <div class="text-center">
                    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl border border-[rgba(109,109,255,0.25)] bg-[rgba(40,40,255,0.1)] shadow-glow-sm">
                        <x-logo :with-wordmark="false" :mark-size="28" />
                    </div>
                    <h1 class="mt-6 text-[1.75rem] font-semibold tracking-tight text-ink-50">Welcome back</h1>
                    <p class="mt-2 text-sm text-ink-400">Log in to continue building with Azenion.</p>
                </div>

                @if (session('status'))
                    <div class="mt-6 rounded-xl border border-emerald-400/25 bg-emerald-400/10 px-4 py-3 text-sm text-emerald-300">{{ session('status') }}</div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="mt-8 space-y-5">
                    @csrf

                    <div>
                        <label for="email" class="block text-sm font-medium text-ink-200">Email</label>
                        <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus
                               class="mt-2 block w-full rounded-xl border border-border bg-[rgba(255,255,255,0.04)] px-4 py-3 text-sm text-ink-50 placeholder-ink-600 transition-all focus:border-accent-400/60 focus:shadow-[0_0_0_1px_rgba(109,109,255,0.2)] focus:outline-none">
                        @error('email') <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-ink-200">Password</label>
                        <input id="password" name="password" type="password" required
                               class="mt-2 block w-full rounded-xl border border-border bg-[rgba(255,255,255,0.04)] px-4 py-3 text-sm text-ink-50 placeholder-ink-600 transition-all focus:border-accent-400/60 focus:shadow-[0_0_0_1px_rgba(109,109,255,0.2)] focus:outline-none">
                        @error('password') <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex items-center justify-between">
                        <label class="flex items-center gap-2 text-sm text-ink-400">
                            <input type="checkbox" name="remember" class="h-4 w-4 rounded border-border bg-[rgba(255,255,255,0.04)] accent-[#2828FF]">
                            Remember me
                        </label>
                    </div>

                    <button type="submit" class="inline-flex w-full items-center justify-center h-12 rounded-full bg-accent text-[15px] font-semibold text-white transition-all duration-300 hover:bg-accent-400 hover:shadow-glow">
                        Log in
                    </button>
                </form>

                <p class="mt-6 text-center text-sm text-ink-500">
                    Don't have an account?
                    <a href="{{ route('join') }}" class="font-medium text-accent-300 hover:underline">Join Azenion</a>
                </p>
            </div>
        </div>
    </main>
</x-layout>
