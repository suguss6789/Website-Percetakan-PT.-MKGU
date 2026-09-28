# Rencana Perubahan: Website E-Commerce → Company Profile
**Proyek:** Website Percetakan PT. MKGU (Multi Karya Grafika Utama)
**Repositori:** `suguss6789/Website-Percetakan-PT.-MKGU`
**Stack:** Laravel 10 · PHP 8.1 · MySQL · Tailwind CSS · Alpine.js
**Tanggal dokumen:** 28 September 2026

---

## Daftar Isi

1. [Latar Belakang dan Tujuan](#1-latar-belakang-dan-tujuan)
2. [Kondisi Proyek Saat Ini](#2-kondisi-proyek-saat-ini)
3. [Keputusan Arsitektur: Database dan Admin Tetap Dipakai](#3-keputusan-arsitektur-database-dan-admin-tetap-dipakai)
4. [Fitur dan File yang Dihapus](#4-fitur-dan-file-yang-dihapus)
5. [Struktur Database Baru](#5-struktur-database-baru)
6. [Sistem Harga Kisaran per Ukuran](#6-sistem-harga-kisaran-per-ukuran)
7. [Model, Route, dan Controller](#7-model-route-dan-controller)
8. [Panel Admin](#8-panel-admin)
9. [Halaman Publik](#9-halaman-publik)
10. [Arah Desain: Supaya Tidak Terasa Seperti Template AI](#10-arah-desain-supaya-tidak-terasa-seperti-template-ai)
11. [Performa, SEO, dan Keamanan](#11-performa-seo-dan-keamanan)
12. [Struktur Folder Akhir](#12-struktur-folder-akhir)
13. [Tahapan Pengerjaan](#13-tahapan-pengerjaan)
14. [Checklist Pengujian](#14-checklist-pengujian)
15. [Yang Perlu Disiapkan oleh Klien](#15-yang-perlu-disiapkan-oleh-klien)
16. [Temuan Lain di Kode Lama](#16-temuan-lain-di-kode-lama)

---

## 1. Latar Belakang dan Tujuan

Website saat ini dibangun sebagai toko online: pelanggan memilih produk, mengisi form pesanan, mengunggah desain, menerima invoice, lalu mengunggah bukti transfer. Dalam praktiknya, pesanan cetak hampir selalu butuh obrolan dulu soal jumlah, bahan, finishing, dan kesiapan file desain. Alur checkout otomatis jadi terasa kaku dan jarang benar-benar dipakai.

Karena itu, website diubah menjadi **company profile** dengan tujuan:

- Memperkenalkan PT. MKGU sebagai percetakan yang kredibel dan berpengalaman.
- Menampilkan katalog produk lengkap dengan spesifikasi, foto, dan **kisaran harga per ukuran**.
- Mengarahkan calon pelanggan untuk menghubungi lewat **WhatsApp** atau datang ke lokasi.
- Tetap bisa dikelola sendiri oleh admin tanpa menyentuh kode (tambah, ubah, hapus produk).

---

## 2. Kondisi Proyek Saat Ini

Hasil pembacaan repositori:

| Bagian | Kondisi |
|---|---|
| Framework | Laravel 10, dompdf untuk invoice PDF |
| Front-end | Tailwind via CDN (`cdn.tailwindcss.com`), Alpine.js, Font Awesome, font Poppins + Roboto |
| Tabel | `categories`, `products`, `orders`, `order_details`, `admins` |
| Produk | Kolom `sizes`, `finishings`, `materials` disimpan sebagai JSON, `base_price` sebagai harga dasar |
| Halaman publik | Beranda, Layanan, Tentang Kami, daftar produk, detail produk + form pesanan, invoice |
| Admin | Dashboard, CRUD produk, kategori, pesanan, pelanggan, unduh bukti bayar & invoice |
| Migrasi | 16 file, beberapa saling menimpa (tambah kolom lalu hapus, ubah nullable bolak-balik) |
| README | Masih bawaan Laravel |

Data perusahaan yang sudah ada di layout dan akan dipakai ulang:

- Nama: Multi Karya Grafika Utama, *Member of PT. Mulia Idola Utama*
- Alamat: Jl. Pisangan Lama II No.5B, Pisangan Timur, Jakarta Timur
- Email: mkgu.jakarta@gmail.com
- WhatsApp: 0812-9727-9919
- Jam operasional: Senin–Jumat 08.00–17.00, Sabtu 08.00–15.00

---

## 3. Keputusan Arsitektur: Database dan Admin Tetap Dipakai

**Database dan panel admin tetap diperlukan.** Alasannya sederhana: produk harus bisa ditambah, diubah, dan dihapus oleh orang yang bukan programmer. Tanpa database, setiap perubahan harga atau foto berarti edit kode lalu upload ulang ke hosting.

Perbandingan singkat:

| Opsi | Kelebihan | Kekurangan |
|---|---|---|
| **Laravel + MySQL + Admin** (dipilih) | Produk dan kontak bisa dikelola lewat browser, foto diunggah langsung | Butuh hosting yang mendukung PHP & MySQL |
| Web statis (HTML saja) | Hosting murah/gratis, sangat cepat, hampir tanpa celah keamanan | Setiap perubahan produk harus lewat kode |

Yang berubah adalah skalanya: database menyusut dari 5 tabel e-commerce menjadi tabel katalog yang ringkas, dan admin hanya berisi menu yang benar-benar dipakai.

---

## 4. Fitur dan File yang Dihapus

### 4.1 Fitur

- Form pemesanan di halaman detail produk
- Upload file desain oleh pelanggan
- Halaman invoice dan konfirmasi pembayaran
- Upload dan unduh bukti transfer
- Pembuatan invoice PDF
- Menu Pesanan dan Pelanggan di admin

### 4.2 File

**Model**
- `app/Models/Order.php`
- `app/Models/OrderDetail.php`

**Controller**
- `app/Http/Controllers/Admin/OrderAdminController.php`
- `app/Http/Controllers/Admin/CustomerAdminController.php` (datanya diambil dari tabel `orders`, jadi ikut hilang)
- Method di `ProductController.php`: `handleFormSubmission()`, `invoice()`, `confirmPayment()`, `downloadInvoice()`

**View**
- `resources/views/pages/invoice.blade.php`
- `resources/views/pdf/invoice.blade.php`
- `resources/views/admin/orders/*` (index, show, edit, designs)
- `resources/views/admin/customers/*` (index, create, edit, show)

**Migrasi** (seluruh folder migrasi diganti, lihat bagian 5.3)
- `create_orders_table`, `create_order_details_table`, `add_payment_proof_to_orders_table`, `recreate_product_id_on_order_details`, `optimize_column_lengths`

**Dependensi**
- `barryvdh/laravel-dompdf` dihapus dari `composer.json`

**File sisa**
- `composer-setup.php`, `gitt.txt`, `CLEANUP_REPORT.md`, `serve.bat` (opsional, kalau tidak dipakai)
- `public/assets/images/products/placeholder.txt`

**Route** yang dihapus dari `routes/web.php`:
```
POST /produk/{product:slug}
GET  /invoice/{order_code}
POST /invoice/{order_code}/confirm
admin/orders/*
admin/customers/*
DELETE admin/products/{product}   ← duplikat, sudah tercakup Route::resource
```

---

## 5. Struktur Database Baru

### 5.1 Diagram Relasi

```
categories 1 ──── n products 1 ──── n product_sizes
                        │
                        └──── n product_images

admins        (berdiri sendiri, untuk login)
settings      (berdiri sendiri, key-value profil & kontak)
```

### 5.2 Rincian Tabel

#### `categories`
| Kolom | Tipe | Keterangan |
|---|---|---|
| id | bigint PK | |
| name | varchar(80) | Contoh: Offset Printing |
| slug | varchar(100) unique | Dibuat otomatis dari nama |
| description | text nullable | Ditampilkan di halaman produk saat kategori dipilih |
| sort_order | smallint default 0 | Urutan tampil |
| timestamps | | |

Kolom `image` lama dihapus karena tidak dipakai di desain baru.

#### `products`
| Kolom | Tipe | Keterangan |
|---|---|---|
| id | bigint PK | |
| category_id | FK → categories, `restrict on delete` | Kategori tidak bisa dihapus selama masih punya produk |
| name | varchar(120) | |
| slug | varchar(140) unique | |
| short_description | varchar(200) | Satu–dua kalimat untuk kartu produk |
| description | text | Deskripsi lengkap, mendukung paragraf |
| specifications | json nullable | Pasangan label–nilai, lihat contoh di bawah |
| min_order | varchar(60) nullable | Contoh: "Minimal 100 pcs" |
| production_time | varchar(60) nullable | Contoh: "3–5 hari kerja" |
| cover_image | varchar(255) nullable | Gambar utama |
| is_featured | boolean default false | Tampil di beranda |
| is_active | boolean default true | Bisa disembunyikan tanpa dihapus |
| sort_order | smallint default 0 | |
| timestamps | | |

Kolom lama `price`, `base_price`, `sizes`, `finishings`, `materials` dilebur ke struktur baru: ukuran dan harga pindah ke tabel `product_sizes`, sedangkan bahan dan finishing masuk ke `specifications`.

Contoh isi `specifications`:
```json
[
  { "label": "Bahan",     "value": "Art Paper 120 gr, Art Paper 150 gr, HVS 100 gr" },
  { "label": "Cetak",     "value": "Full color 1 sisi / 2 sisi" },
  { "label": "Finishing", "value": "Laminasi doff, laminasi glossy, lipat 2 / lipat 3" }
]
```

Format label–nilai dipilih supaya fleksibel. Buku punya spesifikasi "Jilid" dan "Jumlah halaman", paperbag punya "Tali" dan "Laminasi", tanpa perlu menambah kolom baru setiap ada jenis produk berbeda.

#### `product_sizes` (baru, inti sistem harga)
| Kolom | Tipe | Keterangan |
|---|---|---|
| id | bigint PK | |
| product_id | FK → products, `cascade on delete` | |
| label | varchar(60) | Contoh: A5, A4, A3, Custom |
| dimension | varchar(60) nullable | Contoh: 14,8 × 21 cm |
| price_min | unsignedInteger | Batas bawah kisaran, dalam Rupiah |
| price_max | unsignedInteger nullable | Batas atas; kosong berarti tampil "mulai dari" |
| unit | varchar(30) | per lembar, per pcs, per rim, per buku, per m² |
| note | varchar(150) nullable | Contoh: "Harga turun untuk order di atas 1.000 pcs" |
| sort_order | smallint default 0 | |
| timestamps | | |

#### `product_images` (baru)
| Kolom | Tipe | Keterangan |
|---|---|---|
| id | bigint PK | |
| product_id | FK → products, `cascade on delete` | |
| path | varchar(255) | Lokasi file di `storage/app/public/products` |
| alt | varchar(150) nullable | Teks alternatif untuk aksesibilitas dan SEO |
| sort_order | smallint default 0 | |
| timestamps | | |

#### `admins`
Tetap seperti sekarang (`name`, `email`, `password`, `role`).

#### `settings` (baru)
| Kolom | Tipe | Keterangan |
|---|---|---|
| key | varchar(60) PK | |
| value | text nullable | |

Key yang disiapkan:

| Key | Contoh isi |
|---|---|
| `company_name` | Multi Karya Grafika Utama |
| `company_parent` | PT. Mulia Idola Utama |
| `tagline` | (diisi klien) |
| `about_short` | Paragraf singkat untuk beranda |
| `about_full` | Teks lengkap halaman Tentang Kami |
| `vision`, `mission` | |
| `founded_year` | (diisi klien, jangan dikarang) |
| `address` | Jl. Pisangan Lama II No.5B, ... |
| `maps_embed_url` | Link embed Google Maps |
| `whatsapp` | 6281297279919 |
| `phone`, `email` | |
| `hours_weekday`, `hours_saturday` | |
| `instagram`, `facebook`, `tiktok` | |

Nilai `settings` disimpan di cache dan cache dibersihkan otomatis setiap kali admin menyimpan perubahan, jadi tidak ada query berulang di setiap halaman.

### 5.3 Strategi Migrasi

Enam belas file migrasi lama saling menimpa dan membawa tabel pesanan. Semuanya **dihapus dan diganti** dengan migrasi baru yang bersih:

```
2026_10_01_000001_create_admins_table.php
2026_10_01_000002_create_categories_table.php
2026_10_01_000003_create_products_table.php
2026_10_01_000004_create_product_sizes_table.php
2026_10_01_000005_create_product_images_table.php
2026_10_01_000006_create_settings_table.php
```

Dijalankan dengan `php artisan migrate:fresh --seed`.

> ⚠️ `migrate:fresh` menghapus semua tabel. Kalau database lokal/hosting sudah berisi produk penting, ekspor dulu lewat phpMyAdmin.

---

## 6. Sistem Harga Kisaran per Ukuran

### 6.1 Prinsip

Tidak ada harga tetap. Setiap ukuran punya **kisaran harga** karena harga cetak dipengaruhi jumlah pesanan, bahan, finishing, dan tingkat kerumitan. Harga final selalu dikonfirmasi lewat WhatsApp.

### 6.2 Contoh Data (ilustrasi, angka diganti klien)

**Brosur / Flyer**
| Ukuran | Dimensi | Kisaran | Satuan |
|---|---|---|---|
| A5 | 14,8 × 21 cm | Rp800 – Rp1.500 | per lembar |
| A4 | 21 × 29,7 cm | Rp1.200 – Rp2.500 | per lembar |
| A3 | 29,7 × 42 cm | Rp2.500 – Rp5.000 | per lembar |

### 6.3 Aturan Tampilan

| Tempat | Yang ditampilkan |
|---|---|
| Kartu produk (katalog & beranda) | Kisaran dari ukuran termurah sampai termahal: **Rp800 – Rp5.000 / lembar**. Jika satuan antar-ukuran berbeda, tampil **Mulai Rp800** saja |
| Detail produk | Tabel lengkap per ukuran: ukuran, dimensi, kisaran, satuan, catatan |
| `price_max` kosong | Tampil **Mulai Rp800 / lembar** |
| Produk tanpa ukuran | Tampil **Harga sesuai permintaan** + tombol konsultasi |

Di bawah tabel harga selalu ada catatan tetap:

> Harga adalah perkiraan dan dapat berubah tergantung jumlah, bahan, dan finishing. Hubungi kami untuk penawaran pasti.

Format angka memakai gaya Indonesia (`Rp1.500`, titik sebagai pemisah ribuan) lewat helper `rupiah()` di `app/Support/helpers.php`.

### 6.4 Integrasi WhatsApp

Tombol "Tanya Harga" di halaman detail membuka WhatsApp dengan pesan terisi otomatis. Jika pengunjung sudah memilih ukuran di tabel, ukurannya ikut masuk:

```
Halo MKGU, saya ingin tanya harga *Brosur / Flyer* ukuran *A4*.
Jumlah: ...
Bahan: ...
(dari website: https://.../produk/brosur-flyer)
```

---

## 7. Model, Route, dan Controller

### 7.1 Model

| Model | Relasi & fitur |
|---|---|
| `Category` | `hasMany(Product)`; slug otomatis saat `creating` |
| `Product` | `belongsTo(Category)`, `hasMany(ProductSize)` terurut, `hasMany(ProductImage)` terurut; cast `specifications` ke array; scope `active()` dan `featured()`; accessor `price_range_label` dan `image_url` |
| `ProductSize` | `belongsTo(Product)`; accessor `price_label` |
| `ProductImage` | `belongsTo(Product)`; accessor `url`; hapus file fisik saat record dihapus |
| `Setting` | method statis `Setting::get('key', 'default')` dengan cache |
| `Admin` | tetap |

### 7.2 Route Publik

| Method | URL | Nama | Fungsi |
|---|---|---|---|
| GET | `/` | `home` | Beranda |
| GET | `/tentang-kami` | `about` | Profil perusahaan |
| GET | `/layanan` | `services` | Jenis layanan |
| GET | `/produk` | `products.index` | Katalog, filter `?kategori=slug` dan `?q=kata` |
| GET | `/produk/{product:slug}` | `products.show` | Detail produk |
| GET | `/kontak` | `contact` | Kontak & peta |
| GET | `/sitemap.xml` | `sitemap` | Sitemap otomatis |

### 7.3 Route Admin

Prefix `/admin`, middleware `auth` + `is_admin`:

| URL | Fungsi |
|---|---|
| `/admin/login`, `/admin/logout` | Autentikasi (login dibatasi 5 percobaan/menit) |
| `/admin` | Dashboard |
| `/admin/products` (resource) | CRUD produk |
| `/admin/products/{product}/images/{image}` DELETE | Hapus satu foto galeri |
| `/admin/products/{product}/toggle` PATCH | Aktif/nonaktif cepat dari daftar |
| `/admin/categories` (resource, tanpa show) | CRUD kategori |
| `/admin/settings` GET & PUT | Profil & kontak |
| `/admin/account` GET & PUT | Ganti nama, email, password admin |

### 7.4 Controller

```
app/Http/Controllers/
├── PageController.php            home, about, services, contact, sitemap
├── ProductController.php         index, show  (hanya dua method)
├── Auth/LoginController.php      tetap, ditambah rate limit
└── Admin/
    ├── DashboardController.php
    ├── ProductAdminController.php
    ├── CategoryAdminController.php
    ├── SettingController.php
    └── AccountController.php
```

Validasi dipindah ke Form Request (`StoreProductRequest`, `UpdateProductRequest`, `CategoryRequest`, `SettingRequest`) agar controller tetap ringkas.

---

## 8. Panel Admin

Admin juga didesain ulang supaya konsisten dengan warna brand, tapi tetap fungsional dan sederhana: sidebar kiri, konten kanan, sidebar jadi menu geser di HP.

### 8.1 Dashboard
- Jumlah produk aktif, produk nonaktif, jumlah kategori
- Lima produk yang terakhir diubah, dengan tautan edit
- Peringatan kecil untuk produk yang belum punya foto atau belum punya harga
- Tombol cepat: "Tambah Produk", "Lihat Website"

### 8.2 Daftar Produk
- Tabel: foto kecil, nama, kategori, kisaran harga, status unggulan, status aktif, tombol aksi
- Filter kategori dan kotak pencarian
- Toggle aktif/nonaktif langsung dari tabel
- Hapus dengan dialog konfirmasi ("Produk ini dan semua fotonya akan dihapus permanen")
- Paginasi 15 per halaman

### 8.3 Form Tambah / Edit Produk

Dibagi menjadi beberapa bagian dalam satu halaman:

**A. Informasi Dasar**
- Nama produk (wajib), slug otomatis tapi bisa diubah
- Kategori (dropdown, wajib)
- Deskripsi singkat (wajib, maks. 200 karakter, ada penghitung karakter)
- Deskripsi lengkap (wajib)
- Minimal order, estimasi pengerjaan (opsional)

**B. Ukuran & Kisaran Harga** (baris dinamis dengan Alpine.js)
- Tombol "+ Tambah Ukuran"
- Setiap baris: label, dimensi, harga min, harga maks, satuan (dropdown + bisa ketik sendiri), catatan
- Baris bisa dihapus dan diurutkan (tombol naik/turun)
- Validasi: `price_max` harus ≥ `price_min`

**C. Spesifikasi** (baris dinamis)
- Setiap baris: label dan nilai
- Tombol isi cepat untuk label umum: Bahan, Cetak, Finishing, Jilid, Laminasi

**D. Gambar**
- Gambar utama (wajib saat tambah): pratinjau sebelum simpan
- Galeri: unggah banyak sekaligus, maks. 8 foto; bisa hapus satu per satu dan atur urutan
- Aturan: JPG/PNG/WEBP, maks. 2 MB per file
- Saat diunggah, gambar diperkecil ke lebar maks. 1600 px dan dibuat versi thumbnail 600 px (paket `intervention/image`)

**E. Tampilan**
- Checkbox "Tampilkan di beranda (unggulan)"
- Checkbox "Aktif" (produk nonaktif tidak muncul di website)

### 8.4 Kategori
- Nama, deskripsi, urutan
- Kategori yang masih berisi produk tidak bisa dihapus; admin diberi pesan jelas berapa produk yang harus dipindahkan dulu

### 8.5 Pengaturan Profil & Kontak
Form berkelompok: Identitas Perusahaan, Tentang Kami, Kontak, Jam Operasional, Media Sosial. Semua key dari tabel `settings`. Ada petunjuk singkat cara mengambil link embed Google Maps.

### 8.6 Akun Admin
Ubah nama, email, dan password (wajib isi password lama).

---

## 9. Halaman Publik

### 9.1 Layout Umum

**Header**
- Logo kiri, menu: Beranda · Tentang · Layanan · Produk · Kontak
- Tombol "Hubungi Kami" di kanan (ke WhatsApp)
- Saat di-scroll, header mengecil dan diberi garis bawah tipis, bukan bayangan tebal
- Di HP: menu layar penuh dengan tipografi besar

**Footer**
- Logo, satu paragraf profil singkat, *Member of PT. Mulia Idola Utama*
- Kolom: Produk (daftar kategori), Kontak (alamat, telepon, email), Jam Operasional
- Baris bawah: hak cipta dan media sosial

**Tombol WhatsApp melayang** di kanan bawah, dengan label teks "Chat" di desktop (bukan hanya ikon bulat).

### 9.2 Beranda

Urutan section:

1. **Hero**: judul besar yang menyebut apa yang dikerjakan (bukan kalimat umum), subjudul satu baris, dua tombol ("Lihat Produk" dan "Konsultasi Gratis"). Di sisi kanan foto hasil cetak asli yang disusun bertumpuk, seolah lembaran kertas yang baru keluar mesin.
2. **Strip kategori**: deretan kategori yang bisa diklik langsung ke katalog terfilter.
3. **Produk unggulan**: 4–8 produk `is_featured`, dengan kisaran harga.
4. **Tentang singkat**: paragraf `about_short`, angka-angka nyata dari klien (tahun berdiri, jumlah klien, dll. hanya jika datanya ada), tautan ke Tentang Kami.
5. **Cara Pesan**: empat langkah sebagai daftar bernomor besar berbentuk editorial: Konsultasi → Kirim desain → Proof & persetujuan → Cetak & kirim.
6. **Layanan**: ringkasan Offset Printing, Digital Printing, Konveksi & Souvenir.
7. **Penutup**: blok berwarna hijau tua dengan ajakan konsultasi dan nomor WhatsApp yang terlihat jelas.

### 9.3 Tentang Kami
- Pembuka: siapa MKGU dan hubungannya dengan PT. Mulia Idola Utama
- Cerita singkat perusahaan (dari `about_full`)
- Visi dan misi
- Foto workshop/mesin/tim (bagian ini yang paling membangun kepercayaan)
- Ajakan ke katalog produk

### 9.4 Layanan
Setiap layanan ditampilkan sebagai section tersendiri berselang-seling (foto kiri–teks kanan, lalu sebaliknya), berisi penjelasan, contoh produk yang termasuk, dan tautan ke kategori terkait.

### 9.5 Katalog Produk
- Judul halaman + jumlah produk
- Filter kategori sebagai tab horizontal (bisa di-scroll di HP)
- Kotak pencarian
- Grid kartu: 1 kolom (HP), 2 (tablet), 3–4 (desktop)
- Isi kartu: foto, label kategori kecil, nama, deskripsi singkat, kisaran harga
- Paginasi 12 per halaman
- Kondisi kosong: pesan jelas + tombol "Tanya produk lain via WhatsApp"

### 9.6 Detail Produk
- Breadcrumb: Produk / Kategori / Nama
- Kiri: galeri (gambar utama besar + thumbnail, bisa di-swipe di HP, klik untuk perbesar)
- Kanan: kategori, nama, deskripsi singkat, **kisaran harga keseluruhan**, minimal order, estimasi pengerjaan, tombol "Tanya Harga via WhatsApp"
- Di bawahnya, dua tab atau dua section:
  - **Harga per Ukuran**: tabel dari `product_sizes`; setiap baris bisa diklik untuk memilih ukuran yang akan dikirim ke WhatsApp
  - **Spesifikasi**: tabel label–nilai
- Deskripsi lengkap
- Produk lain dari kategori yang sama (4 buah)

### 9.7 Kontak
- Alamat, telepon, WhatsApp, email, jam operasional
- Peta Google Maps (embed)
- Tombol "Petunjuk Arah" yang membuka Google Maps di HP
- Tidak ada form kontak yang menyimpan ke database (menghindari spam dan tabel tambahan); semua ajakan diarahkan ke WhatsApp dan email

### 9.8 Halaman Error
Halaman 404 dan 500 dengan desain yang sama, tautan kembali ke beranda dan katalog.

---

## 10. Arah Desain: Supaya Tidak Terasa Seperti Template AI

Ini bagian yang paling menentukan kesan pertama. Banyak website yang dibuat cepat punya pola yang sama persis, dan pelanggan secara tidak sadar menangkapnya sebagai "tidak serius". Arah desain di sini mengambil bahasa visual **dari dunia percetakan itu sendiri**, bukan dari template generik.

### 10.1 Pola yang Dihindari

| Pola generik | Kenapa dihindari |
|---|---|
| Gradien ungu–biru, efek kaca (glassmorphism), bentuk *blob* mengambang | Ciri paling kentara website hasil generator |
| Tiga kartu ikon berjudul "Kualitas Terbaik / Harga Terjangkau / Pengiriman Cepat" | Semua percetakan mengklaim hal yang sama, tidak membedakan apa pun |
| Hero berisi teks rata tengah di atas gradien, tanpa foto | Tidak menunjukkan produk sama sekali |
| Semua elemen `rounded-2xl` + bayangan tebal | Membuat halaman terlihat seperti kumpulan kartu yang sama |
| Emoji atau ikon dekoratif di setiap judul | Terkesan ramai dan murahan |
| Ilustrasi 3D atau gambar hasil AI | Pelanggan percetakan ingin melihat **hasil cetak nyata** |
| Kalimat seperti "Solusi terbaik untuk kebutuhan Anda", "Wujudkan impian Anda bersama kami" | Tidak memberi informasi apa pun |
| Angka statistik yang dikarang ("500+ klien puas") | Merusak kepercayaan kalau tidak benar |
| Animasi di setiap elemen saat scroll | Melelahkan dan memperlambat |

### 10.2 Konsep: "Meja Cetak"

Website dibuat seolah-olah pengunjung sedang melihat hasil kerja di meja produksi percetakan. Elemen yang diambil:

- **Tanda potong (crop marks)**: garis siku kecil di sudut foto produk dan section tertentu, seperti di lembar cetak sebelum dipotong.
- **Color bar CMYK**: garis tipis empat warna sebagai pembatas section atau aksen di footer.
- **Tanda registrasi**: simbol lingkaran-silang kecil sebagai ornamen, dipakai hemat (maks. 1–2 per halaman).
- **Tekstur kertas**: latar krem sangat lembut (`#FAF7F0`), bukan putih polos.
- **Foto bertumpuk**: di hero dan tentang kami, foto hasil cetak disusun sedikit miring dan saling tumpang tindih, seperti lembaran di atas meja.
- **Label spesifikasi**: label kecil huruf kapital berjarak lebar ("OFFSET · A4 · ART PAPER 150GR"), mengingatkan pada label di tumpukan kertas atau job ticket percetakan.

Semua ornamen ini dibuat dengan SVG/CSS ringan, bukan gambar.

### 10.3 Palet Warna

Diambil langsung dari logo, dengan tambahan varian gelap supaya teks tetap terbaca (sudah dicek rasio kontrasnya terhadap standar WCAG AA, minimal 4,5:1 untuk teks biasa).

| Token | Hex | Kegunaan | Catatan kontras |
|---|---|---|---|
| `brand-green` | `#0AA84A` | Aksen, ikon, garis, latar besar dengan teks besar | Teks putih di atasnya hanya 3,1:1, jadi **tidak untuk teks kecil** |
| `brand-green-deep` | `#067A35` | Tombol utama, link, blok CTA | Teks putih 5,5:1 ✓ |
| `brand-yellow` | `#F9D01A` | Sorotan harga, label "Unggulan", garis bawah judul | Teks tinta 11,2:1 ✓ |
| `brand-orange` | `#F05A28` | Tombol WhatsApp, ajakan penting (hemat) | Teks tinta 4,9:1 ✓; teks putih hanya 3,4:1 |
| `brand-orange-deep` | `#C9431A` | Jika tombol oranye perlu teks putih | Teks putih 4,9:1 ✓ |
| `paper` | `#FAF7F0` | Latar halaman | |
| `ink` | `#1B1F1A` | Teks utama (hitam kehijauan, bukan hitam murni) | 15,6:1 ✓ |
| `ink-muted` | `#5C6259` | Teks sekunder | 5,9:1 ✓ |
| `line` | `#E4DFD3` | Garis pembatas, border | |

Proporsi pemakaian kira-kira: 70% paper & ink, 20% hijau, 7% kuning, 3% oranye. Oranye sengaja dibuat langka supaya tombol ajakan benar-benar menonjol.

### 10.4 Tipografi

Poppins + Roboto diganti karena keduanya adalah pilihan bawaan di sebagian besar template.

| Peran | Font | Alasan |
|---|---|---|
| Judul | **Bricolage Grotesque** (600–800) | Berkarakter, sedikit "cetakan" di bentuk hurufnya, tegas untuk judul besar |
| Isi & UI | **Plus Jakarta Sans** (400–600) | Sangat terbaca di layar kecil, dan dibuat oleh desainer Indonesia |
| Angka harga & label spesifikasi | **JetBrains Mono** atau `ui-monospace` (500) | Memberi kesan "job ticket" dan membuat angka harga sejajar rapi di tabel |

Skala: judul hero 48–72 px di desktop, 36–40 px di HP; isi 16–17 px; tinggi baris isi 1,6. Judul boleh memakai huruf besar-kecil biasa, bukan kapital semua.

### 10.5 Bentuk dan Komponen

- Sudut: **4 px** untuk tombol dan kartu, 0 px untuk foto yang diberi crop marks. Tidak ada sudut sangat bulat.
- Bayangan: hampir tidak dipakai. Pemisahan elemen memakai garis 1 px `line` dan perbedaan latar.
- Tombol utama: latar `brand-green-deep`, teks putih, saat hover bergeser 2 px ke atas dan muncul garis bawah kuning.
- Kartu produk: tanpa bingkai tebal, foto rasio 4:5, di bawahnya label kategori mono kecil, nama, lalu harga dengan sorotan kuning tipis di belakang angka (seperti stabilo).
- Tabel harga: baris bergaris tipis, kolom harga rata kanan dengan font mono, baris terpilih diberi latar kuning muda.
- Grid tidak selalu simetris: beberapa section memakai komposisi 7/5 atau 8/4 kolom agar tidak terasa monoton.

### 10.6 Foto dan Konten Visual

- Prioritaskan **foto asli**: hasil cetak, mesin, proses finishing, tumpukan bahan, tim bekerja.
- Foto produk dengan latar polos yang konsisten (krem atau abu muda) supaya katalog terlihat rapi.
- Jika foto belum lengkap, pakai placeholder bergaya "lembar kosong" dengan crop marks dan nama produk, bukan gambar stok atau gambar AI.
- Ikon hanya dipakai jika benar-benar membantu (telepon, lokasi, WhatsApp), dengan satu set ikon garis yang konsisten (Lucide atau Tabler), bukan Font Awesome solid.

### 10.7 Gaya Penulisan

- Spesifik dan membumi: "Cetak brosur dari 100 lembar, bisa ambil di Pisangan Timur" lebih meyakinkan daripada "Solusi cetak terbaik untuk bisnis Anda".
- Sapaan "Anda", nada ramah tapi tidak berlebihan.
- Kalimat pendek, tanpa tanda seru beruntun.
- Klaim hanya yang bisa dibuktikan klien.

### 10.8 Gerak dan Interaksi

- Satu animasi masuk yang halus untuk hero (lembaran foto "jatuh" ke meja satu per satu, total < 1 detik).
- Elemen lain hanya fade ringan saat pertama terlihat, sekali saja.
- Menghormati pengaturan `prefers-reduced-motion`: semua animasi dimatikan untuk pengguna yang memilihnya.
- Hover yang jelas untuk semua elemen yang bisa diklik; fokus keyboard terlihat (outline kuning).

### 10.9 Responsif

- Dirancang dari layar HP dulu (360 px), karena kebanyakan pelanggan datang dari tautan WhatsApp/Instagram.
- Target sentuh minimal 44 × 44 px.
- Tabel harga di HP berubah menjadi daftar bertumpuk per ukuran agar tidak perlu geser ke samping.
- Tombol WhatsApp melayang tidak menutupi tombol lain di bagian bawah halaman.

---

## 11. Performa, SEO, dan Keamanan

### 11.1 Performa
- **Tailwind dari CDN diganti build lewat Vite.** CDN Tailwind memang tidak dimaksudkan untuk produksi: ukurannya besar dan diproses di browser. Dengan build, CSS akhir hanya berisi kelas yang dipakai (biasanya < 30 KB).
- Font di-host sendiri atau dimuat dengan `display=swap` dan hanya bobot yang dipakai.
- Gambar diperkecil saat upload, disajikan dengan `loading="lazy"`, `width`/`height` eksplisit, dan format WebP bila memungkinkan.
- Query produk memakai eager loading (`with('category', 'sizes')`) untuk menghindari N+1.
- `php artisan config:cache`, `route:cache`, `view:cache` saat deploy.

### 11.2 SEO
- `<title>` dan meta description unik per halaman; halaman produk memakai nama + deskripsi singkat.
- Open Graph (gambar, judul, deskripsi) supaya tautan terlihat bagus saat dibagikan di WhatsApp.
- Structured data `LocalBusiness` di beranda dan `Product` di detail produk (dengan `priceRange`).
- `sitemap.xml` otomatis dan `robots.txt` yang mengarah ke sitemap.
- URL bersih berbahasa Indonesia (`/produk/kalender-meja`).

### 11.3 Keamanan
- Login admin dibatasi 5 percobaan per menit per IP.
- Semua input divalidasi di Form Request; deskripsi ditampilkan dengan escape Blade.
- Upload hanya menerima tipe gambar yang diperiksa dari isi file, bukan hanya ekstensi; nama file diacak.
- `APP_DEBUG=false` dan `APP_ENV=production` di hosting.
- Seeder admin memakai email & password dari `.env`, bukan tertulis di kode.
- Route admin tetap di balik middleware `auth` + `is_admin`.

---

## 12. Struktur Folder Akhir

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── PageController.php
│   │   ├── ProductController.php
│   │   ├── Auth/LoginController.php
│   │   └── Admin/
│   │       ├── DashboardController.php
│   │       ├── ProductAdminController.php
│   │       ├── CategoryAdminController.php
│   │       ├── SettingController.php
│   │       └── AccountController.php
│   ├── Middleware/IsAdmin.php
│   └── Requests/
│       ├── StoreProductRequest.php
│       ├── UpdateProductRequest.php
│       ├── CategoryRequest.php
│       └── SettingRequest.php
├── Models/
│   ├── Admin.php
│   ├── Category.php
│   ├── Product.php
│   ├── ProductSize.php
│   ├── ProductImage.php
│   └── Setting.php
├── Services/ImageService.php        (resize, thumbnail, hapus file)
└── Support/helpers.php              (rupiah(), wa_link(), setting())

database/
├── migrations/                      (6 file baru)
└── seeders/
    ├── DatabaseSeeder.php
    ├── AdminSeeder.php
    ├── SettingSeeder.php
    └── CatalogSeeder.php            (kategori + produk contoh + ukuran)

resources/
├── css/app.css                      (Tailwind + token warna + ornamen cetak)
├── js/app.js                        (Alpine, galeri, pemilih ukuran → WA)
└── views/
    ├── layouts/
    │   ├── app.blade.php
    │   └── admin.blade.php
    ├── components/
    │   ├── product-card.blade.php
    │   ├── price-table.blade.php
    │   ├── crop-frame.blade.php
    │   ├── section-heading.blade.php
    │   ├── wa-button.blade.php
    │   └── admin/ (form-field, dynamic-rows, image-uploader)
    ├── pages/
    │   ├── home.blade.php
    │   ├── about.blade.php
    │   ├── services.blade.php
    │   ├── contact.blade.php
    │   └── products/
    │       ├── index.blade.php
    │       └── show.blade.php
    ├── admin/
    │   ├── dashboard.blade.php
    │   ├── products/ (index, create, edit, _form)
    │   ├── categories/ (index, create, edit)
    │   ├── settings/edit.blade.php
    │   └── account/edit.blade.php
    ├── auth/login.blade.php
    └── errors/ (404, 500)

tailwind.config.js
postcss.config.js
README.md                            (ditulis ulang: cara install, akun admin, deploy)
```

---

## 13. Tahapan Pengerjaan

| Tahap | Pekerjaan | Hasil |
|---|---|---|
| 1. Pembersihan | Hapus fitur e-commerce, file sisa, dompdf, route duplikat | Proyek bersih tanpa sisa pesanan |
| 2. Database | Migrasi baru, model & relasi, seeder data contoh | `migrate:fresh --seed` berjalan tanpa error |
| 3. Setup front-end | Tailwind via Vite, token warna, font, komponen dasar, ornamen cetak | Fondasi desain siap |
| 4. Admin panel | CRUD produk (ukuran, spesifikasi, galeri), kategori, pengaturan, akun | Admin bisa mengelola seluruh isi website |
| 5. Halaman publik | Beranda, Tentang, Layanan, Katalog, Detail, Kontak, error | Website lengkap |
| 6. SEO & performa | Meta, OG, structured data, sitemap, optimasi gambar | Siap diindeks & cepat |
| 7. Pengujian & dokumentasi | Checklist bagian 14, README baru | Siap serah terima |

Setiap tahap bisa ditinjau dulu sebelum lanjut, terutama tahap 3 (arah visual) supaya kalau ada yang kurang sesuai bisa diperbaiki sejak awal.

---

## 14. Checklist Pengujian

**Admin**
- [ ] Login benar masuk dashboard; salah 5× terkena batas percobaan
- [ ] Tambah produk dengan 3 ukuran, 3 spesifikasi, 4 foto
- [ ] Edit produk: hapus satu ukuran, ubah urutan foto, ganti gambar utama
- [ ] Validasi `price_max < price_min` menampilkan pesan yang jelas
- [ ] Nonaktifkan produk → hilang dari website, tetap ada di admin
- [ ] Hapus produk → foto di storage ikut terhapus
- [ ] Hapus kategori yang masih berisi produk → ditolak dengan pesan
- [ ] Ubah nomor WhatsApp di pengaturan → semua tombol WA ikut berubah

**Publik**
- [ ] Kisaran harga di kartu sesuai ukuran termurah–termahal
- [ ] Produk tanpa ukuran menampilkan "Harga sesuai permintaan"
- [ ] Pilih ukuran di tabel → pesan WhatsApp berisi produk + ukuran
- [ ] Filter kategori dan pencarian bekerja bersamaan
- [ ] Galeri bisa di-swipe di HP
- [ ] Tabel harga berubah jadi daftar di layar 360 px
- [ ] Peta tampil di halaman kontak
- [ ] Halaman 404 muncul untuk slug yang tidak ada

**Kualitas**
- [ ] Lighthouse (mobile): Performance ≥ 90, Accessibility ≥ 95, SEO ≥ 95
- [ ] Tidak ada error di console browser
- [ ] Navigasi penuh dengan keyboard, fokus terlihat
- [ ] Diuji di Chrome, Safari (iPhone), dan Chrome Android

---

## 15. Yang Perlu Disiapkan oleh Klien

1. **Logo** dalam format SVG atau PNG resolusi tinggi dengan latar transparan
2. **Foto produk** hasil cetak asli, minimal satu per produk, idealnya 3–4
3. **Foto workshop/mesin/tim** untuk halaman Tentang Kami (3–6 foto)
4. **Daftar produk** beserta ukuran, **kisaran harga per ukuran**, satuan, minimal order, dan estimasi pengerjaan
5. **Spesifikasi** per produk (bahan, finishing, jilid, dll.)
6. **Teks profil**: sejarah singkat, visi, misi, tahun berdiri
7. **Tagline** perusahaan (jika ada)
8. **Link Google Maps** lokasi dan akun media sosial
9. Konfirmasi nomor WhatsApp, telepon, email, dan jam operasional yang dipakai

Selama data belum lengkap, website diisi data contoh yang ditandai jelas agar mudah diganti lewat admin.

---

## 16. Temuan Lain di Kode Lama

Beberapa hal kecil yang ikut dirapikan:

- Judul halaman di `layouts/app.blade.php` tertulis **"MITRA** KARYA GRAFIKA UTAMA", padahal nama di logo dan footer adalah **"MULTI** Karya Grafika Utama". Perlu dikonfirmasi mana yang benar.
- Kelas `ttext-xl` di footer salah ketik (seharusnya `text-xl`).
- Footer memanggil `\App\Models\Category::all()` langsung dari view; dipindah ke View Composer supaya query tidak tercecer di template.
- Seeder masih menulis produk "Kalender 2025"; nama tahun sebaiknya tidak dipakai di nama produk agar tidak perlu diubah setiap tahun.
- Beberapa migrasi memanggil `->change()` bolak-balik pada kolom yang sama; masalah ini hilang dengan migrasi baru.
