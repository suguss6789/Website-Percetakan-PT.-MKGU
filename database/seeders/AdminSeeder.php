<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    public function run()
    {
        \App\Models\Admin::create([
            'name' => 'Admin',
            'email' => 'Luthfi83*#@admin1.com',
            'password' => bcrypt('Luthf18379*#'),
            'role' => 'admin',
        ]);
    }
}
