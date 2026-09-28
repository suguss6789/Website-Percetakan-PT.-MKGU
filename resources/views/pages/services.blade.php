@extends('layouts.app')

@section('title', 'Layanan')
@section('description', 'Layanan offset printing, digital printing, serta konveksi dan souvenir di MKGU Jakarta Timur.')

@php
    $covers = ['offset-printing' => 'buku1', 'digital-printing' => 'brosur2', 'konveksi-souvenir' => 'topi4'];
    $extra = [
        'offset-printing' => 'Paling hemat untuk jumlah besar. Warna dijaga konsisten dari awal sampai akhir produksi.',
        'digital-printing' => 'Tanpa minimal order besar dan cepat selesai. Cocok untuk kebutuhan mendadak atau jumlah sedikit.',
        'konveksi-souvenir' => 'Sablon, bordir, dan cetak sublim untuk merchandise yang dipakai berulang kali.',
    ];
@endphp

@section('content')
    <section class="container-page pb-12 pt-10 lg:pt-14">
        <nav class="label-mono"><a href="{{ route('home') }}" class="hover:text-ink">Beranda</a> / <span class="text-ink">Layanan</span></nav>
        <div class="mt-8 grid gap-8 lg:grid-cols-12 lg:items-end">
            <h1 class="text-4xl font-extrabold sm:text-6xl lg:col-span-7">Satu tempat untuk cetak dan promosi.</h1>
            <p class="text-lg text-ink-muted lg:col-span-4 lg:col-start-9">Pilih lini yang sesuai dengan jumlah dan waktu Anda. Kalau ragu, ceritakan kebutuhannya dan kami sarankan yang paling masuk akal.</p>
        </div>
        <nav class="mt-10 flex flex-wrap gap-2" aria-label="Loncat ke layanan">
            @foreach ($categories as $cat)
                <a href="#{{ $cat->slug }}" class="rounded-full border border-line bg-white px-4 py-2 text-sm font-semibold hover:border-ink">0{{ $loop->iteration }} · {{ $cat->name }}</a>
            @endforeach
        </nav>
    </section>

    @foreach ($categories as $cat)
        <section id="{{ $cat->slug }}" @class(['border-t border-line py-14 lg:py-20', 'bg-white' => $loop->odd])>
            <div class="container-page grid items-start gap-10 lg:grid-cols-12 lg:gap-14">
                <div @class(['lg:col-span-5', 'lg:order-2 lg:col-start-8' => $loop->even])>
                    <figure class="crop-frame reveal bg-paper p-3" style="transform: rotate({{ $loop->even ? '1.5' : '-1.5' }}deg)">
                        <span class="crop-b"></span>
                        @if (isset($covers[$cat->slug]))
                            <img src="{{ asset('assets/portfolio/' . $covers[$cat->slug] . '.webp') }}" alt="Contoh {{ $cat->name }}" loading="lazy" class="aspect-[4/3] w-full bg-white object-contain">
                        @else
                            <div class="aspect-[4/3]"><x-sheet-blank :title="$cat->name" /></div>
                        @endif
                    </figure>
                </div>
                <div @class(['lg:col-span-6', 'lg:col-start-7' => $loop->odd, 'lg:order-1' => $loop->even])>
                    <p class="label-mono"><span class="text-brand-green-deep">0{{ $loop->iteration }}</span> · {{ $cat->products->count() }} produk</p>
                    <h2 class="mt-3 text-3xl font-bold sm:text-5xl">{{ $cat->name }}</h2>
                    <p class="mt-4 text-lg text-ink-muted">{{ $cat->description }} {{ $extra[$cat->slug] ?? '' }}</p>

                    @if ($cat->products->isNotEmpty())
                        <ul class="mt-8 border-t border-ink">
                            @foreach ($cat->products as $p)
                                <li>
                                    <a href="{{ route('products.show', $p) }}" class="group flex items-center justify-between gap-4 border-b border-line py-4 hover:bg-paper">
                                        <span class="font-semibold group-hover:text-brand-green-deep">{{ $p->name }}</span>
                                        <span class="shrink-0 font-mono text-sm text-ink-muted">{{ $p->price_range_label ?? 'Sesuai permintaan' }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                    <a href="{{ route('products.index', ['kategori' => $cat->slug]) }}" class="btn-outline mt-8">Lihat {{ $cat->name }} <x-icon name="arrow-right" class="h-4 w-4" /></a>
                </div>
            </div>
        </section>
    @endforeach

    <div class="pt-4">@include('partials.cta')</div>
@endsection
