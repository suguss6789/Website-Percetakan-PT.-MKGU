@extends('layouts.app')

@section('title', 'MKGU - Mitra Advertising Indonesia')

@section('content')

<!-- ===== HERO SECTION ===== -->
<section id="beranda" class="relative h-[60vh] md:h-[80vh] flex items-center text-white">
    <div x-data="{
        images: [
            '{{ asset('assets/image/logo_bg.png') }}',
            '{{ asset('assets/image/logo_bground_2.png') }}',
            '{{ asset('assets/image/logo_bground_3.png') }}'
        ],

        index: 0,
        timer: null,
        start() {
            this.timer = setInterval(() => this.index = (this.index + 1) % this.images.length, 5000);
        },
        go(i) {
            this.index = i;
            clearInterval(this.timer);
        }
    }" x-init="start()" class="absolute inset-0 z-0 overflow-hidden">

        <!-- Background carousel images -->
        <template x-for="(img, i) in images" :key="i">
            <div x-show="index === i" x-transition.opacity class="absolute inset-0 bg-cover bg-center"
                 :style="`background-image: url(${img})`"></div>
        </template>

        <!-- Overlay -->
        <div class="absolute inset-0 bg-gray-800 opacity-70 mix-blend-multiply"></div>
    </div>

    <!-- Content -->
    <div class="container mx-auto px-6 relative z-10">
        <div class="max-w-3xl text-left">
            <h1 class="text-4xl md:text-6xl font-bold leading-tight mb-4">Multi Karya Grafika Utama</h1>
            <p class="text-lg md:text-xl text-gray-300 mb-2">
                <span class="font-light">Member of </span><span class="font-bold">PT. Mulia Idola Utama</span>
            </p>
            <p class="text-lg md:text-xl text-gray-200 mb-6">
                Mitra Advertising Indonesia, sinergi antara desainer profesional, teknologi modern, dan harga kompetitif.
            </p>
        </div>
    </div>
</section>

<!-- ===== Layanan ===== -->
<section id="layanan" class="py-20 bg-white">
    <div class="container mx-auto px-6">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-gray-800">Solusi Cetak & Advertising</h2>
            <p class="text-gray-600 mt-2 max-w-2xl mx-auto">Menyediakan layanan desain dan cetak untuk kebutuhan instansi pemerintah maupun swasta.</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse ($categories as $category)
                <div class="bg-gray-50 rounded-lg shadow-md overflow-hidden transform hover:-translate-y-2 transition-transform duration-300 group">
                    <div class="p-8">
                        <h3 class="text-2xl font-bold text-brand-teal mb-3 group-hover:text-black transition-colors">{{ $category->name }}</h3>
                        <p class="text-gray-600 text-sm leading-relaxed">{{ $category->description }}</p>
                    </div>
                </div>
            @empty
                <p class="text-center col-span-full">Kategori layanan akan segera ditambahkan.</p>
            @endforelse
        </div>
    </div>
</section>

<!-- ===== Partner Section ===== -->
<section id="partner" class="py-20 bg-brand-teal">
    <div class="container mx-auto px-6">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-white mb-4">Partner Kami</h2>
            <p class="text-gray-100 text-lg max-w-3xl mx-auto">
                Kami telah dipercaya oleh berbagai instansi pemerintah dan perusahaan terkemuka untuk memenuhi kebutuhan printing dan advertising mereka.
            </p>
        </div>
        
                <div class="relative">
            <!-- Navigation Buttons -->
            <button id="scrollLeft" class="absolute left-0 top-1/2 transform -translate-y-1/2 z-10 bg-white/80 hover:bg-white text-brand-teal p-3 rounded-full shadow-lg transition-all duration-300 opacity-80 hover:opacity-100">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </button>
            
            <button id="scrollRight" class="absolute right-0 top-1/2 transform -translate-y-1/2 z-10 bg-white/80 hover:bg-white text-brand-teal p-3 rounded-full shadow-lg transition-all duration-300 opacity-80 hover:opacity-100">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </button>

            <!-- Scroll Container -->
            <div id="partnerScroll" class="flex overflow-x-auto gap-6 pb-4 scrollbar-hide px-12" style="scrollbar-width: none; -ms-overflow-style: none;">
                <!-- BPOM -->
                <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 flex-shrink-0 w-64">
                    <div class="flex items-center justify-center h-24">
                        <img src="https://3.bp.blogspot.com/-vcT2Pzz-DjI/Wg0U-M_XbHI/AAAAAAAAE84/4fgQJRFLFm4tu2qkPHuPwMES0G35qx2QQCLcBGAs/s1600/Badan%252BPOM.jpg" 
                             alt="BPOM - Badan Pengawas Obat dan Makanan" 
                             class="max-h-full max-w-full object-contain">
                    </div>
                    <div class="text-center mt-4">
                        <h3 class="font-semibold text-gray-800">BPOM</h3>
                        <p class="text-sm text-gray-600">Badan Pengawas Obat dan Makanan</p>
                    </div>
                </div>

                <!-- Huawei -->
                <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 flex-shrink-0 w-64">
                    <div class="flex items-center justify-center h-24">
                        <img src="https://logos-world.net/wp-content/uploads/2020/04/Huawei-Logo-2018-present.jpg" 
                             alt="Huawei Technologies" 
                             class="max-h-full max-w-full object-contain">
                    </div>
                    <div class="text-center mt-4">
                        <h3 class="font-semibold text-gray-800">Huawei</h3>
                        <p class="text-sm text-gray-600">Huawei Technologies</p>
                    </div>
                </div>

                <!-- JEEVES -->
                <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 flex-shrink-0 w-64">
                    <div class="flex items-center justify-center h-24">
                        <img src="https://www.jeeves-indonesia.com/images/logo-black.webp" 
                             alt="Jeeves Laundry" 
                             class="max-h-full max-w-full object-contain">
                    </div>
                    <div class="text-center mt-4">
                        <h3 class="font-semibold text-gray-800">JEEVES</h3>
                        <p class="text-sm text-gray-600">JEEVES Indonesia operates</p>
                    </div>
                </div>

                <!-- SKIN+ -->
                <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 flex-shrink-0 w-64">
                    <div class="flex items-center justify-center h-24">
                        <img src="https://tse2.mm.bing.net/th/id/OIP.7grf7Fbm5sV3-NogQr-vlgHaHa?rs=1&pid=ImgDetMain&o=7&rm=3" 
                             alt="SKIN+" 
                             class="max-h-full max-w-full object-contain">
                    </div>
                    <div class="text-center mt-4">
                        <h3 class="font-semibold text-gray-800">SKIN +</h3>
                        <p class="text-sm text-gray-600">By euromedica</p>
                    </div>
                </div>
                </div>
            </div>
        </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const scrollContainer = document.getElementById('partnerScroll');
    const scrollLeftBtn = document.getElementById('scrollLeft');
    const scrollRightBtn = document.getElementById('scrollRight');
    
    const scrollAmount = 300; // Jumlah pixel untuk scroll
    
    // Function untuk update visibility tombol
    function updateButtonVisibility() {
        const isAtStart = scrollContainer.scrollLeft === 0;
        const isAtEnd = scrollContainer.scrollLeft + scrollContainer.clientWidth >= scrollContainer.scrollWidth;
        
        // Sembunyikan tombol kiri jika di awal
        scrollLeftBtn.style.opacity = isAtStart ? '0.3' : '0.8';
        scrollLeftBtn.style.pointerEvents = isAtStart ? 'none' : 'auto';
        
        // Sembunyikan tombol kanan jika di akhir
        scrollRightBtn.style.opacity = isAtEnd ? '0.3' : '0.8';
        scrollRightBtn.style.pointerEvents = isAtEnd ? 'none' : 'auto';
    }
    
    // Scroll ke kiri
    scrollLeftBtn.addEventListener('click', function() {
        scrollContainer.scrollBy({
            left: -scrollAmount,
            behavior: 'smooth'
        });
    });
    
    // Scroll ke kanan
    scrollRightBtn.addEventListener('click', function() {
        scrollContainer.scrollBy({
            left: scrollAmount,
            behavior: 'smooth'
        });
    });
    
    // Update visibility saat scroll
    scrollContainer.addEventListener('scroll', updateButtonVisibility);
    
    // Update visibility saat window resize
    window.addEventListener('resize', updateButtonVisibility);
    
    // Initial update
    updateButtonVisibility();
    
    // Keyboard navigation
    document.addEventListener('keydown', function(e) {
        if (e.key === 'ArrowLeft') {
            e.preventDefault();
            scrollLeftBtn.click();
        } else if (e.key === 'ArrowRight') {
            e.preventDefault();
            scrollRightBtn.click();
        }
    });
});
</script>

@endsection