<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabel products
        Schema::table('products', function (Blueprint $table) {
            $table->string('name', 35)->change();
            $table->string('slug', 35)->change();
            $table->string('cover_image', 80)->change();
        });
        // Tabel categories
        Schema::table('categories', function (Blueprint $table) {
            $table->string('name', 35)->change();
            $table->string('slug', 35)->change();
            $table->string('image', 80)->nullable()->change();
        });
        // Tabel orders
        Schema::table('orders', function (Blueprint $table) {
            $table->string('order_code', 20)->change();
            $table->string('customer_name', 35)->change();
            $table->string('customer_email', 35)->change();
            $table->string('customer_phone', 15)->change();
        });
        // Tabel order_details
        Schema::table('order_details', function (Blueprint $table) {
            $table->string('design_file', 80)->nullable()->change();
        });
        // Tabel admins
        Schema::table('admins', function (Blueprint $table) {
            $table->string('name', 30)->change();
            $table->string('email', 35)->change();
            $table->string('password', 60)->change();
            $table->string('role', 20)->default('admin')->change();
        });

    }

    public function down(): void
    {
        // Tidak perlu implementasi down untuk perubahan panjang kolom
    }
}; 