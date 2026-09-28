@extends('layouts.admin')
@section('title', $category->exists ? 'Edit Kategori' : 'Tambah Kategori')
@section('crumb', 'Kategori / ' . ($category->exists ? 'Edit' : 'Tambah'))

@section('content')
    <a href="{{ route('admin.categories.index') }}" class="text-sm text-ink-muted hover:text-ink">← Semua kategori</a>
    <h1 class="mt-2 text-3xl font-bold">{{ $category->exists ? $category->name : 'Tambah kategori' }}</h1>

    <form method="POST" action="{{ $category->exists ? route('admin.categories.update', $category) : route('admin.categories.store') }}" class="mt-8 max-w-2xl space-y-5 border border-line bg-white p-6">
        @csrf
        @if ($category->exists) @method('PUT') @endif
        <div>
            <label class="field-label" for="name">Nama kategori *</label>
            <input id="name" name="name" value="{{ old('name', $category->name) }}" required maxlength="80" class="field-input">
            @error('name')<p class="field-error">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="field-label" for="description">Deskripsi</label>
            <textarea id="description" name="description" rows="3" maxlength="500" class="field-input">{{ old('description', $category->description) }}</textarea>
            <p class="field-help">Satu-dua kalimat, tampil di halaman katalog saat kategori dipilih.</p>
        </div>
        <div class="max-w-[160px]">
            <label class="field-label" for="sort_order">Urutan</label>
            <input id="sort_order" type="number" name="sort_order" min="0" value="{{ old('sort_order', $category->sort_order ?? 0) }}" class="field-input">
        </div>
        <div class="flex gap-2 pt-2">
            <button class="btn-primary">Simpan</button>
            <a href="{{ route('admin.categories.index') }}" class="btn-outline">Batal</a>
        </div>
    </form>
@endsection
