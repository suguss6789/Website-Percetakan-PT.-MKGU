@extends('layouts.admin')
@section('title', 'Partner')
@section('crumb', 'Partner')

@section('content')
    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <h1 class="text-3xl font-bold">Partner</h1>
            <p class="mt-1 text-ink-muted">Klien atau mitra yang tampil di bagian “Dipercaya oleh” di beranda dan halaman Tentang.</p>
        </div>
        <a href="{{ route('admin.partners.create') }}" class="btn-primary"><x-icon name="plus" class="h-4 w-4" /> Tambah Partner</a>
    </div>

    <div class="mt-6 border border-line bg-white">
        @forelse ($partners as $p)
            <div class="grid grid-cols-[96px_1fr] items-center gap-4 border-b border-line p-4 last:border-0 sm:grid-cols-[96px_1fr_auto_auto]">
                <div class="flex h-14 w-24 items-center justify-center border border-line bg-paper p-2">
                    @if ($p->logo_url)<img src="{{ $p->logo_url }}" alt="" class="max-h-full max-w-full object-contain">
                    @else <span class="text-center font-display text-sm font-bold leading-tight text-ink-muted">{{ $p->name }}</span>@endif
                </div>
                <div class="min-w-0">
                    <p class="font-semibold"><span class="mr-2 font-mono text-xs text-ink-soft">#{{ $p->sort_order }}</span>{{ $p->name }}</p>
                    <p class="truncate text-sm text-ink-muted">{{ $p->description }} @unless($p->logo)<span class="text-brand-orange-deep">· belum ada logo</span>@endunless</p>
                </div>
                <span @class([
                    'col-start-2 inline-flex w-fit items-center gap-2 rounded-full border px-3 py-1 text-sm font-semibold sm:col-start-auto',
                    'border-brand-green/40 bg-brand-green/10 text-brand-green-deep' => $p->is_active,
                    'border-line bg-paper text-ink-muted' => ! $p->is_active,
                ])><span @class(['h-2 w-2 rounded-full', 'bg-brand-green' => $p->is_active, 'bg-ink-soft' => ! $p->is_active])></span>{{ $p->is_active ? 'Tampil' : 'Disembunyikan' }}</span>
                <div class="col-start-2 flex gap-2 sm:col-start-auto">
                    <a href="{{ route('admin.partners.edit', $p) }}" class="inline-flex h-9 w-9 items-center justify-center rounded border border-line hover:border-ink" title="Edit"><x-icon name="pencil" class="h-4 w-4" /></a>
                    <form method="POST" action="{{ route('admin.partners.destroy', $p) }}" onsubmit="return confirm('Hapus partner {{ addslashes($p->name) }}?')">
                        @csrf @method('DELETE')
                        <button class="inline-flex h-9 w-9 items-center justify-center rounded border border-line text-brand-orange-deep hover:border-brand-orange-deep" title="Hapus"><x-icon name="trash" class="h-4 w-4" /></button>
                    </form>
                </div>
            </div>
        @empty
            <p class="p-10 text-center text-ink-muted">Belum ada partner. Section “Dipercaya oleh” otomatis disembunyikan sampai ada partner yang tampil.</p>
        @endforelse
    </div>
@endsection
