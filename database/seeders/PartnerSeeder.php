<?php

namespace Database\Seeders;

use App\Models\Partner;
use Illuminate\Database\Seeder;

/**
 * Partner dari versi lama website. Logo belum disertakan —
 * unggah lewat Admin → Partner. Selama belum ada logo, nama tampil sebagai teks.
 */
class PartnerSeeder extends Seeder
{
    public function run(): void
    {
        $partners = [
            ['BPOM', 'Badan Pengawas Obat dan Makanan'],
            ['Huawei', 'Huawei Technologies'],
            ['JEEVES', 'Jeeves Indonesia'],
            ['SKIN+', 'by Euromedica'],
        ];

        foreach ($partners as $i => [$name, $description]) {
            Partner::updateOrCreate(['name' => $name], ['description' => $description, 'sort_order' => $i, 'is_active' => true]);
        }
    }
}
