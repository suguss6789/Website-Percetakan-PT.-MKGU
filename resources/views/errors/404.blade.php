@extends('layouts.app')

@section('title', '404')

@section('content')
    <section class="container-page flex min-h-[60vh] flex-col items-start justify-center py-20">
        <p class="font-mono text-sm text-brand-green-deep">ERROR 404</p>
        <h1 class="mt-4 max-w-2xl text-fluid-h1 font-extrabold">Halaman ini tidak ada di tumpukan kami.</h1>
        <p class="mt-4 max-w-lg text-lg text-ink-muted">Mungkin tautannya sudah berubah atau produknya sudah tidak ditampilkan.</p>
        <div class="mt-8 flex flex-wrap gap-3">
            <a href="{{ route('home') }}" class="btn-primary">Ke beranda</a>
            <a href="{{ route('products.index') }}" class="btn-outline">Lihat produk</a>
        </div>
    </section>
@endsection
