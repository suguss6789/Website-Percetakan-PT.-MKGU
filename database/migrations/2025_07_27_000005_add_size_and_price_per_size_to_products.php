<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Menambahkan kolom untuk ukuran dan harga per ukuran
            $table->json('sizes')->nullable()->after('price'); // Menyimpan array ukuran dan harga
            $table->decimal('base_price', 15, 2)->nullable()->after('sizes'); // Harga dasar
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['sizes', 'base_price']);
        });
    }
}; 