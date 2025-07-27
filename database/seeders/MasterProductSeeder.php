<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Str;

class MasterProductSeeder extends Seeder
{
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Category::truncate();
        Product::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 1. MEMBUAT KATEGORI (Sesuai gambar)
        $catOffset = Category::create(['name' => 'Offset Printing', 'slug' => 'offset-printing']);
        $catDigital = Category::create(['name' => 'Digital Printing', 'slug' => 'digital-printing']);
        $catKonveksi = Category::create(['name' => 'Konveksi & Souvenir', 'slug' => 'konveksi-souvenir']);

        // 2. MEMBUAT PRODUK (Sesuai gambar, dengan estimasi harga)
        // Harga dalam Rupiah, merepresentasikan harga "mulai dari"
        
        // Produk Offset Printing
        Product::create([
            'category_id' => $catOffset->id,
            'name' => 'Brosur, Poster, Flyer',
            'slug' => Str::slug('Brosur Poster Flyer'),
            'description' => 'Cetak brosur Art Paper 150gr ukuran A4 full color. Cocok untuk promosi masif.',
            'price' => 350000, // Estimasi per 1 rim (500 lembar)
            'cover_image' => null, // Akan diupload melalui admin panel
            'is_featured' => false
        ]);
        Product::create([
            'category_id' => $catOffset->id,
            'name' => 'Paperbag, Shopping Bag',
            'slug' => Str::slug('Paperbag Shopping Bag'),
            'description' => 'Tas kertas custom dengan bahan Kraft atau Ivory, lengkap dengan tali. Meningkatkan citra brand Anda.',
            'price' => 7500, // Estimasi per pcs, min. order 100
            'cover_image' => null, // Akan diupload melalui admin panel
            'is_featured' => false
        ]);
        Product::create([
            'category_id' => $catOffset->id,
            'name' => 'Buku Pedoman, Buku Laporan',
            'slug' => Str::slug('Buku Pedoman Laporan'),
            'description' => 'Cetak buku laporan tahunan atau buku panduan dengan jilid spiral atau lem panas berkualitas.',
            'price' => 45000, // Estimasi per buku, min. order 50
            'cover_image' => null, // Akan diupload melalui admin panel
            'is_featured' => false
        ]);
        Product::create([
            'category_id' => $catOffset->id,
            'name' => 'Kalender 2025',
            'slug' => Str::slug('Kalender 2025'),
            'description' => 'Cetak kalender dinding atau meja custom untuk promosi sepanjang tahun.',
            'price' => 15000, // Estimasi per pcs, min. order 100
            'cover_image' => null, // Akan diupload melalui admin panel
            'is_featured' => false
        ]);

        // Produk Digital Printing
        Product::create([
            'category_id' => $catDigital->id,
            'name' => 'Roll Up / X-Banner',
            'slug' => Str::slug('Roll Up X-Banner'),
            'description' => 'Banner portabel yang mudah dipasang, sudah termasuk stand dan cetak bahan Albatros.',
            'price' => 125000, // Estimasi per set
            'cover_image' => null, // Akan diupload melalui admin panel
            'is_featured' => false
        ]);
        Product::create([
            'category_id' => $catDigital->id,
            'name' => 'Standing Poster, Standing Human',
            'slug' => Str::slug('Standing Poster Human'),
            'description' => 'Display poster dengan bahan foamboard atau impraboard yang kokoh dan ringan.',
            'price' => 90000, // Estimasi per pcs ukuran A2
            'cover_image' => null, // Akan diupload melalui admin panel
            'is_featured' => false
        ]);
        Product::create([
            'category_id' => $catDigital->id,
            'name' => 'ID Card, Lanyard, Member Card',
            'slug' => Str::slug('ID Card Lanyard'),
            'description' => 'Cetak ID Card PVC berkualitas dan lanyard custom dengan sablon atau printing.',
            'price' => 18000, // Estimasi per set (ID Card + Lanyard)
            'cover_image' => null, // Akan diupload melalui admin panel
            'is_featured' => false
        ]);
        Product::create([
            'category_id' => $catDigital->id,
            'name' => 'Tropy, Plakat, Medali',
            'slug' => Str::slug('Tropy Plakat Medali'),
            'description' => 'Buat penghargaan custom dari bahan akrilik, resin, atau logam untuk berbagai acara.',
            'price' => 150000, // Estimasi per plakat akrilik
            'cover_image' => null, // Akan diupload melalui admin panel
            'is_featured' => false
        ]);

        // Produk Konveksi & Souvenir
        Product::create([
            'category_id' => $catKonveksi->id,
            'name' => 'Kaos, Topi, Rompi',
            'slug' => Str::slug('Kaos Topi Rompi'),
            'description' => 'Produksi seragam atau merchandise apparel dengan bahan dan sablon/bordir berkualitas.',
            'price' => 85000, // Estimasi per kaos (Cotton Combed + Sablon)
            'cover_image' => null, // Akan diupload melalui admin panel
            'is_featured' => false
        ]);
        Product::create([
            'category_id' => $catKonveksi->id,
            'name' => 'Bantal Leher, Bantal Promosi',
            'slug' => Str::slug('Bantal Leher Promosi'),
            'description' => 'Souvenir bantal custom dengan printing desain Anda, cocok untuk travel atau event.',
            'price' => 60000, // Estimasi per pcs
            'cover_image' => null, // Akan diupload melalui admin panel
            'is_featured' => false
        ]);
        Product::create([
            'category_id' => $catKonveksi->id,
            'name' => 'Payung, Tumbler, Pulpen',
            'slug' => Str::slug('Payung Tumbler Pulpen'),
            'description' => 'Paket souvenir fungsional yang paling populer untuk branding perusahaan.',
            'price' => 45000, // Estimasi per tumbler custom
            'cover_image' => null, // Akan diupload melalui admin panel
            'is_featured' => false
        ]);
        Product::create([
            'category_id' => $catKonveksi->id,
            'name' => 'Tas Kantong Spunbond',
            'slug' => Str::slug('Tas Kantong Spunbond'),
            'description' => 'Goodie bag ramah lingkungan dengan sablon logo untuk berbagai keperluan acara.',
            'price' => 5000, // Estimasi per pcs, min. order 100
            'cover_image' => null, // Akan diupload melalui admin panel
            'is_featured' => false
        ]);
    }
}
