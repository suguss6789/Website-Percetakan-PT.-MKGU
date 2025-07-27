@extends('layouts.admin')

@section('title', 'Tambah Kategori')
@section('page-title', 'Tambah Kategori')

@section('content')
<div class="max-w-xl mx-auto bg-white rounded shadow p-8">
    <h2 class="text-xl font-bold text-brand-teal mb-6">Tambah Kategori Baru</h2>
    @if($errors->any())
        <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('admin.categories.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label class="block mb-1 font-semibold" for="name">Nama Kategori</label>
            <input type="text" name="name" id="name" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-brand-teal" value="{{ old('name') }}" required>
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-semibold" for="slug">Slug</label>
            <input type="text" name="slug" id="slug" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-brand-teal" value="{{ old('slug') }}" required>
        </div>
        <div class="mb-6">
            <label class="block mb-1 font-semibold" for="description">Deskripsi</label>
            <textarea name="description" id="description" rows="3" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-brand-teal">{{ old('description') }}</textarea>
        </div>
        <div class="flex justify-end">
            <a href="{{ route('admin.categories.index') }}" class="mr-4 px-4 py-2 rounded bg-gray-200 text-gray-700 hover:bg-gray-300">Batal</a>
            <button type="submit" class="px-6 py-2 rounded bg-brand-teal text-white font-bold hover:bg-teal-700 transition">Simpan</button>
        </div>
    </form>
</div>
@endsection 