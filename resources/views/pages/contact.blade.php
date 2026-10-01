@extends('layouts.app')

@section('title', 'Kontak')
@section('description', 'Alamat, WhatsApp, email, dan jam operasional MKGU di ' . setting('address'))

@section('content')
    <section class="container-page pb-14 pt-10 lg:pb-20 lg:pt-14">
        <nav class="label-mono"><a href="{{ route('home') }}" class="hover:text-ink">Beranda</a> / <span class="text-ink">Kontak</span></nav>
        <h1 class="mt-8 max-w-3xl text-fluid-h1 font-extrabold">Mampir, telepon, atau chat saja.</h1>

        <div class="mt-12 grid gap-10 lg:grid-cols-12">
            <div class="min-w-0 lg:col-span-5">
                <a href="{{ wa_link('Halo MKGU, saya ingin konsultasi cetak.') }}" target="_blank" rel="noopener" class="group block bg-brand-green-deep p-5 text-white sm:p-7 transition hover:bg-brand-green-ink">
                    <p class="font-mono text-[0.6875rem] uppercase tracking-[0.14em] text-brand-yellow">Paling cepat</p>
                    <p class="mt-3 flex items-center gap-3 font-display text-[clamp(1.45rem,1rem+2vw,2rem)] font-bold"><x-icon name="whatsapp" class="h-[1em] w-[1em] shrink-0" /> {{ wa_display() }}</p>
                    <p class="mt-2 flex items-center gap-2 text-white/80">Chat WhatsApp <x-icon name="arrow-up-right" class="h-4 w-4 transition group-hover:translate-x-0.5 group-hover:-translate-y-0.5" /></p>
                </a>

                <dl class="mt-8 border-t border-ink">
                    <div class="grid grid-cols-[minmax(5.5rem,7rem)_minmax(0,1fr)] gap-4 border-b border-line py-5">
                        <dt class="label-mono pt-1">Alamat</dt>
                        <dd class="text-[1.0625rem]">{{ setting('address') }}
                            <a href="{{ setting('maps_link', '#') }}" target="_blank" rel="noopener" class="mt-2 flex items-center gap-1.5 text-sm font-semibold text-brand-green-deep hover:underline"><x-icon name="map-pin" class="h-4 w-4" /> Petunjuk arah</a>
                        </dd>
                    </div>
                    <div class="grid grid-cols-[minmax(5.5rem,7rem)_minmax(0,1fr)] gap-4 border-b border-line py-5">
                        <dt class="label-mono pt-1">Email</dt>
                        <dd class="text-[1.0625rem] [overflow-wrap:anywhere]"><a href="mailto:{{ setting('email') }}" class="hover:text-brand-green-deep hover:underline">{{ setting('email') }}</a></dd>
                    </div>
                    @if (setting('phone'))
                        <div class="grid grid-cols-[minmax(5.5rem,7rem)_minmax(0,1fr)] gap-4 border-b border-line py-5">
                            <dt class="label-mono pt-1">Telepon</dt>
                            <dd class="text-[1.0625rem]"><a href="tel:{{ preg_replace('/[^\d+]/', '', setting('phone')) }}" class="hover:text-brand-green-deep hover:underline">{{ setting('phone') }}</a></dd>
                        </div>
                    @endif
                    <div class="grid grid-cols-[minmax(5.5rem,7rem)_minmax(0,1fr)] gap-4 border-b border-line py-5">
                        <dt class="label-mono pt-1">Jam buka</dt>
                        <dd class="text-[1.0625rem]">{{ setting('hours_weekday') }}<br>{{ setting('hours_saturday') }}<br><span class="text-ink-muted">Minggu & hari libur tutup</span></dd>
                    </div>
                </dl>
            </div>

            <div class="min-w-0 lg:col-span-7">
                <div class="crop-frame h-full min-h-[380px] bg-white p-2">
                    <span class="crop-b"></span>
                    @if (setting('maps_embed_url'))
                        <iframe src="{{ setting('maps_embed_url') }}" title="Peta lokasi {{ setting('company_name') }}" class="h-full min-h-[380px] w-full grayscale-[30%]" loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <section class="border-t border-line bg-white py-14">
        <div class="container-page grid gap-8 md:grid-cols-3">
            @foreach ([
                ['Siapkan ukuran & jumlah', 'Dua informasi ini yang paling menentukan harga. Kalau belum pasti, perkiraan kasar juga tidak apa-apa.'],
                ['Format file', 'PDF, AI, CDR, PSD, atau JPG/PNG resolusi tinggi (300 dpi). Teks sebaiknya sudah di-outline.'],
                ['Belum ada desain?', 'Kirim logo, teks, dan contoh yang Anda suka. Tim kami bisa bantu menyusun desainnya.'],
            ] as [$t, $d])
                <div>
                    <p class="font-mono text-sm text-brand-green-deep">0{{ $loop->iteration }}</p>
                    <h2 class="mt-2 text-xl font-bold">{{ $t }}</h2>
                    <p class="mt-2 text-[0.9375rem] text-ink-muted">{{ $d }}</p>
                </div>
            @endforeach
        </div>
    </section>
@endsection
