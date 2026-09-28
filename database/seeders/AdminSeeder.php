<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;

/**
 * Akun admin diambil dari .env (ADMIN_EMAIL, ADMIN_PASSWORD),
 * jadi tidak ada password yang tersimpan di repositori.
 */
class AdminSeeder extends Seeder
{
    public function run(): void
    {
        Admin::updateOrCreate(
            ['email' => env('ADMIN_EMAIL', 'admin@mkgu.test')],
            [
                'name' => env('ADMIN_NAME', 'Admin MKGU'),
                'password' => env('ADMIN_PASSWORD', 'ganti-password-ini'),
                'role' => 'admin',
            ]
        );
    }
}
