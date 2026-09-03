<x-layout :title="'Azenion — Terms of Service'">
    <main class="relative overflow-hidden pt-[120px]">
        <x-page-atmosphere />
        <div class="relative mx-auto max-w-3xl px-5 pb-24 sm:px-8 lg:px-12">
            <x-reveal>
                <x-eyebrow>Legal</x-eyebrow>
                <h1 class="mt-6 text-[2.5rem] font-semibold leading-[1.08] tracking-tight text-ink-50">Terms of Service</h1>
                <p class="mt-3 text-sm text-ink-600">Last updated: {{ date('F j, Y') }}</p>
            </x-reveal>

            <div class="mt-12 space-y-10 text-[0.98rem] leading-8 text-ink-400">
                <x-reveal>
                    <section>
                        <h2 class="text-xl font-semibold text-ink-50">1. Acceptance of Terms</h2>
                        <p class="mt-3">By accessing or using Azenion (the "Platform"), you agree to be bound by these Terms of Service. If you do not agree to these terms, please do not use the Platform.</p>
                    </section>
                </x-reveal>
                <x-reveal>
                    <section>
                        <h2 class="text-xl font-semibold text-ink-50">2. Your Account</h2>
                        <p class="mt-3">You are responsible for maintaining the confidentiality of your account credentials and for all activity that occurs under your account. You must provide accurate and complete information when creating an account and keep it updated.</p>
                    </section>
                </x-reveal>
                <x-reveal>
                    <section>
                        <h2 class="text-xl font-semibold text-ink-50">3. Acceptable Use</h2>
                        <p class="mt-3">You agree not to use the Platform to post unlawful, harmful, threatening, abusive, harassing, defamatory, or otherwise objectionable content. You must respect the rights of others and comply with all applicable laws and regulations.</p>
                    </section>
                </x-reveal>
                <x-reveal>
                    <section>
                        <h2 class="text-xl font-semibold text-ink-50">4. User Content</h2>
                        <p class="mt-3">You retain ownership of content you post. By posting content, you grant the Platform a non-exclusive license to host, display, and distribute it within the Platform. You are solely responsible for the content you share.</p>
                    </section>
                </x-reveal>
                <x-reveal>
                    <section>
                        <h2 class="text-xl font-semibold text-ink-50">5. Termination</h2>
                        <p class="mt-3">We may suspend or terminate your access to the Platform at our discretion, particularly for violations of these terms. You may delete your account at any time.</p>
                    </section>
                </x-reveal>
                <x-reveal>
                    <section>
                        <h2 class="text-xl font-semibold text-ink-50">6. Changes to These Terms</h2>
                        <p class="mt-3">We may update these terms from time to time. We will notify you of any material changes. Continued use of the Platform after changes constitutes acceptance of the revised terms.</p>
                    </section>
                </x-reveal>
            </div>
        </div>
    </main>
</x-layout>
