@extends('layouts.app')

@section('title', 'Katalog Produk - MKGU')

@section('content')
<div class="bg-white">
    <div class="container mx-auto px-6 py-16">
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-800">Katalog Produk Kami</h1>
            <p class="text-gray-600 mt-2">Temukan solusi cetak terbaik untuk segala kebutuhan Anda.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
            @foreach ($products as $product)
                <div class="bg-white rounded-lg shadow-md overflow-hidden group border border-gray-200 hover:shadow-xl transition-shadow duration-300">
                    <a href="{{ route('products.show', $product->slug) }}" class="block">
                        <div class="overflow-hidden h-60">
                            @if($product->image_url)
                                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-300">
                            @else
                                <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                                    <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <div class="p-5">
                            <p class="text-sm text-gray-500 mb-1">{{ $product->category->name ?? 'Tanpa Kategori' }}</p>
                            <h3 class="text-lg font-bold text-gray-800 truncate">{{ $product->name }}</h3>
                            <p class="text-brand-teal font-semibold text-xl mt-2">
                                Mulai dari Rp{{ number_format($product->base_price, 0, ',', '.') }}
                            </p>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>

        <!-- Pagination Links -->
        <div class="mt-12">
            {{ $products->links() }}
        </div>
    </div>
</div>
@endsection
