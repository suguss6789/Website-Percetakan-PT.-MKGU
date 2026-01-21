@extends('layouts.admin')

@section('title', 'Tambah Produk')
@section('page-title', 'Tambah Produk')

@section('content')
<div class="max-w-xl mx-auto bg-white rounded shadow p-8">
    <h2 class="text-xl font-bold text-brand-teal mb-6">Tambah Produk Baru</h2>
    @if($errors->any())
        <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-4">
            <label class="block mb-1 font-semibold" for="name">Nama Produk</label>
            <input type="text" name="name" id="name" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-brand-teal" value="{{ old('name') }}" required>
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-semibold" for="slug">Slug</label>
            <input type="text" name="slug" id="slug" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-brand-teal" value="{{ old('slug') }}" required>
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-semibold" for="category_id">Kategori</label>
            <select name="category_id" id="category_id" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-brand-teal" required>
                <option value="">-- Pilih Kategori --</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-semibold" for="price">Harga Dasar</label>
            <input type="number" name="base_price" id="base_price" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-brand-teal" value="{{ old('base_price') }}" required>
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Ukuran & Harga</label>
            <div id="sizes-container">
                <div class="size-row mb-2 flex gap-2">
                    <input type="text" name="size_names[]" placeholder="Ukuran (misal: A4)" class="flex-1 border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-brand-teal">
                    <input type="number" name="size_prices[]" placeholder="Harga" class="flex-1 border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-brand-teal">
                    <button type="button" class="remove-size px-3 py-2 bg-red-500 text-white rounded hover:bg-red-600">Hapus</button>
                </div>
            </div>
            <button type="button" id="add-size" class="mt-2 px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">+ Tambah Ukuran</button>
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Finishing & Harga</label>
            <div id="finishings-container">
                <div class="finishing-row mb-2 flex gap-2">
                    <input type="text" name="finishing_names[]" placeholder="Finishing (misal: Laminasi Glossy)" class="flex-1 border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-brand-teal">
                    <input type="number" name="finishing_prices[]" placeholder="Harga" class="flex-1 border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-brand-teal">
                    <button type="button" class="remove-finishing px-3 py-2 bg-red-500 text-white rounded hover:bg-red-600">Hapus</button>
                </div>
            </div>
            <button type="button" id="add-finishing" class="mt-2 px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">+ Tambah Finishing</button>
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Bahan & Harga</label>
            <div id="materials-container">
                <div class="material-row mb-2 flex gap-2">
                    <input type="text" name="material_names[]" placeholder="Bahan (misal: Art Carton 260gsm)" class="flex-1 border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-brand-teal">
                    <input type="number" name="material_prices[]" placeholder="Harga" class="flex-1 border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-brand-teal">
                    <button type="button" class="remove-material px-3 py-2 bg-red-500 text-white rounded hover:bg-red-600">Hapus</button>
                </div>
            </div>
            <button type="button" id="add-material" class="mt-2 px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">+ Tambah Bahan</button>
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-semibold" for="description">Deskripsi</label>
            <textarea name="description" id="description" rows="4" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-brand-teal">{{ old('description') }}</textarea>
        </div>
        <div class="mb-6">
            <label class="block mb-1 font-semibold" for="cover_image">Gambar Produk (Utama)</label>
            <input type="file" name="cover_image" id="cover_image" class="w-full border rounded px-3 py-2">
        </div>
        
        <!-- Hapus input multiple images karena dibatalkan -->
        <div class="flex justify-end">
            <a href="{{ route('admin.products.index') }}" class="mr-4 px-4 py-2 rounded bg-gray-200 text-gray-700 hover:bg-gray-300">Batal</a>
            <button type="submit" class="px-6 py-2 rounded bg-brand-teal text-white font-bold hover:bg-teal-700 transition">Simpan</button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const addSizeBtn = document.getElementById('add-size');
    const sizesContainer = document.getElementById('sizes-container');

    addSizeBtn.addEventListener('click', function() {
        const sizeRow = document.createElement('div');
        sizeRow.className = 'size-row mb-2 flex gap-2';
        sizeRow.innerHTML = `
            <input type="text" name="size_names[]" placeholder="Ukuran (misal: A4)" class="flex-1 border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-brand-teal">
            <input type="number" name="size_prices[]" placeholder="Harga" class="flex-1 border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-brand-teal">
            <button type="button" class="remove-size px-3 py-2 bg-red-500 text-white rounded hover:bg-red-600">Hapus</button>
        `;
        sizesContainer.appendChild(sizeRow);
    });

    sizesContainer.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-size')) {
            e.target.parentElement.remove();
        }
    });

    const addFinishingBtn = document.getElementById('add-finishing');
    const finishingsContainer = document.getElementById('finishings-container');
    addFinishingBtn.addEventListener('click', function() {
        const finishingRow = document.createElement('div');
        finishingRow.className = 'finishing-row mb-2 flex gap-2';
        finishingRow.innerHTML = `
            <input type="text" name="finishing_names[]" placeholder="Finishing (misal: Laminasi Glossy)" class="flex-1 border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-brand-teal">
            <input type="number" name="finishing_prices[]" placeholder="Harga" class="flex-1 border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-brand-teal">
            <button type="button" class="remove-finishing px-3 py-2 bg-red-500 text-white rounded hover:bg-red-600">Hapus</button>
        `;
        finishingsContainer.appendChild(finishingRow);
    });
    finishingsContainer.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-finishing')) {
            e.target.parentElement.remove();
        }
    });

    const addMaterialBtn = document.getElementById('add-material');
    const materialsContainer = document.getElementById('materials-container');
    addMaterialBtn.addEventListener('click', function() {
        const materialRow = document.createElement('div');
        materialRow.className = 'material-row mb-2 flex gap-2';
        materialRow.innerHTML = `
            <input type="text" name="material_names[]" placeholder="Bahan (misal: Art Carton 260gsm)" class="flex-1 border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-brand-teal">
            <input type="number" name="material_prices[]" placeholder="Harga" class="flex-1 border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-brand-teal">
            <button type="button" class="remove-material px-3 py-2 bg-red-500 text-white rounded hover:bg-red-600">Hapus</button>
        `;
        materialsContainer.appendChild(materialRow);
    });
    materialsContainer.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-material')) {
            e.target.parentElement.remove();
        }
    });
});
</script>
@endsection 