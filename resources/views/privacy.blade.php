<x-layout :title="'Azenion — Privacy Policy'">
    <main class="relative overflow-hidden pt-[120px]">
        <x-page-atmosphere />
        <div class="relative mx-auto max-w-3xl px-5 pb-24 sm:px-8 lg:px-12">
            <x-reveal>
                <x-eyebrow>Legal</x-eyebrow>
                <h1 class="mt-6 text-[2.5rem] font-semibold leading-[1.08] tracking-tight text-ink-50">Privacy Policy</h1>
                <p class="mt-3 text-sm text-ink-600">Last updated: {{ date('F j, Y') }}</p>
            </x-reveal>

            <div class="mt-12 space-y-10 text-[0.98rem] leading-8 text-ink-400">
                <x-reveal>
                    <section>
                        <h2 class="text-xl font-semibold text-ink-50">1. Information We Collect</h2>
                        <p class="mt-3">We collect information you provide directly, such as your name, email address, and profile details. We also collect usage data to improve the Platform experience.</p>
                    </section>
                </x-reveal>
                <x-reveal>
                    <section>
                        <h2 class="text-xl font-semibold text-ink-50">2. How We Use Your Information</h2>
                        <p class="mt-3">We use your information to operate and improve the Platform, connect you with communities and collaborators, and communicate important updates. We do not sell your personal data.</p>
                    </section>
                </x-reveal>
                <x-reveal>
                    <section>
                        <h2 class="text-xl font-semibold text-ink-50">3. Data Security</h2>
                        <p class="mt-3">We implement reasonable security measures to protect your information. However, no method of transmission over the internet is completely secure, and we cannot guarantee absolute security.</p>
                    </section>
                </x-reveal>
                <x-reveal>
                    <section>
                        <h2 class="text-xl font-semibold text-ink-50">4. Your Rights</h2>
                        <p class="mt-3">You may access, update, or delete your personal information at any time through your account settings or by contacting us. You may also object to certain processing of your data.</p>
                    </section>
                </x-reveal>
                <x-reveal>
                    <section>
                        <h2 class="text-xl font-semibold text-ink-50">5. Contact Us</h2>
                        <p class="mt-3">If you have questions about this Privacy Policy or your data, you can reach us at <a href="mailto:Azenion@outlook.com" class="text-accent-300 hover:underline">Azenion@outlook.com</a>.</p>
                    </section>
                </x-reveal>
            </div>
        </div>
    </main>
</x-layout>
