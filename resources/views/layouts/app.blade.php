<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'MITRA KARYA GRAFIKA UTAMA - Mitra Advertising Indonesia')</title>
    <meta name="description" content="Multi Karya Grafika Utama (MKGU) adalah perusahaan Offset Printing, Digital Printing & Advertising untuk instansi pemerintah dan swasta.">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        /* Warna Kustom Baru Sesuai Brand MKGU */
        .bg-brand-teal { background-color: #00A99D; }
        .text-brand-teal { color: #00A99D; }
        .border-brand-teal { border-color: #00A99D; }
        .ring-brand-teal { --tw-ring-color: #00A99D; }

        body { font-family: 'Roboto', sans-serif; }
        h1, h2, h3, h4, h5, h6 { font-family: 'Poppins', sans-serif; }

        /* Custom Scrollbar Styles */
        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }

        /* Smooth Scroll */
        .overflow-x-auto {
            scroll-behavior: smooth;
        }

        /* Responsive Navigation Buttons */
        @media (max-width: 768px) {
            #scrollLeft, #scrollRight {
                width: 40px;
                height: 40px;
                padding: 8px;
            }
            #scrollLeft svg, #scrollRight svg {
                width: 20px;
                height: 20px;
            }
        }
    </style>
</head>
<body class="bg-gray-100 text-gray-800">

    <!-- ===== HEADER ===== -->
    <header x-data="{ mobileMenuOpen: false }" class="bg-white/80 backdrop-blur-lg shadow-sm sticky top-0 z-50">
        <nav class="container mx-auto p-4 flex justify-between items-center">
    <div>
        <a href="{{ route('home') }}">
            <img src="{{ asset('assets/image/logo.png') }}" alt="Logo MKGU" class="h-10">
        </a>
    </div>

    <div class="hidden md:flex items-center space-x-8">
        <a href="{{ route('home') }}" class="text-gray-600 hover:text-brand-teal">Beranda</a>
        <a href="{{ route('layanan') }}" class="text-gray-600 hover:text-brand-teal">Layanan</a>
        <a href="{{ route('products.index') }}" class="text-gray-600 hover:text-brand-teal">Produk</a>
        <a href="{{ route('about') }}" class="text-gray-600 hover:text-brand-teal">Tentang Kami</a>
    </div>
        </nav>
            <div class="md:hidden">
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-gray-700 focus:outline-none">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
                </button>
            </div>
        </nav>
        <div x-show="mobileMenuOpen" @click.away="mobileMenuOpen = false" class="md:hidden bg-white shadow-lg" x-transition>
            <a href="{{ route('home') }}" class="block px-6 py-3 text-sm text-gray-700 hover:bg-gray-100 hover:text-brand-teal">Beranda</a>
            <a href="{{ route('layanan') }}" class="block px-6 py-3 text-sm text-gray-700 hover:bg-gray-100 hover:text-brand-teal">Layanan</a>
            <a href="{{ route('products.index') }}" class="block px-6 py-3 text-sm text-gray-700 hover:bg-gray-100 hover:text-brand-teal">Produk</a>
            <a href="{{ route('about') }}" class="block px-6 py-3 text-sm text-gray-700 hover:bg-gray-100 hover:text-brand-teal">Tentang Kami</a>
            <a href="#partner" class="block px-6 py-3 text-sm text-gray-700 hover:bg-gray-100 hover:text-brand-teal">Partner</a>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <!-- ===== FOOTER ===== -->
<footer class="bg-gray-900 text-white" id="partner">
    <div class="container mx-auto px-6 py-16">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-12">
            
            <!-- Kolom 1: Info Perusahaan & Jam Operasional -->
            <div>
                <h3 class="text-xl font-semibold mb-2">Multi Karya Grafika Utama</h3>
                <p class="text-gray-400">Member of <span class="ttext-xl font-semibold">PT. Mulia Idola Utama</span>
                <h4 class="font-semibold text-lg mb-2">Jam Operasional:</h4>
                <p class="text-gray-400">Senin–Jumat: 08.00 – 17.00</p>
                <p class="text-gray-400">Sabtu: 08.00 – 15.00</p>
            </div>

            <!-- Kolom 2: Layanan -->
            <div>
                <h3 class="text-lg font-semibold mb-4">Layanan Kami</h3>
                <ul class="space-y-2">
                    @foreach(\App\Models\Category::all() as $category)
                        <li>
                            <a href="#layanan" class="text-gray-400 hover:text-brand-teal transition-colors">
                                {{ $category->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Kolom 3: Hubungi Kami -->
            <div>
                <h3 class="text-lg font-semibold mb-4">Silakan hubungi kami:</h3>
                <ul class="space-y-4">
                    <li class="flex items-start">
                        <svg class="w-5 h-5 mr-3 mt-1 text-brand-teal flex-shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                            <span class="text-gray-400">
                                <a href="https://maps.app.goo.gl/kgGSgWKyeEP6AYaT9">
                                    Jl. Pisangan Lama II No.5B, Pisangan Timur, Jakarta Timur</a></span>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 mr-3 mt-0.5 text-brand-teal flex-shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                        <span class="text-gray-400">0812 9727 9919</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 mr-3 mt-0.5 text-brand-teal flex-shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        <span class="text-gray-400">mkgu.cetak@gmail.com</span>
                    </li>
                </ul>
            </div>
        </div>
        <div class="mt-12 border-t border-gray-800 pt-6 text-center text-sm text-gray-500">
            <p>Copyright &copy; {{ date('Y') }} PT. Multi Karya Grafika Utama. All Right Reserved.</p>
        </div>
    </div>
    
    <!-- Tombol WhatsApp Mengambang -->
   <a href="https://wa.me/6281297279919" target="_blank"
   class="fixed bottom-5 right-5 bg-green-500 text-white p-4 rounded-full shadow-lg hover:bg-green-600 transition-all duration-300 z-50">
    <img src="https://www.svgrepo.com/show/431393/whatsapp.svg" alt="WhatsApp" class="w-8 h-8">
</a>
</footer>
</body>
</html>