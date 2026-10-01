@extends('layouts.admin')
@section('title', $partner->exists ? 'Edit Partner' : 'Tambah Partner')
@section('crumb', 'Partner / ' . ($partner->exists ? 'Edit' : 'Tambah'))

@section('content')
    <a href="{{ route('admin.partners.index') }}" class="text-sm text-ink-muted hover:text-ink">← Semua partner</a>
    <h1 class="mt-2 text-3xl font-bold">{{ $partner->exists ? $partner->name : 'Tambah partner' }}</h1>

    <form method="POST" enctype="multipart/form-data" action="{{ $partner->exists ? route('admin.partners.update', $partner) : route('admin.partners.store') }}"
        class="mt-8 grid max-w-3xl gap-6 border border-line bg-white p-6 md:grid-cols-[220px_1fr]" x-data="{ preview: @js($partner->logo_url), remove: false }">
        @csrf
        @if ($partner->exists) @method('PUT') @endif

        <div>
            <p class="field-label">Logo</p>
            <label class="flex aspect-[3/2] cursor-pointer items-center justify-center border-2 border-dashed border-line bg-paper p-4 hover:border-brand-green-deep">
                <template x-if="preview && !remove"><img :src="preview" alt="" class="max-h-full max-w-full object-contain"></template>
                <span x-show="!preview || remove" class="text-center text-sm text-ink-muted"><x-icon name="image" class="mx-auto mb-2 h-8 w-8" />Klik untuk pilih logo</span>
                <input type="file" name="logo" accept="image/png,image/jpeg,image/webp" class="sr-only" @change="const f = $event.target.files[0]; if (f) { preview = URL.createObjectURL(f); remove = false }">
            </label>
            <p class="field-help">PNG transparan paling bagus. Maks. 2 MB.</p>
            @error('logo')<p class="field-error">{{ $message }}</p>@enderror
            @if ($partner->logo)
                <label class="mt-2 flex items-center gap-2 text-sm text-ink-muted"><input type="checkbox" name="remove_logo" value="1" x-model="remove" class="h-4 w-4 accent-[#C9431A]"> Hapus logo</label>
            @endif
        </div>

        <div class="space-y-5">
            <div>
                <label class="field-label" for="name">Nama partner *</label>
                <input id="name" name="name" value="{{ old('name', $partner->name) }}" required maxlength="80" class="field-input" placeholder="Contoh: BPOM">
                @error('name')<p class="field-error">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="field-label" for="description">Keterangan</label>
                <input id="description" name="description" value="{{ old('description', $partner->description) }}" maxlength="120" class="field-input" placeholder="Contoh: Badan Pengawas Obat dan Makanan">
            </div>
            <div>
                <label class="field-label" for="url">Link website</label>
                <input id="url" type="url" name="url" value="{{ old('url', $partner->url) }}" class="field-input" placeholder="https://… (opsional)">
                @error('url')<p class="field-error">{{ $message }}</p>@enderror
            </div>
            <div class="grid grid-cols-2 gap-5">
                <div>
                    <label class="field-label" for="sort_order">Urutan</label>
                    <input id="sort_order" type="number" min="0" name="sort_order" value="{{ old('sort_order', $partner->sort_order ?? 0) }}" class="field-input">
                </div>
                <label class="flex items-end gap-3 pb-3">
                    <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $partner->is_active)) class="h-4 w-4 accent-[#067A35]">
                    <span class="font-semibold">Tampilkan di website</span>
                </label>
            </div>
            <div class="flex gap-2 pt-2">
                <button class="btn-primary">Simpan</button>
                <a href="{{ route('admin.partners.index') }}" class="btn-outline">Batal</a>
            </div>
        </div>
    </form>
@endsection
