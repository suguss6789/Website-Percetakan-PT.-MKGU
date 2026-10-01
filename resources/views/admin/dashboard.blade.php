@extends('layouts.admin')
@section('title', 'Dashboard')
@section('crumb', 'Dashboard')

@section('content')
    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <h1 class="text-3xl font-bold">Halo, {{ \Illuminate\Support\Str::before(auth()->user()->name, ' ') }}.</h1>
            <p class="mt-1 text-ink-muted">Ringkasan isi website hari ini.</p>
        </div>
        <a href="{{ route('admin.products.create') }}" class="btn-primary"><x-icon name="plus" class="h-4 w-4" /> Tambah Produk</a>
    </div>

    <dl class="mt-8 grid grid-cols-2 gap-px overflow-hidden border border-line bg-line lg:grid-cols-4">
        @foreach ([
            ['Produk tampil', $activeCount, route('admin.products.index', ['status' => 'aktif'])],
            ['Disembunyikan', $hiddenCount, route('admin.products.index', ['status' => 'nonaktif'])],
            ['Produk unggulan', $featuredCount, route('admin.products.index')],
            ['Kategori', $categoryCount, route('admin.categories.index')],
        ] as [$label, $value, $link])
            <a href="{{ $link }}" class="bg-white p-5 hover:bg-paper">
                <dt class="label-mono">{{ $label }}</dt>
                <dd class="mt-2 font-display text-4xl font-bold">{{ $value }}</dd>
            </a>
        @endforeach
    </dl>

    <div class="mt-8 grid gap-6 lg:grid-cols-3">
        <section class="border border-line bg-white lg:col-span-2">
            <h2 class="border-b border-line px-5 py-4 text-lg font-bold">Terakhir diubah</h2>
            <ul>
                @foreach ($recent as $p)
                    <li class="flex items-center justify-between gap-4 border-b border-line px-5 py-3 last:border-0">
                        <div class="min-w-0">
                            <p class="truncate font-semibold">{{ $p->name }}</p>
                            <p class="text-sm text-ink-muted">{{ $p->category?->name }} · {{ $p->updated_at->diffForHumans() }}</p>
                        </div>
                        <a href="{{ route('admin.products.edit', $p) }}" class="btn-outline min-h-[36px] px-3 py-1.5 text-sm">Edit</a>
                    </li>
                @endforeach
            </ul>
        </section>

        <section class="border border-line bg-white">
            <h2 class="border-b border-line px-5 py-4 text-lg font-bold">Perlu dilengkapi</h2>
            <div class="space-y-5 p-5 text-[0.9375rem]">
                <div>
                    <p class="label-mono">Belum ada foto ({{ $noImage->count() }})</p>
                    <ul class="mt-2 space-y-1">
                        @forelse ($noImage as $p)
                            <li><a href="{{ route('admin.products.edit', $p) }}" class="text-brand-green-deep hover:underline">{{ $p->name }}</a></li>
                        @empty <li class="text-ink-muted">Semua produk sudah punya foto.</li> @endforelse
                    </ul>
                </div>
                <div>
                    <p class="label-mono">Belum ada harga ({{ $noPrice->count() }})</p>
                    <ul class="mt-2 space-y-1">
                        @forelse ($noPrice as $p)
                            <li><a href="{{ route('admin.products.edit', $p) }}" class="text-brand-green-deep hover:underline">{{ $p->name }}</a></li>
                        @empty <li class="text-ink-muted">Semua produk sudah punya kisaran harga.</li> @endforelse
                    </ul>
                </div>
            </div>
        </section>
    </div>
@endsection
