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
        <div class="container-page grid items-center gap-12 pb-16 pt-10 lg:grid-cols-12 lg:gap-8 lg:pb-24 lg:pt-16">
            <div class="lg:col-span-6">
                <p class="label-mono flex items-center gap-3">
                    <span class="inline-block h-2.5 w-2.5 rounded-full bg-brand-green"></span>
                    Percetakan · Pisangan Timur, Jakarta Timur
                </p>
                <h1 class="mt-6 text-[42px] font-extrabold sm:text-6xl lg:text-[68px]">
                    Dari brosur sampai kaos seragam, <span class="relative whitespace-nowrap text-brand-green-deep">dicetak rapi<svg class="absolute -bottom-2 left-0 h-3 w-full text-brand-yellow" viewBox="0 0 200 12" preserveAspectRatio="none" aria-hidden="true"><path d="M2 8c40-6 90-7 196-2" stroke="currentColor" stroke-width="6" fill="none" stroke-linecap="round"/></svg></span> di satu tempat.
                </h1>
                <p class="mt-7 max-w-xl text-lg text-ink-muted">
                    Offset printing, digital printing, konveksi & souvenir. Kita obrolkan dulu kebutuhannya, Anda cek proof-nya, baru naik mesin.
                </p>
                <div class="mt-9 flex flex-col gap-3 sm:flex-row">
                    <a href="{{ route('products.index') }}" class="btn-primary">Lihat Produk & Harga <x-icon name="arrow-right" class="h-4 w-4" /></a>
                    <a href="{{ wa_link('Halo MKGU, saya ingin konsultasi cetak.') }}" target="_blank" rel="noopener" class="btn-outline"><x-icon name="whatsapp" class="h-4 w-4" /> Konsultasi Gratis</a>
                </div>
            </div>

            {{-- "Meja cetak": hasil kerja yang ditumpuk --}}
            <div class="relative h-[400px] sm:h-[500px] lg:col-span-6 lg:h-[560px]" aria-label="Contoh hasil cetak">
                <div class="absolute inset-0 -z-10 hidden lg:block" style="background-image:linear-gradient(theme('colors.line') 1px,transparent 1px),linear-gradient(90deg,theme('colors.line') 1px,transparent 1px);background-size:32px 32px;mask-image:radial-gradient(ellipse at center,#000 30%,transparent 72%)"></div>

                <figure class="sheet crop-frame absolute left-[4%] top-[6%] w-[44%] bg-white p-2.5 shadow-[0_18px_40px_-20px_rgba(27,31,26,.35)]" style="--r:-5deg;animation-delay:.05s">
                    <span class="crop-b"></span>
                    <img src="{{ asset('assets/portfolio/buku1.webp') }}" alt="Sampul buku cetak full color" class="aspect-[3/4] w-full object-cover" width="160" height="215">
                </figure>
                <figure class="sheet absolute right-[2%] top-[2%] w-[56%] bg-white p-2.5 shadow-[0_18px_40px_-20px_rgba(27,31,26,.35)]" style="--r:3.5deg;animation-delay:.18s">
                    <img src="{{ asset('assets/portfolio/brosur2.webp') }}" alt="Brosur lipat tiga" class="aspect-[4/3] w-full object-cover" width="260" height="194">
                </figure>
                <figure class="sheet absolute bottom-[10%] left-[18%] w-[40%] bg-white p-2.5 shadow-[0_18px_40px_-20px_rgba(27,31,26,.35)]" style="--r:2deg;animation-delay:.3s">
                    <img src="{{ asset('assets/portfolio/topi4.webp') }}" alt="Topi bordir custom" class="aspect-square w-full object-cover" width="252" height="263">
                </figure>
                <figure class="sheet absolute bottom-[4%] right-[4%] w-[40%] bg-white p-2.5 shadow-[0_18px_40px_-20px_rgba(27,31,26,.35)]" style="--r:-4deg;animation-delay:.42s">
                    <img src="{{ asset('assets/portfolio/mug.webp') }}" alt="Mug dengan logo" class="aspect-[4/3] w-full object-cover" width="288" height="130">
                </figure>

                {{-- Job ticket --}}
                <div class="sheet absolute left-0 top-[52%] hidden w-52 border border-ink/80 bg-paper p-4 font-mono text-[11px] uppercase tracking-[0.1em] sm:block" style="--r:-2deg;animation-delay:.55s">
                    <div class="flex items-center justify-between border-b border-dashed border-ink/40 pb-2">
                        <span class="font-medium text-ink">Alur Kerja</span>
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2"><circle cx="12" cy="12" r="6"/><path d="M12 2v20M2 12h20"/></svg>
                    </div>
                    <ol class="mt-2 space-y-1.5 text-ink-muted">
                        <li class="flex justify-between"><span>Konsultasi</span><span class="text-brand-green-deep">✓</span></li>
                        <li class="flex justify-between"><span>Proof desain</span><span class="text-brand-green-deep">✓</span></li>
                        <li class="flex justify-between"><span>Cetak</span><span class="text-brand-green-deep">✓</span></li>
                        <li class="flex justify-between"><span>Siap ambil</span><span class="text-brand-green-deep">✓</span></li>
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
                        <a href="{{ route('products.index', ['kategori' => $cat->slug]) }}" class="group grid grid-cols-[auto_1fr_auto] items-center gap-x-5 gap-y-2 border-b border-line py-7 transition-colors hover:bg-brand-yellow-soft/60 sm:gap-x-10 sm:px-4 md:grid-cols-[80px_1fr_1.2fr_auto]">
                            <span class="font-mono text-sm text-brand-green-deep">0{{ $loop->iteration }}</span>
                            <span class="font-display text-2xl font-bold sm:text-4xl">{{ $cat->name }}</span>
                            <span class="col-span-3 text-ink-muted md:col-span-1">{{ $cat->description }}</span>
                            <span class="col-start-3 row-start-1 flex items-center gap-3 md:col-start-auto md:row-start-auto">
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
                <div class="mt-12 grid gap-x-6 gap-y-12 sm:grid-cols-2 lg:grid-cols-4">
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
                    <dl class="mt-6 space-y-3 border-t border-dashed border-ink/30 pt-5 text-[15px]">
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
                        <span class="font-display text-7xl font-extrabold leading-none text-transparent [-webkit-text-stroke:1.5px_theme('colors.brand.green-deep')]">{{ $loop->iteration }}</span>
                        <h3 class="mt-8 text-xl font-bold">{{ $title }}</h3>
                        <p class="mt-2 text-[15px] text-ink-muted">{{ $text }}</p>
                    </li>
                @endforeach
            </ol>
        </div>
    </section>

@endsection
