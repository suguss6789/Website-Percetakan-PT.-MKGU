@extends('layouts.admin')

@section('title', 'Daftar Produk')
@section('page-title', 'Daftar Produk')

@section('content')
@if(session('success'))
    <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
        {{ session('success') }}
    </div>
@endif
<div class="max-w-4xl mx-auto bg-white rounded shadow p-8">
    <h2 class="text-xl font-bold text-brand-teal mb-6">Daftar Produk</h2>
    <a href="{{ route('admin.products.create') }}" class="mb-4 inline-block px-4 py-2 bg-brand-teal text-white rounded hover:bg-teal-700">Tambah Produk</a>
    <table class="w-full table-auto">
        <thead>
            <tr class="bg-brand-teal text-white">
                <th class="px-4 py-2">No</th>
                <th class="px-4 py-2">Nama</th>
                <th class="px-4 py-2">Slug</th>
                <th class="px-4 py-2">Gambar</th>
                <th class="px-4 py-2">Kategori</th>
                <th class="px-4 py-2">Harga</th>
                <th class="px-4 py-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $i => $product)
            <tr>
                <td class="border px-4 py-2">{{ $products->firstItem() + $i }}</td>
                <td class="border px-4 py-2">{{ $product->name }}</td>
                <td class="border px-4 py-2">{{ $product->slug }}</td>
                <td class="border px-4 py-2">
                    @if($product->image_url)
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="h-12 w-12 object-cover rounded">
                    @else
                        -
                    @endif
                </td>
                <td class="border px-4 py-2">{{ $product->category->name ?? '-' }}</td>
                <td class="border px-4 py-2">Rp{{ number_format($product->price, 0, ',', '.') }}</td>
                <td class="border px-4 py-2">
                    <a href="{{ route('admin.products.edit', $product->id) }}" class="text-blue-500 hover:underline">Edit</a>
                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500 hover:underline ml-2" onclick="return confirm('Yakin hapus produk ini?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center py-4">Belum ada produk.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="mt-4">
        {{ $products->links() }}
    </div>
</div>
@endsection 