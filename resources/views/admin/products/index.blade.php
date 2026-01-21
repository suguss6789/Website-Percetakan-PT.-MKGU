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
                <th class="border px-4 py-2">No</th>
                <th class="border px-4 py-2">Gambar</th>
                <th class="border px-4 py-2">Nama Produk</th>
                <th class="border px-4 py-2">Kategori</th>
                <th class="border px-4 py-2">Harga Dasar</th>
                <th class="border px-4 py-2">Ukuran</th>
                <th class="border px-4 py-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $index => $product)
            <tr>
                <td class="border px-4 py-2">{{ $index + 1 }}</td>
                <td class="border px-4 py-2">
                    @if($product->image_url)
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-16 h-16 object-cover rounded">
                    @else
                        <div class="w-16 h-16 bg-gray-200 rounded flex items-center justify-center">
                            <span class="text-gray-500 text-xs">No Image</span>
                        </div>
                    @endif
                </td>
                <td class="border px-4 py-2">{{ $product->name }}</td>
                <td class="border px-4 py-2">{{ $product->category->name ?? '-' }}</td>
                <td class="border px-4 py-2">Rp{{ number_format($product->base_price, 0, ',', '.') }}</td>
                <td class="border px-4 py-2">
                    @if($product->sizes)
                        @foreach($product->sizes as $size)
                            <div class="text-sm">
                                <span class="font-semibold">{{ $size['name'] }}:</span> 
                                Rp{{ number_format($size['price'], 0, ',', '.') }}
                            </div>
                        @endforeach
                    @else
                        <span class="text-gray-500">-</span>
                    @endif
                </td>
                <td class="border px-4 py-2">
                    <a href="{{ route('admin.products.edit', $product->id) }}" class="text-blue-500 hover:underline">Edit</a>
                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="inline ml-2">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500 hover:underline" onclick="return confirm('Yakin ingin menghapus produk ini?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="border px-4 py-2 text-center">Tidak ada produk.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="mt-4">
        {{ $products->links() }}
    </div>
</div>
@endsection 