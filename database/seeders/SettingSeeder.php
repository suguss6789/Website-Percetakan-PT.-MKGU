<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        Setting::putMany([
            'company_name' => 'Multi Karya Grafika Utama',
            'company_parent' => 'PT. Mulia Idola Utama',
            'tagline' => 'Percetakan offset, digital printing, konveksi & souvenir di Jakarta Timur.',
            'about_short' => 'Kami mengerjakan cetak offset, digital printing, sampai konveksi dan souvenir promosi dari satu tempat di Pisangan Timur, Jakarta Timur. Mulai dari brosur untuk toko kecil sampai buku laporan tahunan perusahaan, setiap pesanan kami cek bersama Anda sebelum naik mesin.',
            'about_full' => "Multi Karya Grafika Utama adalah percetakan yang berada di bawah naungan PT. Mulia Idola Utama. Kami melayani kebutuhan cetak dan promosi untuk usaha kecil, sekolah, instansi, hingga perusahaan.\n\nPekerjaan kami terbagi dalam tiga lini: offset printing untuk cetak dalam jumlah besar seperti brosur, kalender, buku, dan paperbag; digital printing untuk kebutuhan cepat seperti roll up banner, standing poster, dan ID card; serta konveksi dan souvenir untuk kaos, topi, tumbler, dan merchandise perusahaan.\n\nSebelum dicetak, setiap desain kami periksa dan kirimkan proof kepada Anda. Dengan begitu warna, ukuran, dan teks sudah disetujui sejak awal dan tidak ada kejutan saat barang jadi.",
            'vision' => 'Menjadi mitra cetak dan promosi yang bisa diandalkan oleh usaha dan instansi di Jakarta.',
            'mission' => "Memberi hasil cetak yang rapi dan warna yang konsisten.\nMenjelaskan pilihan bahan dan harga dengan terbuka sebelum produksi.\nMenyelesaikan pesanan sesuai waktu yang dijanjikan.",
            'founded_year' => '',
            'address' => 'Jl. Pisangan Lama II No.5B, Pisangan Timur, Kec. Pulo Gadung, Jakarta Timur',
            'maps_embed_url' => 'https://www.google.com/maps?q=Jl.+Pisangan+Lama+II+No.5B,+Pisangan+Timur,+Jakarta+Timur&output=embed',
            'maps_link' => 'https://www.google.com/maps/search/?api=1&query=Jl.+Pisangan+Lama+II+No.5B,+Pisangan+Timur,+Jakarta+Timur',
            'whatsapp' => '6281297279919',
            'phone' => '0812-9727-9919',
            'email' => 'mkgu.jakarta@gmail.com',
            'hours_weekday' => 'Senin – Jumat, 08.00 – 17.00',
            'hours_saturday' => 'Sabtu, 08.00 – 15.00',
            'instagram' => '',
            'facebook' => '',
            'tiktok' => '',
        ]);
    }
}
