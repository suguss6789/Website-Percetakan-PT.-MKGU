@extends('layouts.admin')

@section('title', 'Edit Produk')
@section('page-title', 'Edit Produk')

@section('content')
<div class="max-w-xl mx-auto bg-white rounded shadow p-8">
    <h2 class="text-xl font-bold text-brand-teal mb-6">Edit Produk</h2>
    @if($errors->any())
        <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label class="block mb-1 font-semibold" for="name">Nama Produk</label>
            <input type="text" name="name" id="name" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-brand-teal" value="{{ old('name', $product->name) }}" required>
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-semibold" for="slug">Slug</label>
            <input type="text" name="slug" id="slug" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-brand-teal" value="{{ old('slug', $product->slug) }}" required>
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-semibold" for="category_id">Kategori</label>
            <select name="category_id" id="category_id" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-brand-teal" required>
                <option value="">-- Pilih Kategori --</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-semibold" for="price">Harga</label>
            <input type="number" name="price" id="price" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-brand-teal" value="{{ old('price', $product->price) }}" required>
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-semibold" for="description">Deskripsi</label>
            <textarea name="description" id="description" rows="4" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-brand-teal">{{ old('description', $product->description) }}</textarea>
        </div>
        <div class="mb-6">
            <label class="block mb-1 font-semibold" for="cover_image">Gambar Produk</label>
            @if($product->image_url)
                <div class="mb-2">
                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="h-16 w-16 object-cover rounded">
                </div>
            @endif
            <input type="file" name="cover_image" id="cover_image" class="w-full border rounded px-3 py-2">
        </div>
        <div class="flex justify-end">
            <a href="{{ route('admin.products.index') }}" class="mr-4 px-4 py-2 rounded bg-gray-200 text-gray-700 hover:bg-gray-300">Batal</a>
            <button type="submit" class="px-6 py-2 rounded bg-brand-teal text-white font-bold hover:bg-teal-700 transition">Simpan Perubahan</button>
        </div>
    </form>
</div>
@endsection 