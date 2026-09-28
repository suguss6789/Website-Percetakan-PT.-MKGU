@extends('layouts.admin')
@section('title', 'Kategori')
@section('crumb', 'Kategori')

@section('content')
    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <h1 class="text-3xl font-bold">Kategori</h1>
            <p class="mt-1 text-ink-muted">Kategori tampil sebagai filter di katalog dan sebagai lini layanan.</p>
        </div>
        <a href="{{ route('admin.categories.create') }}" class="btn-primary"><x-icon name="plus" class="h-4 w-4" /> Tambah Kategori</a>
    </div>

    <div class="mt-6 border border-line bg-white">
        @foreach ($categories as $c)
            <div class="flex flex-col gap-3 border-b border-line p-5 last:border-0 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <p class="font-semibold"><span class="mr-2 font-mono text-xs text-ink-soft">#{{ $c->sort_order }}</span>{{ $c->name }}</p>
                    <p class="text-sm text-ink-muted">{{ $c->products_count }} produk · /produk?kategori={{ $c->slug }}</p>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('admin.categories.edit', $c) }}" class="btn-outline min-h-[36px] px-3 py-1.5 text-sm">Edit</a>
                    <form method="POST" action="{{ route('admin.categories.destroy', $c) }}" onsubmit="return confirm('Hapus kategori {{ addslashes($c->name) }}?')">
                        @csrf @method('DELETE')
                        <button class="btn min-h-[36px] border border-line px-3 py-1.5 text-sm text-brand-orange-deep hover:border-brand-orange-deep" @if($c->products_count) title="Masih berisi produk" @endif>Hapus</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
@endsection
