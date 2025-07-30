@extends('layouts.app')

@section('title', 'Layanan Kami - MKGU')

@section('content')
<div class="bg-gray-50">
    <div class="container mx-auto px-6 py-16">
        <!-- Header Section -->
        <div class="text-center mb-16">
            <h1 class="text-5xl font-bold text-gray-800 mb-6">Layanan Kami</h1>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed">
                Berikut adalah layanan yang kami tawarkan untuk solusi bisnis Anda.
            </p>
        </div>

        <!-- Hero Section with Image -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden mb-16">
            <div class="grid md:grid-cols-2 gap-0">
                <div class="p-8 md:p-12 flex items-center">
                    <div>
                        <h2 class="text-3xl font-bold text-gray-800 mb-6">
                            Wujudkan Semua Kebutuhan Promosi Anda di PT. Multi Karya Grafika Utama!
                        </h2>
                        <p class="text-lg text-gray-700 leading-relaxed">
                            Kami adalah mitra terpercaya untuk semua kebutuhan cetak dan promosi bisnis Anda. 
                            Dengan teknologi terkini dan tim profesional, kami siap memberikan solusi terbaik.
                        </p>
                    </div>
                </div>
                <div class="relative">
                    <img src="{{ asset('assets/image/layanan PT 1.jpg') }}" 
                         alt="Layanan PT Multi Karya Grafika Utama" 
                         class="w-full h-full object-cover">
                </div>
            </div>
        </div>

                 <!-- Services Section -->
         <div class="grid md:grid-cols-3 gap-8 mb-16">
             <!-- Offset Printing -->
             <div class="bg-white rounded-xl shadow-lg p-8 hover:shadow-xl transition-shadow">
                 <div class="text-center mb-6">
                     <div class="w-16 h-16 bg-brand-teal/10 rounded-full flex items-center justify-center mx-auto mb-4">
                         <span class="text-2xl">🖨️</span>
                     </div>
                     <h3 class="text-2xl font-bold text-gray-800 mb-3">Offset Printing</h3>
                 </div>
                 <p class="text-lg text-gray-700 leading-relaxed">
                     Butuh materi cetak untuk bisnis? Kami siap membantu Anda dengan layanan Offset Printing 
                     untuk membuat brosur, kalender, hingga paperbag berkualitas tinggi dengan hasil yang memuaskan.
                 </p>
             </div>

             <!-- Digital Printing -->
             <div class="bg-white rounded-xl shadow-lg p-8 hover:shadow-xl transition-shadow">
                 <div class="text-center mb-6">
                     <div class="w-16 h-16 bg-brand-teal/10 rounded-full flex items-center justify-center mx-auto mb-4">
                         <span class="text-2xl">🖨️</span>
                     </div>
                     <h3 class="text-2xl font-bold text-gray-800 mb-3">Digital Printing</h3>
                 </div>
                 <p class="text-lg text-gray-700 leading-relaxed">
                     Perlu media promosi yang cepat dan modern? Andalkan layanan Digital Printing kami 
                     untuk banner, spanduk, dan ID card yang menarik perhatian dengan proses yang cepat.
                 </p>
             </div>

             <!-- Konveksi & Souvenir -->
             <div class="bg-white rounded-xl shadow-lg p-8 hover:shadow-xl transition-shadow">
                 <div class="text-center mb-6">
                     <div class="w-16 h-16 bg-brand-teal/10 rounded-full flex items-center justify-center mx-auto mb-4">
                         <span class="text-2xl">🎁</span>
                     </div>
                     <h3 class="text-2xl font-bold text-gray-800 mb-3">Konveksi & Souvenir</h3>
                 </div>
                 <p class="text-lg text-gray-700 leading-relaxed">
                     Ingin souvenir yang berkesan? Divisi Konveksi & Souvenir kami ahli dalam menciptakan 
                     kaos, topi, dan tumbler custom dengan desain eksklusif sesuai keinginan Anda.
                 </p>
             </div>
         </div>

         <!-- Call to Action -->
         <div class="bg-brand-teal rounded-2xl p-8 text-center text-white">
             <h3 class="text-3xl font-bold mb-4">
                 PT. Multi Karya Grafika Utama
             </h3>
             <p class="text-xl mb-6">
                 Satu Solusi untuk Semua Kebutuhan Cetak dan Promosi Anda
             </p>
                         <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                 <a href="{{ route('products.index') }}"
                    class="bg-white text-brand-teal px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors">
                     Pesan Sekarang
                 </a>
                 <a href="{{ route('about') }}"
                    class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-brand-teal transition-colors">
                     Hubungi Kami
                 </a>
             </div>
         </div>
    </div>
</div>
@endsection