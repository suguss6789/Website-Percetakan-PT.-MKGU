@extends('layouts.app')

@section('title', $activeCategory ? $activeCategory->name : 'Produk & Harga')
@section('description', $activeCategory?->description ?: 'Katalog produk cetak MKGU lengkap dengan spesifikasi dan kisaran harga per ukuran.')

@section('content')
    <section class="border-b border-line">
        <div class="container-page pb-10 pt-10 lg:pt-14">
            <nav class="label-mono" aria-label="Breadcrumb"><a href="{{ route('home') }}" class="hover:text-ink">Beranda</a> / <span class="text-ink">Produk</span></nav>
            <div class="mt-6 grid gap-8 lg:grid-cols-12 lg:items-end">
                <div class="lg:col-span-7">
                    <h1 class="text-4xl font-extrabold sm:text-6xl">{{ $activeCategory?->name ?? 'Produk & kisaran harga' }}</h1>
                    <p class="mt-4 max-w-xl text-lg text-ink-muted">
                        {{ $activeCategory?->description ?? 'Harga ditulis sebagai kisaran per ukuran. Harga pasti tergantung jumlah, bahan, dan finishing yang dipilih.' }}
                    </p>
                </div>
                <form method="GET" action="{{ route('products.index') }}" class="lg:col-span-5" role="search">
                    @if ($activeCategory)<input type="hidden" name="kategori" value="{{ $activeCategory->slug }}">@endif
                    <label for="q" class="sr-only">Cari produk</label>
                    <div class="relative">
                        <x-icon name="search" class="pointer-events-none absolute left-4 top-1/2 h-5 w-5 -translate-y-1/2 text-ink-soft" />
                        <input id="q" name="q" value="{{ $search }}" type="search" placeholder="Cari: brosur, kaos, kalender…"
                            class="h-14 w-full rounded border border-ink/70 bg-white pl-12 pr-28 text-[16px] placeholder:text-ink-soft focus:border-brand-green-deep focus:outline-none focus:ring-2 focus:ring-brand-green/25">
                        <button class="btn-primary absolute right-1.5 top-1.5 h-11 min-h-0 px-4">Cari</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="container-page">
            <div class="-mb-px flex gap-1 overflow-x-auto [scrollbar-width:none]" role="tablist" aria-label="Kategori">
                @php $tab = 'shrink-0 border-b-[3px] px-4 py-3 text-[15px] font-semibold transition-colors'; @endphp
                <a href="{{ route('products.index', array_filter(['q' => $search])) }}" @class([$tab, 'border-brand-yellow text-ink' => ! $activeCategory, 'border-transparent text-ink-muted hover:text-ink' => $activeCategory])>Semua</a>
                @foreach ($categories as $cat)
                    @php $on = $activeCategory?->is($cat); @endphp
                    <a href="{{ route('products.index', array_filter(['kategori' => $cat->slug, 'q' => $search])) }}" @class([$tab, 'border-brand-yellow text-ink' => $on, 'border-transparent text-ink-muted hover:text-ink' => ! $on])>
                        {{ $cat->name }} <span class="ml-1 font-mono text-xs text-ink-soft">{{ $cat->products_count }}</span>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <section class="py-12 lg:py-16">
        <div class="container-page">
            <p class="label-mono mb-8">
                {{ $products->total() }} produk
                @if ($search) untuk “<span class="text-ink">{{ $search }}</span>” · <a href="{{ route('products.index', array_filter(['kategori' => $activeCategory?->slug])) }}" class="underline hover:text-ink">hapus pencarian</a>@endif
            </p>

            @if ($products->isEmpty())
                <div class="crop-frame mx-auto max-w-lg border border-dashed border-ink/40 bg-white p-10 text-center">
                    <span class="crop-b"></span>
                    <p class="font-display text-2xl font-bold">Belum ada yang cocok.</p>
                    <p class="mt-2 text-ink-muted">Produk yang Anda cari mungkin belum masuk katalog, tapi kemungkinan besar tetap bisa kami kerjakan.</p>
                    <a href="{{ wa_link('Halo MKGU, apakah bisa cetak ' . ($search ?: 'produk') . '?') }}" target="_blank" rel="noopener" class="btn-wa mt-6"><x-icon name="whatsapp" class="h-4 w-4" /> Tanyakan via WhatsApp</a>
                </div>
            @else
                <div class="grid gap-x-6 gap-y-14 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                    @foreach ($products as $product)
                        <x-product-card :product="$product" />
                    @endforeach
                </div>
                <div class="mt-14">{{ $products->links() }}</div>
            @endif
        </div>
    </section>

@endsection
