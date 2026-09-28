@extends('layouts.admin')
@section('title', $product->exists ? 'Edit ' . $product->name : 'Tambah Produk')
@section('crumb', 'Produk / ' . ($product->exists ? 'Edit' : 'Tambah'))

@php
    $sizes = old('sizes', $product->exists ? $product->sizes->map(fn ($s) => $s->only(['label', 'dimension', 'price_min', 'price_max', 'unit', 'note']))->all() : [['label' => '', 'dimension' => '', 'price_min' => '', 'price_max' => '', 'unit' => 'per pcs', 'note' => '']]);
    $specs = old('specs', $product->specifications ?: [['label' => 'Bahan', 'value' => ''], ['label' => 'Finishing', 'value' => '']]);
    $units = ['per pcs', 'per lembar', 'per rim', 'per buku', 'per set', 'per m²', 'per box'];
@endphp

@section('content')
    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <a href="{{ route('admin.products.index') }}" class="text-sm text-ink-muted hover:text-ink">← Semua produk</a>
            <h1 class="mt-2 text-3xl font-bold">{{ $product->exists ? $product->name : 'Tambah produk' }}</h1>
        </div>
        @if ($product->exists)
            <a href="{{ route('products.show', $product) }}" target="_blank" class="btn-outline"><x-icon name="external" class="h-4 w-4" /> Lihat di website</a>
        @endif
    </div>

    <form method="POST" enctype="multipart/form-data" action="{{ $product->exists ? route('admin.products.update', $product) : route('admin.products.store') }}" class="mt-8 grid gap-6 xl:grid-cols-[1fr_320px]">
        @csrf
        @if ($product->exists) @method('PUT') @endif

        <div class="space-y-6">
            {{-- A. Informasi dasar --}}
            <section class="border border-line bg-white p-6" x-data="{ short: @js(old('short_description', $product->short_description) ?? '') }">
                <h2 class="text-xl font-bold">Informasi dasar</h2>
                <div class="mt-5 grid gap-5 sm:grid-cols-2">
                    <div class="sm:col-span-2">
                        <label class="field-label" for="name">Nama produk *</label>
                        <input id="name" name="name" value="{{ old('name', $product->name) }}" required maxlength="120" class="field-input" placeholder="Contoh: Brosur, Poster & Flyer">
                        @error('name')<p class="field-error">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="field-label" for="category_id">Kategori *</label>
                        <select id="category_id" name="category_id" required class="field-input">
                            <option value="">Pilih kategori</option>
                            @foreach ($categories as $c)<option value="{{ $c->id }}" @selected(old('category_id', $product->category_id) == $c->id)>{{ $c->name }}</option>@endforeach
                        </select>
                        @error('category_id')<p class="field-error">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="field-label" for="slug">Alamat URL</label>
                        <div class="flex items-center rounded border border-line bg-paper focus-within:border-brand-green-deep">
                            <span class="pl-3 font-mono text-xs text-ink-soft">/produk/</span>
                            <input id="slug" name="slug" value="{{ old('slug', $product->slug) }}" class="w-full bg-transparent px-1 py-2.5 font-mono text-sm focus:outline-none" placeholder="otomatis dari nama">
                        </div>
                        @error('slug')<p class="field-error">{{ $message }}</p>@else<p class="field-help">Kosongkan agar dibuat otomatis.</p>@enderror
                    </div>
                    <div class="sm:col-span-2">
                        <label class="field-label" for="short_description">Deskripsi singkat *</label>
                        <input id="short_description" name="short_description" x-model="short" required maxlength="200" class="field-input" placeholder="Satu kalimat yang tampil di kartu produk">
                        <p class="field-help flex justify-between"><span>Tampil di kartu produk dan hasil pencarian Google.</span><span x-text="short.length + '/200'"></span></p>
                        @error('short_description')<p class="field-error">{{ $message }}</p>@enderror
                    </div>
                    <div class="sm:col-span-2">
                        <label class="field-label" for="description">Deskripsi lengkap *</label>
                        <textarea id="description" name="description" rows="6" required class="field-input" placeholder="Jelaskan kegunaan, pilihan, dan hal yang perlu diketahui pelanggan. Pisahkan paragraf dengan baris kosong.">{{ old('description', $product->description) }}</textarea>
                        @error('description')<p class="field-error">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="field-label" for="min_order">Minimal order</label>
                        <input id="min_order" name="min_order" value="{{ old('min_order', $product->min_order) }}" class="field-input" placeholder="Contoh: Minimal 100 pcs">
                    </div>
                    <div>
                        <label class="field-label" for="production_time">Estimasi pengerjaan</label>
                        <input id="production_time" name="production_time" value="{{ old('production_time', $product->production_time) }}" class="field-input" placeholder="Contoh: 3 – 5 hari kerja">
                    </div>
                </div>
            </section>

            {{-- B. Ukuran & kisaran harga --}}
            <section class="border border-line bg-white p-6" x-data="{ rows: @js(array_values($sizes)), blank: { label: '', dimension: '', price_min: '', price_max: '', unit: 'per pcs', note: '' },
                move(i, d) { const j = i + d; if (j < 0 || j >= this.rows.length) return; [this.rows[i], this.rows[j]] = [this.rows[j], this.rows[i]]; } }">
                <div class="flex flex-wrap items-end justify-between gap-3">
                    <div>
                        <h2 class="text-xl font-bold">Ukuran & kisaran harga</h2>
                        <p class="mt-1 text-sm text-ink-muted">Isi harga termurah dan termahal untuk setiap ukuran. Kosongkan harga maksimum jika ingin tampil “Mulai Rp…”.</p>
                    </div>
                    <button type="button" @click="rows.push({ ...blank })" class="btn-outline min-h-[38px] px-3 py-1.5 text-sm"><x-icon name="plus" class="h-4 w-4" /> Tambah ukuran</button>
                </div>
                <datalist id="units">@foreach ($units as $u)<option value="{{ $u }}">@endforeach</datalist>

                <div class="mt-5 space-y-3">
                    <template x-for="(row, i) in rows" :key="i">
                        <div class="grid gap-3 border border-line bg-paper p-4 md:grid-cols-12">
                            <div class="md:col-span-2"><label class="field-label text-xs">Ukuran *</label><input :name="`sizes[${i}][label]`" x-model="row.label" class="field-input" placeholder="A4"></div>
                            <div class="md:col-span-3"><label class="field-label text-xs">Dimensi</label><input :name="`sizes[${i}][dimension]`" x-model="row.dimension" class="field-input" placeholder="21 × 29,7 cm"></div>
                            <div class="md:col-span-2"><label class="field-label text-xs">Harga min (Rp) *</label><input :name="`sizes[${i}][price_min]`" x-model="row.price_min" inputmode="numeric" class="field-input font-mono" placeholder="1000"></div>
                            <div class="md:col-span-2"><label class="field-label text-xs">Harga maks (Rp)</label><input :name="`sizes[${i}][price_max]`" x-model="row.price_max" inputmode="numeric" class="field-input font-mono" placeholder="2500"></div>
                            <div class="md:col-span-3"><label class="field-label text-xs">Satuan *</label><input :name="`sizes[${i}][unit]`" x-model="row.unit" list="units" class="field-input"></div>
                            <div class="md:col-span-9"><label class="field-label text-xs">Catatan</label><input :name="`sizes[${i}][note]`" x-model="row.note" class="field-input" placeholder="Opsional, misal: harga turun untuk order di atas 1.000 pcs"></div>
                            <div class="flex items-end justify-end gap-2 md:col-span-3">
                                <button type="button" @click="move(i, -1)" :disabled="i === 0" class="inline-flex h-10 w-10 items-center justify-center rounded border border-line bg-white disabled:opacity-40" title="Naikkan"><x-icon name="arrow-up" class="h-4 w-4" /></button>
                                <button type="button" @click="move(i, 1)" :disabled="i === rows.length - 1" class="inline-flex h-10 w-10 items-center justify-center rounded border border-line bg-white disabled:opacity-40" title="Turunkan"><x-icon name="arrow-down" class="h-4 w-4" /></button>
                                <button type="button" @click="rows.splice(i, 1)" class="inline-flex h-10 w-10 items-center justify-center rounded border border-line bg-white text-brand-orange-deep" title="Hapus ukuran"><x-icon name="trash" class="h-4 w-4" /></button>
                            </div>
                        </div>
                    </template>
                    <p x-show="rows.length === 0" class="border border-dashed border-line p-6 text-center text-sm text-ink-muted">Belum ada ukuran. Produk akan tampil dengan keterangan “Harga sesuai permintaan”.</p>
                </div>
                @foreach ($errors->get('sizes.*') as $msgs)@foreach ($msgs as $m)<p class="field-error">{{ $m }}</p>@endforeach @endforeach
            </section>

            {{-- C. Spesifikasi --}}
            <section class="border border-line bg-white p-6" x-data="{ rows: @js(array_values($specs)) }">
                <div class="flex flex-wrap items-end justify-between gap-3">
                    <div>
                        <h2 class="text-xl font-bold">Spesifikasi</h2>
                        <p class="mt-1 text-sm text-ink-muted">Pasangan label dan isi, misal “Bahan” → “Art Paper 150 gr”.</p>
                    </div>
                    <div class="flex flex-wrap gap-1.5">
                        @foreach (['Bahan', 'Cetak', 'Finishing', 'Jilid', 'Laminasi'] as $quick)
                            <button type="button" @click="rows.push({ label: @js($quick), value: '' })" class="rounded-full border border-line px-3 py-1 text-xs font-semibold hover:border-ink">+ {{ $quick }}</button>
                        @endforeach
                        <button type="button" @click="rows.push({ label: '', value: '' })" class="rounded-full border border-ink px-3 py-1 text-xs font-semibold">+ Lainnya</button>
                    </div>
                </div>
                <div class="mt-5 space-y-2">
                    <template x-for="(row, i) in rows" :key="i">
                        <div class="grid grid-cols-[1fr_auto] gap-2 sm:grid-cols-[180px_1fr_auto]">
                            <input :name="`specs[${i}][label]`" x-model="row.label" class="field-input col-span-2 sm:col-span-1" placeholder="Label">
                            <input :name="`specs[${i}][value]`" x-model="row.value" class="field-input" placeholder="Isi spesifikasi">
                            <button type="button" @click="rows.splice(i, 1)" class="inline-flex h-11 w-11 items-center justify-center rounded border border-line text-brand-orange-deep" title="Hapus"><x-icon name="trash" class="h-4 w-4" /></button>
                        </div>
                    </template>
                </div>
                @foreach ($errors->get('specs.*') as $msgs)@foreach ($msgs as $m)<p class="field-error">{{ $m }}</p>@endforeach @endforeach
            </section>

            {{-- D. Gambar --}}
            <section class="border border-line bg-white p-6">
                <h2 class="text-xl font-bold">Gambar</h2>
                <p class="mt-1 text-sm text-ink-muted">JPG, PNG, atau WEBP, maks. 2 MB per foto. Foto otomatis diperkecil dan dioptimalkan.</p>

                <div class="mt-5 grid gap-6 md:grid-cols-[220px_1fr]" x-data="{ preview: @js($product->image_url) }">
                    <div>
                        <p class="field-label">Gambar utama {{ $product->cover_image ? '' : '*' }}</p>
                        <label class="block aspect-[4/5] cursor-pointer border-2 border-dashed border-line bg-paper hover:border-brand-green-deep">
                            <template x-if="preview"><img :src="preview" alt="" class="h-full w-full object-contain p-2"></template>
                            <span x-show="!preview" class="grid h-full place-items-center p-4 text-center text-sm text-ink-muted"><span><x-icon name="image" class="mx-auto mb-2 h-8 w-8" />Klik untuk pilih foto</span></span>
                            <input type="file" name="cover_image" accept="image/jpeg,image/png,image/webp" class="sr-only" @change="const f = $event.target.files[0]; if (f) preview = URL.createObjectURL(f)">
                        </label>
                        <p class="field-help">{{ $product->cover_image ? 'Pilih foto baru untuk mengganti.' : 'Wajib diisi.' }}</p>
                        @error('cover_image')<p class="field-error">{{ $message }}</p>@enderror
                    </div>

                    <div x-data="{ files: [] }">
                        <p class="field-label">Galeri tambahan <span class="font-normal text-ink-muted">(maks. 8 foto)</span></p>
                        @if ($product->exists && $product->images->isNotEmpty())
                            <div class="mb-4 grid grid-cols-3 gap-3 sm:grid-cols-4">
                                @foreach ($product->images as $img)
                                    <div class="border border-line bg-paper p-1.5">
                                        <img src="{{ $img->thumb_url }}" alt="" class="aspect-square w-full object-contain">
                                        <div class="mt-1.5 flex items-center gap-1">
                                            <input type="number" name="image_order[{{ $img->id }}]" value="{{ $img->sort_order }}" min="0" max="99" class="w-full rounded border border-line px-1.5 py-1 text-xs" title="Urutan">
                                            <button type="submit" form="del-img-{{ $img->id }}" class="inline-flex h-7 w-7 shrink-0 items-center justify-center rounded border border-line bg-white text-brand-orange-deep" title="Hapus foto" onclick="return confirm('Hapus foto ini?')"><x-icon name="trash" class="h-3.5 w-3.5" /></button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <p class="field-help -mt-2 mb-4">Angka di bawah foto menentukan urutan (kecil tampil lebih dulu).</p>
                        @endif
                        <label class="flex cursor-pointer flex-col items-center justify-center border-2 border-dashed border-line bg-paper px-4 py-8 text-center text-sm text-ink-muted hover:border-brand-green-deep">
                            <x-icon name="plus" class="mb-2 h-6 w-6" />
                            <span x-text="files.length ? files.length + ' foto dipilih' : 'Pilih satu atau beberapa foto'"></span>
                            <input type="file" name="gallery[]" multiple accept="image/jpeg,image/png,image/webp" class="sr-only" @change="files = [...$event.target.files].map(f => URL.createObjectURL(f))">
                        </label>
                        <div x-show="files.length" class="mt-3 grid grid-cols-4 gap-2 sm:grid-cols-6">
                            <template x-for="src in files" :key="src"><img :src="src" alt="" class="aspect-square w-full border border-line object-cover"></template>
                        </div>
                        @error('gallery')<p class="field-error">{{ $message }}</p>@enderror
                        @error('gallery.*')<p class="field-error">{{ $message }}</p>@enderror
                    </div>
                </div>
            </section>
        </div>

        {{-- E. Tampilan & simpan --}}
        <aside>
            <div class="space-y-5 border border-line bg-white p-6 xl:sticky xl:top-6">
                <h2 class="text-xl font-bold">Tampilan</h2>
                <label class="flex items-start gap-3">
                    <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $product->is_active)) class="mt-1 h-4 w-4 accent-[#067A35]">
                    <span><span class="font-semibold">Tampilkan di website</span><span class="block text-sm text-ink-muted">Matikan untuk menyembunyikan tanpa menghapus.</span></span>
                </label>
                <label class="flex items-start gap-3">
                    <input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $product->is_featured)) class="mt-1 h-4 w-4 accent-[#067A35]">
                    <span><span class="font-semibold">Produk unggulan</span><span class="block text-sm text-ink-muted">Tampil di beranda.</span></span>
                </label>
                <div>
                    <label class="field-label" for="sort_order">Urutan tampil</label>
                    <input id="sort_order" type="number" name="sort_order" min="0" value="{{ old('sort_order', $product->sort_order ?? 0) }}" class="field-input">
                    <p class="field-help">Angka kecil tampil lebih dulu.</p>
                </div>
                <button class="btn-primary w-full">{{ $product->exists ? 'Simpan perubahan' : 'Simpan produk' }}</button>
                <a href="{{ route('admin.products.index') }}" class="btn w-full text-ink-muted hover:text-ink">Batal</a>
            </div>
        </aside>
    </form>

    {{-- Form hapus foto galeri (di luar form utama agar tidak bersarang) --}}
    @if ($product->exists)
        @foreach ($product->images as $img)
            <form id="del-img-{{ $img->id }}" method="POST" action="{{ route('admin.products.images.destroy', [$product, $img]) }}" class="hidden">@csrf @method('DELETE')</form>
        @endforeach
    @endif
@endsection
