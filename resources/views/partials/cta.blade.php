<section class="pb-16 lg:pb-24">
    <div class="container-page">
        <div class="relative overflow-hidden bg-brand-green-deep px-6 py-14 text-white sm:px-12 lg:py-20">
            <svg class="pointer-events-none absolute -right-10 -top-10 h-64 w-64 text-white/10" viewBox="0 0 100 100" fill="none" stroke="currentColor" stroke-width=".8" aria-hidden="true"><circle cx="50" cy="50" r="28"/><circle cx="50" cy="50" r="14"/><path d="M50 0v100M0 50h100"/></svg>
            <div class="relative grid items-end gap-10 lg:grid-cols-12">
                <div class="lg:col-span-8">
                    <p class="font-mono text-[11px] uppercase tracking-[0.14em] text-brand-yellow">Punya rencana cetak?</p>
                    <h2 class="mt-3 text-3xl font-bold text-white sm:text-5xl">Kirim ukuran dan jumlahnya, kami balas dengan penawaran.</h2>
                    <p class="mt-4 max-w-xl text-white/80">Konsultasi dan penawaran harga tidak dipungut biaya. Anda bebas membandingkan dulu.</p>
                </div>
                <div class="flex flex-col gap-3 lg:col-span-4 lg:items-end">
                    <a href="{{ wa_link('Halo MKGU, saya ingin minta penawaran cetak.') }}" target="_blank" rel="noopener" class="btn-wa w-full lg:w-auto"><x-icon name="whatsapp" class="h-5 w-5" /> {{ wa_display() }}</a>
                    <a href="mailto:{{ setting('email') }}" class="btn-ghost-light w-full lg:w-auto"><x-icon name="mail" class="h-4 w-4" /> {{ setting('email') }}</a>
                </div>
            </div>
        </div>
    </div>
</section>
