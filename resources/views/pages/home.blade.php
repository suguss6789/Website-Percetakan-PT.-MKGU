@extends('layouts.app')

@section('description', setting('tagline'))

@push('head')
<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'LocalBusiness',
    'name' => setting('company_name'),
    'description' => setting('tagline'),
    'image' => asset('assets/image/logo.png'),
    'url' => url('/'),
    'telephone' => '+' . wa_number(),
    'email' => setting('email'),
    'address' => ['@type' => 'PostalAddress', 'streetAddress' => setting('address'), 'addressLocality' => 'Jakarta Timur', 'addressCountry' => 'ID'],
    'openingHours' => ['Mo-Fr 08:00-17:00', 'Sa 08:00-15:00'],
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
</script>
@endpush

@section('content')
    {{-- HERO --}}
    <section class="relative overflow-hidden">
        <div class="container-page grid items-center gap-x-[clamp(2rem,4vw,5rem)] gap-y-12 pb-16 pt-10 lg:grid-cols-12 lg:pb-24 lg:pt-16">
            <div class="min-w-0 lg:col-span-6">
                <p class="label-mono flex items-center gap-3">
                    <span class="inline-block h-2.5 w-2.5 rounded-full bg-brand-green"></span>
                    Percetakan · Pisangan Timur, Jakarta Timur
                </p>
                <h1 class="mt-6 text-fluid-hero font-extrabold">
                    Dari brosur sampai kaos seragam, <span class="relative whitespace-nowrap text-brand-green-deep">dicetak rapi<svg class="absolute -bottom-2 left-0 h-3 w-full text-brand-yellow" viewBox="0 0 200 12" preserveAspectRatio="none" aria-hidden="true"><path d="M2 8c40-6 90-7 196-2" stroke="currentColor" stroke-width="6" fill="none" stroke-linecap="round"/></svg></span> di satu tempat.
                </h1>
                <p class="mt-7 max-w-xl text-fluid-lead text-ink-muted">
                    Offset printing, digital printing, konveksi & souvenir. Kita obrolkan dulu kebutuhannya, Anda cek proof-nya, baru naik mesin.
                </p>
                <div class="mt-9 flex flex-col gap-3 sm:flex-row">
                    <a href="{{ route('products.index') }}" class="btn-primary">Lihat Produk & Harga <x-icon name="arrow-right" class="h-4 w-4" /></a>
                    <a href="{{ wa_link('Halo MKGU, saya ingin konsultasi cetak.') }}" target="_blank" rel="noopener" class="btn-outline"><x-icon name="whatsapp" class="h-4 w-4" /> Konsultasi Gratis</a>
                </div>
            </div>

            {{-- "Meja cetak": hasil kerja yang ditumpuk. Semua posisi & ukuran dalam % dari kotak berasio tetap,
                 jadi komposisinya sama di HP, tablet, laptop, maupun monitor besar. --}}
            <div class="hero-collage relative mx-auto aspect-[1/0.92] w-full max-w-[34rem] lg:col-span-6 lg:max-w-none" aria-label="Contoh hasil cetak">
                <div class="absolute -inset-6 -z-10 hidden lg:block" style="background-image:linear-gradient(theme('colors.line') 1px,transparent 1px),linear-gradient(90deg,theme('colors.line') 1px,transparent 1px);background-size:32px 32px;mask-image:radial-gradient(ellipse at center,#000 30%,transparent 72%)"></div>

                <figure class="sheet crop-frame absolute left-[5%] top-[4%] w-[40%] bg-white p-[1.6%] shadow-[0_18px_40px_-20px_rgba(27,31,26,.35)]" style="--r:-5deg;animation-delay:.05s">
                    <span class="crop-b"></span>
                    <img src="{{ asset('assets/portfolio/buku1.webp') }}" alt="Sampul buku cetak full color" class="aspect-[3/4] w-full object-cover" width="620" height="860">
                </figure>
                <figure class="sheet absolute right-0 top-0 w-[54%] bg-white p-[1.4%] shadow-[0_18px_40px_-20px_rgba(27,31,26,.35)]" style="--r:3.5deg;animation-delay:.18s">
                    <img src="{{ asset('assets/portfolio/brosur2.webp') }}" alt="Brosur lipat tiga" class="aspect-[4/3] w-full object-cover" width="1000" height="746">
                </figure>
                <figure class="sheet absolute bottom-[5%] left-[31%] w-[35%] bg-white p-[1.6%] shadow-[0_18px_40px_-20px_rgba(27,31,26,.35)]" style="--r:2deg;animation-delay:.3s">
                    <img src="{{ asset('assets/portfolio/topi4.webp') }}" alt="Topi bordir custom" class="aspect-square w-full object-cover" width="1000" height="1044">
                </figure>
                <figure class="sheet absolute bottom-[11%] right-0 w-[35%] bg-white p-[1.6%] shadow-[0_18px_40px_-20px_rgba(27,31,26,.35)]" style="--r:-4deg;animation-delay:.42s">
                    <img src="{{ asset('assets/portfolio/mug.webp') }}" alt="Mug dengan logo" class="aspect-[4/3] w-full object-cover" width="1000" height="451">
                </figure>

                {{-- Job ticket: lebar & teks ikut ukuran kolase (container query) --}}
                <div class="hero-ticket sheet absolute bottom-[3%] left-0 hidden w-[31%] border border-ink/80 bg-paper font-mono uppercase sm:block" style="--r:-2deg;animation-delay:.55s">
                    <div class="flex items-center justify-between border-b border-dashed border-ink/40 pb-[0.6em]">
                        <span class="font-medium text-ink">Alur Kerja</span>
                        <svg class="h-[1.3em] w-[1.3em]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2" aria-hidden="true"><circle cx="12" cy="12" r="6"/><path d="M12 2v20M2 12h20"/></svg>
                    </div>
                    <ol class="mt-[0.6em] space-y-[0.45em] text-ink-muted">
                        <li class="flex justify-between gap-2"><span>Konsultasi</span><span class="text-brand-green-deep">✓</span></li>
                        <li class="flex justify-between gap-2"><span>Proof desain</span><span class="text-brand-green-deep">✓</span></li>
                        <li class="flex justify-between gap-2"><span>Cetak</span><span class="text-brand-green-deep">✓</span></li>
                        <li class="flex justify-between gap-2"><span>Siap ambil</span><span class="text-brand-green-deep">✓</span></li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    {{-- LINI KERJA --}}
    <section class="border-y border-line bg-white py-16 lg:py-24">
        <div class="container-page">
            <div class="flex flex-col gap-6 md:flex-row md:items-end md:justify-between">
                <x-section-heading label="Lini Kerja" title="Tiga bagian, satu tempat pesan." class="reveal" />
                <p class="max-w-sm text-ink-muted reveal">Tidak perlu cari vendor berbeda untuk buku, banner, dan kaos acara. Semuanya bisa dipesan sekaligus di sini.</p>
            </div>
            <ul class="mt-12 border-t border-ink">
                @foreach ($categories as $cat)
                    <li class="reveal">
                        <a href="{{ route('products.index', ['kategori' => $cat->slug]) }}" class="group grid grid-cols-[auto_1fr_auto] items-center gap-x-5 gap-y-2 border-b border-line py-7 transition-colors hover:bg-brand-yellow-soft/60 sm:gap-x-10 sm:px-4 lg:grid-cols-[80px_1fr_1.2fr_auto]">
                            <span class="font-mono text-sm text-brand-green-deep">0{{ $loop->iteration }}</span>
                            <span class="font-display text-fluid-h3 font-bold">{{ $cat->name }}</span>
                            <span class="col-span-3 text-ink-muted lg:col-span-1">{{ $cat->description }}</span>
                            <span class="col-start-3 row-start-1 flex items-center gap-3 lg:col-start-auto lg:row-start-auto">
                                <span class="hidden font-mono text-xs text-ink-soft sm:inline">{{ $cat->products_count }} produk</span>
                                <span class="inline-flex h-11 w-11 items-center justify-center rounded-full border border-ink/20 transition group-hover:border-ink group-hover:bg-ink group-hover:text-paper"><x-icon name="arrow-up-right" class="h-4 w-4" /></span>
                            </span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </section>

    {{-- PRODUK UNGGULAN --}}
    @if ($featured->isNotEmpty())
        <section class="py-16 lg:py-24">
            <div class="container-page">
                <div class="flex flex-col gap-6 sm:flex-row sm:items-end sm:justify-between">
                    <x-section-heading label="Sering Dipesan" title="Produk yang paling banyak ditanyakan.">
                        Harga yang tertera adalah kisaran per ukuran. Angka pastinya menyesuaikan jumlah, bahan, dan finishing.
                    </x-section-heading>
                    <a href="{{ route('products.index') }}" class="btn-outline shrink-0">Semua produk <x-icon name="arrow-right" class="h-4 w-4" /></a>
                </div>
                <div class="mt-12 grid grid-cols-2 gap-x-4 gap-y-10 sm:gap-x-6 sm:gap-y-12 lg:grid-cols-4">
                    @foreach ($featured as $product)
                        <div class="reveal" style="transition-delay: {{ ($loop->index % 4) * 70 }}ms"><x-product-card :product="$product" /></div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @include('partials.partners')

    {{-- TENTANG SINGKAT --}}
    <section class="bg-paper-dark py-16 lg:py-24">
        <div class="container-page grid gap-12 lg:grid-cols-12">
            <div class="reveal lg:col-span-7">
                <x-section-heading label="Tentang MKGU" title="Kami cek bareng sebelum naik mesin." />
                <p class="mt-6 max-w-2xl text-lg leading-relaxed text-ink-muted">{{ setting('about_short') }}</p>
                <a href="{{ route('about') }}" class="mt-8 inline-flex items-center gap-2 font-semibold text-brand-green-deep underline decoration-brand-yellow decoration-[3px] underline-offset-[6px] hover:decoration-brand-green-deep">
                    Kenali kami lebih jauh <x-icon name="arrow-right" class="h-4 w-4" />
                </a>
            </div>
            <aside class="reveal lg:col-span-5">
                <div class="crop-frame border border-ink/80 bg-paper p-6 sm:p-8">
                    <span class="crop-b"></span>
                    <p class="label-mono">Datang langsung</p>
                    <p class="mt-3 font-display text-2xl font-bold leading-snug">{{ setting('address') }}</p>
                    <dl class="mt-6 space-y-3 border-t border-dashed border-ink/30 pt-5 text-[0.9375rem]">
                        <div class="flex justify-between gap-4"><dt class="text-ink-muted">Senin – Jumat</dt><dd class="font-mono">08.00 – 17.00</dd></div>
                        <div class="flex justify-between gap-4"><dt class="text-ink-muted">Sabtu</dt><dd class="font-mono">08.00 – 15.00</dd></div>
                        <div class="flex justify-between gap-4"><dt class="text-ink-muted">WhatsApp</dt><dd class="font-mono">{{ wa_display() }}</dd></div>
                    </dl>
                    <a href="{{ setting('maps_link', '#') }}" target="_blank" rel="noopener" class="btn-outline mt-6 w-full"><x-icon name="map-pin" class="h-4 w-4" /> Petunjuk arah</a>
                </div>
            </aside>
        </div>
    </section>

    {{-- CARA PESAN --}}
    <section class="py-16 lg:py-24">
        <div class="container-page">
            <x-section-heading label="Cara Pesan" title="Empat langkah, tanpa ribet." class="reveal" />
            @php
                $steps = [
                    ['Konsultasi', 'Ceritakan kebutuhan Anda lewat WhatsApp atau datang langsung. Kami bantu pilihkan bahan dan ukuran yang pas dengan anggaran.'],
                    ['Kirim desain', 'Kirim file siap cetak (PDF, AI, CDR, atau JPG resolusi tinggi). Belum punya desain? Bisa kami bantu buatkan.'],
                    ['Proof & setuju', 'Kami kirim proof untuk dicek: warna, teks, ukuran. Produksi baru jalan setelah Anda setuju.'],
                    ['Cetak & ambil', 'Pesanan dikerjakan sesuai jadwal yang disepakati. Bisa diambil di tempat atau dikirim.'],
                ];
            @endphp
            <ol class="mt-12 grid gap-px overflow-hidden border border-line bg-line sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($steps as [$title, $text])
                    <li class="reveal flex flex-col bg-paper p-7" style="transition-delay: {{ $loop->index * 80 }}ms">
                        <span class="font-display text-[clamp(3.5rem,2.5rem+3vw,5.5rem)] font-extrabold leading-none text-transparent [-webkit-text-stroke:1.5px_theme('colors.brand.green-deep')]">{{ $loop->iteration }}</span>
                        <h3 class="mt-8 text-xl font-bold">{{ $title }}</h3>
                        <p class="mt-2 text-[0.9375rem] text-ink-muted">{{ $text }}</p>
                    </li>
                @endforeach
            </ol>
        </div>
    </section>

@endsection
