@extends('layouts.admin')

@section('title', 'Manajemen Kategori')
@section('page-title', 'Kategori Produk')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-xl font-bold text-brand-teal">Daftar Kategori</h2>
    <a href="{{ route('admin.categories.create') }}" class="bg-brand-teal text-white px-4 py-2 rounded hover:bg-teal-700 transition">Tambah Kategori</a>
</div>
@if(session('success'))
    <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">{{ session('success') }}</div>
@endif
<div class="overflow-x-auto">
    <table class="min-w-full bg-white rounded shadow text-sm">
        <thead>
            <tr class="bg-brand-teal text-white">
                <th class="py-2 px-4">No</th>
                <th class="py-2 px-4">Nama</th>
                <th class="py-2 px-4">Slug</th>
                <th class="py-2 px-4">Deskripsi</th>
                <th class="py-2 px-4">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $i => $category)
            <tr class="border-b">
                <td class="py-2 px-4">{{ $categories->firstItem() + $i }}</td>
                <td class="py-2 px-4">{{ $category->name }}</td>
                <td class="py-2 px-4">{{ $category->slug }}</td>
                <td class="py-2 px-4">{{ $category->description }}</td>
                <td class="py-2 px-4">
                    <a href="{{ route('admin.categories.edit', $category) }}" class="text-blue-600 hover:underline mr-2">Edit</a>
                    <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus kategori ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="mt-4">{{ $categories->links() }}</div>
</div>
@endsection 