@extends('layouts.app')

@section('title', $product->name)
@section('description', $product->short_description)
@if ($product->image_url) @section('og_image', $product->image_url) @endif

@php
    $gallery = collect();
    if ($product->image_url) $gallery->push(['url' => $product->image_url, 'thumb' => $product->thumb_url, 'alt' => $product->name]);
    foreach ($product->images as $img) $gallery->push(['url' => $img->url, 'thumb' => $img->thumb_url, 'alt' => $img->alt ?: $product->name]);
    $prices = $product->sizes->flatMap(fn ($s) => array_filter([$s->price_min, $s->price_max]));
@endphp

@push('head')
<script type="application/ld+json">
{!! json_encode(array_filter([
    '@context' => 'https://schema.org',
    '@type' => 'Product',
    'name' => $product->name,
    'description' => $product->short_description,
    'image' => $gallery->pluck('url')->all() ?: null,
    'category' => $product->category?->name,
    'brand' => ['@type' => 'Brand', 'name' => setting('company_name')],
    'offers' => $prices->isNotEmpty() ? [
        '@type' => 'AggregateOffer', 'priceCurrency' => 'IDR',
        'lowPrice' => $prices->min(), 'highPrice' => $prices->max(),
        'offerCount' => $product->sizes->count(),
    ] : null,
]), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
</script>
@endpush

@section('content')
<div x-data="sizePicker({ product: @js($product->name), url: @js(route('products.show', $product)), number: @js(wa_number()) })">
    <section class="container-page pb-12 pt-8 lg:pb-20 lg:pt-12">
        <nav class="label-mono" aria-label="Breadcrumb">
            <a href="{{ route('products.index') }}" class="hover:text-ink">Produk</a> /
            <a href="{{ route('products.index', ['kategori' => $product->category->slug]) }}" class="hover:text-ink">{{ $product->category->name }}</a> /
            <span class="text-ink">{{ $product->name }}</span>
        </nav>

        <div class="mt-8 grid gap-10 lg:grid-cols-12 lg:gap-14">
            {{-- Galeri --}}
            <div class="lg:col-span-7">
                @if ($gallery->isNotEmpty())
                    <div x-data="gallery(@js($gallery->values()))" class="lg:sticky lg:top-24">
                        <div class="crop-frame relative aspect-[4/3] bg-white" @touchstart.passive="touchStart" @touchend="touchEnd">
                            <span class="crop-b"></span>
                            <template x-for="(img, i) in images" :key="i">
                                <button type="button" x-show="active === i" @click="zoom = true" class="absolute inset-0 cursor-zoom-in border border-line p-6" :aria-label="'Perbesar gambar ' + (i + 1)">
                                    <img :src="img.url" :alt="img.alt" class="h-full w-full object-contain" :loading="i === 0 ? 'eager' : 'lazy'">
                                </button>
                            </template>
                            <template x-if="images.length > 1">
                                <div class="pointer-events-none absolute inset-x-3 top-1/2 flex -translate-y-1/2 justify-between">
                                    <button type="button" @click="go(active - 1)" class="pointer-events-auto inline-flex h-11 w-11 items-center justify-center rounded-full border border-line bg-paper/90 hover:bg-white" aria-label="Gambar sebelumnya"><x-icon name="chevron-left" /></button>
                                    <button type="button" @click="go(active + 1)" class="pointer-events-auto inline-flex h-11 w-11 items-center justify-center rounded-full border border-line bg-paper/90 hover:bg-white" aria-label="Gambar berikutnya"><x-icon name="chevron-right" /></button>
                                </div>
                            </template>
                            <span x-show="images.length > 1" class="absolute bottom-3 right-3 bg-ink px-2 py-1 font-mono text-[11px] text-paper" x-text="(active + 1) + ' / ' + images.length"></span>
                        </div>
                        <div x-show="images.length > 1" class="mt-4 flex gap-3 overflow-x-auto pb-1">
                            <template x-for="(img, i) in images" :key="'t' + i">
                                <button type="button" @click="go(i)" class="h-20 w-20 shrink-0 border-2 bg-white p-1 transition" :class="active === i ? 'border-brand-green-deep' : 'border-line hover:border-ink/40'" :aria-label="'Lihat gambar ' + (i + 1)">
                                    <img :src="img.thumb" alt="" class="h-full w-full object-contain">
                                </button>
                            </template>
                        </div>

                        {{-- Perbesar --}}
                        <div x-cloak x-show="zoom" x-transition.opacity @keydown.escape.window="zoom = false" @click.self="zoom = false" class="fixed inset-0 z-50 flex items-center justify-center bg-ink/90 p-4" role="dialog" aria-modal="true">
                            <button type="button" @click="zoom = false" class="absolute right-4 top-4 inline-flex h-11 w-11 items-center justify-center rounded-full bg-paper text-ink" aria-label="Tutup"><x-icon name="x" /></button>
                            <img :src="images[active].url" :alt="images[active].alt" class="max-h-[88vh] max-w-full bg-white object-contain p-4">
                        </div>
                    </div>
                @else
                    <div class="crop-frame aspect-[4/3]"><span class="crop-b"></span><div class="h-full border border-line"><x-sheet-blank :title="$product->name" :label="$product->category->name" /></div></div>
                @endif
            </div>

            {{-- Info --}}
            <div class="lg:col-span-5">
                <p class="label-mono text-brand-green-deep">{{ $product->category->name }}</p>
                <h1 class="mt-2 text-4xl font-extrabold sm:text-5xl">{{ $product->name }}</h1>
                <p class="mt-4 text-lg text-ink-muted">{{ $product->short_description }}</p>

                <div class="mt-7 border-y border-line py-5">
                    <p class="label-mono">Kisaran harga</p>
                    <p class="mt-1 font-mono text-2xl font-medium">
                        @if ($product->price_range_label)<span class="highlight">{{ $product->price_range_label }}</span>
                        @else <span class="text-ink-muted">Harga sesuai permintaan</span>@endif
                    </p>
                </div>

                @if ($product->min_order || $product->production_time)
                    <dl class="grid grid-cols-2 border-b border-line">
                        @if ($product->min_order)
                            <div class="py-4 pr-4"><dt class="label-mono">Minimal order</dt><dd class="mt-1 font-semibold">{{ $product->min_order }}</dd></div>
                        @endif
                        @if ($product->production_time)
                            <div @class(['py-4', 'border-l border-line pl-4' => $product->min_order])><dt class="label-mono">Pengerjaan</dt><dd class="mt-1 font-semibold">{{ $product->production_time }}</dd></div>
                        @endif
                    </dl>
                @endif

                <div class="mt-7">
                    <a :href="waUrl" href="{{ $product->whatsapp_url }}" target="_blank" rel="noopener" class="btn-wa w-full text-base">
                        <x-icon name="whatsapp" class="h-5 w-5" />
                        <span x-text="selected ? 'Tanya harga ukuran ' + selected : 'Tanya harga via WhatsApp'">Tanya harga via WhatsApp</span>
                    </a>
                    @if ($product->sizes->isNotEmpty())
                        <p class="mt-3 text-center text-sm text-ink-muted">Pilih ukuran di tabel bawah agar langsung tercantum di pesan.</p>
                    @endif
                </div>
            </div>
        </div>
    </section>

    {{-- Harga per ukuran --}}
    <section id="harga" class="border-t border-line bg-white py-14 lg:py-20">
        <div class="container-page grid gap-12 lg:grid-cols-12">
            <div class="lg:col-span-7">
                <x-section-heading number="01" label="Harga per ukuran" title="Pilih ukuran" />
                @if ($product->sizes->isNotEmpty())
                    <fieldset class="mt-8">
                        <legend class="sr-only">Ukuran</legend>
                        {{-- Kepala tabel (desktop) --}}
                        <div class="hidden grid-cols-[28px_1.1fr_1fr_1.4fr] gap-4 border-b border-ink pb-3 font-mono text-[11px] uppercase tracking-[0.14em] text-ink-muted sm:grid">
                            <span></span><span>Ukuran</span><span>Dimensi</span><span class="text-right">Kisaran harga</span>
                        </div>
                        @foreach ($product->sizes as $size)
                            @php $value = $size->label . ($size->dimension && $size->dimension !== '—' ? " ({$size->dimension})" : ''); @endphp
                            <label class="grid cursor-pointer grid-cols-[28px_1fr] items-start gap-x-4 gap-y-1 border-b border-line py-4 transition-colors hover:bg-paper sm:grid-cols-[28px_1.1fr_1fr_1.4fr] sm:items-center sm:px-0"
                                :class="selected === @js($value) && 'bg-brand-yellow-soft hover:bg-brand-yellow-soft'">
                                <input type="radio" name="size" value="{{ $value }}" x-model="selected" class="mt-1 h-4 w-4 accent-[#067A35] sm:mt-0">
                                <span class="font-semibold">{{ $size->label }}
                                    @if ($size->note)<span class="block text-sm font-normal text-ink-muted">{{ $size->note }}</span>@endif
                                </span>
                                <span class="col-start-2 font-mono text-sm text-ink-muted sm:col-start-auto">{{ $size->dimension }}</span>
                                <span class="col-start-2 font-mono text-[15px] sm:col-start-auto sm:text-right">{{ $size->price_label }} <span class="text-ink-muted">/ {{ \Illuminate\Support\Str::after($size->unit, 'per ') }}</span></span>
                            </label>
                        @endforeach
                    </fieldset>
                @else
                    <p class="mt-8 text-ink-muted">Harga produk ini dihitung sesuai permintaan. Kirimkan ukuran dan jumlah yang Anda butuhkan lewat WhatsApp.</p>
                @endif
                <p class="mt-6 flex gap-3 border-l-[3px] border-brand-yellow bg-paper px-4 py-3 text-sm text-ink-muted">
                    Harga adalah perkiraan dan dapat berubah tergantung jumlah, bahan, dan finishing. Hubungi kami untuk penawaran pasti.
                </p>
            </div>

            @if (! empty($product->specifications))
                <div class="lg:col-span-5">
                    <x-section-heading number="02" label="Spesifikasi" title="Detail teknis" />
                    <dl class="mt-8 border-t border-ink">
                        @foreach ($product->specifications as $spec)
                            <div class="grid grid-cols-[120px_1fr] gap-4 border-b border-line py-4">
                                <dt class="font-mono text-[11px] uppercase tracking-[0.14em] text-ink-muted">{{ $spec['label'] }}</dt>
                                <dd class="text-[15px]">{{ $spec['value'] }}</dd>
                            </div>
                        @endforeach
                    </dl>
                </div>
            @endif
        </div>
    </section>

    {{-- Deskripsi --}}
    <section class="py-14 lg:py-20">
        <div class="container-page grid gap-10 lg:grid-cols-12">
            <div class="lg:col-span-4"><x-section-heading number="03" label="Deskripsi" title="Tentang produk ini" /></div>
            <div class="prose-mkgu text-[17px] leading-relaxed lg:col-span-7 lg:col-start-6">
                @foreach (preg_split("/\n\s*\n/", trim($product->description)) as $para)
                    <p>{!! nl2br(e($para)) !!}</p>
                @endforeach
            </div>
        </div>
    </section>
</div>

    @if ($related->isNotEmpty())
        <section class="border-t border-line py-14 lg:py-20">
            <div class="container-page">
                <div class="flex items-end justify-between gap-6">
                    <h2 class="text-3xl font-bold">Lainnya di {{ $product->category->name }}</h2>
                    <a href="{{ route('products.index', ['kategori' => $product->category->slug]) }}" class="hidden font-semibold text-brand-green-deep hover:underline sm:inline">Lihat semua →</a>
                </div>
                <div class="mt-10 grid gap-x-6 gap-y-12 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach ($related as $item)<x-product-card :product="$item" />@endforeach
                </div>
            </div>
        </section>
    @endif

@endsection
