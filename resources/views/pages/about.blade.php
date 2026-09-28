@extends('layouts.app')

@section('title', 'Tentang Kami')
@section('description', setting('about_short'))

@section('content')
    <section class="container-page pb-14 pt-10 lg:pb-20 lg:pt-14">
        <nav class="label-mono"><a href="{{ route('home') }}" class="hover:text-ink">Beranda</a> / <span class="text-ink">Tentang</span></nav>
        <div class="mt-8 grid gap-10 lg:grid-cols-12">
            <h1 class="text-4xl font-extrabold sm:text-6xl lg:col-span-7">Percetakan kecil yang mengerjakan <span class="text-brand-green-deep">banyak hal</span> dengan teliti.</h1>
            <div class="lg:col-span-4 lg:col-start-9 lg:pt-4">
                <p class="label-mono">Bagian dari</p>
                <p class="mt-2 font-display text-2xl font-bold">{{ setting('company_parent') }}</p>
                @if (setting('founded_year'))
                    <p class="label-mono mt-6">Berdiri sejak</p>
                    <p class="mt-2 font-display text-2xl font-bold">{{ setting('founded_year') }}</p>
                @endif
            </div>
        </div>
    </section>

    {{-- Strip foto hasil kerja --}}
    <section class="overflow-hidden border-y border-line bg-white py-10" aria-label="Contoh hasil kerja">
        <div class="flex gap-6 px-4 sm:justify-center">
            @foreach (['buku5' => 'Buku panduan', 'brosur2' => 'Brosur lipat tiga', 'bantal_leher' => 'Bantal leher promosi', 'tas' => 'Tas spunbond', 'topi4' => 'Topi bordir'] as $file => $alt)
                <figure class="w-44 shrink-0 bg-paper p-2 sm:w-52" style="transform: rotate({{ [-2, 1.5, -1, 2, -1.5][$loop->index] }}deg)">
                    <img src="{{ asset("assets/portfolio/{$file}.webp") }}" alt="{{ $alt }}" loading="lazy" class="aspect-square w-full object-cover">
                    <figcaption class="mt-2 font-mono text-[10px] uppercase tracking-[0.14em] text-ink-muted">{{ $alt }}</figcaption>
                </figure>
            @endforeach
        </div>
    </section>

    <section class="py-14 lg:py-20">
        <div class="container-page grid gap-10 lg:grid-cols-12">
            <div class="lg:col-span-4"><x-section-heading number="01" label="Cerita kami" title="Siapa kami" /></div>
            <div class="prose-mkgu text-lg leading-relaxed lg:col-span-7 lg:col-start-6">
                @foreach (preg_split("/\n\s*\n/", trim((string) setting('about_full'))) as $para)
                    <p>{!! nl2br(e($para)) !!}</p>
                @endforeach
            </div>
        </div>
    </section>

    <section class="bg-paper-dark py-14 lg:py-20">
        <div class="container-page grid gap-12 lg:grid-cols-12">
            <div class="lg:col-span-5">
                <x-section-heading number="02" label="Visi" title="Arah kami" />
                <p class="mt-6 font-display text-2xl font-semibold leading-snug">“{{ setting('vision') }}”</p>
            </div>
            <div class="lg:col-span-6 lg:col-start-7">
                <x-section-heading number="03" label="Misi" title="Cara kami bekerja" />
                <ol class="mt-6 border-t border-ink">
                    @foreach (array_filter(array_map('trim', explode("\n", (string) setting('mission')))) as $item)
                        <li class="flex gap-5 border-b border-line py-5">
                            <span class="font-mono text-sm text-brand-green-deep">0{{ $loop->iteration }}</span>
                            <span class="text-[17px]">{{ $item }}</span>
                        </li>
                    @endforeach
                </ol>
            </div>
        </div>
    </section>

    <section class="py-14 lg:py-20">
        <div class="container-page grid items-center gap-10 lg:grid-cols-12">
            <div class="lg:col-span-3">
                <figure class="crop-frame mx-auto w-40 bg-white p-2 lg:w-full">
                    <span class="crop-b"></span>
                    <img src="{{ asset('assets/portfolio/mesin.webp') }}" alt="Mesin cetak offset" loading="lazy" class="aspect-[2/5] w-full object-cover">
                </figure>
            </div>
            <div class="lg:col-span-8 lg:col-start-5">
                <x-section-heading label="Yang kami pegang" title="Tiga hal yang tidak kami tawar." />
                <div class="mt-8 grid gap-8 sm:grid-cols-3">
                    @foreach ([
                        ['Proof dulu', 'Tidak ada pesanan yang naik mesin sebelum Anda setuju dengan proof-nya.'],
                        ['Harga terbuka', 'Rincian bahan, jumlah, dan finishing kami jelaskan sebelum Anda membayar.'],
                        ['Jadwal jelas', 'Estimasi selesai disepakati di awal dan kami kabari bila ada kendala.'],
                    ] as [$t, $d])
                        <div class="border-t-[3px] border-brand-yellow pt-4">
                            <h3 class="text-xl font-bold">{{ $t }}</h3>
                            <p class="mt-2 text-[15px] text-ink-muted">{{ $d }}</p>
                        </div>
                    @endforeach
                </div>
                <a href="{{ route('products.index') }}" class="btn-primary mt-10">Lihat katalog produk <x-icon name="arrow-right" class="h-4 w-4" /></a>
            </div>
        </div>
    </section>

    @include('partials.cta')
@endsection
