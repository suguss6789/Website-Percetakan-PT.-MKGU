<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Services\ImageService;
use Illuminate\Database\Seeder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

/**
 * DATA CONTOH. Kisaran harga di bawah hanya ilustrasi —
 * ganti lewat panel admin dengan harga asli MKGU.
 */
class CatalogSeeder extends Seeder
{
    public function run(): void
    {
        $withImages = ! app()->runningUnitTests();
        if ($withImages) {
            Storage::disk('public')->deleteDirectory('products');
        }

        $offset = Category::create(['name' => 'Offset Printing', 'sort_order' => 1,
            'description' => 'Cetak dalam jumlah besar dengan warna yang konsisten dari lembar pertama sampai terakhir.']);
        $digital = Category::create(['name' => 'Digital Printing', 'sort_order' => 2,
            'description' => 'Untuk kebutuhan cepat dan jumlah sedikit: banner, display promosi, kartu identitas.']);
        $souvenir = Category::create(['name' => 'Konveksi & Souvenir', 'sort_order' => 3,
            'description' => 'Kaos, topi, tas, dan merchandise dengan logo atau desain Anda.']);

        $products = [
            [$offset, 'Brosur, Poster & Flyer', true,
                'Brosur lipat, flyer, dan poster full color untuk promosi toko, acara, atau kampanye.',
                "Cocok untuk promosi yang disebar dalam jumlah banyak. Tersedia lipat dua, lipat tiga, atau lembaran tanpa lipatan. Untuk pesanan di atas 1.000 lembar kami sarankan offset agar harga per lembar lebih rendah; di bawah itu bisa dikerjakan dengan digital printing.",
                [['Bahan', 'Art Paper 120 gr, Art Paper 150 gr, HVS 100 gr'], ['Cetak', 'Full color 1 sisi / 2 sisi'], ['Finishing', 'Tanpa lipat, lipat 2, lipat 3, laminasi doff/glossy']],
                'Minimal 500 lembar', '3 – 5 hari kerja',
                [['A5', '14,8 × 21 cm', 400, 1200, 'per lembar'], ['A4', '21 × 29,7 cm', 700, 2000, 'per lembar'], ['A3', '29,7 × 42 cm', 1500, 4500, 'per lembar', 'Cocok untuk poster dinding']]],

            [$offset, 'Paperbag & Shopping Bag', true,
                'Tas kertas custom dengan logo Anda, bahan ivory atau kraft, lengkap dengan tali.',
                "Paperbag membuat produk yang dibawa pulang pelanggan tetap membawa nama brand Anda. Tersedia bahan ivory untuk tampilan bersih dan kraft untuk kesan natural.",
                [['Bahan', 'Ivory 230 gr, Ivory 260 gr, Kraft 150 gr'], ['Tali', 'Tali kur, tali pita, tali kertas pilin'], ['Finishing', 'Laminasi doff/glossy, spot UV (opsional)']],
                'Minimal 100 pcs', '7 – 10 hari kerja',
                [['Kecil', '15 × 8 × 20 cm', 4500, 7500, 'per pcs'], ['Sedang', '25 × 10 × 30 cm', 6500, 10500, 'per pcs'], ['Besar', '35 × 12 × 40 cm', 9000, 15000, 'per pcs']]],

            [$offset, 'Buku Pedoman & Buku Laporan', false,
                'Buku laporan tahunan, modul, dan buku pedoman dengan jilid lem panas atau spiral.',
                "Untuk dokumen yang akan dibaca dan disimpan lama. Isi dan sampul bisa memakai bahan berbeda, dan kami bantu hitung jumlah halaman agar pas dengan susunan cetak.",
                [['Isi', 'HVS 70 gr / 80 gr, Art Paper 120 gr'], ['Sampul', 'Art Carton 260 gr, laminasi doff/glossy'], ['Jilid', 'Lem panas (perfect binding), spiral kawat, jahit kawat']],
                'Minimal 50 buku', '7 – 14 hari kerja',
                [['A5', '14,8 × 21 cm', 18000, 45000, 'per buku', 'Tergantung jumlah halaman'], ['A4', '21 × 29,7 cm', 28000, 75000, 'per buku', 'Tergantung jumlah halaman']]],

            [$offset, 'Kalender Dinding & Meja', true,
                'Kalender custom untuk promosi sepanjang tahun, bisa dinding atau meja.',
                "Kalender tetap terpajang selama dua belas bulan, sehingga nama dan kontak usaha Anda terlihat setiap hari. Desain setiap bulan bisa berbeda.",
                [['Bahan', 'Art Paper 150 gr (dinding), Art Carton 260 gr (meja)'], ['Jilid', 'Ring kawat / klem kaleng'], ['Halaman', '7 lembar atau 13 lembar']],
                'Minimal 100 pcs', '7 – 10 hari kerja',
                [['Meja', '21 × 15 cm', 12000, 22000, 'per pcs'], ['Dinding A3', '29,7 × 42 cm', 15000, 30000, 'per pcs']]],

            [$digital, 'Roll Up & X-Banner', true,
                'Display promosi berdiri untuk pameran, lobi kantor, atau depan toko. Ringan dan mudah dibawa.',
                "Roll up memakai tiang yang bisa digulung ke dalam tas, jadi praktis dipindah dari satu acara ke acara lain. X-banner lebih ekonomis untuk pemakaian sesekali.",
                [['Bahan', 'Albatros, Flexi Korea, Luster'], ['Rangka', 'Roll up aluminium / X-banner fiber'], ['Bonus', 'Tas jinjing']],
                'Bisa 1 pcs', '1 – 2 hari kerja',
                [['X-Banner', '60 × 160 cm', 85000, 150000, 'per pcs'], ['Roll Up', '80 × 200 cm', 250000, 450000, 'per pcs'], ['Roll Up Lebar', '100 × 200 cm', 350000, 600000, 'per pcs']]],

            [$digital, 'Standing Poster & Standing Figure', false,
                'Standee potong bentuk untuk acara, peluncuran produk, atau figur penyambut tamu.',
                "Dicetak di atas bahan kaku lalu dipotong mengikuti bentuk gambar, lengkap dengan penyangga di belakang.",
                [['Bahan', 'Foam board 5 mm, PVC board 3 mm'], ['Cetak', 'Full color 1 sisi'], ['Finishing', 'Potong pola + kaki penyangga']],
                'Bisa 1 pcs', '2 – 3 hari kerja',
                [['Standing poster', '60 × 160 cm', 175000, 300000, 'per pcs'], ['Standing figure', 'Tinggi 170 cm', 350000, 650000, 'per pcs']]],

            [$digital, 'ID Card & Member Card', true,
                'Kartu identitas karyawan dan kartu member dari PVC tebal, cetak full color.',
                "Kartu dicetak di PVC tebal sehingga awet dipakai setiap hari dan tidak mudah patah. Bisa ditambah nomor urut, foto, atau barcode yang berbeda di setiap kartu.",
                [['Bahan', 'PVC 0,76 mm (setebal kartu ATM)'], ['Cetak', 'Full color 1 sisi / 2 sisi'], ['Tambahan', 'Nomor urut, foto & nama berbeda, barcode'], ['Aksesoris', 'Holder, yoyo, casing akrilik']],
                'Minimal 10 pcs', '2 – 4 hari kerja',
                [['ID Card', '8,6 × 5,4 cm', 7500, 15000, 'per pcs', 'Harga termasuk cetak 2 sisi'], ['Member Card', '8,6 × 5,4 cm', 5000, 12000, 'per pcs']]],

            [$digital, 'Lanyard', false,
                'Tali ID card dengan logo atau nama perusahaan, bisa satu paket dengan kartu dan holder.',
                "Lanyard dipakai setiap hari, jadi logo Anda ikut terlihat ke mana pun karyawan atau peserta acara pergi. Tersedia sablon untuk desain sederhana dan printing sublim untuk desain penuh warna.",
                [['Bahan', 'Tissue, polyester'], ['Cetak', 'Sablon 1 – 2 warna / printing sublim full color'], ['Pengait', 'Stopper, kait besi, jepit buaya']],
                'Minimal 50 pcs', '5 – 7 hari kerja',
                [['Lebar 1,5 cm', '1,5 × 90 cm', 8000, 15000, 'per pcs'], ['Lebar 2 cm', '2 × 90 cm', 10000, 18000, 'per pcs']]],

            [$souvenir, 'Kaos Custom', true,
                'Kaos seragam acara, komunitas, atau kantor dengan sablon atau bordir logo Anda.',
                "Pilihan bahan dan teknik disesuaikan dengan jumlah dan anggaran. Sablon plastisol untuk warna tajam dan awet, DTF untuk desain rumit dalam jumlah sedikit, bordir untuk kesan resmi.",
                [['Bahan', 'Cotton combed 24s / 30s, lacoste (polo)'], ['Teknik', 'Sablon plastisol, DTF, bordir'], ['Model', 'Kaos oblong, polo, lengan panjang']],
                'Minimal 24 pcs', '10 – 14 hari kerja',
                [['S – XL', 'Dewasa', 55000, 95000, 'per pcs'], ['XXL – XXXL', 'Dewasa', 65000, 110000, 'per pcs'], ['Polo', 'S – XL', 85000, 140000, 'per pcs']]],

            [$souvenir, 'Topi Custom', true,
                'Topi promosi dan seragam dengan logo bordir atau sablon.',
                "Topi cocok untuk kegiatan lapangan, gathering, atau merchandise acara. Logo bordir memberi kesan rapi dan tahan lama, sedangkan sablon lebih hemat untuk jumlah besar.",
                [['Bahan', 'Rafel, drill, jaring (trucker)'], ['Teknik', 'Bordir, sablon'], ['Pengatur', 'Velcro / gesper besi']],
                'Minimal 24 pcs', '10 – 14 hari kerja',
                [['Topi baseball', 'All size', 30000, 65000, 'per pcs'], ['Topi trucker', 'All size', 35000, 70000, 'per pcs']]],

            [$souvenir, 'Rompi', false,
                'Rompi kerja atau seragam lapangan dengan logo dan nama perusahaan.',
                "Rompi banyak dipakai untuk tim lapangan, panitia acara, atau relawan. Bisa ditambah kantong, reflektor, dan bordir nama di bagian dada.",
                [['Bahan', 'Drill, taslan, jaring'], ['Teknik', 'Bordir, sablon'], ['Tambahan', 'Kantong, reflektor, resleting']],
                'Minimal 12 pcs', '14 – 21 hari kerja',
                [['S – XL', 'Dewasa', 110000, 185000, 'per pcs'], ['XXL – XXXL', 'Dewasa', 125000, 200000, 'per pcs']]],

            [$souvenir, 'Tumbler & Mug', true,
                'Tumbler dan mug dengan logo perusahaan untuk seminar, gathering, atau hadiah klien.',
                "Barang yang dipakai setiap hari membuat logo Anda terus terlihat. Tumbler stainless bisa di-grafir laser untuk hasil elegan, sedangkan mug keramik dicetak sublim full color.",
                [['Tumbler', 'Stainless / plastik, 350 – 500 ml'], ['Mug', 'Keramik putih / warna bagian dalam, 11 oz'], ['Cetak', 'Grafir laser, sublim, sablon']],
                'Minimal 24 pcs', '7 – 14 hari kerja',
                [['Mug keramik', '11 oz', 20000, 40000, 'per pcs'], ['Tumbler plastik', '350 – 500 ml', 25000, 45000, 'per pcs'], ['Tumbler stainless', '350 – 500 ml', 45000, 85000, 'per pcs']]],

            [$souvenir, 'Pulpen Custom', false,
                'Pulpen promosi dengan logo, souvenir murah yang paling sering dibagikan.',
                "Pulpen adalah souvenir paling ekonomis untuk seminar, pameran, atau hadiah pelanggan. Logo dicetak di badan pulpen dengan sablon atau grafir laser untuk pulpen metal.",
                [['Bahan', 'Plastik, metal'], ['Cetak', 'Sablon 1 warna, grafir laser (metal)'], ['Tinta', 'Hitam / biru']],
                'Minimal 100 pcs', '7 – 10 hari kerja',
                [['Pulpen plastik', '—', 2500, 6000, 'per pcs'], ['Pulpen metal', '—', 8000, 15000, 'per pcs']]],

            [$souvenir, 'Payung Custom', false,
                'Payung dengan logo perusahaan, berguna sekaligus terlihat jelas saat dipakai.',
                "Payung punya bidang cetak yang luas sehingga logo mudah terlihat dari jauh. Tersedia payung lipat yang praktis dibawa dan payung golf ukuran besar.",
                [['Bahan', 'Kain parasut / polyester'], ['Rangka', 'Besi / fiber anti angin (golf)'], ['Cetak', 'Sablon 1 – 4 panel']],
                'Minimal 50 pcs', '10 – 14 hari kerja',
                [['Payung lipat', 'Diameter ± 100 cm', 45000, 85000, 'per pcs'], ['Payung golf', 'Diameter ± 130 cm', 70000, 120000, 'per pcs']]],
            [$souvenir, 'Bantal Leher & Bantal Promosi', false,
                'Bantal cetak full color dengan logo atau karakter brand, untuk hadiah pelanggan atau merchandise acara.',
                "Dicetak sublim penuh di kain lalu dijahit dan diisi dakron, jadi warnanya tidak mudah pudar saat dicuci. Bentuk bisa mengikuti pola khusus.",
                [['Bahan', 'Kain velboa / spandex, isi dakron'], ['Cetak', 'Sublim full color 2 sisi'], ['Bentuk', 'Bantal leher, kotak, tulang, custom pola']],
                'Minimal 25 pcs', '10 – 14 hari kerja',
                [['Bantal leher', 'Standar dewasa', 35000, 65000, 'per pcs'], ['Bantal kotak', '30 × 30 cm', 40000, 75000, 'per pcs'], ['Bantal kotak', '40 × 40 cm', 55000, 95000, 'per pcs']]],

            [$souvenir, 'Tas Spunbond', false,
                'Tas kain spunbond untuk goodie bag acara atau kemasan belanja yang bisa dipakai ulang.',
                "Ringan, murah, dan bisa dipakai berkali-kali. Tersedia model jinjing dan model dengan lipatan samping.",
                [['Bahan', 'Spunbond 75 gr / 100 gr'], ['Cetak', 'Sablon 1 – 2 warna'], ['Model', 'Tali jinjing, lipat samping (bawah)']],
                'Minimal 100 pcs', '7 – 10 hari kerja',
                [['Kecil', '25 × 30 cm', 3500, 6000, 'per pcs'], ['Sedang', '30 × 40 cm', 4500, 8000, 'per pcs']]],
        ];

        // Foto contoh hasil kerja (diambil dari materi promosi MKGU yang ada di repo).
        $gallery = [
            'Brosur, Poster & Flyer' => ['brosur2', 'brosur3'],
            'Buku Pedoman & Buku Laporan' => ['buku5', 'buku1', 'buku2'],
            'Kaos Custom' => ['kaos'],
            'Topi Custom' => ['topi4', 'topi'],
            'Tumbler & Mug' => ['mug'],
            'Payung Custom' => ['payung'],
            'Bantal Leher & Bantal Promosi' => ['bantal_leher', 'bantal'],
            'Tas Spunbond' => ['tas'],
        ];
        $images = app(ImageService::class);
        $sampleDir = database_path('seeders/sample-images');

        foreach ($products as $i => [$cat, $name, $featured, $short, $desc, $specs, $minOrder, $time, $sizes]) {
            $product = $cat->products()->create([
                'name' => $name,
                'short_description' => $short,
                'description' => $desc,
                'specifications' => array_map(fn ($s) => ['label' => $s[0], 'value' => $s[1]], $specs),
                'min_order' => $minOrder,
                'production_time' => $time,
                'is_featured' => $featured,
                'sort_order' => $i,
            ]);

            foreach ($sizes as $j => $s) {
                $product->sizes()->create([
                    'label' => $s[0], 'dimension' => $s[1], 'price_min' => $s[2], 'price_max' => $s[3],
                    'unit' => $s[4], 'note' => $s[5] ?? null, 'sort_order' => $j,
                ]);
            }

            foreach ($withImages ? ($gallery[$name] ?? []) : [] as $k => $file) {
                $upload = new UploadedFile("{$sampleDir}/{$file}.jpg", "{$file}.jpg", 'image/jpeg', null, true);
                $path = $images->store($upload);
                if ($k === 0) {
                    $product->update(['cover_image' => $path]);
                } else {
                    $product->images()->create(['path' => $path, 'alt' => $name, 'sort_order' => $k]);
                }
            }
        }
    }
}
