@extends('layouts.app')

@section('title', 'Tentang Kami - MKGU')

@section('content')
<!-- ===== TENTANG KAMI SECTION ===== -->
<section id="tentang" class="py-20 bg-gray-50">
    <div class="container mx-auto px-6">
        <div class="flex flex-col md:flex-row items-center gap-12">
            <div class="md:w-1/2">
                <img src="https://placehold.co/800x600/e2e8f0/334155?text=MKGU+Team" alt="Tentang MKGU" class="rounded-lg shadow-xl w-full">
            </div>
            <div class="md:w-1/2">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">Kenapa Memilih Kami?</h2>
                <p class="text-gray-600 mb-4 leading-relaxed">
                    Kami tidak hanya menawarkan kualitas yang prima melainkan juga harga yang kompetitif. Sinergi antara desainer yang profesional dan berpengalaman, teknologi desain yang up-to-date, serta didukung oleh para mitra percetakan dengan teknologi mesin printing yang modern.
                </p>
                <p class="text-gray-600 mb-6 leading-relaxed">
                    Hal ini menjadikan waktu untuk produksi cetak lebih efisien dan bisa membantu memenuhi target waktu yang dijadwalkan. Kami memberikan kemudahan komunikasi dan koordinasi untuk solusi kebutuhan desain dan cetak Anda.
                </p>
            </div>
        </div>
    </div>
</section>
@endsection
