@extends('layouts.app')

@section('title', $product->name . ' - MKGU')

@section('content')
<div class="bg-gray-50 py-12">
    <div class="container mx-auto px-6">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            
            <!-- Kolom Gambar Produk -->
            <div>
                @if($product->image_url)
                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full rounded-lg shadow-lg">
                @else
                    <div class="w-full h-96 bg-gray-200 rounded-lg shadow-lg flex items-center justify-center">
                        <svg class="w-24 h-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                @endif
            </div>

            <!-- Kolom Detail & Form Pemesanan -->
            <div>
                <span class="text-sm text-gray-500">{{ $product->category->name }}</span>
                <h1 class="text-4xl font-bold text-gray-900 mt-1">{{ $product->name }}</h1>
                <p class="text-brand-teal font-bold text-3xl my-4">
                    Mulai dari Rp{{ number_format($product->price, 0, ',', '.') }}
                </p>
                <p class="text-gray-600 leading-relaxed mb-6">
                    {{ $product->description }}
                </p>

                <div class="bg-white p-8 rounded-lg shadow-md border border-gray-200">
                    <h3 class="text-2xl font-bold mb-6">Pemesanan</h3>
                    <form action="{{ route('products.submit', $product->slug) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                                <input type="text" id="name" name="name" required class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-teal focus:border-transparent">
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                <input type="email" id="email" name="email" required class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-teal focus:border-transparent">
                            </div>
                            <div>
                                <label for="whatsapp" class="block text-sm font-medium text-gray-700 mb-1">Nomor WhatsApp</label>
                                <input type="text" id="whatsapp" name="whatsapp" required placeholder="Contoh: 08123456789" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-teal focus:border-transparent">
                            </div>
                            <div>
                                <label for="quantity" class="block text-sm font-medium text-gray-700 mb-1">Kuantitas</label>
                                <input type="number" id="quantity" name="quantity" required placeholder="Masukkan jumlah pesanan" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-teal focus:border-transparent">
                            </div>
                        </div>
                        <div class="mt-6">
                            <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Catatan Tambahan</label>
                            <textarea id="notes" name="notes" rows="4" placeholder="Jelaskan spesifikasi yang Anda inginkan (ukuran, bahan, finishing, dll)" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-teal focus:border-transparent"></textarea>
                        </div>
                        <div class="mt-6">
                            <label for="design_file" class="block text-sm font-medium text-gray-700 mb-1">Upload Desain File (PDF/JPG/PNG, max 2MB, opsional)</label>
                            <input type="file" id="design_file" name="design_file" accept=".pdf,.jpg,.jpeg,.png" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-brand-teal/10 file:text-brand-teal hover:file:bg-brand-teal/20">
                        </div>
                        <div class="mt-8">
                            <button type="submit" class="w-full bg-brand-teal text-white font-bold py-4 px-8 rounded-lg hover:bg-opacity-90 transition-all duration-300 shadow-lg text-lg">
                                Kirim
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
