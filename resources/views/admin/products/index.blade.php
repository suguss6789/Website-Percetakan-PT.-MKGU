@extends('layouts.admin')
@section('title', 'Produk')
@section('crumb', 'Produk')

@section('content')
    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <h1 class="text-3xl font-bold">Produk</h1>
            <p class="mt-1 text-ink-muted">{{ $products->total() }} produk. Produk nonaktif tidak tampil di website.</p>
        </div>
        <a href="{{ route('admin.products.create') }}" class="btn-primary"><x-icon name="plus" class="h-4 w-4" /> Tambah Produk</a>
    </div>

    <form method="GET" class="mt-6 grid gap-3 sm:grid-cols-[1fr_200px_160px_auto]">
        <input type="search" name="q" value="{{ $search }}" placeholder="Cari nama produk…" class="field-input" aria-label="Cari">
        <select name="kategori" class="field-input" aria-label="Kategori">
            <option value="">Semua kategori</option>
            @foreach ($categories as $c)<option value="{{ $c->id }}" @selected(request('kategori') == $c->id)>{{ $c->name }}</option>@endforeach
        </select>
        <select name="status" class="field-input" aria-label="Status">
            <option value="">Semua status</option>
            <option value="aktif" @selected(request('status') === 'aktif')>Tampil</option>
            <option value="nonaktif" @selected(request('status') === 'nonaktif')>Disembunyikan</option>
        </select>
        <button class="btn-outline">Terapkan</button>
    </form>

    <div class="mt-6 overflow-hidden border border-line bg-white">
        @forelse ($products as $p)
            <div class="grid grid-cols-[64px_1fr] items-center gap-4 border-b border-line p-4 last:border-0 md:grid-cols-[64px_1.6fr_1fr_1.2fr_auto]">
                <div class="h-16 w-16 border border-line bg-paper">
                    @if ($p->thumb_url)<img src="{{ $p->thumb_url }}" alt="" class="h-full w-full object-contain p-1">
                    @else <div class="grid h-full place-items-center text-ink-soft"><x-icon name="image" /></div>@endif
                </div>
                <div class="min-w-0">
                    <p class="truncate font-semibold">
                        {{ $p->name }}
                        @if ($p->is_featured)<span class="ml-1 bg-brand-yellow px-1.5 py-0.5 align-middle font-mono text-[10px] uppercase tracking-wider">Unggulan</span>@endif
                    </p>
                    <p class="text-sm text-ink-muted">{{ $p->category?->name }} · {{ $p->sizes->count() }} ukuran</p>
                </div>
                <p class="col-start-2 font-mono text-sm md:col-start-auto">{{ $p->price_range_label ?? '—' }}</p>
                <form method="POST" action="{{ route('admin.products.toggle', $p) }}" class="col-start-2 md:col-start-auto">
                    @csrf @method('PATCH')
                    <button @class([
                        'inline-flex items-center gap-2 rounded-full border px-3 py-1 text-sm font-semibold',
                        'border-brand-green/40 bg-brand-green/10 text-brand-green-deep' => $p->is_active,
                        'border-line bg-paper text-ink-muted' => ! $p->is_active,
                    ]) title="Klik untuk mengubah">
                        <span @class(['h-2 w-2 rounded-full', 'bg-brand-green' => $p->is_active, 'bg-ink-soft' => ! $p->is_active])></span>
                        {{ $p->is_active ? 'Tampil' : 'Disembunyikan' }}
                    </button>
                </form>
                <div class="col-start-2 flex gap-2 md:col-start-auto" x-data="{ confirm: false }">
                    <a href="{{ route('products.show', $p) }}" target="_blank" class="inline-flex h-9 w-9 items-center justify-center rounded border border-line hover:border-ink" title="Lihat di website"><x-icon name="eye" class="h-4 w-4" /></a>
                    <a href="{{ route('admin.products.edit', $p) }}" class="inline-flex h-9 w-9 items-center justify-center rounded border border-line hover:border-ink" title="Edit"><x-icon name="pencil" class="h-4 w-4" /></a>
                    <button type="button" @click="confirm = true" class="inline-flex h-9 w-9 items-center justify-center rounded border border-line text-brand-orange-deep hover:border-brand-orange-deep" title="Hapus"><x-icon name="trash" class="h-4 w-4" /></button>

                    <div x-cloak x-show="confirm" x-transition.opacity class="fixed inset-0 z-50 grid place-items-center bg-ink/50 p-4" @keydown.escape.window="confirm = false" @click.self="confirm = false">
                        <div class="w-full max-w-md bg-white p-6">
                            <h2 class="text-xl font-bold">Hapus “{{ $p->name }}”?</h2>
                            <p class="mt-2 text-ink-muted">Produk ini beserta semua ukuran, harga, dan fotonya akan dihapus permanen. Kalau hanya ingin menyembunyikan sementara, pakai tombol status.</p>
                            <div class="mt-6 flex justify-end gap-2">
                                <button type="button" @click="confirm = false" class="btn-outline">Batal</button>
                                <form method="POST" action="{{ route('admin.products.destroy', $p) }}">@csrf @method('DELETE')<button class="btn bg-brand-orange-deep text-white hover:bg-[#a93814]">Ya, hapus</button></form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <p class="p-10 text-center text-ink-muted">Belum ada produk yang cocok.</p>
        @endforelse
    </div>
    <div class="mt-6">{{ $products->links() }}</div>
@endsection
